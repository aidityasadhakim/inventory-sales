<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Pending extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Pendingmodel', 'pending');
        $this->load->model('Customermodel', 'customer');
        $this->load->model('PaymentMethodmodel', 'method');
        $this->load->model('Itemmodel', 'item');
    }

    // List all your items
    public function index( $offset = 0 )
    {
        $data['title'] = 'Nota Penjualan Sementara';
        $data['page'] = 'pending';
        $this->load->view('pendings/view', $data);
    }

    function getDataTable()
    {
        $list = $this->pending->getDataTables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date('d F Y', strtotime($field['transaction_date']));
            $row[] = $field['customer_name'];
            $row[] = 'Rp. '.number_format($field['total']);
            $row[] = ($field['is_cash'] == 1) ? 'Lunas' : 'Utang';
            $row[] = ($field['method_id'] == 0) ? 'Belum Dibayar' : getDataColumn('payment_methods', 'id', $field['method_id'], 'name');
            $row[] = $field['note'];
            $row[] = '<div class="btn-group">
                            <a href="'.base_url('pending/item/'.$field['id']).'" class="btn btn-warning">Ubah Item</a>
                          </div>';
            $row[] = '<div class="btn-group">
                            <a href="'.base_url('pending/complete/'.$field['id']).'" class="btn btn-success">Selesaikan</a>
                            <a href="'.base_url('pending/delete/'.$field['id']).'" class="btn btn-danger" onclick="return confirm(\'Yakin Batal?\')">Batalkan</a>
                          </div>';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pending->countAll(),
            "recordsFiltered" => $this->pending->countFiltered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');
            $customer_id = $this->input->post('customer_id');
            $customer_name = getDataColumn('customers', 'id', $customer_id, 'name');
            $is_customer = 1;
            $note = $this->input->post('note');
            $method_id = $this->input->post('method_id');

            $item_ids = $this->input->post('item_ids');
            $price = $this->input->post('price');
            $qty = $this->input->post('qty');

            $is_cash = ($this->input->post('is_cash') != null) ? $this->input->post('is_cash') : 1;
            $total = $this->input->post('total');
            $cash = $this->input->post('cash');
            $changes = $this->input->post('changes');


            $dataInsert = array('transaction_date' => $transaction_date,
                        'is_customer'  => $is_customer,
                        'customer_id'  => $customer_id,
                        'customer_name'  => $customer_name,
                        'code'  => '-',
                        'total'  => $total,
                        'cash'  => $cash,
                        'changes' => $changes,
                        'method_id' => $method_id,
                        'is_cash'  => $is_cash,
                        'item_ids'  => $item_ids,
                        'price'  => $price,
                        'status' => 2,
                        'type' => 'sale',
                        'note' => $note,
                        'qty'  => $qty
                        );            

            $result = $this->pending->insertData($dataInsert);
            if ($result['msg'] == 'success') {
                $this->pending->updateDataSalesById($result['trans_id'], array('code' => 'IHS'.$result['trans_id']));
                $this->session->set_flashdata('msg', 'Data berhasil ditambah!');
                redirect('pending');
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal ditambah! Stok tidak cukup.');
                redirect('pending');   
            }
        }
        else {
            $data['title'] = 'Tambah Data Penjualan Sementara';
            $data['page']  = 'pending';
            $data['customers'] = $this->customer->getAllData();
            $data['methods'] = $this->method->getAllData();
            // $data['items'] = $this->pending->getAllItems();
            $this->load->view('pendings/insert',$data);
        }
    }

    //Update one item
    public function update( $id = NULL )
    {
        $data['row'] = $this->sale->getDataById($id);
        $data['details'] = $this->sale->getDataDetailByIdTrans($id);
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');
            $customer_id = $this->input->post('customer_id');
            $customer_name = getDataColumn('customers', 'id', $customer_id, 'name');
            $is_customer = 1;
            $note = $this->input->post('note');
            $method_id = $this->input->post('method_id');

            $item_ids = $this->input->post('item_ids');
            $price = $this->input->post('price');
            $qty = $this->input->post('qty');

            $is_cash = ($this->input->post('is_cash') != null) ? $this->input->post('is_cash') : 1;
            $total = $this->input->post('total');
            $cash = $this->input->post('cash');
            $changes = $this->input->post('changes');


            $dataUpdate = array('transaction_date' => $transaction_date,
                        'is_customer'  => $is_customer,
                        'customer_id'  => $customer_id,
                        'customer_name'  => $customer_name,
                        'code'  => '-',
                        'total'  => $total,
                        'cash'  => $cash,
                        'changes' => $changes,
                        'method_id' => $method_id,
                        'is_cash'  => $is_cash,
                        'item_ids'  => $item_ids,
                        'price'  => $price,
                        'status' => 1,
                        'type' => 'sale',
                        'note' => $note,
                        'qty'  => $qty
                        );            

            $result = $this->sale->updateData($id, $dataUpdate);
            if ($result['msg'] == 'success') {
                $this->session->set_flashdata('msg', 'Data berhasil diubah!');
                redirect('sale');
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal diubah! Stok tidak cukup.');
                redirect('sale');   
            }
        }
        else {
            $data['title'] = 'Ubah Data Penjualan';
            $data['page']  = 'master';
            $data['customers'] = $this->customer->getAllData();
            $data['methods'] = $this->method->getAllData();
            // $data['items'] = $this->sale->getAllItems();
            $this->load->view('sales/update',$data);
        }
    }

    //Delete one item
    public function delete( $id = NULL )
    {
        $this->pending->deleteData($id);
        $this->session->set_flashdata('msg', 'Data berhasil dibatalkan!');
        redirect('pending');
    }

    public function getDataProduct()
    {
        $id = $this->input->post('id');
        $row = $this->item->getDataById($id);
        $stock = $this->item->getAvailableStock($id);
        $data = array('price' => $row['salePrice'], 'stock' => $stock);
        echo json_encode($data);
    }

    public function item($id = '')
    {
        $data['row'] = $this->pending->getDataById($id);
        $data['title'] = 'Item Nota Penjualan Sementara - '.$data['row']['code'];
        $data['page'] = 'pending';
        $data['items'] = $this->pending->getDataDetailByIdTrans($id);
        $this->load->view('pendings/view-item', $data);
    }

    public function addItem($id = '')
    {
        if ($this->input->post('submit')) {

            $item_ids = $this->input->post('item_ids');
            $qty = $this->input->post('qty');
            $price = $this->input->post('price');

            $dataInsert = array('sale_id' => $id,
                        'item_ids'  => $item_ids,
                        'price'  => $price,
                        'qty'  => $qty
                        );            

            $result = $this->pending->insertDataItem($dataInsert);
            if ($result['msg'] == 'success') {
                $this->session->set_flashdata('msg', 'Data berhasil ditambah!');
                redirect('pending/item/'.$id);
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal ditambah! Stok tidak cukup.');
                redirect('pending/item/'.$id);   
            }
        }
        else {
            $data['title'] = 'Tambah Item Nota Penjualan Sementara';
            $data['page']  = 'pending';
            $data['id'] = $id;
            $data['items'] = $this->pending->getDataDetailByIdTrans($id);
            $this->load->view('pendings/insert-item',$data);
        }
    }

    public function updateItem($id = '')
    {
        $data['row'] = $this->pending->getDataDetailById($id);
        if ($this->input->post('submit')) {

            $item_id = $this->input->post('item_id');
            $qty = $this->input->post('qty');
            $price = $this->input->post('price');

            $dataUpdate = array('sale_id' => $data['row']['sale_id'],
                        'item_id'  => $item_id,
                        'price'  => $price,
                        'qty'  => $qty
                        );            

            $result = $this->pending->updateDataItem($id, $dataUpdate);
            if ($result['msg'] == 'success') {
                $this->session->set_flashdata('msg', 'Data berhasil ditambah!');
                redirect('pending/item/'.$data['row']['sale_id']);
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal ditambah! Stok tidak cukup.');
                redirect('pending/item/'.$data['row']['sale_id']);   
            }
        }
        else {
            $data['title'] = 'Ubah Item Nota Penjualan Sementara';
            $data['page']  = 'pending';
            $data['id'] = $data['row']['sale_id'];
            // $data['items'] = $this->pending->getAllItems();
            $this->load->view('pendings/update-item',$data);
        }
    }

    public function deleteItem($id = '')
    {
        $row = $this->pending->getDataDetailById($id);
        $this->pending->deleteDataItem($id);
        $this->session->set_flashdata('msg', 'Data berhasil dihapus!');
        redirect('pending/item/'.$row['sale_id']);
    }

    public function complete($id = NULL)
    {
        $data['row'] = $this->pending->getDataById($id);
        $data['details'] = $this->pending->getDataDetailByIdTrans($id);
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');
            $customer_id = $this->input->post('customer_id');
            $customer_name = getDataColumn('customers', 'id', $customer_id, 'name');
            $is_customer = 1;
            $note = $this->input->post('note');
            $method_id = $this->input->post('method_id');

            $is_cash = ($this->input->post('is_cash') != null) ? $this->input->post('is_cash') : 1;
            $total = $this->input->post('total');
            $cash = $this->input->post('cash');
            $changes = $this->input->post('changes');


            $dataUpdate = array('transaction_date' => $transaction_date,
                        'is_customer'  => $is_customer,
                        'customer_id'  => $customer_id,
                        'customer_name'  => $customer_name,
                        'total'  => $total,
                        'cash'  => $cash,
                        'changes' => $changes,
                        'method_id' => $method_id,
                        'is_cash'  => $is_cash,
                        'status' => 2,
                        'type' => 'sale',
                        'note' => $note
                        );            

            $result = $this->pending->updateDataSalesById($id, $dataUpdate);
            $this->session->set_flashdata('msg', 'Transaksi berhasil diselesaikan!');
            redirect('pending');
        }
        else {
            $data['title'] = 'Konfirmasi Data Penjualan';
            $data['page']  = 'master';
            $data['customers'] = $this->customer->getAllData();
            $data['methods'] = $this->method->getAllData();
            // $data['items'] = $this->pending->getAllItems();
            $this->load->view('pendings/complete',$data);
        }
    }

    public function getAllItems()
    {
        $keyword = $this->input->post('term');
        $page = $this->input->post('page');
        $uid = $this->input->post('uid');
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        $endCount = $offset + $resultCount;

        $items = $this->pending->searchItems($keyword, $offset, $endCount, $uid);

        $count = count($this->pending->searchItems($keyword, $offset, $endCount, $uid));

        $morePages = $endCount <= $count;
        $data = [];
        foreach ($items as $key => $value) {
            $stock = $this->item->getAvailableStock($value['id']);
            if ($stock > 0) {
                $dataColumn['text'] = $value['name'];
                $dataColumn['id'] = $value['id'];
                $data[] = $dataColumn;
            }
        }
        echo json_encode(['results' => $data, 'pagination' => array('more' => $morePages)]);
    }
}

/* End of file Pending.php */
/* Location: ./application/controllers/Pending.php */

 ?>