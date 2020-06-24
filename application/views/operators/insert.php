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
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-4">
                      <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-4">
                      <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="level" class="col-sm-2 col-form-label">Hak Akses</label>
                    <div class="col-sm-3">
                      <select name="level" class="form-control" id="level" required>
                        <option value="2">Sub Admin</option>
                        <option value="3">Operator</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="password" class="form-control" id="password" minlength="8" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="confirm_password" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password" minlength="8">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="submit" value="add">Submit</button>
                  <a href="<?php echo base_url('operator') ?>" class="btn btn-default float-right">Cancel</a>
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