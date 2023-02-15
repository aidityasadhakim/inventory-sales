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
            font-family: 'Calibri';
            line-height: 23px;
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
        tfoot tr td:first-child {
            text-align: right;
            padding-right: 10px;
        }
    </style>
    <script type="text/javascript">
        window.print();
    </script>
</head>
<body class="receipt">
    <p>
        <a href="<?php echo base_url('retur') ?>" class="btn-hide">Kembali</a>
    </p>
    <section class="sheet padding-5">
        <h3 class="title"><?php echo $info['title']; ?></h3>
        <h4 class="subtitle"><?php echo $info['address']; ?><br><?php echo $info['subtitle']; ?></h4>
        <hr>
        <h5 style="text-align: center;">Nota Retur</h5>
        <p>No Nota: <?php echo $row['id']; ?></p>
        <div>
            <p class="left"><?php echo getDataColumn('sales', 'id', $row['sale_id'], 'customer_name') ?></p>
            <p class="right"><?php echo date('d/m/Y', strtotime($row['transaction_date'])) ?></p>

        </div>
        <div style="clear: both"></div>
        <hr>
        <?php 
        $item_name = getDataColumn('items', 'id', $row['item_id'], 'name');
        $item_price = getDataColumn('sale_details', 'id', $row['sale_detail_id'], 'price');
         ?>
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td width="60%" class="item-name"><?php echo $item_name ?></td>
                    <td><?php echo $row['qty']; ?> x <?php echo number_format($item_price); ?></td>
                    <td><?php echo number_format($row['qty']*$item_price); ?></td>
                </tr>
                <tr>
                    <td colspan="3"><hr></td>
                </tr>
            </tbody>
        </table>
        <table width="100%">
            <tr>
                <td style="text-align: right; padding-right: 10px" width="85%">Total </td>
                <td> <?php echo number_format($row['qty']*$item_price); ?></td>
            </tr>
        </table>
        <p>
            <button type="button" class="btn-hide" onclick="window.print()">Cetak</button>
        </p>
    </section>
</body>
</html>