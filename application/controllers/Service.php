<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Servicemodel', 'service');
        $this->load->model('Customermodel', 'customer');
        $this->load->model('PaymentMethodmodel', 'method');
        $this->load->model('Itemmodel', 'item');
        $this->load->model('Papermodel', 'paper');
    }

    // List all your items
    public function index( $offset = 0 )
    {
        $data['title'] = 'Nota Servis';
        $data['page'] = 'services';
        $this->load->view('services/view', $data);
    }

    function getDataTable()
    {
        $list = $this->service->getDataTables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date('d F Y', strtotime($field['transaction_date']));
            $row[] = '<a href="'.base_url('service/detail/'.$field['id']).'" target="_blank">'.$field['customer_name'].'</a>';
            $row[] = 'Rp. '.number_format($field['total']);
            $row[] = ($field['is_cash'] == 1) ? 'Lunas' : 'Utang';
            $row[] = $field['note'];
            if ($field['is_cash'] == 0) {
                $button_pay = '<a href="'.base_url('service/pay/'.$field['id']).'" class="btn btn-warning">Bayar</a>';
            }
            else {
                $button_pay = '';
            }
            $row[] = '<div class="btn-group">
                            '.$button_pay.'
                            <a href="'.base_url('service/cetak/'.$field['id']).'" class="btn btn-default">Cetak</a>
                            <a href="'.base_url('service/update/'.$field['id']).'" class="btn btn-success">Ubah</a>
                            <a href="'.base_url('service/delete/'.$field['id']).'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus?\')">Hapus</a>
                          </div>';
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->service->countAll(),
            "recordsFiltered" => $this->service->countFiltered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        if ($this->input->post('submit')) {
            $transaction_date = $this->input->post('transaction_date');
            if ($this->input->post('is_customer') != null) {
                $customer_id = $this->input->post('customer_id');
                $customer_name = getDataColumn('customers', 'id', $customer_id, 'name');
                $is_customer = 1;
            }
            else {
                $customer_id = null;
                $customer_name = $this->input->post('customer_name');
                $is_customer = 0;
            }
            $note = $this->input->post('note');
            $method_id = $this->input->post('method_id');
            $type_service = ($this->input->post('type_service') != null) ? $this->input->post('type_service') : 'hardware';

            $item_ids = ($this->input->post('item_ids')[0] == '') ? null : $this->input->post('item_ids');
            $price = $this->input->post('price');
            $qty = $this->input->post('qty');

            $is_cash = ($this->input->post('is_cash') != null) ? $this->input->post('is_cash') : 1;
            $payment_at = ($this->input->post('is_cash') != null) ? null : date('Y-m-d H:i:s');
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
                        'type_service' => $type_service,
                        'is_cash'  => $is_cash,
                        'payment_at'  => $payment_at,
                        'item_ids'  => $item_ids,
                        'price'  => $price,
                        'status' => 2,
                        'type' => 'service',
                        'note' => $note,
                        'qty'  => $qty
                        );            

            $result = $this->service->insertData($dataInsert);
            if ($result['msg'] == 'success') {
                $this->service->updateDataServicesById($result['trans_id'], array('code' => 'IHS'.$result['trans_id']));
                $this->session->set_flashdata('msg', 'Data berhasil ditambah!');
                redirect('service');
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal ditambah! Stok tidak cukup.');
                redirect('service');   
            }
        }
        else {
            $data['title'] = 'Tambah Data Servis';
            $data['page']  = 'master';
            $data['customers'] = $this->customer->getAllData();
            $data['methods'] = $this->method->getAllData();
            $data['items'] = $this->service->getAllItems();
            $this->load->view('services/insert',$data);
        }
    }

    //Update one item
    public function update( $id = NULL )
    {
        $data['row'] = $this->service->getDataById($id);
        $data['details'] = $this->service->getDataDetailByIdTrans($id);
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');
            if ($this->input->post('is_customer') != 0) {
                $customer_id = $this->input->post('customer_id');
                $customer_name = getDataColumn('customers', 'id', $customer_id, 'name');
                $is_customer = 1;
            }
            else {
                $customer_id = null;
                $customer_name = $this->input->post('customer_name');
                $is_customer = 0;
            }
            $note = $this->input->post('note');
            $method_id = $this->input->post('method_id');
            $type_service = ($this->input->post('type_service') != null) ? $this->input->post('type_service') : 'hardware';

            $item_ids = ($this->input->post('item_ids')[0] == '') ? null : $this->input->post('item_ids');
            $price = $this->input->post('price');
            $qty = $this->input->post('qty');

            $is_cash = ($this->input->post('is_cash') != null) ? $this->input->post('is_cash') : 1;
            $payment_at = ($this->input->post('is_cash') != null) ? null : date('Y-m-d H:i:s');
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
                        'type_service' => $type_service,
                        'is_cash'  => $is_cash,
                        'payment_at'  => $payment_at,
                        'item_ids'  => $item_ids,
                        'price'  => $price,
                        'status' => 2,
                        'type' => 'service',
                        'note' => $note,
                        'qty'  => $qty
                        );            

            $result = $this->service->updateData($id, $dataUpdate);
            if ($result['msg'] == 'success') {
                $this->session->set_flashdata('msg', 'Data berhasil diubah!');
                redirect('service');
            }
            else {
                $this->session->set_flashdata('error', 'Data gagal diubah! Stok tidak cukup.');
                redirect('service');   
            }
        }
        else {
            $data['title'] = 'Ubah Data Servis';
            $data['page']  = 'master';
            $data['customers'] = $this->customer->getAllData();
            $data['methods'] = $this->method->getAllData();
            $data['items'] = $this->service->getAllItems();
            $this->load->view('services/update',$data);
        }
    }

    //Delete one item
    public function delete( $id = NULL )
    {
        $this->service->deleteData($id);
        $this->session->set_flashdata('msg', 'Data berhasil dihapus!');
        redirect('service');
    }

    public function detail($id = '', $type = '')
    {
        $data['title'] = 'Detail Data Servis';
        $data['page']  = 'master';
        $data['row'] = $this->service->getDataById($id);
        $data['details'] = $this->service->getDataDetailByIdTrans($id);
        if ($type == 'teknisi') {
            $this->load->view('services/detail-teknisi',$data);
        }
        else {
            $this->load->view('services/detail',$data);
        }
    }

    public function getDataProduct()
    {
        $id = $this->input->post('id');
        $is_customer = $this->input->post('is_customer');
        $row = $this->item->getDataById($id);
        $stock = $this->item->getAvailableStock($id);
        if ($is_customer == 0) {
            // $percentage = getDataColumn('percentages', 'label', 'harga-umum', 'amount');
            // $price = $row['salePrice'] + (($row['salePrice']*$percentage)/100);
            $price = $row['salePrice'];
        }
        else {
            $price = $row['salePrice'];
        }
        $data = array('price' => $price, 'stock' => $stock);
        echo json_encode($data);
    }

    public function pay($id = '')
    {
        $data['row'] = $this->service->getDataById($id);
        if ($this->input->post('submit')) {

            $transaction_date = $this->input->post('transaction_date');
            $method_id = $this->input->post('method_id');
            $total = $this->input->post('total');
            $cash = $this->input->post('cash');
            $changes = $this->input->post('changes');


            $dataUpdate = array(
                        'cash'  => $cash,
                        'changes' => $changes,
                        'method_id' => $method_id,
                        'payment_at' => date('Y-m-d H:i:s'),
                        'is_cash'  => 1
                        );            

            $this->service->updateDataServicesById($id, $dataUpdate);

            $dataInsert = array('transaction_date' => $transaction_date, 
                        'sale_id' => $id,
                        'amount' => $cash,
                        'paid_by' => $this->session->userdata('id')
                        );

            $this->service->insertDataPay($dataInsert);
            
            $this->session->set_flashdata('msg', 'Pembayaran Berhasil!');
            redirect('service');
        }
        else {
            $data['title'] = 'Pembayaran Piutang '.$data['row']['code'];
            $data['page']  = 'master';
            $data['methods'] = $this->method->getAllData();
            $this->load->view('services/pay',$data);
        }
    }

    public function cetak($id = null)
    {
        $data['info'] = $this->paper->getDataDefault();
        $data['row'] = $this->service->getDataById($id);
        $data['details'] = $this->service->getDataDetailByIdTrans($id);
        $this->load->view('services/print', $data);
    }

    public function getAllItems()
    {
        $keyword = $this->input->post('term');
        $page = $this->input->post('page');
        $uid = $this->input->post('uid');
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        $endCount = $offset + $resultCount;

        $items = $this->service->searchItems($keyword, $offset, $endCount, $uid);

        $count = count($this->service->searchItems($keyword, $offset, $endCount, $uid));

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

/* End of file Service.php */
/* Location: ./application/controllers/Service.php */

 ?>