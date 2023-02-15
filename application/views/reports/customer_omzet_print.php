<!DOCTYPE html>
<html>
<head>
    <title>Cetak Omzet</title>
</head>
<style type="text/css">
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
    #customers {
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #000;
      padding: 8px;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      font-weight: bold;;
    }
</style>
<body>
    <?php if ($start_date != null): ?>
    <h2>Laporan Omzet Pelanggan Periode <?php echo date('d F Y', strtotime($start_date)) ?> - <?php echo date('d F Y', strtotime($end_date)) ?></h2>
    <?php else: ?>
    <h2>Laporan Omzet Pelanggan Periode Keseluruhan</h2>
    <?php endif ?>
<table border="1" id="customers">
        <tr>
          <th>No</th>
          <th>Nama Pelanggan</th>
          <th>Kontak</th>
          <th>Alamat</th>
          <th>Jumlah Transaksi</th>
          <th>Total Nominal Transaksi</th>
          <th>Total Modal</th>
          <th>Laba</th>
        </tr>
        <?php foreach ($sales as $key => $value): ?>
          <tr>
            <td><?php echo $key + 1 ?></td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['phone'] ?></td>
            <td><?php echo $value['address'] ?></td>
            <td><?php echo $value['transactionCount'] ?></td>
            <td>Rp. <?php echo number_format($value['transactionNominalCount']) ?></td>
            <td>Rp. <?php echo number_format($value['modalCount']) ?></td>
            <td>Rp. <?php echo number_format($value['transactionNominalCount'] - $value['modalCount']) ?></td>
          </tr>
        <?php endforeach ?>
</table>
</body>
</html>