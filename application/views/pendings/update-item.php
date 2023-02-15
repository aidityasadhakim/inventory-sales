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
                    <label for="item_id" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-4">
                      <input type="text" name="item_name" class="form-control" id="item_name" value="<?php echo getDataColumn('items', 'id', $row['item_id'], 'name') ?>" readonly>
                      <input type="hidden" name="item_id" id="item_id" value="<?php echo $row['item_id'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="qty" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-2">
                      <input type="text" name="qty" class="form-control number" id="qty" value="<?php echo $row['qty'] ?>">
                      <input type="hidden" name="qty-available" id="qty-available" value="<?php echo getDataColumn('items', 'id', $row['item_id'], 'stock') + $row['qty'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="price" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-3">
                      <input type="text" name="price" class="form-control" id="price" value="<?php echo $row['price'] ?>">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info btn-submit" name="submit" value="edit">Submit Item</button>
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

    $(document).on("change", "#item_id", function(){
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
          $('#price').val(harga);
          $('#qty-available').val(data.stock);
          var jumlah = 1;
          $('#qty').val(jumlah);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });

    });

    $(document).on("keyup", "#qty", function(e){
      if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode >= 8 && $(this).val() != '')) {
        var obj = this;
        var qty = $(this).val();
        var qtyAvailable = $('#qty-available').val();
        var price = $('#price').val();
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