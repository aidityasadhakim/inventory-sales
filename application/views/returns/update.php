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
                    <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Retur Transaksi</label>
                    <div class="col-sm-4">
                      <input type="date" name="transaction_date" class="form-control" id="transaction_date" required value="<?php echo $row['transaction_date'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="sale_code" class="col-sm-2 col-form-label">Kode Transaksi Penjualan</label>
                    <div class="col-sm-2">
                      <input type="text" name="sale_code" class="form-control" id="sale_code" required value="<?php echo getDataColumn('sales', 'id', $row['sale_id'], 'code') ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="customer_name" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                    <div class="col-sm-4">
                      <input type="text" name="customer_name" class="form-control" id="customer_name" required value="<?php echo getDataColumn('sales', 'id', $row['sale_id'], 'customer_name') ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="item_id" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-4">
                      <input type="text" name="item_id" class="form-control" id="item_id" required value="<?php echo getDataColumn('items', 'id', $row['item_id'], 'name') ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="qty" class="col-sm-2 col-form-label">Jumlah Retur</label>
                    <div class="col-sm-2">
                      <input type="text" name="qty" class="form-control" id="qty" value="<?php echo $row['qty'] ?>">
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
                  <input type="hidden" name="sale_id" value="<?php echo $row['sale_id'] ?>">
                  <input type="hidden" name="sale_detail_id" value="<?php echo $row['sale_detail_id'] ?>">
                  <input type="hidden" name="old_qty" value="<?php echo $row['qty'] ?>">
                  <button type="submit" class="btn btn-info" name="submit" value="update">Submit</button>
                  <a href="<?php echo base_url('retur') ?>" class="btn btn-default float-right">Cancel</a>
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