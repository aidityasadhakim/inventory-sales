<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reportmodel', 'report');
        $this->load->model('PaymentMethodmodel', 'method');
        $this->load->model('Customermodel', 'customer');
        $this->load->model('Itemmodel', 'item');
        isLogin();
    }

    public function stock()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['item_id'] = $this->input->post('item_id');
                $data['is_date'] = $this->input->post('is_date');
                $data['item'] = $this->item->getDataById($data['item_id']);

                $data['stocks'] = $this->report->getDataStockByPeriod($data['start_date'], $data['end_date'], $data['item_id']);

                $data['title'] = 'Laporan Mutasi Stok Barang';
                $data['page'] = 'report';
                $data['items'] = $this->report->getAllItems();
                $this->load->view('reports/stock_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['item_id'] = $this->input->post('item_id');

                $data['stocks'] = $this->report->getDataStockByPeriod($data['start_date'], $data['end_date'], $data['item_id']);
                
                $this->load->view('reports/stock_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Mutasi Stok Barang';
            $data['page'] = 'report';
            $data['items'] = $this->report->getAllItems();
            $this->load->view('reports/stock_view', $data);
        }
    }

    public function min_stock()
    {
        $data['title'] = 'Laporan Stok Hampir Habis';
        $data['page'] = 'report';
        $data['items'] = $this->report->getDataMinStock();
        $this->load->view('reports/min_stock_view', $data);
    }

    public function cash_in()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['method_id'] = $this->input->post('method_id');

                $data['sales'] = $this->report->getDataCashSaleByPeriod($data['start_date'], $data['end_date'], $data['method_id']);

                $data['title'] = 'Laporan Kas Masuk';
                $data['page'] = 'report';
                $data['methods'] = $this->method->getAllData();
                $this->load->view('reports/cashin_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['method_id'] = $this->input->post('method_id');

                $data['sales'] = $this->report->getDataCashSaleByPeriod($data['start_date'], $data['end_date'], $data['method_id']);
                
                $this->load->view('reports/cashin_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Kas Masuk';
            $data['page'] = 'report';
            $data['methods'] = $this->method->getAllData();
            $this->load->view('reports/cashin_view', $data);
        }
    }

    public function cash_out()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['method_id'] = $this->input->post('method_id');

                $data['purchases'] = $this->report->getDataCashPurchaseByPeriod($data['start_date'], $data['end_date'], $data['method_id']);

                $data['title'] = 'Laporan Kas Keluar';
                $data['page'] = 'report';
                $data['methods'] = $this->method->getAllData();
                $this->load->view('reports/cashout_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['method_id'] = $this->input->post('method_id');

                $data['purchases'] = $this->report->getDataCashPurchaseByPeriod($data['start_date'], $data['end_date'], $data['method_id']);
                
                $this->load->view('reports/cashout_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Kas Keluar';
            $data['page'] = 'report';
            $data['methods'] = $this->method->getAllData();
            $this->load->view('reports/cashout_view', $data);
        }
    }

    public function sales()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date']);

                $data['title'] = 'Laporan Penjualan';
                $data['page'] = 'report';
                $this->load->view('reports/sales_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['method_id'] = $this->input->post('method_id');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date']);
                
                $this->load->view('reports/sales_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Penjualan';
            $data['page'] = 'report';
            $this->load->view('reports/sales_view', $data);
        }
    }

    public function purchases()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');

                $data['purchases'] = $this->report->getDataPurchasesByPeriod($data['start_date'], $data['end_date']);

                $data['title'] = 'Laporan Pembelian';
                $data['page'] = 'report';
                $this->load->view('reports/purchases_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');

                $data['purchases'] = $this->report->getDataPurchasesByPeriod($data['start_date'], $data['end_date']);
                
                $this->load->view('reports/purchases_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Pembelian';
            $data['page'] = 'report';
            $this->load->view('reports/purchases_view', $data);
        }
    }

    public function profit()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['type'] = $this->input->post('type');
                $data['is_cash'] = $this->input->post('is_cash');
                $data['method_id'] = $this->input->post('method_id');
                $data['customer_id'] = $this->input->post('customer_id');

                $data['sales'] = $this->report->getDataSalesByPeriodPage($data['start_date'], $data['end_date'], $data['type'], $data['is_cash'], $data['method_id'], $data['customer_id']);

                $data['title'] = 'Laporan Laba/Rugi';
                $data['page'] = 'report';
                $data['methods'] = $this->method->getAllData();
                $data['customers'] = $this->customer->getAllData();
                $this->load->view('reports/profit_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['type'] = $this->input->post('type');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date'], $data['type']);
                
                $this->load->view('reports/profit_view', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Laba/Rugi';
            $data['page'] = 'report';
            $data['methods'] = $this->method->getAllData();
            $data['customers'] = $this->customer->getAllData();
            $this->load->view('reports/profit_view', $data);
        }
    }

    public function debt()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');

                $data['debts'] = $this->report->getDataDebtByPeriod($data['start_date'], $data['end_date']);

                $data['title'] = 'Laporan Utang';
                $data['page'] = 'report';
                $this->load->view('reports/debt_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');

                $data['debts'] = $this->report->getDataDebtByPeriod($data['start_date'], $data['end_date']);
                
                $this->load->view('reports/debt_download', $data);   
            }
        }
        else {
            $data['title'] = 'Laporan Utang';
            $data['page'] = 'report';
            $this->load->view('reports/debt_view', $data);
        }
    }

    public function claim()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['customer_id'] = $this->input->post('customer_id');
                $data['type'] = $this->input->post('type');

                $data['claims'] = $this->report->getDataClaimByPeriod($data['start_date'], $data['end_date'], $data['customer_id'], $data['type']);

                $data['title'] = 'Laporan Piutang';
                $data['page'] = 'report';
                $data['customers'] = $this->customer->getAllData();
                $this->load->view('reports/claim_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['customer_id'] = $this->input->post('customer_id');

                $data['claims'] = $this->report->getDataClaimByPeriod($data['start_date'], $data['end_date'], $data['customer_id']);
                
                $this->load->view('reports/claim_download', $data);   
            }
        }
        else {
            $data['title'] = 'Laporan Piutang';
            $data['page'] = 'report';
            $data['customers'] = $this->customer->getAllData();
            $this->load->view('reports/claim_view', $data);
        }
    }

    public function customers($value='')
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['customer_id'] = $this->input->post('customer_id');

                $data['sales'] = $this->report->getDataSalesCustomerByPeriod($data['start_date'], $data['end_date'], $data['customer_id']);

                $data['title'] = 'Laporan Penjualan Per Pelanggan';
                $data['page'] = 'report';
                $data['customers'] = $this->customer->getAllData();
                $this->load->view('reports/customer_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['customer_id'] = $this->input->post('customer_id');

                $data['sales'] = $this->report->getDataSalesCustomerByPeriod($data['start_date'], $data['end_date'], $data['customer_id']);
                
                $this->load->view('reports/customer_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Penjualan Per Pelanggan';
            $data['page'] = 'report';
            $data['customers'] = $this->customer->getAllData();
            $this->load->view('reports/customer_view', $data);
        }
    }

    public function item()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['keyword'] = $this->input->post('keyword');

                $data['items'] = $this->report->getAllAvailableItems($data['keyword']);

                $data['title'] = 'Laporan Stok Barang';
                $data['page'] = 'report';
                $this->load->view('reports/item_view', $data);
            }
            else if ($type == 'download') {
                $data['keyword'] = $this->input->post('keyword');

                $data['items'] = $this->report->getAllAvailableItems($data['keyword']);
                
                $this->load->view('reports/item_download', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Stok Barang';
            $data['page'] = 'report';
            $data['items'] = $this->report->getAllAvailableItems();
            $this->load->view('reports/item_view', $data);
        }
    }

    public function profit_technician()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['is_cash'] = $this->input->post('is_cash');
                $data['method_id'] = $this->input->post('method_id');
                $data['customer_id'] = $this->input->post('customer_id');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date'], 'service', $data['is_cash'], $data['method_id'], $data['customer_id']);

                $data['title'] = 'Laporan Setor Teknisi';
                $data['page'] = 'report';
                $data['methods'] = $this->method->getAllData();
                $data['customers'] = $this->customer->getAllData();
                $this->load->view('reports/profit_technician_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['type'] = $this->input->post('type');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date'], $data['type']);
                
                $this->load->view('reports/profit_view', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Setor Teknisi';
            $data['page'] = 'report';
            $data['methods'] = $this->method->getAllData();
            $data['customers'] = $this->customer->getAllData();
            $this->load->view('reports/profit_technician_view', $data);
        }
    }

    public function profit_service()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['is_cash'] = $this->input->post('is_cash');
                $data['method_id'] = $this->input->post('method_id');
                $data['customer_id'] = $this->input->post('customer_id');
                $data['type'] = $this->input->post('type');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date'], 'service', $data['is_cash'], $data['method_id'], $data['customer_id'], $data['type']);

                $data['title'] = 'Laporan Laba/Rugi Servis';
                $data['page'] = 'report';
                $data['methods'] = $this->method->getAllData();
                $data['customers'] = $this->customer->getAllData();
                $this->load->view('reports/profit_service_view', $data);
            }
            else if ($type == 'download') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['type'] = $this->input->post('type');

                $data['sales'] = $this->report->getDataSalesByPeriod($data['start_date'], $data['end_date'], $data['type']);
                
                $this->load->view('reports/profit_view', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Laba/Rugi Servis';
            $data['page'] = 'report';
            $data['methods'] = $this->method->getAllData();
            $data['customers'] = $this->customer->getAllData();
            $this->load->view('reports/profit_service_view', $data);
        }
    }

    public function retur()
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['is_date'] = ($this->input->post('is_date') != null) ? $this->input->post('is_date') : 0;
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['customer_id'] = $this->input->post('customer_id');
                $data['item_id'] = $this->input->post('item_id');

                $data['retur'] = $this->report->getDataReturByPeriod($data['start_date'], $data['end_date'], $data['customer_id'], $data['item_id']);

                $data['title'] = 'Laporan Retur';
                $data['page'] = 'report';
                $data['customers'] = $this->customer->getAllData();
                $this->load->view('reports/retur_view', $data);
            }
            else if ($type == 'download') {
                
            }
        }
        else {
            $data['title'] = 'Laporan Retur';
            $data['page'] = 'report';
            $data['customers'] = $this->customer->getAllData();
            $this->load->view('reports/retur_view', $data);
        }
    }

    public function omzet_customers($value='')
    {
        if ($this->input->post('submit')) {
            $type = $this->input->post('submit');
            if ($type == 'view') {
                $data['is_date'] = ($this->input->post('is_date') != null) ? $this->input->post('is_date') : 0;
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['sales'] = $this->report->getDataSalesPeriodCustomer($data['start_date'], $data['end_date']);

                $data['title'] = 'Laporan Omzet Penjualan Pelanggan';
                $data['page'] = 'report';
                $this->load->view('reports/customer_omzet_view', $data);
            }
            else if ($type == 'cetak') {
                $data['start_date'] = $this->input->post('start_date');
                $data['end_date'] = $this->input->post('end_date');
                $data['start_page'] = $this->input->post('start_page');
                $data['end_page'] = $this->input->post('end_page');
                $data['sales'] = $this->report->getDataSalesPeriodCustomer($data['start_date'], $data['end_date'], $data['start_page'], $data['end_page']);
                
                $this->load->view('reports/customer_omzet_print', $data);    
            }
        }
        else {
            $data['title'] = 'Laporan Omzet Penjualan Pelanggan';
            $data['page'] = 'report';
            $this->load->view('reports/customer_omzet_view', $data);
        }
    }

    public function omzet_customer_detail($customer_id='', $start_date = null, $end_date = null)
    {
        $data['customer'] = $this->customer->getDataById($customer_id);
        if ($start_date != null && $end_date != null) {
            $data['title'] = 'Laporan Detail Omzet Penjualan Pelanggan '.$data['customer']['name'].' Periode '.date('d F Y', strtotime($start_date)).' - '.date('d F Y', strtotime($end_date));
        }
        else {
            $data['title'] = 'Laporan Detail Omzet Penjualan Keseluruhan Pelanggan '.$data['customer']['name'];   
        }
        $data['page'] = 'report';
        $data['sales'] = $this->report->getDataSalesCustomerByPeriod($start_date, $end_date, $customer_id);
        $this->load->view('reports/customer_omzet_detail', $data);
    }

    public function getDataSalePage()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $type = $this->input->post('type');
        $is_cash = $this->input->post('is_cash');
        $method_id = $this->input->post('method_id');
        $customer_id = $this->input->post('customer_id');

        $list = $this->report->getDataSalesByPeriodPage($start_date, $end_date, $type, $is_cash, $method_id, $customer_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $total_profit = $field['total'] - getTotalBuyPrice($field['id']);
            $row = array();
            $row[] = $no;
            $row[] = date('d F Y', strtotime($field['transaction_date']));
            $row[] = 'IHS'.$field['id'];
            if ($field['type'] == 'sale') {
                $row[] = '<a href="'.base_url('sale/detail/'.$field['id']).'" target="_blank">'.$field['customer_name'].'</a>';
            }
            else {
                $row[] = '<a href="'.base_url('service/detail/'.$field['id']).'" target="_blank">'.$field['customer_name'].'</a>';
            }
            $row[] = 'Rp. '.number_format($field['total']);
            $row[] = 'Rp. '.number_format(getTotalBuyPrice($field['id']));
            if ($total_profit < 0) {
                $row[] = 'Rp. ('.number_format($total_profit).')';
            }
            else {
                $row[] = 'Rp. '.number_format($total_profit);
            }

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report->countAll($start_date, $end_date, $type, $is_cash, $method_id, $customer_id),
            "recordsFiltered" => $this->report->countFiltered($start_date, $end_date, $type, $is_cash, $method_id, $customer_id),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function getRecapDataSale()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $type = $this->input->post('type');
        $is_cash = $this->input->post('is_cash');
        $method_id = $this->input->post('method_id');
        $customer_id = $this->input->post('customer_id');

        $sales = $this->report->getDataSummarySalesByPeriod($start_date, $end_date, $type, $is_cash, $method_id, $customer_id);
        // $sale_ids = [];
        $total_sale = $this->report->sumTotalSale($start_date, $end_date, $type, $is_cash, $method_id, $customer_id);
        $total_modal = $sales['modal'];
        $total_profit = 0;
        // foreach ($sales as $key => $value) {
        //     $total_sale += $value['total'];
        //     $total_modal += getTotalBuyPrice($value['id']);
        // }

        $total_profit = $total_sale - $total_modal;

        $data['totalSale'] = 'Rp. '.number_format($total_sale);
        $data['totalModal'] = 'Rp. '.number_format($total_modal);
        $data['totalProfit'] = 'Rp. '.number_format($total_profit);

        echo json_encode($data);

    }

    public function getAllReturnedItems()
    {
        $keyword = $this->input->post('term');
        $page = $this->input->post('page');
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        $endCount = $offset + $resultCount;

        $items = searchReturnedItems($keyword, $offset, $endCount);

        $count = count(searchReturnedItems($keyword, $offset, $endCount));

        $morePages = $endCount <= $count;
        $data = [];
        foreach ($items as $key => $value) {
            $dataColumn['text'] = $value['name'];
            $dataColumn['id'] = $value['id'];
            $data[] = $dataColumn;
        }
        echo json_encode(['results' => $data, 'pagination' => array('more' => $morePages)]);
    }

    public function getDataTableCustomersReport()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $sales = $this->report->getDataSalesByPeriod($start_date, $end_date);

        $list = $this->report->getDataTablesCustomer();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $totalNomSales = getDataSalesPeriodCustomer($sales, $field->id, 'nominal');
            $totalModalSales = getDataModalSalesPeriodCustomer($sales, $field->id);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->name;
            $row[] = $field->phone;
            $row[] = $field->address;
            $row[] = getDataSalesPeriodCustomer($sales, $field->id, 'total');
            $row[] = 'Rp. '.number_format($totalNomSales);
            $row[] = 'Rp. '.number_format($totalModalSales);
            $row[] = 'Rp. '.number_format($totalNomSales - $totalModalSales);

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report->countAllCustomer(),
            "recordsFiltered" => $this->report->countFilteredCustomer(),
            "data" => $data,
        );
        echo json_encode($output);
    }

}
/* End of file Report.php */
/* Location: ./application/controllers/Report.php */

 ?>