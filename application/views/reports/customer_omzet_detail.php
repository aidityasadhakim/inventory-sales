<?php $this->load->view('layouts/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark"> <?php echo $title; ?> </h1> -->
          </div>
        </div>
      </div>
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
                  <div class="table-responsive">
                    <table class="table table-bordered" id="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal Transaksi</th>
                          <th>Nama Pelanggan</th>
                          <th>Total Harga</th>
                          <th>Status Bayar</th>
                          <th>Metode Pembayaran</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $total = 0; foreach ($sales as $key => $value): ?>
                          <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo date('d F Y', strtotime($value['transaction_date'])); ?></td>
                            <td><?php echo '<a href="'.base_url('sale/detail/'.$value['id']).'" target="_blank">'.$value['customer_name'].'</a>'; ?></td>
                            <td><?php echo 'Rp. '.number_format($value['total']); ?></td>
                            <td><?php echo ($value['is_cash'] == 1) ? 'Lunas' : 'Utang'; ?></td>
                            <td><?php echo getDataColumn('payment_methods', 'id', $value['method_id'], 'name'); ?></td>
                            <td><?php echo $value['note']; ?></td>
                          </tr>
                        <?php $total += $value['total']; endforeach ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"><strong>Total Keseluruhan</strong></td>
                          <td colspan="4"><strong>Rp. <?php echo number_format($total) ?></strong></td>
                        </tr>
                      </tfoot>  
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