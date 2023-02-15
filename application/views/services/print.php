<!DOCTYPE html>
<html>
<head>
    <title>Cetak Nota Penjualan</title>
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/normalize.css">
    <style>

        body.receipt .sheet { width: <?php echo $info['width']; ?>mm; } /* sheet size */
        @media print { body.receipt { width: <?php echo $info['width']; ?>mm } .btn-hide { display: none !important; } } /* fix for Chrome */

        * {
            font-size: 12px;
            padding: 0;
            margin: 0;
            font-family: 'Times New Roman';
            line-height: 23px;
        }
        .left {
            float: left;
        }
        .right {
            float: right;
        }
        .center {
            text-align: center;
        }
        .padding-5 {
            padding: 5mm;
        }
        .title  {
            font-size: 14px;
            text-align: center;
            margin-bottom: 5px;
        }
        .subtitle  {
            font-size: 12px;
            text-align: center;
            margin-bottom: 5px;
        }
        .regards {
            text-align: center;
            font-size: 12px;
            margin-top: 5px;
        }
        hr {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .header {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        window.print();
    </script>
</head>
<body class="receipt">
    <p>
        <a href="<?php echo base_url('service') ?>" class="btn-hide">Kembali</a>
    </p>
    <section class="sheet padding-5">
        <h3 class="title"><?php echo $info['title']; ?></h3>
        <h4 class="subtitle"><?php echo $info['address']; ?><br><?php echo $info['subtitle']; ?></h4>
        <hr>
        <p class="header">NOTA SERVIS</p>
        <p>No Nota: <?php echo $row['code']; ?></p>
        <div>
            <p class="left"><?php echo $row['customer_name'] ?></p>
            <p class="right"><?php echo date('d/m/Y', strtotime($row['transaction_date'])) ?></p>
        </div>
        <div style="clear: both"></div>
        <p class="center"><?php echo $row['note'] ?></p>
        <hr>
        <table border="0" width="100%">
            <?php if (!empty($details)): ?>
            <tbody>
                <?php foreach ($details as $key => $value): ?>
                <tr>
                    <td width="70%" class="item-name"><?php echo getDataColumn('items', 'id', $value['item_id'], 'name'); ?></td>
                    <td><?php echo $value['qty']; ?> pcs</td>
                </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
            </tbody>
            <?php endif ?>
        </table>
        <table width="100%">
            <tr>
                <td style="text-align: right;" width="85%">Total </td>
                <td> <?php echo number_format($row['total']); ?></td>
            </tr>
            <tr>
                <td style="text-align: right;">Bayar </td>
                <td> <?php echo number_format($row['cash']); ?></td>
            </tr>
            <tr>
                <td style="text-align: right;">Kembalian </td>
                <td> <?php echo number_format($row['changes']); ?></td>
            </tr>
        </table>
        <p>
            <button type="button" class="btn-hide" onclick="window.print()">Cetak</button>
        </p>
    </section>
</body>
</html>