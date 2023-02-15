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
                      <input type="text" name="name" class="form-control" id="name" required value="<?php echo $row['name'] ?>">
                    </div>
                  </div>
                  <div class="form-group row"<?php echo ($this->session->userdata('level') == 2 || $this->session->userdata('level') == 3) ? ' style="display:none"' : ''; ?>>
                    <label for="buyPrice" class="col-sm-2 col-form-label">Harga Beli</label>
                    <div class="col-sm-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp. </div>
                        </div>
                        <input type="text" name="buyPrice" class="form-control number" id="buyPrice" required value="<?php echo $row['buyPrice'] ?>">
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
                        <input type="text" name="salePrice" class="form-control number" id="salePrice" required value="<?php echo $row['salePrice'] ?>"<?php echo ($this->session->userdata('level') == 3) ? ' readonly' : ''; ?>>
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
                        <input type="number" name="salePriceNon" class="form-control number" id="salePriceNon" required value="<?php echo $row['salePriceNon'] ?>" min="<?php echo $row['salePrice'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="stockMin" class="col-sm-2 col-form-label">Stok Minimal</label>
                    <div class="col-sm-2">
                      <input type="text" name="stockMin" class="form-control number" id="stockMin" required value="<?php echo $row['stockMin'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-3">
                      <select name="type" class="form-control" id="type">
                        <option value="Accessories"<?php echo ($row['type'] == 'Accessories') ? ' selected' : '' ?>>Accessories</option>
                        <option value="Part"<?php echo ($row['type'] == 'Part') ? ' selected' : '' ?>>Part</option>
                        <option value="Unit"<?php echo ($row['type'] == 'Unit') ? ' selected' : '' ?>>Unit</option>
                        <option value="Tools"<?php echo ($row['type'] == 'Tools') ? ' selected' : '' ?>>Tools</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-5">
                      <input type="text" name="note" class="form-control" id="note" value="<?php echo $row['note'] ?>">
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