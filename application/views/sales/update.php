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
                    <label for="transaction_date" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                    <div class="col-sm-4">
                      <input type="date" name="transaction_date" class="form-control" id="transaction_date" required readonly value="<?php echo $row['transaction_date']; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="customer_id" class="col-sm-2 col-form-label">Pelanggan</label>
                    <div class="col-sm-4">
                      <select name="customer_id" class="form-control select2" id="customer_id" required>
                        <option value="">--Pilih Pelanggan--</option>
                        <?php foreach ($customers as $key => $value): ?>
                        <option value="<?php echo $value['id'] ?>"<?php echo ($value['id'] == $row['customer_id']) ? ' selected' : '' ?>><?php echo $value['name'] ?></option>
                      <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="note" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-5">
                      <input type="text" name="note" class="form-control" id="note" value="<?php echo $row['note'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="method_id" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-3">
                      <select name="method_id" class="form-control select2" id="method_id" required>
                        <option value="">--Pilih Pembayaran--</option>
                        <?php foreach ($methods as $key => $value): ?>
                        <option value="<?php echo $value['id'] ?>"<?php echo ($value['id'] == $row['method_id']) ? ' selected' : '' ?>><?php echo $value['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_cash" name="is_cash" value="0"<?php echo ($row['is_cash'] == 0) ? ' checked' : '' ?>>
                        <label class="form-check-label" for="is_cash">Utang</label>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th width="30%">Nama Barang</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Subtotal</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($details as $key => $value): ?>
                        <tr class="tr-input-field">
                          <td>
                            <select name="item_ids[]" class="form-control select-product item-id">
                              <option value="">--Pilih Barang--</option>
                              <?php foreach ($items as $keyItem => $valueItem): ?>
                              <option value="<?php echo $value['id'] ?>"<?php echo ($valueItem['id'] == $value['item_id']) ? ' selected' : '' ?>><?php echo $valueItem['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td><input type="text" name="price[]" class="form-control price" readonly required value="<?php echo $value['price'] ?>"></td>
                          <td>
                            <input type="hidden" class="form-control qty-available" value="<?php echo $value['stock'] + $value['qty'] ?>">
                            <input type="text" name="qty[]" class="form-control qty number" required value="<?php echo $value['qty'] ?>">
                          </td>
                          <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly required value="<?php echo $value['price']*$value['qty'] ?>"></td>
                          <td>
                            <?php if ($key > 0): ?>
                              <a href="#" class="remove_field btn btn-danger">X</a>
                            <?php else: ?>
                              &nbsp;
                            <?php endif ?>
                          </td>
                        </tr>
                        <?php endforeach ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" class="text-right"><strong>Total Seluruh</strong></td>
                          <td colspan="2"><input type="text" name="total" class="form-control" id="total" readonly required value="<?php echo $row['total'] ?>"></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><strong>Bayar</strong></td>
                          <td colspan="2"><input type="text" name="cash" class="form-control number" id="cash" required value="<?php echo $row['cash'] ?>"></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><strong>Kembalian</strong></td>
                          <td colspan="2"><input type="text" name="changes" class="form-control" id="changes" readonly required value="<?php echo $row['changes'] ?>"></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <p>
                  <button type="button" id="item-add" class="btn btn-primary">Tambah Barang</button>
                  </p>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info btn-submit" name="submit" value="edit">Submit</button>
                  <a href="<?php echo base_url('sale') ?>" class="btn btn-default float-right">Cancel</a>
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
<script type="text/javascript">
  $(function() {
    $('.select-product').select2({
        allowClear: true,
        width: '100%'
    })
    $("#item-add").click(function(){
        $('.select-product').select2('destroy');
        var rowCount = $('table tbody tr').length;
        var tr    = $('tbody tr:last').closest('.tr-input-field');
        var clone = tr.clone();
        clone.find(':text').val('');
        tr.after(clone);
        if (rowCount == 1) {
            $("table tbody tr:last td:last-child").append('<a href="#" class="remove_field btn btn-danger">X</a>');
        }
        $('.select-product').select2({
            allowClear: true,
            width: '100%'
        })
    });

    $('table tbody').on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); 
         $(this).closest('tr').remove();
    });

    $(document).keydown(function(e) {

      var self = $(':focus'),
          
          form = self.parents('form:eq(0)'),
          focusable;

      focusable = form.find('input,a,select,button,textarea,div[contenteditable=true]').filter(':visible');

      function enterKey(){
        if (e.which === 13 && !self.is('textarea,div[contenteditable=true]')) {

          if ($.inArray(self, focusable) && (!self.is('a,button'))){
            e.preventDefault();
          } 

          focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

          return false;
        }
      }
      if (e.shiftKey) { enterKey() } else { enterKey() }
    });

    function sumGrandTotal() {
      var sum = 0;
      $('.subtotal').each(function(){
          sum += parseInt($(this).val());  // Or this.innerHTML, this.innerText
      });
      $('#total').val(sum);
    }

    function validateCash() {
      var total = $('#total').val();
      var cash = $('#cash').val();
      var changes = parseInt(cash) - parseInt(total);
      if (parseInt(changes) < 0) {
        $('.btn-submit').prop('disabled', 'disabled');
      }
      else{
        $('.btn-submit').removeAttr('disabled');
      }
      $('#changes').val(changes);
    }

    $(document).on("change", ".item-id", function(){
      var obj = this;
      var id = $(this).val();
      
      $.ajax({
        url: base_url + 'sale/getDataProduct',
        type: 'POST',
        data: {'id': id},
        dataType: 'json'
      })
      .done(function(data) {
          var harga = data.price;
          $(obj).closest('tr').find('.price').val(harga);
          $(obj).closest('tr').find('.qty-available').val(data.stock);
          var jumlah = 1;
          var subtotal = parseInt(harga) * parseInt(jumlah);
          $(obj).closest('tr').find('.qty').val(jumlah);
          $(obj).closest('tr').find('.qty').focus();
          $(obj).closest('tr').find('.subtotal').val(subtotal);
          sumGrandTotal();
          validateCash();
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });

    });

    $(document).on("keyup", ".qty", function(e){
      if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode >= 8 && $(this).val() != '')) {
        var obj = this;
        var qty = $(this).val();
        var qtyAvailable = $(this).closest('tr').find('.qty-available').val();
        var price = $(obj).closest('tr').find('.price').val();
        if (parseInt(qty) > parseInt(qtyAvailable)) {
          alert('Stok Kurang');
          $('.btn-submit').prop('disabled', 'disabled');
        }
        else {
          var subtotal = parseInt(price) * parseInt(qty);
          $(obj).closest('tr').find('.subtotal').val(subtotal);
          sumGrandTotal();
          validateCash();
        }
      }
    });

    $(document).on("keyup", "#cash", function(e){
      if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode == 8 && $(this).val() != '')) {
        validateCash();
      }
    });

  });
</script>