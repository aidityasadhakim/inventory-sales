<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Retur extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Returmodel', 'retur');
        $this->load->model('Papermodel', 'paper');
    }

    // List all your items
    public function index( $offset = 0 )
    {
        $data['title'] = 'Nota Retur';
        $data['page'] = 'returns';
        $data['returns'] = $this->retur->getAllData();
        $this->load->view('returns/view', $data);
    }

    // Add a new item
    public function add()
    {
        if ($this->input->post('submit')) {

            $sale_id = $this->input->post('sale_id');

            $data['title'] = 'Tambah Nota Retur';
            $data['page']  = 'returns';
            $data['sales'] = $this->retur->getAllDataSales();
            $data['rowSale'] = $this->retur->getDataSalesById($sale_id);
            $data['rowSaleDetails'] = $this->retur->getDataDetailSalesByIdTrans($sale_id);
            $this->load->view('returns/insert',$data);
        }
        else {
            $data['title'] = 'Tambah Nota Retur';
            $data['page']  = 'returns';
            $data['sales'] = $this->retur->getAllDataSales();
            $this->load->view('returns/insert',$data);
        }
    }

    public function store($value='')
    {
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');

            $sale_id = $this->input->post('sale_id');
            $cash = $this->input->post('cash');

            $sale_detail_id = $this->input->post('sale_detail_id');
            $item_id = $this->input->post('item_id');
            $item_price = $this->input->post('item_price');
            $item_qty = $this->input->post('item_qty');
            $retur_qty = $this->input->post('retur_qty');
            $retur_note = $this->input->post('retur_note');

            $dataInsert = array(
                    'transaction_date'  => $transaction_date,
                    'sale_id'  => $sale_id,
                    'sale_detail_id'  => $sale_detail_id,
                    'item_id'  => $item_id,
                    'item_price'  => $item_price,
                    'item_qty' => $item_qty,
                    'retur_qty' => $retur_qty,
                    'retur_note' => $retur_note,
                    'cash' => $cash
                    );

            $result = $this->retur->insertData($dataInsert);
            if ($result['msg'] == 'success') {
                $this->session->set_flashdata('msg', 'Data berhasil ditambah!');
                redirect('retur');
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal ditambah! Stok tidak sesuai.');
                redirect('retur');   
            }
        }
    }

    public function detail($id = '')
    {
        $data['title'] = 'Detil Nota Retur';
        $data['page']  = 'returns';
        $data['rowRetur'] = $this->retur->getDataById($id);
        $data['rowNota'] = $this->retur->getDataSalesById($data['rowRetur']['sale_id']);
        $data['resDetailNota'] = $this->retur->getDataDetailSalesByIdTrans($data['rowRetur']['sale_id']);
        $this->load->view('returns/detail',$data);
    }

    //Update one item
    public function update( $id = NULL )
    {
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');
            $sale_id = $this->input->post('sale_id');
            $sale_detail_id = $this->input->post('sale_detail_id');
            $old_qty = $this->input->post('old_qty');
            $qty = $this->input->post('qty');
            $note = $this->input->post('note');

            $rowDetail = $this->retur->resetDataQtySaleDetail($sale_detail_id, $old_qty);

            $qtyDetail = $rowDetail['qty'] - $qty;

            $dataUpdateDetailSale = array(
                    'qty'  => $qtyDetail
                    ); 

            $dataUpdate = array(
                    'qty' => $qty,
                    'note' => $note,
                    'user_id' => $this->session->userdata('id')
                    );

            if ($qty != 0) {
                $this->retur->updateDataSaleDetail($sale_detail_id, $dataUpdateDetailSale);
                $this->retur->updateData($id, $dataUpdate);
            }
            $this->updateDataSaleOnReturn($sale_id);
            $this->session->set_flashdata('msg', 'Data berhasil diubah!');
            redirect('retur');
        }
        else {
            $data['title'] = 'Ubah Nota Retur';
            $data['page']  = 'returns';
            $data['row'] = $this->retur->getDataById($id);
            $this->load->view('returns/update',$data);
        }
    }

    //Delete one item
    public function delete( $id = NULL )
    {
        
        $result = $this->retur->deleteData($id);

        if ($result['msg'] == 'success') {
            $this->updateDataSaleOnReturn($result['sale_id']);
            $this->session->set_flashdata('msg', 'Data berhasil dihapus!');
            redirect('retur');
        }
        else {
            $this->session->set_flashdata('error', 'Data gagal dihapus! Stok tidak cukup untuk dikembalikan.');
            redirect('retur');   
        }
    }

    public function updateDataSaleOnReturn($sale_id)
    {
        $rowSale = $this->retur->getDataSalesById($sale_id);
        $rowSaleDetails = $this->retur->getDataDetailSalesByIdTrans($sale_id);

        $grand_total = 0;
        foreach ($rowSaleDetails as $key => $value) {
            $subtotal = $value['qty'] * $value['price'];

            $grand_total += $subtotal;
        }

        $changes = $rowSale['cash'] - $grand_total;
        $dataUpdateSale = array('total' => $grand_total, 'changes' => $changes);
        $this->retur->updateDataSale($sale_id, $dataUpdateSale);
    }

    public function cetak($id = null)
    {
        $data['info'] = $this->paper->getDataDefault();
        $data['row'] = $this->retur->getDataById($id);
        $this->load->view('returns/print', $data);
    }

    public function stock($id = '')
    {
        $row = $this->retur->getDataById($id);
        $result = $this->retur->addToStock($row);

        if ($result['msg'] == 'success') {
            $this->session->set_flashdata('msg', 'Stok berhasil dikembalikan!');
            redirect('retur');
        }
        else {
            $this->session->set_flashdata('error', 'Data gagal dikembalikan! Stok tidak cukup untuk dikembalikan.');
            redirect('retur');   
        }
    }
}

/* End of file Retur.php */
/* Location: ./application/controllers/Retur.php */

 ?>