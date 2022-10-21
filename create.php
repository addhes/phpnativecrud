<?php
include('config.php');

    if (isset($_POST['bsimpan'])) {
       $image = $_FILES['foto_barang']['name'];
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
                $foto_baru = $angka_acak. '-'. $image;
    
                if ($_FILES['foto_barang']['size'] < $max_size) {

                    if (in_array($ekstensi, $ekstensi_image) === true) {

                        $querycekname = "SELECT nama_barang FROM barang WHERE nama_barang = '$namaBarang'";
                        $pic = mysqli_query($koneksi, $querycekname);

                        // die(var_dump($pic));
                        
                        if ($pic->num_rows == 0) {
                            move_uploaded_file($file_tmp, 'gambar/' .$foto_baru);

                            $query = "INSERT INTO barang (foto_barang, nama_barang, harga_beli, harga_jual, stok) 
                            VALUES ('$foto_baru', '$namaBarang', '$hargaBeli', '$hargaJual', '$stok')";
                            $result = mysqli_query($koneksi, $query);
                            
                            if($result) {
                                echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php'</script>";
                            } else {
                                die("Query Error: ".mysqli_errno($koneksi). " - " .mysqli_errno($koneksi));
                            }

                        } else {
                            echo "<script>alert('Nama Barang harus unik'); window.location='index.php'</script>";
                        }
        
                        
                    } else {
                        echo "<script>alert('ekstensi gambar hanya boleh jpg / png'); window.location='index.php'</script>";
                    }

                } else {
                    echo "<script>alert('gambar tidak boleh lebih dari 100KB'); window.location='index.php'</script>";
                }
    
           } else {
            echo "<script>alert('silahkan upload gambar dahulu'); window.location='index.php'</script>";
           }
        
           

    }
    
?>