<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model('Itemmodel', 'item');
    }

    // List all your items
    public function index( $offset = 0 )
    {
        $data['title'] = 'Master Barang';
        $data['page'] = 'master';
        $this->load->view('items/view', $data);
    }

    function getDataTable()
    {
        $list = $this->item->getDataTables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->name;
            $row[] = getStockAvailable($field->id);

            // $percentage = getDataColumn('percentages', 'label', 'harga-umum', 'amount');
            // $price_general = $field->salePrice + (($field->salePrice*$percentage)/100);
            $price_general = $field->salePriceNon;
            if ($this->session->userdata('level') == 1) {    
                $highBuyPrice = getLatestPrice($field->id);
                $row[] = '<a href="'.base_url('item/stock/'.$field->id).'">Rp. '.number_format($highBuyPrice).'</a>';
            }
            $row[] = 'Rp. '.number_format($field->salePrice);
            $row[] = 'Rp. '.number_format($price_general);
            $row[] = ucfirst($field->type);
            $row[] = $field->note;
            if ($this->session->userdata('level') == 1) {
                $button_stock = '<a href="'.base_url('stock/index/'.$field->id).'" class="btn btn-warning">Stok</a>';
                $button_edit_delete = '<a href="'.base_url('item/update/'.$field->id).'" class="btn btn-success">Ubah</a>
                            <a href="'.base_url('item/delete/'.$field->id).'" class="btn btn-danger" onclick="return confirm(\'Yakin hapus?\')">Hapus</a>';
            }
            elseif ($this->session->userdata('level') == 2) {
                $button_stock = '';
                $button_edit_delete = '<a href="'.base_url('item/update/'.$field->id).'" class="btn btn-success">Ubah</a>';
            }
            else {
                $button_stock = '';
                $button_edit_delete = '<a href="'.base_url('item/update/'.$field->id).'" class="btn btn-success">Ubah</a>';
            }
            $row[] = '<div class="btn-group">
                            '.$button_stock.'                            
                            '.$button_edit_delete.'                            
                          </div>';
            
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->item->countAll(),
            "recordsFiltered" => $this->item->countFiltered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // Add a new item
    public function add()
    {
        if ($this->input->post('submit')) {

            $name = $this->input->post('name');
            $slug = str_replace(' ', '', strtolower($name));
            $salePrice = $this->input->post('salePrice');
            $salePriceNon = $this->input->post('salePriceNon');
            $buyPrice = $this->input->post('buyPrice');
            $stockMin = $this->input->post('stockMin');
            $type = $this->input->post('type');
            $note = $this->input->post('note');


            $dataInsert = array('slug' => $slug,
                        'code'  => '-',
                        'name'  => $name,
                        'stock'  => 0,
                        'stockMin'  => $stockMin,
                        'buyPrice' => $buyPrice,
                        'salePrice' => $salePrice,
                        'salePriceNon' => $salePriceNon,
                        'type'  => $type,
                        'note'  => $note
                        );            

            $id = $this->item->insertData($dataInsert);
            $this->item->updateData($id, array('code' => 'ITM'.$id));
            $this->session->set_flashdata('msg', 'Data berhasil ditambah!');
            redirect('item');
        }
        else {
            $data['title'] = 'Tambah Data Barang';
            $data['page']  = 'master';
            $this->load->view('items/insert',$data);
        }
    }

    //Update one item
    public function update( $id = NULL )
    {
        $data['row'] = $this->item->getDataById($id);
        if ($this->input->post('submit')) {

            $name = $this->input->post('name');
            $slug = str_replace(' ', '', strtolower($name));
            $salePrice = $this->input->post('salePrice');
            $salePriceNon = $this->input->post('salePriceNon');
            $buyPrice = $this->input->post('buyPrice');
            $stockMin = $this->input->post('stockMin');
            $type = $this->input->post('type');
            $note = $this->input->post('note');


            $dataUpdate = array('slug' => $slug,
                        'name'  => $name,
                        'stockMin'  => $stockMin,
                        'buyPrice' => $buyPrice,
                        'salePrice' => $salePrice,
                        'salePriceNon' => $salePriceNon,
                        'type'  => $type,
                        'note'  => $note
                        );   
            

            $this->item->updateData($id, $dataUpdate);
            $this->session->set_flashdata('msg', 'Data berhasil diubah!');
            redirect('item');
        }
        else {
            $data['title'] = 'Ubah Data Barang';
            $data['page']  = 'master';
            $this->load->view('items/update', $data);
        }
    }

    //Delete one item
    public function delete( $id = NULL )
    {
        $this->item->deleteData($id);
        $this->session->set_flashdata('msg', 'Data berhasil dihapus!');
        redirect('item');
    }

    public function stock($item_id)
    {
        $data['title'] = 'Stok Barang';
        $data['page']  = 'master';
        $data['row'] = $this->item->getDataById($item_id);
        $data['stocks'] = $this->item->getStocks($item_id);
        $this->load->view('items/stock', $data);
    }
}

/* End of file Item.php */
/* Location: ./application/controllers/Item.php */

 ?>