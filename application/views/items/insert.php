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
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-4">
                      <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="buyPrice" class="col-sm-2 col-form-label">Harga Beli</label>
                    <div class="col-sm-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp. </div>
                        </div>
                        <input type="text" name="buyPrice" class="form-control number" id="buyPrice" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="salePrice" class="col-sm-2 col-form-label">Harga Jual</label>
                    <div class="col-sm-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp. </div>
                        </div>
                        <input type="text" name="salePrice" class="form-control number" id="salePrice" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="salePriceNon" class="col-sm-2 col-form-label">Harga Jual Non Pelanggan</label>
                    <div class="col-sm-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp. </div>
                        </div>
                        <input type="text" name="salePriceNon" class="form-control number" id="salePriceNon" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stockMin" class="col-sm-2 col-form-label">Stok Minimal</label>
                    <div class="col-sm-2">
                      <input type="text" name="stockMin" class="form-control number" id="stockMin" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-3">
                      <select name="type" class="form-control" id="type">
                        <option value="Accessories">Accessories</option>
                        <option value="Part">Part</option>
                        <option value="Unit">Unit</option>
                        <option value="Tools">Tools</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-5">
                      <input type="text" name="note" class="form-control" id="note" required>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="submit" value="add">Submit</button>
                  <a href="<?php echo base_url('item') ?>" class="btn btn-default float-right">Cancel</a>
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