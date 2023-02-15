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
                    <div class="offset-sm-2 col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_date" name="is_date" value="1"<?php if (isset($is_date)) echo ($is_date == 1) ? ' checked' : ''; ?>>
                        <label class="form-check-label" for="is_date">Berdasarkan Tanggal?</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="start_date" class="col-sm-2 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-3">
                      <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo (isset($start_date)) ? $start_date : null ?>" <?php if (isset($is_date)) echo ($is_date == 1) ? 'required' : 'disabled'; else echo 'disabled'; ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="end_date" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-3">
                      <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo (isset($end_date)) ? $end_date : null ?>" <?php if (isset($is_date)) echo ($is_date == 1) ? 'required' : 'disabled'; else echo 'disabled'; ?>>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-info" name="submit" value="view">Submit</button>
                </form>
                <br><br>
                <?php if (isset($sales)): ?>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Pelanggan</th>
                          <th>Kontak</th>
                          <th>Alamat</th>
                          <th>Jumlah Transaksi</th>
                          <th>Total Nominal Transaksi</th>
                          <th>Total Modal</th>
                          <th>Laba</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($sales as $key => $value): ?>
                          <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo $value['name'] ?></td>
                            <td><?php echo $value['phone'] ?></td>
                            <td><?php echo $value['address'] ?></td>
                            <td><?php echo $value['transactionCount'] ?></td>
                            <?php if ($start_date != null && $end_date != null): ?>
                              <td><a href="<?php echo base_url('report/omzet_customer_detail/'.$value['id'].'/'.$start_date.'/'.$end_date) ?>" target="_blank">Rp. <?php echo number_format($value['transactionNominalCount']) ?></a></td>
                            <?php else: ?>
                              <td><a href="<?php echo base_url('report/omzet_customer_detail/'.$value['id']) ?>" target="_blank">Rp. <?php echo number_format($value['transactionNominalCount']) ?></a></td>
                            <?php endif ?>
                            
                            <td>Rp. <?php echo number_format($value['modalCount']) ?></td>
                            <td>Rp. <?php echo number_format($value['transactionNominalCount'] - $value['modalCount']) ?></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                  <form class="form-inline" method="post" target="_blank">
                    <input type="hidden" name="start_date" value="<?php echo (isset($start_date)) ? $start_date : null ?>">
                    <input type="hidden" name="end_date" value="<?php echo (isset($end_date)) ? $end_date : null ?>">
                    <label class="my-1 mr-2" for="start_page">Dari Data Ke </label>
                    <input type="number" name="start_page" class="form-control my-1 mr-sm-2" id="start_page" value="1" onchange="document.getElementById('end_page').min=this.value;">

                    <label class="my-1 mr-2" for="end_page">Sampai</label>
                    <input type="number" name="end_page" class="form-control my-1 mr-sm-2" id="end_page" value="10" min="1">

                    <button type="submit" class="btn btn-warning my-1" name="submit" value="cetak">Cetak</button>
                  </form>
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
      $('#start_date').prop('required', 'required');
      $('#start_date').removeAttr('disabled');
      $('#end_date').prop('required', 'required');
      $('#end_date').removeAttr('disabled');
    }
    else {
      $('#start_date').prop('disabled', 'disabled');
      $('#start_date').removeAttr('required');
      $('#end_date').prop('disabled', 'disabled');
      $('#end_date').removeAttr('required');
    }
    resetItem();
  });
});
</script>