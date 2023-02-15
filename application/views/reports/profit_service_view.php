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
                <form class="form-horizontal" method="post">
                  <div class="form-group row">
                    <label for="start_date" class="col-sm-2 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-3">
                      <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo (isset($start_date)) ? $start_date : date('Y-m-d') ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="end_date" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-3">
                      <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo (isset($end_date)) ? $end_date : date('Y-m-d') ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="customer_id" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                    <div class="col-sm-3">
                      <select name="customer_id" class="form-control select2" id="customer_id">
                        <option value=""<?php if (isset($customer_id)) echo ($customer_id == '') ? ' selected' : ''; ?>>Semua</option>
                      <?php 
                      foreach ($customers as $key => $value): 
                        $selected = '';
                        if (isset($customer_id)) {
                          $selected = ($customer_id == $value['id']) ? ' selected' : '';
                        }
                      ?>
                        <option value="<?php echo $value['id'] ?>"<?php echo $selected; ?>><?php echo $value['name'] ?></option>
                      <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">Tipe Servis</label>
                    <div class="col-sm-3">
                      <select name="type" class="form-control select2" id="type">
                        <option value=""<?php if (isset($type)) echo ($type == '') ? ' selected' : '' ?>>Semua</option>
                        <option value="hardware"<?php if (isset($type)) echo ($type == 'hardware') ? ' selected' : '' ?>>Hardware</option>
                        <option value="software"<?php if (isset($type)) echo ($type == 'software') ? ' selected' : '' ?>>Software</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="is_cash" class="col-sm-2 col-form-label">Tunai/Utang</label>
                    <div class="col-sm-3">
                      <select name="is_cash" class="form-control select2" id="is_cash">
                        <option value=""<?php if (isset($is_cash)) echo ($is_cash == '') ? ' selected' : '' ?>>Semua</option>
                        <option value="1"<?php if (isset($is_cash)) echo ($is_cash == '1') ? ' selected' : '' ?>>Tunai</option>
                        <option value="0"<?php if (isset($is_cash)) echo ($is_cash == '0') ? ' selected' : '' ?>>Utang</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="method_id" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-3">
                      <select name="method_id" class="form-control select2" id="method_id">
                        <option value=""<?php if (isset($method_id)) echo ($method_id == '') ? ' selected' : '' ?>>Semua</option>
                      <?php 
                      foreach ($methods as $key => $value): 
                        $selected = '';
                        if (isset($method_id)) {
                          $selected = ($method_id == $value['id']) ? ' selected' : '';
                        }
                      ?>
                        <option value="<?php echo $value['id'] ?>"<?php echo $selected; ?>><?php echo $value['name'] ?></option>
                      <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-info" name="submit" value="view">Submit</button>
                </form>
                <?php if (isset($sales)): ?>
                  <hr>
                  <h4>Laba/Rugi Servis <?php echo ucfirst($type) ?> Periode <?php echo date('d F Y', strtotime($start_date)) ?> - <?php echo date('d F Y', strtotime($end_date)) ?></h4>
                  <div class="table-responsive mt-10">
                    <table class="table table-bordered" id="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Kode Transaksi</th>
                          <th>Nama Pelanggan</th>
                          <th>Total Transaksi</th>
                          <th>Modal</th>
                          <th>Laba (Rugi)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $total_sale = 0;
                        $total_modal = 0;
                        foreach ($sales as $key => $value): 
                        ?>
                        <tr>
                          <td><?php echo $key+1 ?></td>
                          <td><?php echo date('d F Y', strtotime($value['transaction_date'])) ?></td>
                          <td>IHS<?php echo $value['id'] ; ?></td>
                          <td><a href="<?php echo base_url('service/detail/'.$value['id']) ?>" target="_blank"><?php echo $value['customer_name']; ?></a></td>
                          <td>Rp. <?php echo number_format($value['total']); ?></td>
                          <td>Rp. <?php echo number_format(getTotalBuyPrice($value['id'])); ?></td>
                          <td>
                            <?php $total_profit = $value['total'] - getTotalBuyPrice($value['id']); if ($total_profit < 0): ?>
                              Rp. (<?php echo number_format($total_profit) ?>)
                            <?php else: ?>
                              Rp. <?php echo number_format($total_profit) ?>
                            <?php endif ?>
                          </td>
                        </tr>
                        <?php 
                        $total_sale += $value['total'];
                        $total_modal += getTotalBuyPrice($value['id']);
                        endforeach 
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4"><strong>Total</strong></td>
                          <td><strong>Rp. <?php echo number_format($total_sale); ?></strong></td>
                          <td><strong>Rp. <?php echo number_format($total_modal); ?></strong></td>
                          <td><strong>Rp. <?php echo number_format($total_sale - $total_modal); ?></strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                <?php endif ?>
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