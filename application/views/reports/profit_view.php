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
                    <label for="type" class="col-sm-2 col-form-label">Tipe</label>
                    <div class="col-sm-3">
                      <select name="type" class="form-control select2" id="type">
                        <option value=""<?php if (isset($type)) echo ($type == '') ? ' selected' : '' ?>>Semua</option>
                        <option value="sale"<?php if (isset($type)) echo ($type == 'sale') ? ' selected' : '' ?>>Penjualan</option>
                        <option value="service"<?php if (isset($type)) echo ($type == 'service') ? ' selected' : '' ?>>Servis</option>
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
                  <button type="button" class="btn btn-info" name="submit" value="view" id="submit">Lihat Rincian</button>
                  <button type="button" class="btn btn-success" name="submit" value="view" id="submit-rekap">Lihat Rekap</button>
                </form>
                  <hr>
                  <div id="table-detail" style="display: none">
                  <h4>Rincian Laba/Rugi Periode <span class="showStartDate"></span> - <span class="showEndDate"></span></h4>
                  <div class="table-responsive mt-10">
                    <table class="table table-bordered" id="data-table-profit-general">
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
                        
                      </tbody>
                    </table>
                  </div>
                  </div>
                  <div id="table-recap" style="display: none">
                  <h4>Rekapitulasi Laba/Rugi Periode <span class="showStartDate"></span> - <span class="showEndDate"></span></h4>
                  <div class="table-responsive mt-10">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Total Transaksi Penjualan</th>
                          <th>Total Modal</th>
                          <th>Total Laba (Rugi)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr id="row-loading">
                          <td colspan="3" class="text-center">Loading...</td>
                        </tr>
                        <tr>
                          <td><strong><span id="totalSale"></span></strong></td>
                          <td><strong><span id="totalModal"></span></strong></td>
                          <td><strong><span id="totalProfit"></span></strong></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
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
<script type="text/javascript">
$(function () {
  function dateFormatter(date) {
    var date = new Date(date);
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var day = date.getDate();
    var month = months[date.getMonth()];
    var year = date.getFullYear();

    return day + ' ' + month + ' ' + year;
  }
  $('#submit').click(function(event) {
    $('#table-detail').show();
    $('#table-recap').hide();
    $('#data-table-profit-general').DataTable({ 
      "destroy": true, 
      "processing": true, 
      "serverSide": true, 
      "order": [], 
       
      "ajax": {
          "url": "<?php echo base_url('report/getDataSalePage')?>",
          "type": "POST",
          "data": {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            customer_id: $('#customer_id').val(),
            type: $('#type').val(),
            is_cash: $('#is_cash').val(),
            method_id: $('#method_id').val(),
          }
      },

       
      "columnDefs": [
      { 
          "targets": [ 0 ], 
          "orderable": false, 
      },
      ],

    });

    $('.showStartDate').text(dateFormatter($('#start_date').val()));
    $('.showEndDate').text(dateFormatter($('#end_date').val()));
  });

  $('#submit-rekap').click(function(event) {
    $('#table-detail').hide();
    $('#table-recap').show();
    $('#row-loading').show();
    $.ajax({
      url: '<?php echo base_url('report/getRecapDataSale')?>',
      type: 'POST',
      dataType: 'json',
      data: {
        start_date: $('#start_date').val(),
        end_date: $('#end_date').val(),
        customer_id: $('#customer_id').val(),
        type: $('#type').val(),
        is_cash: $('#is_cash').val(),
        method_id: $('#method_id').val(),
      },
    })
    .done(function(data) {
      $('#totalSale').text(data.totalSale);
      $('#totalModal').text(data.totalModal);
      $('#totalProfit').text(data.totalProfit);
      $('#row-loading').hide();
      console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
      $('.showStartDate').text(dateFormatter($('#start_date').val()));
      $('.showEndDate').text(dateFormatter($('#end_date').val()));
    });
    
  });
});
</script>