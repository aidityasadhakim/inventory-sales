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
                <h5 class="card-title m-0"><?php echo $title; ?> - <?php echo $row['name']; ?></h5>
              </div>
              <div class="card-body">
                <p>
                  <a href="<?php echo base_url('item') ?>" class="btn btn-default">Kembali</a>
                </p>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Jumlah Stok</th>
                        <th>Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $total = 0; foreach ($stocks as $key => $value): ?>
                        <tr>
                          <td><?php echo $key+1; ?></td>
                          <td><?php echo $value['qty']; ?></td>
                          <td>Rp. <?php echo number_format($value['buyPrice']); ?></td>
                        </tr>
                      <?php $total += $value['qty']; endforeach ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td><strong>Total</strong></td>
                        <td colspan="2"><strong><?php echo $total; ?></strong></td>
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