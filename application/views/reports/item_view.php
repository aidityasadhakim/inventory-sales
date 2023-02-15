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
                    <label for="keyword" class="col-sm-2 col-form-label">Cari Nama Barang</label>
                    <div class="col-sm-3">
                      <input type="text" name="keyword" class="form-control" id="keyword" value="<?php echo (isset($keyword)) ? $keyword : '' ?>" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-info" name="submit" value="view">Submit</button>
                  <a href="<?php echo base_url('report/item') ?>" class="btn btn-warning">Reset</a>
                </form>
                <hr>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $totalItem = 0; $totalPrice = 0; foreach ($items as $key => $value): ?>
                        <tr>
                          <td><?php echo $key + 1; ?></td>
                          <td><?php echo $value['code'] ?></td>
                          <td><?php echo $value['name']; ?></td>
                          <td><?php echo $value['qty'] ?></td>
                          <td>Rp. <?php echo number_format($value['buyPrice']) ?></td>
                          <td>Rp. <?php echo number_format($value['qty'] * $value['buyPrice']) ?></td>
                        </tr>
                      <?php $totalItem += $value['qty']; $totalPrice += ($value['qty'] * $value['buyPrice']); endforeach ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong><?php echo $totalItem; ?></strong></td>
                        <td><strong>Rp. <?php echo number_format($totalPrice); ?></strong></td>
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