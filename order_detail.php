<?php 
    include "Koneksi.php"; include "session.php";
    $id_pemesanan = $_GET['id'];
    $id_produk = "";

    $sql = "SELECT * FROM tbl_pemesanan WHERE id_pemesanan = '$id_pemesanan'";
    $result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/status_pesanan.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>Status Pesanan</title>
</head>
<body>
    <!-- header -->
    <?php include "header.php"; ?>

    <!--  -->
    <?php while($read = mysqli_fetch_assoc($result)):?>
        <?php 
            $id_produk = $read['id_produk'];
            $sql_produk = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_produk = '$id_produk'");
            $result_produk = mysqli_fetch_assoc($sql_produk); 

            $sql_publisher = mysqli_query($conn, "SELECT nama FROM tbl_penjual WHERE id_penjual = '$result_produk[id_penjual]'");
            $result_publisher = mysqli_fetch_assoc($sql_publisher);
        ?>
    <!-- Container -->
    <div id="container">
            <!-- Detail -->
            <div class="detail interactive2">
                <div class="gambar">
                    <!-- Scene visualisasi produk -->
                    <img src="<?php
                        if($result_produk['visual'] == "") {echo "img/schola.webp";}
                        else {echo 'img/produk/'.$result_produk['visual'];}
                    ?>">
                </div>
                <div class="produk_container">
                    <div class="p_pcs">
                        <h1><?= $result_produk['nama']; ?> <br> <?= $result_publisher['nama']; ?></h1>
                        <p>Rp<?= $result_produk['harga'] ?>,-</p>
                    </div>
                    <div class="p_harga">
                        <?php if($_SESSION['tipe_login'] == "Pembeli") {
                            if ($read['status'] == "Dibayar"){
                        ?>
                            <form method="post">
                                <select name="status" id="status">
                                    <option value="Dibayar" selected>Dibayar</option>
                                    <option value="Dikemas">Dikemas</option>
                                    <option value="Dikirim">Dikirim</option>
                                </select>
                                <button type="submit" name="update">Ubah</button>
                            </form>
                        <?php } else if($read['status'] == "Dikemas") { ?>
                            <form method="post">
                                <select name="status" id="status">
                                    <option value="Dibayar">Dibayar</option>
                                    <option value="Dikemas" selected>Dikemas</option>
                                    <option value="Dikirim">Dikirim</option>
                                </select>
                                <button type="submit" name="update">Ubah</button>
                            </form>
                        <?php } else if($read['status'] == "Dikirim") { ?>
                            <form method="post">
                                <select name="status" id="status">
                                    <option value="Dikirim" selected>Dikirim</option>
                                </select>
                            </form>
                        <?php } ?>


                        <!-- KALAU PENJUAL -->
                        <?php } else if($_SESSION['tipe_login'] == "Penjual") { ?>
                        <?php if($read['status'] == "Dibayar") { ?>
                            <form method="post">
                                <select name="status" id="status">
                                    <option value="Dibayar" selected>Dibayar</option>
                                </select>
                            </form>
                        <?php } else if($read['status'] == "Dikemas") { ?>
                            <form method="post">
                                <select name="status" id="status">
                                    <option value="Dikemas" selected>Dikemas</option>
                                </select>
                            </form>
                        <?php } else if($read['status'] == "Dikirim") { ?>
                            <form method="post">
                                <select name="status" id="status">
                                    <option value="Dikirim" selected>Dikirim</option>
                                    <option value="Diterima">Diterima</option>
                                </select>
                                <button type="submit" name="update">Ubah</button>
                            </form>
                         <?php } else if($read['status'] == "Diterima"){ ?>
                            <div class="form">
                                <select name="status" id="status">
                                    <option value="Diterima" selected>Diterima</option>
                                </select>
                                <button onclick="open_upload_review();">Beri Ulasan</button>
                            </div>
                        <?php 
                        }
                    } ?>

                    </div>
                </div>
            </div>
    </div>
    <?php endwhile; ?>

    <!-- Iframe -->
    <button onclick="close_upload_review();" class="iframe_container" id="upload_review_container">
        <iframe src="frame/upload_review.php?idpr=<?= $id_produk; ?>"
            id="upload_review" frameborder="0"></iframe>
    </button>

</body>
</html>


<script>
    var upload_review = document.getElementById('upload_review_container');
    function open_upload_review() {upload_review.style.display = "flex";}
    function close_upload_review() {upload_review.style.display = "none";}
</script>












<?php
    if(isset($_POST['update'])) {
        $status = $_POST['status'];
        mysqli_query($conn, "UPDATE tbl_pemesanan SET
        `status` = '$status' WHERE id_pemesanan = '$id_pemesanan'");

        echo "<meta http-equiv='refresh' content='1; url=orders.php'>";
    }
?>



