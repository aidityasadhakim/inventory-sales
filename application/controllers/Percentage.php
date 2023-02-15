<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Percentage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Percentagemodel', 'percentage');
    }

    // List all your items
    public function index( $label = '' )
    {
        $data['row'] = $this->percentage->getDataByLabel($label);
        if ($this->input->post('submit')) {

            $amount = $this->input->post('amount');

            
            $dataUpdate = array(
                        'amount'  => $amount
                        );

            $this->percentage->updateData($data['row']['id'], $dataUpdate);
            $this->session->set_flashdata('msg', 'Data berhasil diubah!');
            redirect('percentage/index/'.$label); 

        }
        else {
            $data['title'] = 'Pengaturan Persentase Harga Jual';
            $data['page']  = 'master';
            $this->load->view('percentages/update', $data);
        }
    }
}

/* End of file Percentage.php */
/* Location: ./application/controllers/Percentage.php */

 ?>