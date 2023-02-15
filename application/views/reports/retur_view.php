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
                <form class="form-horizontal" method="post">
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_date" name="is_date" value="1"<?php if (isset($is_date)) echo ($is_date == 1) ? ' checked' : ''; ?>>
                        <label class="form-check-label" for="is_date">Berdasarkan Tanggal?</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="start_date" class="col-sm-2 col-form-label">Tanggal Awal</label>
                    <div class="col-sm-3">
                      <input type="date" name="start_date" class="form-control" id="start_date" value="<?php echo (isset($start_date)) ? $start_date : date('Y-m-d') ?>" <?php if (isset($is_date)) echo ($is_date == 1) ? 'required' : 'disabled'; else echo 'disabled'; ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="end_date" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                    <div class="col-sm-3">
                      <input type="date" name="end_date" class="form-control" id="end_date" value="<?php echo (isset($end_date)) ? $end_date : date('Y-m-d') ?>" <?php if (isset($is_date)) echo ($is_date == 1) ? 'required' : 'disabled'; else echo 'disabled'; ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="customer_id" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                    <div class="col-sm-3">
                      <select name="customer_id" class="form-control select2" id="customer_id">
                        <option value=""<?php if (isset($customer_id)) echo ($customer_id == '') ? ' selected' : ''; ?>>Semua</option>
                      <?php 
                      foreach ($customers as $key => $value): 
                        $selected = '';
                        if (isset($customer_id)) {
                          $selected = ($customer_id == $value['id']) ? ' selected' : '';
                        }
                      ?>
                        <option value="<?php echo $value['id'] ?>"<?php echo $selected; ?>><?php echo $value['name'] ?></option>
                      <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="item_id" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-3">
                      <select name="item_id" class="form-control select-product" id="item_id">
                        <?php if (isset($item_id)): ?>
                          <?php if ($item_id != ''): ?>
                            <option value="<?php echo $item_id ?>" selected><?php echo getDataColumn('items', 'id', $item_id, 'name'); ?></option>
                          <?php endif ?>
                        <?php endif ?>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-info" name="submit" value="view">Submit</button>
                </form>
                <?php if (isset($retur)): ?>
                  <hr>
                  <h4>Retur 
                    <?php 
                    if ($start_date != null) {
                      echo 'Periode '.date('d F Y', strtotime($start_date)) ?> - <?php echo date('d F Y', strtotime($end_date));
                    }
                    else {
                      echo 'Semua Periode';
                    }
                    ?></h4>
                  <div class="table-responsive mt-10">
                    <table class="table table-bordered" id="data-table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Kode Penjualan</th>
                          <th>Nama Pelanggan</th>
                          <th>Nama Barang</th>
                          <th>Jumlah Retur</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        foreach ($retur as $key => $value): 
                        ?>
                        <tr>
                          <td><?php echo $key+1 ?></td>
                          <td><?php echo date('d F Y', strtotime($value['transaction_date'])) ?></td>
                          <td><a href="<?php echo base_url('sale/detail/'.$value['sale_id']) ?>" target="_blank"><?php echo $value['code']; ?></a></td>
                          <td><?php echo $value['customer_name'] ; ?></td>
                          <td><?php echo $value['name'] ; ?></td>
                          <td><?php echo $value['qty'] ; ?></td>
                          <td><?php echo $value['note'] ; ?></td>
                        </tr>
                        <?php 
                        endforeach 
                        ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif ?>
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
<script type="text/javascript">
  $(function() {
    var base_url = '<?php echo base_url(); ?>';
    $('.select-product').select2({
        allowClear: true,
        width: '100%',
        placeholder: '--Semua Barang--',
        minimumInputLength: 2,
        delay: 250,
        ajax: {
          url: base_url + '/report/getAllReturnedItems',
          dataType: "json",
          type: "POST",
          data: function (params) {

              var queryParameters = {
                  term: params.term,
                  page: params.page || 1
              }
              return queryParameters;
          },
          cache: true
      }
    })

    $('#is_date').click(function(event) {
      if($(this).prop('checked')) {
        $('#start_date').prop('required', 'required');
        $('#start_date').removeAttr('disabled');
        $('#end_date').prop('required', 'required');
        $('#end_date').removeAttr('disabled');
      }
      else {
        $('#start_date').prop('disabled', 'disabled');
        $('#start_date').removeAttr('required');
        $('#end_date').prop('disabled', 'disabled');
        $('#end_date').removeAttr('required');
      }
      resetItem();
    });
  });
</script>