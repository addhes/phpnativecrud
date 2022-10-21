<?php
include 'config.php';

if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql = "DELETE from barang where id=$id";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        echo "<script>alert('Data berhasil dihapus'); window.location='index.php'</script>";
    } else {
        die(mysqli_error($koneksi));
    }
}
?>