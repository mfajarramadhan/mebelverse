<?php
    include "koneksi.php"; include "session.php";

    $keyword = "";
    $sql = "SELECT * FROM tbl_produk ORDER BY RAND() LIMIT 30";
    $result = mysqli_query($conn, $sql);
    
    if(isset($_POST['search'])){
        $sql = "SELECT * FROM tbl_produk WHERE nama LIKE '%$_POST[keyword]%' ORDER BY RAND() LIMIT 30";
        $result = mysqli_query($conn, $sql);
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/beranda.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/product_item.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>Mebelverse | Home</title>
</head>
<body>

    <!-- Header -->
    <?php include "header.php"; ?>

    <!-- Home Banner Container -->
    <div class="banner_container">
        <div class="banner">
            <a class="banner_item banner_left"
                href="https://youtu.be/ZIICgY2oZtk?si=s3byACHdksOnz5g4" target="_blank">
                <img src="img/banner_left.webp">
            </a>
            <a class="banner_item banner_right">
                <img src="img/banner_right.webp">
            </a>
        </div>
    </div>

    <!-- Produk -->
    <div class="content">
        <div class="allproduk_container">
            <div class="allproduk_content">
                <div class="allproduk" >



                <!-- ============================================================================================== -->
                <script>
                    var jum_scene_3d = 1;
                    var nama_file_gltf = [];
                </script>
                <?php
                if(mysqli_num_rows($result) > 0) {
                while($read = mysqli_fetch_assoc($result)): ?>
                <a class="produk_item">
                    <div class="pi_detail">
                        <?php if($read['format_visual'] != "3d") { ?>
                            <div class="pi_gambar">
                                <img src="<?php
                                    if($read['visual'] == "") {echo "img/avga/unknown_product.webp";}
                                    else {echo 'img/produk/'.$read['visual'];}
                                ?>">
                            </div>
                        <?php } else { ?>
                            <script>
                                document.write("<div class='pi_gambar pi_3d' id='scene_" + jum_scene_3d + "'></div>");
                                nama_file_gltf[jum_scene_3d] = "<?= $read['visual'] ?>";
                            </script>
                            <script>jum_scene_3d++;</script>
                        <?php } ?>
                        <div class="pi_deskripsi">
                            <div class="pi_nama">
                                <p><?= $read['nama']; ?></p>
                            </div>
                            <div class="pi_harga">
                                <p>Rp<?= number_format($read['harga'], 0, ',', '.'); ?>,-</p>
                                <div class="pi_rate">
                                    <?php if($read['rating'] > .1) { ?>
                                        <p><?= round($read['rating'], 1); ?></p>
                                        <?php include 'img/svg/star.svg'; ?>
                                    <?php } else { ?>
                                        <p style="visibility: hidden;">0</p>
                                        <?php include 'img/svg/star_inactive.svg'; ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="product_btn_container">
                                <button class="product_btn" onclick="window.location.href = 'product.php?id=<?php echo $read['id_produk']; ?>'">Lihat</button>
                            </div>
                        </div>
                    </div>
                </a>
                <?php  endwhile; ?>
                <script src="js/scene_3d_multi.js?v=<?php echo time(); ?>" type="module"></script>
                <!-- ============================================================================================== -->
                <?php } else { ?>
                    <div id="no_result">
                        <img src="img/avga/tidak_ada_hasil.webp">
                        <div>
                            <h1>Tidak Ada Produk</h1>
                            <p>Mungkin coba cari produk yang lain?</p>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>  
        </div>
    </div>

    
    <!-- Footer -->
    <?php include "footer.html"; ?>

    <!-- Floating Button -->
    <?php include "floating_button.php"; ?>

</body>
</html>