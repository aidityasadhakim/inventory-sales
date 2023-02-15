<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Papermodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'papers';

    public function getAllData()
    {
        $this->db->where('deleted_at', null);
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

    public function getDataDefault()
    {
        $this->db->where('deleted_at', null);
        $this->db->where('is_default', 1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }
    }

    public function updateData($id,$data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->table, $data);
    }

    public function resetData($id)
    {
        $this->db->update($this->table, array('is_default' => 0));
        $data['is_default'] = 1;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->table, $data);
    }

}

/* End of file Papermodel.php */
/* Location: ./application/models/Papermodel.php */
 ?>