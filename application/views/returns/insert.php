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
                    <label for="sale_id" class="col-sm-2 col-form-label">Kode Transaksi</label>
                    <div class="col-sm-3">
                      <select name="sale_id" class="form-control select2" id="sale_id" required="">
                        <option value="">--Pilih Nota Penjualan--</option>
                        <?php foreach ($sales as $key => $value): ?>
                          <option value="<?php echo $value['id'] ?>"><?php echo $value['code'] ?> - <?php echo $value['c_name'] ?> - <?php echo date('d-m-Y', strtotime($value['transaction_date'])) ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="submit" value="add">Submit</button>
                  <a href="<?php echo base_url('retur') ?>" class="btn btn-default float-right">Cancel</a>
                </div>
              </form>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <?php if (isset($rowSale)): ?>
        <div class="row">
          <div class="col-lg-12">

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="card-title m-0">Data Penjualan - <?php echo $rowSale['code']; ?></h5>
              </div>
              <div class="card-body">
                <form method="post" action="<?php echo base_url('retur/store') ?>">
                  <input type="hidden" name="cash" value="<?php echo $rowSale['cash'] ?>">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                          <tr>
                            <td><strong>Tanggal Retur</strong></td>
                            <td><input type="date" name="transaction_date" class="form-control" value="<?php echo date('Y-m-d') ?>"></td>
                          </tr>
                          <tr>
                            <td><strong>Kode Transaksi</strong></td>
                            <td>: <?php echo $rowSale['code'] ?></td>
                          </tr>
                          <tr>
                            <td><strong>Tanggal Transaksi Penjualan</strong></td>
                            <td><?php echo date('d F Y', strtotime($rowSale['transaction_date'])) ?></td>
                          </tr>
                          <tr>
                            <td><strong>Pelanggan</strong></td>
                            <td><?php echo $rowSale['c_name'] ?></td>
                          </tr>
                          <tr>
                            <td><strong>Keterangan</strong></td>
                            <td><?php echo $rowSale['note'] ?></td>
                          </tr>
                          <tr>
                            <td><strong>Total Harga</strong></td>
                            <td>Rp. <?php echo number_format($rowSale['total']) ?></td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Barang</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Jumlah yang diretur</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($rowSaleDetails as $key => $value): ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><input type="text" name="item_name[]" class="form-control" value="<?php echo $value['name'] ?>" readonly></td>
                            <td><input type="text" name="item_price[]" class="form-control" value="<?php echo $value['price'] ?>" readonly></td>
                            <td><input type="text" name="item_qty[]" class="form-control item-qty" value="<?php echo $value['qty'] ?>" readonly></td>
                            <td><input type="text" name="retur_qty[]" class="form-control retur-qty number" value="0"></td>
                            <td><input type="text" name="retur_note[]" class="form-control" placeholder="Keterangan">
                                <input type="hidden" name="sale_detail_id[]" value="<?php echo $value['sd_id'] ?>">
                                <input type="hidden" name="item_id[]" value="<?php echo $value['i_id'] ?>">
                            </td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                  <input type="hidden" name="sale_id" value="<?php echo $rowSale['s_id'] ?>">
                  <button type="submit" class="btn btn-info btn-submit" name="submit" value="add">Submit</button>
                </form>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <?php endif ?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('layouts/footer'); ?>
<script type="text/javascript">
  $(function() {
    var base_url = '<?php echo base_url(); ?>';
    $(document).on("keyup", ".retur-qty", function(e){
      if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode >= 8 && $(this).val() != '')) {
        var obj = this;
        var qty = $(this).val();
        var qtyAvailable = $(this).closest('tr').find('.item-qty').val();
        if (parseInt(qty) > parseInt(qtyAvailable)) {
          alert('Stok Kurang');
          $('.btn-submit').prop('disabled', 'disabled');
        }
        else {
          $('.btn-submit').removeAttr('disabled');
        }
      }
    });
  });

</script>