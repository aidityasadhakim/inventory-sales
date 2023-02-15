<?php 

$konek = mysqli_connect('localhost', 'root', '', 'db72_inventori');

$sql = mysqli_query($konek, "SELECT * FROM sales WHERE type='service'");
while ($data = mysqli_fetch_array($sql)) {
    $sale_id = $data['id'];
    $sqlDetail = mysqli_query($konek, "SELECT * FROM sale_details WHERE sale_id='$sale_id'");
    while ($dataDetail = mysqli_fetch_array($sqlDetail)) {
        $id = $dataDetail['id'];
        $item_id = $dataDetail['item_id'];
        $sqlPrice = mysqli_query($konek, "SELECT * FROM items WHERE id='$item_id'");
        $dataPrice = mysqli_fetch_array($sqlPrice);
        $price = $dataPrice['salePrice'];
        $updateQuery = mysqli_query($konek, "UPDATE sale_details SET price='$price' WHERE id = '$id'") or die (mysqli_error($konek));
    }
}