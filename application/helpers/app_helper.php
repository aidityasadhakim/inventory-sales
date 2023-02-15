<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('isLogin'))
{
function isLogin() {
        $ci = &get_instance();
        if ($ci->session->userdata('is_login') == TRUE) {
            return TRUE;
        } else {
            $ci->session->set_flashdata('error', 'Anda tidak memiliki hak akses');
            redirect('login');
        }
    }
}

if (!function_exists('isLoginAdmin'))
{
function isLoginAdmin() {
        $ci = &get_instance();
        if ($ci->session->userdata('is_login') == TRUE && $ci->session->userdata('level') == 1 ) {
            return TRUE;
        } else {
            $ci->session->set_flashdata('error', 'Anda tidak memiliki hak akses');
            redirect('login');
        }
    }
}

if (!function_exists('getLabelLevelUser'))
{
function getLabelLevelUser($level) {
        if ($level == 1) {
            return 'Administrator';
        } 
        else if ($level == 2) {
            return 'Sub Admin';
        }
        else if ($level == 3) {
            return 'Operator';
        }
    }
}

if (!function_exists('getLabelTypeTransaction'))
{
function getLabelTypeTransaction($type) {
        if ($type == 'sale') {
            return 'Penjualan';
        } 
        elseif ($type == 'service') {
            return 'Servis';
        }
        elseif ($type == 'purchase') {
            return 'Pembelian';
        }
        elseif ($type == 'stock') {
            return 'Stok';
        }
    }
}

if (!function_exists('getDataColumn'))
{
function getDataColumn($table, $condition, $value, $field) {
        $CI =& get_instance();
        $CI->db->where($condition, $value);
        $query = $CI->db->get($table);
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            return $data[$field];
        }
        else {
            return null;
        }
    }
}

if (!function_exists('decreaseStock'))
{
function decreaseStock($item_id = '', $qty) {
        $CI =& get_instance();
        $CI->db->set('stock', 'stock - '.$qty, FALSE);
        $CI->db->where('id', $item_id);
        $CI->db->where('stock >=', $qty);
        $CI->db->update('items');
        return $CI->db->affected_rows();
    }
}

if (!function_exists('increaseStock'))
{
function increaseStock($item_id = '', $qty) {
        $CI =& get_instance();
        $CI->db->set('stock', 'stock + '.$qty, FALSE);
        $CI->db->where('id', $item_id);
        $CI->db->update('items');
    }
}

if (!function_exists('getMaxPrice'))
{
function getMaxPrice($item_id) {
        $CI =& get_instance();
        $CI->db->select_max('buyPrice');
        $CI->db->where('item_id', $item_id);
        $CI->db->where('sale_id IS NULL', null, false);
        $CI->db->where('deleted_at', null);
        $query = $CI->db->get('stocks');
        $data = $query->row_array();
        return $data['buyPrice'];
    }
}

if (!function_exists('getMinPrice'))
{
function getMinPrice($item_id) {
        $CI =& get_instance();
        $CI->db->select_min('buyPrice');
        $CI->db->where('item_id', $item_id);
        $CI->db->where('sale_id IS NULL', null, false);
        $CI->db->where('deleted_at', null);
        $query = $CI->db->get('stocks');
        $data = $query->row_array();
        return $data['buyPrice'];
    }
}

if (!function_exists('getTotalBuyPrice'))
{
function getTotalBuyPrice($sale_id) {
        $CI =& get_instance();
        $CI->db->select_sum('buyPrice');
        $CI->db->where('sale_id', $sale_id);
        $CI->db->where('deleted_at', null);
        $query = $CI->db->get('stocks');
        $data = $query->row_array();
        if (!empty($data['buyPrice'])) {
            return $data['buyPrice'];
        }
        else {
            return 0;
        }
    }
}

if (!function_exists('getStockAvailable'))
{
function getStockAvailable($item_id) {
        $CI =& get_instance();
        $CI->db->select_sum('qty');
        $CI->db->where('item_id', $item_id);
        $CI->db->where('sale_id IS NULL', null, false);
        $CI->db->where('deleted_at', null);
        $query = $CI->db->get('stocks');
        $data = $query->row_array();
        if (!empty($data['qty'])) {
            return $data['qty'];
        }
        else {
            return 0;
        }
    }
}

if (!function_exists('getLatestPrice'))
{
function getLatestPrice($item_id) {
        $CI =& get_instance();
        $CI->db->select('buyPrice');
        $CI->db->where('item_id', $item_id);
        $CI->db->where('sale_id IS NULL', null, false);
        $CI->db->where('deleted_at', null);
        $CI->db->order_by('id', 'desc');
        $CI->db->limit(1);
        $query = $CI->db->get('stocks');
        $data = $query->row_array();
        return $data['buyPrice'];
    }
}

if (!function_exists('getItemBuyPrice'))
{
function getItemBuyPrice($sale_id, $item_id) {
        $CI =& get_instance();
        $CI->db->select_sum('buyPrice');
        $CI->db->where('sale_id', $sale_id);
        $CI->db->where('item_id', $item_id);
        $CI->db->where('deleted_at', null);
        $query = $CI->db->get('stocks');
        $data = $query->row_array();
        if (!empty($data['buyPrice'])) {
            return $data['buyPrice'];
        }
        else {
            return 0;
        }
    }
}

if (!function_exists('getTotalBuyPriceTeknisi'))
{
function getTotalBuyPriceTeknisi($sale_id) {
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->where('sale_id', $sale_id);
        $query = $CI->db->get('sale_details');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            $price = 0;
            foreach ($data as $key => $value) {
                $price += ($value['price'] * $value['qty']);
            }
            return $price;
        }
        else {
            return 0;
        }
    }
}

if (!function_exists('searchReturnedItems'))
{
function searchReturnedItems($keyword, $offset, $limit) {
        $CI =& get_instance();
        $CI->db->select('*')->from('items')->like('name', $keyword)->order_by('name', 'asc')->limit($limit, $offset)->where('`id` IN (SELECT `item_id` FROM `returns` GROUP BY item_id)', NULL, FALSE);
        $query = $CI->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return array();
        }
    }
}
