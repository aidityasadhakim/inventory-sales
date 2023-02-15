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
                    <label for="item_id" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-4">
                      <select name="item_id" class="form-control select2" id="item_id" required>
                        <option value="">--Pilih Barang--</option>
                      <?php 
                      foreach ($items as $key => $value): 
                        $selected = '';
                        if (isset($item_id)) {
                          $selected = ($item_id == $value['id']) ? ' selected' : '';
                        }
                      ?>
                        <option value="<?php echo $value['id'] ?>"<?php echo $selected; ?>><?php echo $value['name'] ?></option>
                      <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_date" name="is_date" value="1"<?php if (isset($is_date)) echo ($is_date == 1) ? ' checked' : '' ?>>
                        <label class="form-check-label" for="is_date">Berdasarkan Tanggal?</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="start_date" class="col-sm-2 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-3">
                      <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo (isset($start_date)) ? $start_date : date('Y-m-d') ?>" required<?php if (isset($is_date)) echo ($is_date == 1) ? '' : ' disabled'; else echo ' disabled'; ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="end_date" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-3">
                      <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo (isset($end_date)) ? $end_date : date('Y-m-d') ?>" required<?php if (isset($is_date)) echo ($is_date == 1) ? '' : ' disabled'; else echo ' disabled'; ?>>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-info" name="submit" value="view">Submit</button>
                </form>
                <br><br>
                <?php if (isset($stocks)): ?>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal Transaksi</th>
                          <th>Kode Transaksi</th>
                          <th>Pemasok/Pelanggan</th>
                          <th>Jumlah</th>
                          <th>Keterangan</th>
                          <th>Jenis Transaksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $sumStock = 0; foreach ($stocks as $key => $value): ?>
                          <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo date('d F Y H:i:s', strtotime($value['created_at'])) ?></td>
                            <td>
                              <?php 
                              if ($value['type'] == 'sale' || $value['type'] == 'sale') {
                                $dataSale = $this->report->getDataSaleById($value['transaction_id']);
                                $link = base_url('sale/detail/'.$value['transaction_id']);
                                $code = $dataSale['code'];
                                $name = $dataSale['customer_name'];
                              }
                              elseif ($value['type'] == 'purchase') {
                                $dataPurchase = $this->report->getDataPurchaseById($value['transaction_id']);
                                $link = base_url('purchase/detail/'.$value['transaction_id']);
                                $code = $dataPurchase['code'];
                                $name = $dataPurchase['name'];
                              }
                              elseif ($value['type'] == 'stock') {
                                $code = '-';
                                $link = '#';
                                $name = '-';
                              }
                              ?>
                              <a href="<?php echo $link ?>" target="_blank"><?php echo $code; ?></a>
                            </td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $value['amount']; ?></td>
                            <td><?php echo $value['note'] ?></td>
                            <td><?php echo getLabelTypeTransaction($value['type']) ?></td>
                          </tr>
                        <?php $sumStock += $value['amount']; endforeach ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4"><strong>Jumlah Stok Tersedia</strong></td>
                          <td colspan="3"><strong><?php echo $item['stock'] ?></strong></td>
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
<script type="text/javascript">
  $(function() {
    $('#is_date').click(function(event) {
      if($(this).prop('checked')) {
        $('#start_date').removeAttr('disabled');
        $('#end_date').removeAttr('disabled');
      }
      else {
        $('#start_date').prop('disabled', 'disabled');
        $('#end_date').prop('disabled', 'disabled');
      }
    }); 
  });
</script>