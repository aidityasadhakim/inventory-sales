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
                <?php if($this->session->flashdata('msg')): ?>
                  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('msg'); ?>
                  </div>
                <?php endif; ?>
                <div class="table-responsive">
                  <table class="table table-bordered" id="data-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul Toko</th>
                        <th>Alamat</th>
                        <th>No Kontak</th>
                        <th>Ukuran Kertas</th>
                        <th>Default</th>
                        <th>#</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($papers as $key => $value): ?>
                        <tr>
                          <td><?php echo $key+1 ?></td>
                          <td><?php echo $value['title'] ?></td>
                          <td><?php echo $value['address'] ?></td>
                          <td><?php echo $value['subtitle'] ?></td>
                          <td><?php echo $value['width'] ?> mm </td>
                          <td>
                            <?php if ($value['is_default'] == 1): ?>
                              Default
                            <?php else: ?>
                              <a href="<?php echo base_url('paper/default/'.$value['id']); ?>" class="btn btn-success">Jadikan default</a>
                            <?php endif ?>
                          </td>
                          <td>
                            <div class="btn-group">
                              <a href="<?php echo base_url('paper/update/'.$value['id']); ?>" class="btn btn-success">Ubah</a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
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