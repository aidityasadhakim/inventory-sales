<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Pendingmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'sales';
    var $table_detail = 'sale_details';
    var $table_customer = 'customers';
    var $table_item = 'items';
    var $table_payment = 'payment_methods';
    var $table_stock = 'stocks';

    var $column_order = array(null, 'transaction_date', 'is_customer', 'customer_id', 'customer_name', 'code', 'total', 'cash', 'changes', 'method_id', 'is_cash', 'status', 'type', 'note');
    var $column_search = array('s.code', 's.name');
    var $order = array('s.id' => 'desc');

    private function _getDatatablesQuery()
    {
        $this->db->select('*');
        $this->db->where('s.deleted_at', null);
        $this->db->where('s.type', 'sale');
        $this->db->where('s.status', 1);
        $this->db->from('sales as s');
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function getDataTables()
    {
        $this->_getDatatablesQuery();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
 
    function countFiltered()
    {
        $this->_getDatatablesQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function countAll()
    {
        $this->db->where('deleted_at', null);
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllItems()
    {
        $this->db->order_by('name', 'asc');
        $this->db->where('deleted_at', null);
        $this->db->where('stock >', 0);
        $query = $this->db->get($this->table_item);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function searchItems($keyword, $offset, $limit, $uid)
    {
        $this->db->order_by('name', 'asc');
        $this->db->where('deleted_at', null);
        // $this->db->where('stock >', 0);
        $this->db->where_not_in('id', $uid);
        $this->db->like('name', $keyword);
        $query = $this->db->get($this->table_item, $limit, $offset);
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

    public function getDataDetailByIdTrans($id)
    {
        $this->db->select('*, i.id as i_id, sale_details.id as sd_id');
        $this->db->where('sale_id', $id);
        $this->db->join('items as i', 'i.id = sale_details.item_id');
        $query = $this->db->get($this->table_detail);
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
        $dataInsert = array('transaction_date' => $data['transaction_date'],
                        'is_customer'  => $data['is_customer'],
                        'customer_id'  => $data['customer_id'],
                        'customer_name'  => $data['customer_name'],
                        'code'  => '-',
                        'total'  => $data['total'],
                        'method_id' => $data['method_id'],
                        'is_cash'  => $data['is_cash'],
                        'payment_at' => ($data['is_cash'] == 0) ? null : date('Y-m-d H:i:s'),
                        'status' => 1,
                        'type' => 'sale',
                        'note' => $data['note'],
                        'created_at' => date('Y-m-d H:i:s')
                        ); 
        $this->db->insert($this->table,$dataInsert);
        $idx = $this->db->insert_id();

        foreach ($data['item_ids'] as $key => $value) {
            $dataInsertDetail = array('sale_id' => $idx,
                                    'item_id' => $value,
                                    'qty' => $data['qty'][$key],
                                    'price' => $data['price'][$key]
                                    );
            $this->db->insert($this->table_detail, $dataInsertDetail);
            $dataInsertMutation = array('transaction_id' => $idx,
                                    'item_id' => $value,
                                    'amount' => '-'.$data['qty'][$key],
                                    'type' => 'sale',
                                    'created_at' => date('Y-m-d H:i:s')
                                    );
            $this->db->insert('stock_mutations', $dataInsertMutation);

            $this->db->where('deleted_at', null);
            $this->db->where('item_id', $value);
            $this->db->where('sale_id IS NULL', null, false);
            $row = $this->db->get($this->table_stock)->num_rows();
            if ($row < $data['qty'][$key]) {
                $this->db->trans_rollback();
                return array('msg' => 'fail');
            }
            else {
                $limit = $data['qty'][$key];
                $query = "UPDATE stocks SET sale_id='$idx'
                            WHERE id IN (
                                SELECT id FROM (
                                    SELECT id FROM stocks
                                    WHERE sale_id IS NULL
                                    AND
                                    item_id = '$value'
                                    AND
                                    deleted_at IS null
                                    ORDER BY id ASC
                                    LIMIT 0, $limit
                                ) tmp
                            )";
                $this->db->query($query);
            }

            $res = $this->decreaseStock($value, $data['qty'][$key]);

            if ($res == 0) {
                $this->db->trans_rollback();
                return array('msg' => 'fail');
            }
        }
        $this->db->trans_commit();
        return array('msg' => 'success', 'trans_id' => $idx);
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

    public function updateData($id, $data)
    {
        $this->db->trans_begin();
        $dataUpdate = array('transaction_date' => $data['transaction_date'],
                        'is_customer'  => $data['is_customer'],
                        'customer_id'  => $data['customer_id'],
                        'customer_name'  => $data['customer_name'],
                        'total'  => $data['total'],
                        'cash'  => $data['cash'],
                        'changes' => $data['changes'],
                        'method_id' => $data['method_id'],
                        'is_cash'  => $data['is_cash'],
                        'status' => 2,
                        'type' => 'sale',
                        'note' => $data['note'],
                        'updated_at' => date('Y-m-d H:i:s')
                        ); 
        $this->db->where('id', $id);
        $this->db->update($this->table, $dataUpdate);

        $this->db->where('sale_id', $id);
        $this->db->delete($this->table_detail);

        $this->db->where('transaction_id', $id);
        $this->db->where('type', 'sale');
        $this->db->delete('stock_mutations');

        foreach ($data['item_ids'] as $key => $value) {
            $dataInsertDetail = array('sale_id' => $id,
                                    'item_id' => $value,
                                    'qty' => $data['qty'][$key],
                                    'price' => $data['price'][$key]
                                    );
            $this->db->insert($this->table_detail, $dataInsertDetail);
            $dataInsertMutation = array('transaction_id' => $id,
                                    'item_id' => $value,
                                    'amount' => '-'.$data['qty'][$key],
                                    'type' => 'sale',
                                    'created_at' => date('Y-m-d H:i:s')
                                    );
            $this->db->insert('stock_mutations', $dataInsertMutation);

            $res = $this->decreaseStock($value, $data['qty'][$key]);

            if ($res == 0) {
                $this->db->trans_rollback();
                return array('msg' => 'fail');
            }
        }
        $this->db->trans_commit();
        return array('msg' => 'success');
    }

    public function updateDataSalesById($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update($this->table,$data);
    }

    public function deleteData($id)
    {
        $data = array('deleted_at' => date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update($this->table,$data);

        $this->db->where('sale_id', $id);
        $this->db->delete($this->table_detail);

        $this->db->where('transaction_id', $id);
        $this->db->where('type', 'sale');
        $this->db->delete('stock_mutations');
    }

    public function insertDataItem($data)
    {
        $this->db->trans_begin();
        foreach ($data['item_ids'] as $key => $value) {
            $idx = $data['sale_id'];
            $dataInsertDetail = array('sale_id' => $idx,
                                    'item_id' => $value,
                                    'qty' => $data['qty'][$key],
                                    'price' => $data['price'][$key]
                                    );
            $this->db->insert($this->table_detail, $dataInsertDetail);
            $dataInsertMutation = array('transaction_id' => $idx,
                                    'item_id' => $value,
                                    'amount' => '-'.$data['qty'][$key],
                                    'type' => 'sale',
                                    'created_at' => date('Y-m-d H:i:s')
                                    );
            $this->db->insert('stock_mutations', $dataInsertMutation);

            $this->db->where('deleted_at', null);
            $this->db->where('item_id', $value);
            $this->db->where('sale_id IS NULL', null, false);
            $row = $this->db->get($this->table_stock)->num_rows();
            if ($row < $data['qty'][$key]) {
                $this->db->trans_rollback();
                return array('msg' => 'fail');
            }
            else {
                $limit = $data['qty'][$key];
                $query = "UPDATE stocks SET sale_id='$idx'
                            WHERE id IN (
                                SELECT id FROM (
                                    SELECT id FROM stocks
                                    WHERE sale_id IS NULL
                                    AND
                                    item_id = '$value'
                                    AND
                                    deleted_at IS null
                                    ORDER BY id ASC
                                    LIMIT 0, $limit
                                ) tmp
                            )";
                $this->db->query($query);
            }
            
            $res = $this->decreaseStock($value, $data['qty'][$key]);

            if ($res == 0) {
                $this->db->trans_rollback();
                return array('msg' => 'fail');
            }
        }

        $this->db->trans_commit();
        return array('msg' => 'success');
    }

    public function getDataDetailById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_detail);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }
    }

    public function updateDataItem($id, $data)
    {
        $this->db->trans_begin();
        $row = $this->getDataDetailById($id);
        $sale_id = $row['sale_id'];
        $item_id = $row['item_id'];
        $this->increaseStock($row['item_id'], $row['qty']);
        
        $this->db->where('sale_id', $sale_id);
        $this->db->where('item_id', $row['item_id']);
        $this->db->update($this->table_stock, array('sale_id' => null));

        $this->db->where('id', $id);
        $this->db->update($this->table_detail, $data);

        $this->db->where('transaction_id', $row['sale_id']);
        $this->db->where('item_id', $row['item_id']);
        $this->db->where('type', 'sale');
        $this->db->delete('stock_mutations');

        $dataInsertMutation = array('transaction_id' => $data['sale_id'],
                                'item_id' => $data['item_id'],
                                'amount' => '-'.$data['qty'],
                                'type' => 'sale',
                                'created_at' => date('Y-m-d H:i:s')
                                );

        $this->db->insert('stock_mutations', $dataInsertMutation);

        $this->db->where('deleted_at', null);
        $this->db->where('item_id', $row['item_id']);
        $this->db->where('sale_id IS NULL', null, false);
        $row = $this->db->get($this->table_stock)->num_rows();
        if ($row < $data['qty']) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }
        else {
            $limit = $data['qty'];
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

        $res = $this->decreaseStock($data['item_id'], $data['qty']);

        if ($res == 0) {
            $this->db->trans_rollback();
            return array('msg' => 'fail');
        }
        $this->db->trans_commit();
        return array('msg' => 'success');
    }

    public function deleteDataItem($id = '')
    {
        $row = $this->getDataDetailById($id);

        $this->db->where('transaction_id', $row['sale_id']);
        $this->db->where('item_id', $row['item_id']);
        $this->db->where('type', 'sale');
        $this->db->delete('stock_mutations');

        $this->db->where('sale_id', $id);
        $this->db->where('item_id', $row['item_id']);
        $this->db->update($this->table_stock, array('sale_id' => null));

        $this->db->where('id', $id);
        $this->db->delete($this->table_detail);

    }

}

/* End of file Pendingmodel.php */
/* Location: ./application/models/Pendingmodel.php */
 ?>