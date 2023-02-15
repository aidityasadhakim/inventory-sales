<?php $this->load->view('layouts/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> <?php echo $title; ?> </h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0"><?php echo $title; ?></h5>
              </div>
              <div class="card-body">
                <?php if($this->session->flashdata('msg')): ?>
                  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('msg'); ?>
                  </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('error'); ?>
                  </div>
                <?php endif; ?>
                <p>
                  <a href="<?php echo base_url('retur/add') ?>" class="btn btn-primary">Tambah</a>
                </p>
                <div class="table-responsive">
                  <table class="table table-bordered" id="data-table-return">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Penjualan</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Retur</th>
                        <th>Keterangan</th>
                        <th>#</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($returns as $key => $value): ?>
                        <tr>
                          <td><?php echo $key+1 ?></td>
                          <td><?php echo date('d F Y', strtotime($value['transaction_date'])) ?></td>
                          <td><?php echo $value['s_code'] ?></td>
                          <td><?php echo $value['s_customer_name'] ?></td>
                          <td><?php echo $value['i_name'] ?></td>
                          <td><?php echo $value['qty'] ?></td>
                          <td><?php echo $value['note'] ?></td>
                          <td>
                            <div class="btn-group">
                              <a href="<?php echo base_url('retur/cetak/'.$value['id']); ?>" class="btn btn-default">Cetak</a>
                              <?php if ($value['is_stock'] == 0): ?>
                              <a href="<?php echo base_url('retur/stock/'.$value['id']); ?>" class="btn btn-success" onclick="return confirm('Yakin Kembalikan Stok?');">Kembalikan Stok</a>
                              <?php endif ?>
                              <?php if ($this->session->userdata('level') == 1): ?>
                              <a href="<?php echo base_url('retur/delete/'.$value['id']); ?>" class="btn btn-danger" onclick="return confirm('Yakin Hapus?');">Hapus</a>
                              <?php endif ?>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('layouts/footer'); ?>