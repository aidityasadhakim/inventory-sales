<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Paper extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Papermodel', 'paper');
    }

    public function index()
    {
        $data['title'] = 'Pengaturan Kertas Nota';
        $data['page'] = 'master';
        $data['papers'] = $this->paper->getAllData();
        $this->load->view('papers/view', $data);
    }


    public function update( $id = 0 )
    {
        $data['row'] = $this->paper->getDataById(1);
        if ($this->input->post('submit')) {

            $title = $this->input->post('title');
            $address = $this->input->post('address');
            $subtitle = $this->input->post('subtitle');
            $width = $this->input->post('width');

            
            $dataUpdate = array(
                        'title'  => $title,
                        'subtitle'  => $subtitle,
                        'address'  => $address,
                        'width'  => $width
                        );

            $this->paper->updateData($id, $dataUpdate);
            $this->session->set_flashdata('msg', 'Data berhasil diubah!');
            redirect('paper'); 

        }
        else {
            $data['title'] = 'Pengaturan Kertas Nota';
            $data['page']  = 'master';
            $this->load->view('papers/update', $data);
        }
    }

    public function default($id='')
    {
        $this->paper->resetData($id);
        $this->session->set_flashdata('msg', 'Jadi default berhasil!');
        redirect('paper'); 
    }
}

/* End of file Paper.php */
/* Location: ./application/controllers/Paper.php */

 ?>