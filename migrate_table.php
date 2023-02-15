<?php 
$konek = mysqli_connect('localhost', 'root', '', 'asc');

$query = mysqli_query($konek, "SELECT * FROM barang");
while($data = mysqli_fetch_assoc($query)) {
    $slug = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($data['nama_barang']));
    $name = $data['nama_barang'];
    $queryStock = mysqli_query($konek, "SELECT SUM(jumlah) AS jumlah FROM stok WHERE id_barang='".$data['id_barang']."'");
    $dataStock = mysqli_fetch_assoc($queryStock);
    $stock = $dataStock['jumlah'];
    $stockMin = 10;
    $queryHargaBeli = mysqli_query($konek, "SELECT harga_beli FROM stok WHERE id_barang='".$data['id_barang']."' ORDER BY created_at DESC LIMIT 1" );
    $dataHargaBeli = mysqli_fetch_assoc($queryHargaBeli);
    $buyPrice = $dataHargaBeli['harga_beli'];
    $queryHargaJual = mysqli_query($konek, "SELECT harga_jual FROM harga WHERE id_barang='".$data['id_barang']."' ORDER BY created_at DESC LIMIT 1" );
    $dataHargaJual = mysqli_fetch_assoc($queryHargaJual);
    $salePrice = $dataHargaJual['harga_jual'];
    $note = $data['keterangan'];
    $type = 'Part';
    $created_at = date('Y-m-d H:i:s');

    $queryInsert = mysqli_query($konek, "INSERT INTO items SET slug='$slug', code='-', name='$name', stock='$stock', stockMin='$stockMin', buyPrice='$buyPrice', salePrice='$salePrice', note='$note', type='$type', created_at='$created_at'");
    $idx = mysqli_insert_id($konek);
    $code = 'ITM'.$idx;
    $queryUpdate = mysqli_query($konek, "UPDATE items SET code='$code' WHERE id = '$idx'");
}
 ?>
