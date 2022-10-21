<?php
    include('config.php');
    $jumlahDataPerhalaman = 2;
    $resultdata = mysqli_query($koneksi, "SELECT * FROM barang");
    $jumlahData = mysqli_num_rows($resultdata);
    $jumlaHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
    $awalData = ( $jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

    $resultBarang =  "SELECT * FROM barang LIMIT $awalData, $jumlahDataPerhalaman";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test nutech</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center pb-2">Test php - Ade Setiawan</h2>

        <div class="card">
            <div class="card-header">
                Data Barang
            </div>
            <div class="card-body">
                <div class="row pb-4">
                    <div class="col-md-7">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahData">
                            Tambah <li class="fa fa-plus"></li>
                        </button>
                    </div>
                    <div class="col-md-4 d-inline">
                        <form action="" method="GET">
                        <div class="input-group">
                                <input type="text" name="keyword" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>" class="form-control rounded" placeholder="Search . . ." autocomplete="off" />
                                <button type="submit" class="btn btn-primary" name=""><li class="fa fa-search"></li></button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Foto Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'config.php';
                            if (isset($_GET['keyword'])) {
                                $filtersearch = $_GET['keyword'];
                                $query = "SELECT * FROM barang WHERE CONCAT(nama_barang, stok) LIKE '%$filtersearch%'";
                                $pic = mysqli_query($koneksi, $query);

                                if (mysqli_num_rows($pic) > 0) {
                                    foreach ($pic as $key => $data) 
                                    {
                                        ?>
                                            <tr>
                                                <td><?= $key+1; ?></td>
                                                <td><?= '<img src="gambar/' .$data['foto_barang'].'" width="50px"; height="50px"; alt="">' ?></td>
                                                <td><?= $data['nama_barang']; ?></td>
                                                <td><?= $data['harga_beli']; ?></td>
                                                <td><?= $data['harga_jual']; ?></td>
                                                <td><?= $data['stok']; ?></td>
                                                <td>
                                                    <!-- <a href=""><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#asd">Edit</button>
                                                    </a> -->
                                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateData<?=$data['id']?>"><li class="fa fa-pencil"></li></button>
                                                    <a href="delete.php?deleteid=<?=$data['id']?>" 
                                                        onclick="return confirm('Yakin mau dihapus?')"><button class="btn btn-danger"><li class="fa fa-trash"></li></button>
                                                    </a>
                                                </td>
                                            </tr>
    
                                            <!-- Modal untuk Updae data -->
                                            <div class="modal fade" id="updateData<?=$data['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="update.php" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_barang" value="<?= $data['id']; ?>">
    
                                                            <div class="row g-3 align-items-center">
                                                                <div class="col-md-3">
                                                                    <label for="inputPassword6" class="col-form-label">Foto Barang</label>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <input type="file" class="form-control" name="foto_barang">
                                                                    <input type="hidden" class="form-control" value="<?= $data['foto_barang']; ?>" name="foto_barang_old">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="inputPassword6" class="col-form-label">Nama Barang</label>
                                                                    <input type="text" value="<?= $data['nama_barang']; ?>" class="form-control" name="nama_barang" placeholder="input Nama Barang">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="inputPassword6" class="col-form-label">Harga Beli</label>
                                                                    <input type="number" value="<?= $data['harga_beli']; ?>" class="form-control" name="harga_beli" placeholder="input Harga Beli">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="number" class="col-form-label">Harga Jual</label>
                                                                    <input type="number" value="<?= $data['harga_jual']; ?>" class="form-control" name="harga_jual" placeholder="input Harga Jual">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="inputPassword6" class="col-form-label">Stok</label>
                                                                    <input type="number" value="<?= $data['stok']; ?>" class="form-control" name="stok" placeholder="input Stok">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit" name="bupdate">Simpan</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                } else {
                                    echo "<h5>Tidak ada data ditemukan</h5>";
                                }
                            } else {
                                // pagination
                                
                                // $barangs = mysqli_num_rows($resultdata);
                                // var_dump($barangs);
                                // $query = "SELECT * FROM barang";
                                $pic = mysqli_query($koneksi, $resultBarang);
                                if (mysqli_num_rows($pic) > 0) {
                                    foreach ($pic as $key => $data) 
                                    {
                                        ?>
                                            <tr>
                                                <td><?= $key+1; ?></td>
                                                <td><?= '<img src="gambar/' .$data['foto_barang'].'" width="50px"; height="50px"; alt="">' ?></td>
                                                <td><?= $data['nama_barang']; ?></td>
                                                <td><?= number_format($data['harga_beli']); ?></td>
                                                <td><?= $data['harga_jual']; ?></td>
                                                <td><?= $data['stok']; ?></td>
                                                <td>
                                                    <!-- <a href=""><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#asd">Edit</button>
                                                    </a> -->
                                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateData<?=$data['id']?>"><li class="fa fa-pencil text-white"></li></button>
                                                    <a href="delete.php?deleteid=<?=$data['id']?>" 
                                                        onclick="return confirm('Yakin mau dihapus?')"><button class="btn btn-danger"><li class="fa fa-trash"></li></button>
                                                    </a>
                                                </td>
                                            </tr>
    
                                            <!-- Modal untuk Updae data -->
                                            <div class="modal fade" id="updateData<?=$data['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Barang</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="update.php" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id_barang" value="<?= $data['id']; ?>">
    
                                                            <div class="row g-3 align-items-center">
                                                                <div class="col-md-3">
                                                                    <label for="inputPassword6" class="col-form-label">Foto Barang</label>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <input type="file" class="form-control" name="foto_barang">
                                                                    <input type="hidden" class="form-control" value="<?= $data['foto_barang']; ?>" name="foto_barang_old">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="inputPassword6" class="col-form-label">Nama Barang</label>
                                                                    <input type="text" value="<?= $data['nama_barang']; ?>" class="form-control" name="nama_barang" placeholder="input Nama Barang">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="inputPassword6" class="col-form-label">Harga Beli</label>
                                                                    <input type="number" value="<?= $data['harga_beli']; ?>" class="form-control" name="harga_beli" placeholder="input Harga Beli">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="number" class="col-form-label">Harga Jual</label>
                                                                    <input type="number" value="<?= $data['harga_jual']; ?>" class="form-control" name="harga_jual" placeholder="input Harga Jual">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center">
                                                                <div class="">
                                                                    <label for="inputPassword6" class="col-form-label">Stok</label>
                                                                    <input type="number" value="<?= $data['stok']; ?>" class="form-control" name="stok" placeholder="input Stok">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit" name="bupdate">Simpan</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                                
                            }
                            ?>

                    </tbody>
                </table>
                <!-- Navigasi -->
                <div style="float: right;">
                <?php for( $i=1; $i <= $jumlaHalaman; $i++) : ?>
                    <?php if($i == $halamanAktif) : ?>
                        <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"> <?= $i; ?></a>
                    <?php else : ?>
                        <a href="?halaman=<?= $i; ?>"> <?= $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal untuk tambah data -->
    <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="create.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <label for="inputPassword6" class="col-form-label">Foto Barang</label>
                        </div>
                        <div class="col-auto">
                            <input type="file" class="form-control" name="foto_barang">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="">
                            <label for="inputPassword6" class="col-form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" placeholder="input Nama Barang">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="">
                            <label for="inputPassword6" class="col-form-label">Harga Beli</label>
                            <input type="number" class="form-control" name="harga_beli" placeholder="input Harga Beli">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="">
                            <label for="number" class="col-form-label">Harga Jual</label>
                            <input type="number" class="form-control" name="harga_jual" placeholder="input Harga Jual">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="">
                            <label for="inputPassword6" class="col-form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" placeholder="input Stok">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" name="bsimpan">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    

    <!-- footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>