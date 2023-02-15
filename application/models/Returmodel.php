<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Returmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'returns';
    var $table_sale = 'sales';
    var $table_detail_sale = 'sale_details';
    var $table_item = 'items';

    public function getAllData()
    {
        $this->db->select('r.id, r.note, r.transaction_date, r.qty, s.code as s_code, s.customer_name as s_customer_name, i.name as i_name, r.is_stock');
        $this->db->where('r.deleted_at', null);
        $this->db->from('returns as r');
        $this->db->join('sales as s', 's.id = r.sale_id');
        $this->db->join('items as i', 'i.id = r.item_id');
        $this->db->order_by('r.id', 'desc');
        $this->db->where('r.deleted_at', null);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataById($id)
    {
        $this->db->where('deleted_at', null);
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }
    }

    public function getAllDataSales()
    {
        $this->db->select('s.id, s.code, s.transaction_date, s.customer_name as c_name');
        $this->db->from('sales as s');
        $this->db->order_by('s.id', 'desc');
        $this->db->where('s.deleted_at', null);
        $this->db->where('s.type', 'sale');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataSalesById($id='')
    {
        $this->db->select('*, s.id as s_id, s.customer_name as c_name');
        $this->db->where('s.deleted_at', null);
        $this->db->where('s.type', 'sale');
        $this->db->where('s.id', $id);
        $this->db->from('sales as s');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }
    }

    public function getDataDetailSalesByIdTrans($id)
    {
        $this->db->select('i.id as i_id, i.name, sale_details.id as sd_id, sale_details.qty, sale_details.price');
        $this->db->where('sale_id', $id);
        $this->db->join('items as i', 'i.id = sale_details.item_id');
        $query = $this->db->get($this->table_detail_sale);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function insertData($data)
    {
        $this->db->trans_begin();
        $grand_total = 0;


        foreach ($data['sale_detail_id'] as $key => $value) {
            $qtyDetail = $data['item_qty'][$key] - $data['retur_qty'][$key];
            $subtotalDetail = $data['item_price'][$key] * $qtyDetail;

            $grand_total += $subtotalDetail;

            $dataUpdateDetailSale = array(
                    'qty'  => $qtyDetail
                    ); 

            $dataInsert = array(
                    'transaction_date'  => $data['transaction_date'],
                    'sale_id'  => $data['sale_id'],
                    'sale_detail_id'  => $value,
                    'item_id'  => $data['item_id'][$key],
                    'qty' => $data['retur_qty'][$key],
                    'note' => $data['retur_note'][$key],
                    'user_id' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                    );
            

            if ($data['retur_qty'][$key] != 0) {
                $this->db->insert($this->table, $dataInsert);
                $idx = $this->db->insert_id();

                $sale_id = $data['sale_id'];
                $item_id = $data['item_id'][$key];

                // $this->db->where('deleted_at', null);
                // $this->db->where('item_id', $item_id);
                // $this->db->where('sale_id', $sale_id);
                // $row = $this->db->get('stocks')->num_rows();
                // if ($row < $data['retur_qty'][$key]) {
                //     $this->db->trans_rollback();
                //     return array('msg' => 'fail');
                // }
                // else {
                //     $dataInsertMutation = array('transaction_id' => $idx,
                //                     'item_id' => $item_id,
                //                     'amount' => $data['retur_qty'][$key],
                //                     'type' => 'retur',
                //                     'created_at' => date('Y-m-d H:i:s')
                //                     );
                //     $this->db->insert('stock_mutations', $dataInsertMutation);

                //     $this->increaseStock($item_id, $data['retur_qty'][$key]);

                //     $limit = $data['retur_qty'][$key];
                //     $query = "UPDATE stocks SET sale_id = null
                //                 WHERE id IN (
                //                     SELECT id FROM (
                //                         SELECT id FROM stocks
                //                         WHERE sale_id = '$sale_id'
                //                         AND
                //                         item_id = '$item_id'
                //                         AND
                //                         deleted_at IS null
                //                         ORDER BY id ASC
                //                         LIMIT 0, $limit
                //                     ) tmp
                //                 )";
                //     $this->db->query($query);
                // }

                $this->updateDataSaleDetail($value, $dataUpdateDetailSale);
            }

        }

        $changes = $data['cash'] - $grand_total;
        $dataUpdateSale = array('total' => $grand_total, 'changes' => $changes);
        $this->updateDataSale($data['sale_id'], $dataUpdateSale);

        $this->db->trans_commit();
        return array('msg' => 'success');
    }

    public function updateData($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->table,$data);
    }

    public function updateDataSale($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->table_sale,$data);
    }

    public function updateDataSaleDetail($id, $data)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table_detail_sale,$data);
    }

    public function deleteData($id)
    {
        $this->db->trans_begin();
        $row = $this->getDataById($id);
        $sale_id = $row['sale_id'];
        $item_id = $row['item_id'];

        if ($row['is_stock'] == 1) {

        $this->db->where('deleted_at', null);
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id IS NULL', null, false);
        $rowStock = $this->db->get('stocks')->num_rows();
        if ($rowStock < $row['qty']) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }
        else {
            $limit = $row['qty'];
            $query = "UPDATE stocks SET sale_id='$sale_id'
                        WHERE id IN (
                            SELECT id FROM (
                                SELECT id FROM stocks
                                WHERE sale_id IS NULL
                                AND
                                item_id = '$item_id'
                                AND
                                deleted_at IS null
                                ORDER BY id ASC
                                LIMIT 0, $limit
                            ) tmp
                        )";
            $this->db->query($query);
        }

        $res = $this->decreaseStock($item_id, $row['qty']);

        if ($res == 0) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }

        $this->db->where('transaction_id', $id);
        $this->db->where('type', 'retur');
        $this->db->delete('stock_mutations');

        }

        $data = array('deleted_at' => date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update($this->table,$data);
        
        $this->resetDataQtySaleDetail($row['sale_detail_id'], $row['qty']);

        $this->db->trans_commit();
        return array('msg' => 'success', 'sale_id' => $row['sale_id']);

    }

    public function resetDataQtySaleDetail($id, $qty)
    {
        $this->db->where('id',$id);
        $this->db->set('qty', 'qty + '.$qty, FALSE);
        $this->db->update($this->table_detail_sale);

        $this->db->where('id', $id);
        $query = $this->db->get($this->table_detail_sale);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }        
    }

    public function decreaseStock($item_id = '', $qty)
    {
        $this->db->set('stock', 'stock - '.$qty, FALSE);
        $this->db->where('id', $item_id);
        $this->db->where('stock >=', $qty);
        $this->db->update($this->table_item);
        return $this->db->affected_rows();
    }

    public function increaseStock($item_id = '', $qty)
    {
        $this->db->set('stock', 'stock + '.$qty, FALSE);
        $this->db->where('id', $item_id);
        $this->db->update($this->table_item);
    }

    public function addToStock($row)
    {
        $this->db->trans_begin();

        $sale_id = $row['sale_id'];
        $item_id = $row['item_id'];

        $this->db->where('deleted_at IS NULL', null, false);
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', $sale_id);
        $jumlah = $this->db->get('stocks')->num_rows();
        if ($jumlah < $row['qty']) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }
        else {
            $dataInsertMutation = array('transaction_id' => $row['id'],
                            'item_id' => $item_id,
                            'amount' => $row['qty'],
                            'type' => 'retur',
                            'created_at' => date('Y-m-d H:i:s')
                            );
            $this->db->insert('stock_mutations', $dataInsertMutation);

            $this->increaseStock($item_id, $row['qty']);

            $limit = $row['qty'];
            $query = "UPDATE stocks SET sale_id = NULL
                        WHERE id IN (
                            SELECT id FROM (
                                SELECT id FROM stocks
                                WHERE sale_id = '$sale_id'
                                AND
                                item_id = '$item_id'
                                AND
                                deleted_at IS null
                                ORDER BY id ASC
                                LIMIT 0, $limit
                            ) tmp
                        )";
            $this->db->query($query);
            $this->updateData($row['id'], array('is_stock' => 1));
        }

        $this->db->trans_commit();
        return array('msg' => 'success');
    }

}

/* End of file Returmodel.php */
/* Location: ./application/models/Returmodel.php */
 ?>