<?php 

    include "Koneksi.php"; include "session.php";
    $id_akses = $_SESSION['id_login'];
    $sql = ""; $result = "";
    if($_SESSION['tipe_login'] == "Penjual") {
        $sql = "SELECT * FROM tbl_pemesanan
            WHERE NOT status='keranjang'
            AND id_pelanggan = $id_akses
            AND tipe_pelanggan = 'Penjual'
            ORDER BY waktu_pemesanan DESC";
        $result = mysqli_query($conn, $sql);
    } else if($_SESSION['tipe_login'] == "User") {
        $sql = "SELECT * FROM tbl_pemesanan
            WHERE NOT status='keranjang'
            AND id_pelanggan = $id_akses
            AND tipe_pelanggan = 'User'
            ORDER BY waktu_pemesanan DESC";
        $result = mysqli_query($conn, $sql);
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/daftar_pesanan.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>Status Pesanan</title>
</head>
<body>
    <!-- header -->
    <?php include "header.php"; ?>

    <!--  -->
    <?php while($read = mysqli_fetch_assoc($result)):?>
        <?php 
            $sql_produk = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_produk = '$read[id_produk]'");
            $result_produk = mysqli_fetch_assoc($sql_produk); 

            $sql_publisher = mysqli_query($conn, "SELECT nama FROM tbl_penjual WHERE id_penjual = '$result_produk[id_penjual]'");
            $result_publisher = mysqli_fetch_assoc($sql_publisher);
        ?>
    <!-- Container --> 
    <div id="container">
        <!-- Detail -->
        <?php if($_SESSION['tipe_login'] == "Penjual") { ?>
            <a href="order_detail.php?id=<?php echo $read['id_pemesanan']; ?>">
        <?php } ?>
        
            <div class="detail interactive2">
                <div class="gambar">
                    <!-- Scene visualisasi produk -->
                    <?php if($result_produk['format_visual'] == "img") { ?>
                        <img src="<?php
                            if($result_produk['visual'] == "") {echo "img/avga/avga.webp";}
                            else {echo 'img/produk/'.$result_produk['visual'];}
                        ?>">
                    <?php } else { ?>
                    <?php } ?>
                </div>
                <div class="produk_container">
                    <div class="p_pcs">
                        <h1><?= $result_produk['nama']; ?> <br> <?= $result_publisher['nama']; ?></h1>
                        <p><?= $read['jumlah']; ?>pcs</p>
                    </div>
                    <div class="p_harga">
                        <p>Rp<?= $result_produk['harga'] ?>,-</p>
                        <p><?= $read['status']; ?></p>
                    </div>
                </div>
            </div>
        <?php if($_SESSION['tipe_login'] == "Penjual") { ?>
            </a>
        <?php } ?>
    </div>
    <?php endwhile; ?>
</body>
</html>