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
              <form class="form-horizontal" method="post">
                <div class="card-body">
                <?php if($this->session->flashdata('error')): ?>
                  <div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <?php echo $this->session->flashdata('error'); ?>
                  </div>
                <?php endif; ?>
                  <div class="form-group row">
                    <label for="amount" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-4">
                      <input type="text" name="amount" class="form-control" id="amount" required>
                    </div>
                  </div>
                  <?php if ($type == 'increase'): ?>
                  <div class="form-group row">
                    <label for="buyPrice" class="col-sm-2 col-form-label">Harga Beli</label>
                    <div class="col-sm-4">
                      <input type="text" name="buyPrice" class="form-control number" id="buyPrice" required>
                    </div>
                  </div>
                  <?php else: ?>
                  <div class="form-group row">
                    <label for="buyPrice" class="col-sm-2 col-form-label">Harga Beli</label>
                    <div class="col-sm-4">
                      <select name="buyPrice" class="form-control" id="buyPrice" required>
                        <?php foreach ($prices as $key => $value): ?>
                          <option><?php echo $value['buyPrice']; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <?php endif ?>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-5">
                      <textarea name="note" class="form-control" id="note"></textarea>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="submit" value="add">Submit</button>
                  <a href="<?php echo base_url('stock/index/'.$item_id) ?>" class="btn btn-default float-right">Cancel</a>
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