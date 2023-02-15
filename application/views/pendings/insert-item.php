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
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th width="55%">Nama Barang</th>
                          <th width="5%">Jumlah</th>
                          <th width="15%">Harga</th>
                          <th width="15%">Subtotal</th>
                          <th width="10%">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($items as $key => $value): ?>
                          <tr>
                            <td><?php echo $value['name'] ?></td>
                            <td><?php echo $value['qty'] ?></td>
                            <td>Rp. <?php echo number_format($value['price']) ?></td>
                            <td>Rp. <?php echo number_format($value['qty'] * $value['price']) ?>
                              <input type="hidden" class="form-control subtotal" value="<?php echo ($value['qty'] * $value['price']) ?>">
                            </td>
                          </tr>
                        <?php endforeach ?>
                        <tr class="tr-input-field">
                          <td>
                            <select name="item_ids[]" class="form-control select-product item-id">
                              
                            </select>
                          </td>
                          <td>
                            <input type="hidden" class="form-control qty-available">
                            <input type="text" name="qty[]" class="form-control qty number" required>
                          </td>
                          <td><input type="text" name="price[]" class="form-control price" readonly required></td>
                          <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly required></td>
                          <td>&nbsp;</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3" class="text-right"><strong>Total Seluruh</strong></td>
                          <td colspan="2"><input type="text" name="total" class="form-control" id="total" readonly required></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <p>
                  <button type="button" id="item-add" class="btn btn-primary">Tambah Barang</button>
                  </p>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info btn-submit" name="submit" value="add">Submit Item</button>
                  <a href="<?php echo base_url('pending/item/'.$id) ?>" class="btn btn-default float-right">Cancel</a>
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
        width: '100%',
        minimumInputLength: 2,
        placeholder: '--Pilih Barang--',
        delay: 250,
        ajax: {
          url: base_url + '/pending/getAllItems',
          dataType: "json",
          type: "POST",
          data: function (params) {

              var  arr = $.map
              (
                $(".item-id option:selected"), function(n)
                 {
                      return n.value;
                  }
              );

              var queryParameters = {
                  term: params.term,  
                  uid: arr,
                  page: params.page || 1
              }
              return queryParameters;
          },
          cache: true
        }
    })

    $("#item-add").click(function(){
        $('.select-product').select2('destroy');
        var rowCount = $('table tbody tr').closest('.tr-input-field').length;
        var tr    = $('tbody tr:last').closest('.tr-input-field');
        var clone = tr.clone();
        clone.find(':text').val('');
        clone.find('select').val('');
        tr.after(clone);
        if (rowCount == 1) {
            $("table tbody tr:last td:last-child").append('<a href="#" class="remove_field btn btn-danger">X</a>');
        }
        $('.select-product').select2({
            allowClear: true,
            width: '100%',
            placeholder: '--Pilih Barang--',
            minimumInputLength: 2,
            delay: 250,
            ajax: {
              url: base_url + '/pending/getAllItems',
              dataType: "json",
              type: "POST",
              data: function (params) {

                  var  arr = $.map
                  (
                    $(".item-id option:selected"), function(n)
                     {
                          return n.value;
                      }
                  );

                  var queryParameters = {
                      term: params.term,  
                      uid: arr,
                      page: params.page || 1
                  }
                  return queryParameters;
              },
              cache: true
          }
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

    $(document).on("change", ".item-id", function(){
      var obj = this;
      var id = $(this).val();
      
      $.ajax({
        url: base_url + 'pending/getDataProduct',
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
          // validateCash();
        }
      }
    });

  });
</script>