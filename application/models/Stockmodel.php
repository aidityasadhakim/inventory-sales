<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Stockmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'stock_mutations';
    var $table_stock = 'stocks';

    public function getStockByItemId($item_id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('item_id', $item_id);
        $this->db->where('type', 'stock');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getPrices($item_id)
    {
        $this->db->group_by('buyPrice');
        $this->db->where('sale_id IS NULL', null, false);
        $this->db->where('deleted_at', null);
        $this->db->where('item_id', $item_id);
        $query = $this->db->get($this->table_stock);
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

    public function insertData($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    public function updateData($id,$data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->table,$data);
    }

    public function deleteData($id)
    {
        $data = array('deleted_at' => date('Y-m-d H:i:s'));

        $dataStock = $this->getDataById($id);
        decreaseStock($dataStock['item_id'], $dataStock['amount']);
        $this->db->where('id',$id);
        $this->db->update($this->table,$data);

        if ($dataStock['amount'] > 0) {
            $this->db->where('purchase_id', $id);
            $this->db->where('type', 'stock');
            $this->db->update($this->table_stock, $data);
        }
        else {
            $query = "UPDATE stocks SET deleted_at='$deleted_at'
                    WHERE id IN (
                        SELECT id FROM (
                            SELECT id FROM stocks
                            WHERE sale_id IS NULL
                            AND
                            item_id = '$item_id'
                            AND
                            buyPrice = '$buyPrice'
                            ORDER BY id ASC
                            LIMIT 0, $limit
                        ) tmp
                    )";
            $this->db->query($query);
        }
    }    

    public function addStock($data)
    {   
        $this->db->trans_begin();
        increaseStock($data['item_id'], $data['amount']);

        $dataInsert = array(
                        'transaction_id' => 0,
                        'item_id'  => $data['item_id'],
                        'amount'  => $data['amount'],
                        'type' => 'stock',
                        'note'  => $data['note'],
                        'created_at' => date('Y-m-d H:i:s')
                        );
        $this->db->insert($this->table, $dataInsert);

        $idx = $this->db->insert_id();
        
        for ($i=0; $i < $data['amount']; $i++) { 
            $dataStock = array('purchase_id' => $idx, 'item_id' => $data['item_id'], 'qty' => 1, 'buyPrice' => $data['buyPrice'], 'type' => 'stock', 'created_at' => date('Y-m-d H:i:s'));
            $this->db->insert($this->table_stock, $dataStock);
        }
        $this->db->trans_commit();
    }

    public function decreaseStock($data)
    {
        $this->db->trans_begin();
        $this->db->order_by('id', 'asc');
        $this->db->where('item_id', $data['item_id']);
        $this->db->where('buyPrice', $data['buyPrice']);
        $this->db->where('sale_id IS NULL', null, false);
        $row = $this->db->get($this->table_stock)->num_rows();

        if ($row < $data['amount']) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }

        $limit = $data['amount'];
        $deleted_at = date('Y-m-d H:i:s');
        $buyPrice = $data['buyPrice'];
        $item_id = $data['item_id'];
        $query = "UPDATE stocks SET deleted_at='$deleted_at'
                    WHERE id IN (
                        SELECT id FROM (
                            SELECT id FROM stocks
                            WHERE sale_id IS NULL
                            AND
                            item_id = '$item_id'
                            AND
                            buyPrice = '$buyPrice'
                            ORDER BY id ASC
                            LIMIT 0, $limit
                        ) tmp
                    )";
        $this->db->query($query);

        $affected = decreaseStock($data['item_id'], $data['amount']);

        if ($affected == 0) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }

        $dataInsert = array(
                        'transaction_id' => 0,
                        'item_id'  => $data['item_id'],
                        'amount'  => '-'.$data['amount'],
                        'type' => 'stock',
                        'note'  => $data['note'],
                        'created_at' => date('Y-m-d H:i:s')
                        );
        $this->db->insert($this->table, $dataInsert);

        $this->db->trans_commit();
        return array('msg' => 'success');
    }

}

/* End of file Stockmodel.php */
/* Location: ./application/models/Stockmodel.php */

 ?>