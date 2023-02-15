<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Istana HP Sales &amp; Inventory | <?php echo $title ?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    .select2-selection--single {
      height: 100% !important;
    }
    .select2-selection__rendered{
      word-wrap: break-word !important;
      text-overflow: inherit !important;
      white-space: normal !important;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="<?php echo base_url('dashboard') ?>" class="navbar-brand">
        <img src="<?php echo base_url('assets') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">ISTANA HP</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo base_url('dashboard') ?>" class="nav-link">Dasbor</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Data Master</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?php echo base_url('item') ?>" class="dropdown-item">Barang</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('customer') ?>" class="dropdown-item">Pelanggan</a></li>
              <?php if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2): ?>
              <li><a href="<?php echo base_url('supplier') ?>" class="dropdown-item">Pemasok</a></li>
              <?php endif ?>
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('PaymentMethod') ?>" class="dropdown-item">Jenis Pembayaran</a></li>
              <?php if ($this->session->userdata('level') == 1): ?>
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('operator') ?>" class="dropdown-item">Operator</a></li>  
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('percentage/index/harga-umum') ?>" class="dropdown-item">Persentase Harga Umum</a></li>  
              <li><a href="<?php echo base_url('paper') ?>" class="dropdown-item">Pengaturan Kertas Nota</a></li>  
              <?php endif ?>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Penjualan</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?php echo base_url('sale') ?>" class="dropdown-item">Nota Jual </a></li>
              <li><a href="<?php echo base_url('pending') ?>" class="dropdown-item">Nota Jual Sementara</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('service') ?>" class="dropdown-item">Nota Servis</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('retur') ?>" class="dropdown-item">Retur</a></li>
            </ul>
          </li>
          <?php if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2): ?>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pembelian</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?php echo base_url('purchase') ?>" class="dropdown-item">Nota Beli </a></li>
            </ul>
          </li>
          <?php endif ?>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <?php if ($this->session->userdata('level') == 1): ?>
              <li><a href="<?php echo base_url('report/item') ?>" class="dropdown-item">Laporan Stok </a></li>
              <?php endif ?>
              <li><a href="<?php echo base_url('report/stock') ?>" class="dropdown-item">Laporan Mutasi Stok </a></li>
              <li><a href="<?php echo base_url('report/min_stock') ?>" class="dropdown-item">Laporan Stok Hampir habis</a></li>
              <li><a href="<?php echo base_url('report/cash_in') ?>" class="dropdown-item">Laporan Kas Masuk</a></li>
              <?php if ($this->session->userdata('level') == 1): ?>
              <li><a href="<?php echo base_url('report/cash_out') ?>" class="dropdown-item">Laporan Kas Keluar</a></li>
              <?php endif ?>
              <li class="dropdown-divider"></li>
              <li><a href="<?php echo base_url('report/sales') ?>" class="dropdown-item">Laporan Penjualan</a></li>
              <?php if ($this->session->userdata('level') == 1): ?>
              <li><a href="<?php echo base_url('report/purchases') ?>" class="dropdown-item">Laporan Pembelian</a></li>
              <li><a href="<?php echo base_url('report/retur') ?>" class="dropdown-item">Laporan Retur</a></li>
              <?php endif ?>
              <li><a href="<?php echo base_url('report/customers') ?>" class="dropdown-item">Laporan Per Pelanggan</a></li>
              <li class="dropdown-divider"></li>
              <?php if ($this->session->userdata('level') == 1): ?>
              <li><a href="<?php echo base_url('report/profit_technician') ?>" class="dropdown-item">Laporan Setor Teknisi</a></li>
              <li><a href="<?php echo base_url('report/omzet_customers') ?>" class="dropdown-item">Laporan Omzet Pelanggan</a></li>
              <li><a href="<?php echo base_url('report/profit') ?>" class="dropdown-item">Laporan Laba/Rugi</a></li>
              <li><a href="<?php echo base_url('report/profit_service') ?>" class="dropdown-item">Laporan Laba/Rugi Servis</a></li>
              <li><a href="<?php echo base_url('report/debt') ?>" class="dropdown-item">Laporan Utang</a></li>
              <?php endif ?>
              <li><a href="<?php echo base_url('report/claim') ?>" class="dropdown-item">Laporan Piutang</a></li>
            </ul>
          </li>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url('assets') ?>/dist/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline"><?php echo $this->session->userdata('full_name'); ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-primary">
              <img src="<?php echo base_url('assets') ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

              <p>
                <?php echo $this->session->userdata('full_name'); ?> - <?php echo getLabelLevelUser($this->session->userdata('level')); ?>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <a href="<?php echo base_url('setting') ?>" class="btn btn-default btn-flat">Pengaturan</a>
              <a href="<?php echo base_url('dashboard/logout') ?>" class="btn btn-default btn-flat float-right">Keluar</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->
