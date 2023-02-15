<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Stockmodel', 'stock');
    }

    // List all your items
    public function index($id = 0)
    {
        $data['title'] = 'Manajemen Stok Barang';
        $data['page'] = 'master';
        $data['stocks'] = $this->stock->getStockByItemId($id);
        $data['item_id'] = $id;
        $this->load->view('stocks/view', $data);
    }

    // Add a new item
    public function add($type, $item_id)
    {
        if ($this->input->post('submit')) {

            $amount = $this->input->post('amount');
            $buyPrice = $this->input->post('buyPrice');
            $note = $this->input->post('note');

            if ($type == 'increase') {
                $dataInsert = array(
                        'transaction_id' => 0,
                        'item_id'  => $item_id,
                        'amount'  => $amount,
                        'buyPrice'  => $buyPrice,
                        'type' => 'stock',
                        'note'  => $note
                        );
                $this->stock->addStock($dataInsert);
                $this->session->set_flashdata('msg', 'Stok berhasil ditambah!');
                redirect('stock/index/'.$item_id);
            }
            else {
                $dataInsert = array(
                        'transaction_id' => 0,
                        'item_id'  => $item_id,
                        'amount'  => $amount,
                        'buyPrice'  => $buyPrice,
                        'type' => 'stock',
                        'note'  => $note
                        );
                $result = $this->stock->decreaseStock($dataInsert);
                if ($result['msg'] == 'fail') {
                    $this->session->set_flashdata('error', 'Stok gagal dikurangkan!');
                    redirect('stock/add/decrease/'.$item_id);
                }
                else {
                    $this->session->set_flashdata('msg', 'Stok berhasil dikurangkan!');
                    redirect('stock/index/'.$item_id);
                }
            }
            

        }
        else {
            if ($type == 'increase') {
                $data['title'] = 'Tambah Stok Barang';
            }
            else {
                $data['title'] = 'Kurangi Stok Barang';
            }
            $data['page']  = 'master';
            $data['type'] = $type;
            $data['item_id'] = $item_id;
            $data['prices'] = $this->stock->getPrices($data['item_id']);
            $this->load->view('stocks/insert',$data);
        }
    }

    //Update one item
    public function update( $id = NULL )
    {

    }

    //Delete one item
    public function delete( $id = NULL )
    {
        $row = $this->stock->getDataById($id);
        $affected = decreaseStock($row['item_id'], $row['amount']);
        if ($affected == 0) {
            $this->session->set_flashdata('error', 'Data Stok gagal dihapus!');
            redirect('stock/index/'.$row['item_id']);
        }
        else {
            $this->stock->deleteData($id);
            $this->session->set_flashdata('msg', 'Data Stok berhasil dihapus!');
            redirect('stock/index/'.$row['item_id']);
        }
    }
}

/* End of file Stock.php */
/* Location: ./application/controllers/Stock.php */

 ?>