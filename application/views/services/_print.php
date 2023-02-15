<!DOCTYPE html>
<html>
<head>
    <title>Cetak Nota Penjualan</title>
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/paper.css">
    <style>

        @page { size: <?php echo $size_paper; ?>mm 100mm } /* output size */
        body.receipt .sheet { width: <?php echo $size_paper; ?>mm; } /* sheet size */
        @media print { body.receipt { width: <?php echo $size_paper; ?>mm } } /* fix for Chrome */

        * {
            font-size: 8px;
            padding: 0;
            margin: 0;
            font-family: 'Helvetica Neue';
        }
        .left {
            float: left;
        }
        .right {
            float: right;
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
            font-size: 10px;
            text-align: center;
            margin-bottom: 5px;
        }
        .regards {
            text-align: center;
            font-size: 11px;
            margin-top: 5px;
        }
        hr {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        tfoot tr td:first-child {
            text-align: right;
            padding-right: 10px;
        }
        .header {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body class="receipt">
    <section class="sheet padding-5">
        <h3 class="title">Istana HP</h3>
        <h4 class="subtitle">Jalan Hidayatullah No 7 Samarinda<br>No Telp: 085319383333 / 0541-200618</h4>
        <hr>
        <p class="header">NOTA SERVIS</p>
        <p>No Nota: <?php echo $row['code']; ?></p>
        <div>
            <p class="left"><?php echo getDataColumn('customers', 'id', $row['customer_id'], 'name') ?></p>
            <p class="right"><?php echo date('d/m/Y', strtotime($row['transaction_date'])) ?></p>

        </div>
        <div style="clear: both"></div>
        <hr>
        <table border="0" width="100%">
            <tbody>
                <?php foreach ($details as $key => $value): ?>
                <tr>
                    <td width="70%"><?php echo getDataColumn('items', 'id', $value['item_id'], 'name'); ?></td>
                    <td><?php echo $value['qty']; ?> pcs</td>
                </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total </td>
                    <td> <?php echo number_format($row['total']); ?></td>
                </tr>
                <tr>
                    <td>Bayar </td>
                    <td> <?php echo number_format($row['cash']); ?></td>
                </tr>
                <tr>
                    <td>Kembalian </td>
                    <td> <?php echo number_format($row['changes']); ?></td>
                </tr>
            </tfoot>
        </table>
        <p class="regards">
            Hormat Kami<br>*Terima Kasih*
        </p>
    </section>
</body>
</html>