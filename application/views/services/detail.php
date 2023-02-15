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
                      <td><strong>Nama Pelanggan</strong></td>
                      <td>: <?php echo $row['customer_name']; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Keterangan</strong></td>
                      <td>: <?php echo $row['note']; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Jenis Servis</strong></td>
                      <td>: <?php echo ucfirst($row['type_service']); ?></td>
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
                      <thead>
                        <tr>
                          <th width="30%">Nama Barang</th>
                          <?php if ($this->session->userdata('level') == 1): ?>
                          <th>Harga Pokok</th>
                          <?php endif ?>
                          <th>Jumlah</th>
                        </tr>
                      </thead>
                      <?php $totalModal = 0; if (!empty($details)): ?>
                      <tbody>
                        <?php foreach ($details as $key => $value): ?>
                          <tr>
                            <td><?php echo getDataColumn('items', 'id', $value['item_id'], 'name'); ?></td>
                            <?php if ($this->session->userdata('level') == 1): ?>
                            <td>Rp. <?php echo number_format(getItemBuyPrice($value['sale_id'], $value['item_id'])); ?></td>
                            <?php endif ?>
                            <td><?php echo $value['qty']; ?></td>
                          </tr>
                        <?php $totalModal += getItemBuyPrice($value['sale_id'], $value['item_id']); endforeach ?>
                      </tbody>
                      <?php endif ?>
                      <tfoot>
                        <tr>
                          <td class="text-right"><strong>Total Seluruh</strong></td>
                          <?php if ($this->session->userdata('level') == 1): ?>
                          <td>Rp. <?php echo number_format($totalModal) ?></td>
                          <?php endif ?>
                          <td>Rp. <?php echo number_format($row['total']) ?></td>
                        </tr>
                        <?php if ($this->session->userdata('level') == 1): ?>
                        <tr>
                          <td class="text-right"><strong>Profit</strong></td>
                          <td>&nbsp;</td>
                          <td>Rp. <?php echo number_format($row['total'] - $totalModal) ?></td>
                        </tr>
                        <?php endif ?>
                        <tr id="tr-cash">
                          <td class="text-right"><strong>Bayar</strong></td>
                          <?php if ($this->session->userdata('level') == 1): ?>
                          <td>&nbsp;</td>
                          <?php endif ?>
                          <td>Rp. <?php echo number_format($row['cash']) ?></td>
                        </tr>
                        <tr id="tr-changes">
                          <td class="text-right"><strong>Kembalian</strong></td>
                          <?php if ($this->session->userdata('level') == 1): ?>
                          <td>&nbsp;</td>
                          <?php endif ?>
                          <td>Rp. <?php echo number_format($row['changes']) ?></td>
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