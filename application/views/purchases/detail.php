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
                <p>
                  <button type="button" onclick="window.close()" class="btn btn-default">Kembali</button>
                </p>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <td width="30%"><strong>Tanggal Transaksi</strong></td>
                      <td>: <?php echo date('d F Y', strtotime($row['transaction_date'])); ?></td>
                    </tr>
                    <tr>
                      <td><strong>Nama Pemasok</strong></td>
                      <td>: <?php echo getDataColumn('suppliers', 'id', $row['supplier_id'], 'name'); ?></td>
                    </tr>
                    <tr>
                      <td><strong>Keterangan</strong></td>
                      <td>: <?php echo $row['note']; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Metode Pembayaran</strong></td>
                      <td>: <?php echo getDataColumn('payment_methods', 'id', $row['method_id'], 'name'); ?></td>
                    </tr>
                    <tr>
                      <td><strong>Status Pembayaran</strong></td>
                      <td>: <?php echo ($row['is_cash'] == 1) ? 'Lunas' : 'Utang'; ?></td>
                    </tr>
                  </table>
                </div>
                <div class="table-responsive">
                    <table class="table">
                      <?php if (!empty($details)): ?>
                      <thead>
                        <tr>
                          <th width="30%">Nama Barang</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Subtotal</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($details as $key => $value): ?>
                          <tr>
                            <td><?php echo $value['name']; ?></td>
                            <td>Rp. <?php echo number_format($value['price']); ?></td>
                            <td><?php echo $value['qty']; ?></td>
                            <td>Rp. <?php echo number_format($value['price'] * $value['qty']); ?></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                      <?php endif ?>
                      <tfoot>
                        <tr>
                          <td colspan="3" class="text-right"><strong>Total Seluruh</strong></td>
                          <td colspan="2">Rp. <?php echo number_format($row['total']) ?></td>
                        </tr>
                        <tr id="tr-cash">
                          <td colspan="3" class="text-right"><strong>Bayar</strong></td>
                          <td colspan="2">Rp. <?php echo number_format($row['cash']) ?></td>
                        </tr>
                        <tr id="tr-changes">
                          <td colspan="3" class="text-right"><strong>Kembalian</strong></td>
                          <td colspan="2">Rp. <?php echo number_format($row['changes']) ?></td>
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