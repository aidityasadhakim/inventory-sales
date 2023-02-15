<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Operatormodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'users';

    public function getAllData()
    {
        $this->db->order_by('name', 'asc');
        $this->db->where('deleted_at', null);
        $this->db->where('id !=', 1);
        $this->db->where('id !=', 3);
        $query = $this->db->get($this->table);
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

    public function checkExist($username)
    {
        $this->db->where('deleted_at', null);
        $this->db->where('username', $username);
        $this->db->where('status', 1);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function checkExistUpdate($id, $username)
    {
        $this->db->where('deleted_at', null);
        $this->db->where('username', $username);
        $this->db->where('id !=', $id);
        $this->db->where('status', 1);
        $query = $this->db->get($this->table);
        return $query->num_rows();
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

}

/* End of file Customermodel.php */
/* Location: ./application/models/Customermodel.php */
 ?>