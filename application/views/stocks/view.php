<?php $this->load->view('layouts/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> <?php echo $title; ?> - <?php echo getDataColumn('items', 'id', $item_id, 'name') ?></h1>
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
                <h5 class="card-title m-0"><?php echo $title; ?> - <?php echo getDataColumn('items', 'id', $item_id, 'name') ?></h5>
              </div>
              <div class="card-body">
                <?php if($this->session->flashdata('msg')): ?>
                  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('msg'); ?>
                  </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('error'); ?>
                  </div>
                <?php endif; ?>
                <p>
                  <a href="<?php echo base_url('item') ?>" class="btn btn-default">Kembali</a>
                  <a href="<?php echo base_url('stock/add/increase/'.$item_id) ?>" class="btn btn-primary">Tambahkan Stok</a>
                  <a href="<?php echo base_url('stock/add/decrease/'.$item_id) ?>" class="btn btn-warning">Kurangkan Stok</a>
                </p>
                <div class="table-responsive">
                  <table class="table table-bordered" id="data-table-customer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <!-- <th>#</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($stocks as $key => $value): ?>
                        <tr>
                          <td><?php echo $key+1 ?></td>
                          <td><?php echo date('d F Y', strtotime($value['created_at'])) ?></td>
                          <td><?php echo $value['amount'] ?></td>
                          <td><?php echo $value['note'] ?></td>
                          <!-- <td>
                            <div class="btn-group">
                              <a href="<?php echo base_url('stock/delete/'.$value['id']); ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </div>
                          </td> -->
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