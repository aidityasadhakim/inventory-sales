<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    var $table_item = 'items';
    var $table_stock = 'stock_mutations';
    var $table_sale = 'sales';
    var $table_purchase = 'purchases';

    public function getAllItems($value='')
    {
        $this->db->order_by('name', 'asc');
        $this->db->where('deleted_at', null);
        $query = $this->db->get($this->table_item);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataStockByPeriod($start_date, $end_date, $item_id)
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('deleted_at', null);
        $this->db->where('item_id', $item_id);
        if ($start_date != null && $end_date != null) {
            $this->db->where('DATE(created_at) >=', $start_date);
            $this->db->where('DATE(created_at) <=', $end_date);
        }
        $query = $this->db->get($this->table_stock);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataMinStock()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('deleted_at', null);
        $this->db->where('stock < stockMin', NULL);
        $query = $this->db->get($this->table_item);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataCashSaleByPeriod($start_date, $end_date, $method)
    {
        $this->db->order_by('payment_at', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('is_cash', 1);
        $this->db->where('status', 2);
        if ($method != 0) {
            $this->db->where('method_id', $method);
        }
        $this->db->where('DATE(payment_at) >=', $start_date);
        $this->db->where('DATE(payment_at) <=', $end_date);
        $query = $this->db->get($this->table_sale);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataCashPurchaseByPeriod($start_date, $end_date, $method)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('is_cash', 1);
        $this->db->where('status', 2);
        if ($method != 0) {
            $this->db->where('method_id', $method);
        }
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $query = $this->db->get($this->table_purchase);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataSalesByPeriod($start_date, $end_date, $type = '', $is_cash = '', $method = '', $customer = '', $type_service = '')
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('status', 2);
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        if ($type != '') {
            $this->db->where('type', $type);
        }
        if ($is_cash != '') {
            $this->db->where('is_cash', $is_cash);
        }
        if ($method != '') {
            $this->db->where('method_id', $method);
        }
        if ($customer != '') {
            $this->db->where('customer_id', $customer);
        }
        if ($type_service != '') {
            $this->db->where('type_service', $type_service);
        }
        $query = $this->db->get($this->table_sale);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataPurchasesByPeriod($start_date, $end_date)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('status', 2);
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $query = $this->db->get($this->table_purchase);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataSumSalesByPeriod($start_date, $end_date)
    {
        $this->db->select_sum('total');
        $this->db->where('deleted_at', null);
        $this->db->where('status', 2);
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $query = $this->db->get($this->table_sale);
        $data = $query->row_array();
        return $data['total'];
    }

    public function getDataSumPurchasesByPeriod($start_date, $end_date)
    {
        $this->db->select_sum('total');
        $this->db->where('deleted_at', null);
        $this->db->where('status', 2);
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $query = $this->db->get($this->table_purchase);
        $data = $query->row_array();
        return $data['total'];
    }

    public function getDataDebtByPeriod($start_date, $end_date)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('is_cash', 0);
        $this->db->where('status', 2);
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $query = $this->db->get($this->table_purchase);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataClaimByPeriod($start_date, $end_date, $customer_id, $type = '')
    {
        $this->db->order_by('id', 'desc');
        if ($customer_id != 'all') {
            $this->db->where('customer_id', $customer_id);
        }
        if ($type != '') {
            $this->db->where('type', $type);
        }
        $this->db->where('deleted_at', null);
        $this->db->where('is_cash', 0);
        $this->db->where('status', 2);
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $query = $this->db->get($this->table_sale);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataSalesCustomerByPeriod($start_date = null, $end_date = null, $customer_id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('deleted_at', null);
        $this->db->where('status', 2);
        $this->db->where('customer_id', $customer_id);
        if ($start_date != null && $end_date != null) {
            $this->db->where('DATE(transaction_date) >=', $start_date);
            $this->db->where('DATE(transaction_date) <=', $end_date);
        }
        $query = $this->db->get($this->table_sale);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataSaleById($id)
    {
        $this->db->where('deleted_at', null);
        $this->db->where('id', $id);
        $query = $this->db->get('sales');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }
    }

    public function getDataPurchaseById($id)
    {
        $this->db->select('*');
        $this->db->where('p.deleted_at', null);
        $this->db->where('p.id', $id);
        $this->db->from('purchases as p');
        $this->db->join('suppliers as s', 's.id = p.supplier_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else {
            return array();
        }
    }

    public function getAllAvailableItems($search='')
    {
        if ($search == '') {
            $sql = "SELECT i.id, i.code, i.name, COALESCE(sum(s.qty),0) as qty, s.buyPrice FROM 
                    `items` as i LEFT JOIN `stocks` as s ON i.id=s.item_id WHERE qty > 0 AND s.sale_id IS NULL GROUP BY i.id";
        }
        else {
            $sql = "SELECT i.id, i.code, i.name, COALESCE(sum(s.qty),0) as qty, s.buyPrice FROM 
                    `items` as i LEFT JOIN `stocks` as s ON i.id=s.item_id WHERE i.name LIKE '%$search%' AND qty > 0 AND s.sale_id IS NULL GROUP BY i.id";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    public function getDataReturByPeriod($start_date = null, $end_date = null, $customer_id = '', $item_id = null)
    {
        $this->db->select('r.transaction_date, r.qty, r.note, r.sale_id, r.item_id, i.name, s.code, s.customer_name');
        $this->db->where('r.deleted_at', null);
        if ($start_date != null) {
            $this->db->where('DATE(r.transaction_date) >=', $start_date);
            $this->db->where('DATE(r.transaction_date) <=', $end_date);
        }
        if ($customer_id != '') {
            $this->db->where('s.customer_id', $customer_id);
        }
        if ($item_id != null) {
            $this->db->where('r.item_id', $item_id);
        }
        $this->db->from('returns as r');
        $this->db->join('sales as s', 's.id = r.sale_id');
        $this->db->join('items as i', 'i.id = r.item_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }

    //Get Sales Pagination

    var $column_order = array(null, 'transaction_date', 'is_customer', 'customer_id', 'customer_name', 'code', 'total', 'cash', 'changes', 'method_id', 'is_cash', 'status', 'type', 'type_service', 'note');
    var $column_search = array('s.code', 's.customer_name');
    var $order = array('s.id' => 'desc');

    private function _getDatatablesQuery($start_date, $end_date, $type, $is_cash, $method, $customer, $type_service)
    {
        $this->db->select('*');
        $this->db->where('s.deleted_at', null);
        $this->db->where('DATE(s.transaction_date) >=', $start_date);
        $this->db->where('DATE(s.transaction_date) <=', $end_date);
        if ($type != '') {
            $this->db->where('s.type', $type);
        }
        if ($is_cash != '') {
            $this->db->where('s.is_cash', $is_cash);
        }
        if ($method != '') {
            $this->db->where('s.method_id', $method);
        }
        if ($customer != '') {
            $this->db->where('s.customer_id', $customer);
        }
        if ($type_service != '') {
            $this->db->where('s.type_service', $type_service);
        }
        $this->db->from('sales as s');
 
        $i = 0;
     
        foreach ($this->column_search as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function getDataSalesByPeriodPage($start_date = '', $end_date = '', $type = '', $is_cash = '', $method_id = '', $customer_id = '', $type_service = '')
    {
        $this->_getDatatablesQuery($start_date, $end_date, $type, $is_cash, $method_id, $customer_id, $type_service);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
 
    function countFiltered($start_date = '', $end_date = '', $type = '', $is_cash = '', $method_id = '', $customer_id = '', $type_service = '')
    {
        $this->_getDatatablesQuery($start_date, $end_date, $type, $is_cash, $method_id, $customer_id, $type_service);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function countAll($start_date = '', $end_date = '', $type = '', $is_cash = '', $method = '', $customer = '', $type_service = '')
    {
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $this->db->where('deleted_at', null);
        if ($type != '') {
            $this->db->where('type', $type);
        }
        if ($is_cash != '') {
            $this->db->where('is_cash', $is_cash);
        }
        if ($method != '') {
            $this->db->where('method_id', $method);
        }
        if ($customer != '') {
            $this->db->where('customer_id', $customer);
        }
        if ($type_service != '') {
            $this->db->where('type_service', $type_service);
        }
        $this->db->from($this->table_sale);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //End Pagination
    public function sumTotalSale($start_date = '', $end_date = '', $type = '', $is_cash = '', $method = '', $customer = '', $type_service = '')
    {
        $this->db->select_sum('total');
        $this->db->where('DATE(transaction_date) >=', $start_date);
        $this->db->where('DATE(transaction_date) <=', $end_date);
        $this->db->where('deleted_at', null);
        if ($type != '') {
            $this->db->where('type', $type);
        }
        if ($is_cash != '') {
            $this->db->where('is_cash', $is_cash);
        }
        if ($method != '') {
            $this->db->where('method_id', $method);
        }
        if ($customer != '') {
            $this->db->where('customer_id', $customer);
        }
        if ($type_service != '') {
            $this->db->where('type_service', $type_service);
        }
        $this->db->from($this->table_sale);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data['total'];
    }

    public function getDataSummarySalesByPeriod($start_date = '', $end_date = '', $type = '', $is_cash = '', $method = '', $customer = '', $type_service = '')
    {
        $where = "DATE(a.transaction_date) >= '$start_date' AND DATE(a.transaction_date) <= '$end_date'";
        if ($type != '') {
            $where .= " AND a.type = '$type'";
        }
        if ($is_cash != '') {
            $where .= " AND a.is_cash = '$is_cash'";
        }
        if ($method != '') {
            $where .= " AND a.method_id = '$method'";
        }
        if ($customer != '') {
            $where .= " AND a.customer_id = '$customer'";
        }
        if ($type_service != '') {
            $where .= " AND a.type_service = '$type_service'";
        }
        $sql = "SELECT * FROM (SELECT a.id, SUM(buyPrice) modal
                 FROM sales a LEFT JOIN stocks i
                   ON a.id = i.sale_id
                WHERE $where AND a.deleted_at IS NULL AND i.deleted_at IS NULL
                GROUP BY a.id WITH ROLLUP) summary WHERE id IS NULL";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    //get customer pagination

    public function getDataSalesPeriodCustomer($start_date = null, $end_date = null, $offset = null, $limit = null)
    {
        if ($start_date != null && $end_date != null) {
            $sql = "SELECT DISTINCT customers.id, customers.name, customers.phone, customers.address, (SELECT COUNT(*) FROM sales WHERE sales.customer_id = customers.id AND sales.status = 2 AND deleted_at IS NULL AND (transaction_date BETWEEN '$start_date' AND '$end_date')) AS transactionCount, COALESCE((SELECT SUM(total) FROM sales WHERE sales.customer_id = customers.id AND sales.status = 2 AND deleted_at IS NULL AND (transaction_date BETWEEN '$start_date' AND '$end_date')),0) AS transactionNominalCount, (SELECT SUM(stocks.buyPrice) FROM stocks WHERE sale_id IN (SELECT sales.id FROM sales WHERE sales.customer_id = customers.id AND sales.status = 2 AND deleted_at IS NULL AND (transaction_date BETWEEN '$start_date' AND '$end_date'))) AS modalCount FROM customers USE INDEX(PRIMARY) Order BY transactionNominalCount DESC";
        }
        else {
            $sql = "SELECT DISTINCT customers.id, customers.name, customers.phone, customers.address, (SELECT COUNT(*) FROM sales WHERE sales.customer_id = customers.id AND sales.status = 2 AND deleted_at IS NULL) AS transactionCount, COALESCE((SELECT SUM(total) FROM sales WHERE sales.customer_id = customers.id AND sales.status = 2 AND deleted_at IS NULL),0) AS transactionNominalCount, (SELECT SUM(stocks.buyPrice) FROM stocks WHERE sale_id IN (SELECT sales.id FROM sales WHERE sales.customer_id = customers.id AND sales.status = 2 AND deleted_at IS NULL)) AS modalCount FROM customers USE INDEX(PRIMARY) Order BY transactionNominalCount DESC";
        }
        if ($offset != null && $limit != null) {
            $sql .= " LIMIT $offset,$limit";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    var $column_order_customer = array(null, 'name', 'phone', 'address');
    var $column_search_customer = array('name');
    var $order_customer = array('name' => 'asc');
    private function _getDatatablesQueryCustomer()
    {
        $this->db->where('deleted_at', null);
        $this->db->from('customers');
 
        $i = 0;
     
        foreach ($this->column_search_customer as $item)
        {
            if($_POST['search']['value'])
            {
                 
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search_customer) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order_customer[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order_customer))
        {
            $order = $this->order_customer;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function getDataTablesCustomer()
    {
        $this->_getDatatablesQueryCustomer();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function countFilteredCustomer()
    {
        $this->_getDatatablesQueryCustomer();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function countAllCustomer()
    {
        $this->db->where('deleted_at', null);
        $this->db->from('customers');
        $query = $this->db->get();
        return $query->num_rows();
    }

}

/* End of file Reportmodel.php */
/* Location: ./application/models/Reportmodel.php */
 ?>