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
              <form class="form-horizontal" method="post">
                <div class="card-body">
                  <?php if($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php endif; ?>
                  <?php if($this->session->flashdata('msg')): ?>
                  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('msg'); ?>
                  </div>
                  <?php endif; ?>
                  <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Nama Toko</label>
                    <div class="col-sm-4">
                      <input type="text" name="title" class="form-control" id="title" value="<?php echo $row['title'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-5">
                      <input type="text" name="address" class="form-control" id="address" value="<?php echo $row['address'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="width" class="col-sm-2 col-form-label">No Kontak</label>
                    <div class="col-sm-5">
                      <input type="text" name="subtitle" class="form-control" id="subtitle" value="<?php echo $row['subtitle'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="width" class="col-sm-2 col-form-label">Lebar Kertas (milimeter)</label>
                    <div class="col-sm-2">
                      <div class="input-group mb-2">
                        <input type="text" name="width" class="form-control" id="width" value="<?php echo $row['width'] ?>" required>
                        <div class="input-group-append">
                          <div class="input-group-text">mm</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="submit" value="add">Submit</button>
                </div>
              </form>
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