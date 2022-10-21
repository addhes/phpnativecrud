<?php
include('config.php');


if (isset($_POST['bupdate'])) {
    $image = $_FILES['foto_barang']['name'];
    $image_old = $_POST['foto_barang_old'];
    $id = $_POST['id_barang'];
    $namaBarang = $_POST['nama_barang'];
    $hargaBeli = $_POST['harga_beli'];
    $hargaJual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    if ($image != "") {
        $ekstensi_image = array('png', 'jpg');
        $x = explode('.', $image);
        $ekstensi = strtolower(end($x));
        $max_size = 100000;
        $file_tmp = $_FILES['foto_barang']['tmp_name'];
        $angka_acak = rand(1, 999);
        $foto_baru = $angka_acak . '-' . $image;

        if ($_FILES['foto_barang']['size'] < $max_size) {

            if (in_array($ekstensi, $ekstensi_image) === true) {
                move_uploaded_file($file_tmp, 'gambar/' . $foto_baru);

                $query = "UPDATE barang SET 
                        foto_barang='$foto_baru', nama_barang='$namaBarang',
                        harga_beli='$hargaBeli', harga_jual='$hargaJual', stok='$stok'
                        WHERE id = $id";
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    echo "<script>alert('Data berhasil diubah'); window.location='index.php'</script>";
                } else {
                    die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_errno($koneksi));
                }
            } else {
                echo "<script>alert('ekstensi gambar hanya boleh jpg / png'); window.location='index.php'</script>";
            }
        } else {
            echo "<script>alert('gambar tidak boleh lebih dari 100KB'); window.location='index.php'</script>";
        }
    } else {
        $foto_baru = $image_old;
        $query = "UPDATE barang SET 
                        foto_barang='$foto_baru', nama_barang='$namaBarang',
                        harga_beli='$hargaBeli', harga_jual='$hargaJual', stok='$stok'
                        WHERE id = $id";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>alert('Data berhasil diubah'); window.location='index.php'</script>";
        } else {
            die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_errno($koneksi));
        }
    }
}
