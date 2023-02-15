<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Itemmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'items';
    var $table_stock = 'stocks';
    var $column_order = array(null, 'slug', 'code', 'name', 'stock', 'buyPrice', 'salePrice', 'salePriceNon', 'note', 'type');
    var $column_search = array('name');
    var $order = array('name' => 'asc');

    
    private function _getDatatablesQuery()
    {
        $this->db->where('deleted_at', null);
        $this->db->from($this->table);
 
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
        return $query->result();
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
        $this->db->where('id',$id);
        $this->db->update($this->table,$data);
    }

    public function getStocks($item_id)
    {
        $this->db->select('buyPrice, SUM(qty) AS qty', FALSE);
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id IS NULL', null, false);
        $this->db->where('deleted_at', null);
        $this->db->group_by('buyPrice');
        $query = $this->db->get($this->table_stock);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    
    public function getAvailableStock($item_id='')
    {
        $this->db->select_sum('qty');
        $this->db->where('deleted_at', null);
        $this->db->where('item_id', $item_id);
        $this->db->where('sale_id', null);
        $query = $this->db->get($this->table_stock);
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            return $data['qty'];
        }
        else {
            return array();
        }
    }

}

/* End of file Itemmodel.php */
/* Location: ./application/models/Itemmodel.php */
 ?>