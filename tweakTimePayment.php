<?php 

$konek = mysqli_connect('localhost', 'root', '', 'db72_inventori');

$sql = mysqli_query($konek, "SELECT * FROM claim_paids");
while ($data = mysqli_fetch_array($sql)) {
    $sale_id = $data['sale_id'];
    $payment_at = $data['created_at'];
    $updateQuery = mysqli_query($konek, "UPDATE sales SET payment_at='$payment_at' WHERE id = '$sale_id'") or die (mysqli_error($konek));
}