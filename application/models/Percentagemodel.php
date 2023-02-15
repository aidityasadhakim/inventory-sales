<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Percentagemodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table = 'percentages';

    public function getDataByLabel($label)
    {
        $this->db->where('deleted_at', null);
        $this->db->where('label', $label);
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

}

/* End of file Percentagemodel.php */
/* Location: ./application/models/Percentagemodel.php */
 ?>