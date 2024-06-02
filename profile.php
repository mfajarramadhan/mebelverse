<?php
    include "koneksi.php"; include "session.php";
    
    $id_profil = $_GET['id'];
    $tipe_profil = $_GET['type'];
    $isMyProfile = "";

    $sql = ""; $result = ""; $result_produk = "";
    if($tipe_profil == "j") {
        $sql = mysqli_query($conn, "SELECT * FROM tbl_penjual WHERE id_penjual = '$id_profil'");
        $result = mysqli_fetch_assoc($sql);
        $result_produk = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_penjual = '$id_profil'");
    }
    else if($tipe_profil == "b") {
        $sql = mysqli_query($conn, "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$id_profil'");
        $result = mysqli_fetch_assoc($sql);
    }

    // isMyProfile validation
    if(!empty($_SESSION)) {
        if($id_profil == $_SESSION['id_login']) {
            if($tipe_profil == "j" && $_SESSION['tipe_login'] == "Penjual") {
                $isMyProfile = "true";
            }
            else if($tipe_profil == "b" && $_SESSION['tipe_login'] == "User") {
                $isMyProfile = "true";
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/product_item.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/profil.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title>
        <?php if($tipe_profil == "j") {echo "Toko ";} else if ($tipe_profil == "b") {echo "Pembeli ";} ?>
        | <?= $result['nama']; ?>
    </title>
</head>

<body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <!-- Detail Toko -->
    <div class="detail_toko">
        <!-- Left -->
        <div class="detail_toko_child" id="detail_toko_left">
            <div id="img_name">
                <button id="detail_img_container" onclick="open_foto_profil()">
                    <?php if($result['foto_profil'] != "") { ?>
                        <img src="img/profpic/<?= $result['foto_profil']; ?>">
                    <?php } else { if($tipe_profil == "j") { ?>
                            <img src="img/avga/unknown_profile.webp">
                        <?php } else if($tipe_profil == "b") { ?>
                            <img src="img/avga/unknown_buyer.webp">
                    <?php }} ?>
                </button>
                <div>
                    <h2><?= $result['nama']; ?></h2>
                    <p>
                        <?php if($tipe_profil == "j") {echo "Penjual";} 
                        else if($tipe_profil == "b") {echo "Pembeli";} ?>
                    </p>
                </div>
            </div>
            <div id="detail_content">
                <div id="detail_content_div">
                    <table>
                        <?php if($tipe_profil == "j") { ?>
                            <tr>
                                <td>Jumlah Produk Dijual</td><td>:</td><td><?php echo mysqli_num_rows($result_produk); ?> Produk</td>
                            </tr>
                        <?php } ?>
                        <tr><td>No. Telepon</td><td>:</td><td>0<?php echo $result['no_telepon']; ?></td></tr>
                        <tr><td>Alamat Email</td><td>:</td><td><?php echo $result['email']; ?></td></tr>
                        <?php if($tipe_profil == "j") { ?>
                            <tr><td>Lokasi Toko</td>
                        <?php } else if($tipe_profil == "b") { ?>
                            <tr><td>Kota</td>
                        <?php } ?>
                        <td>:</td><td><?php echo $result['kota']; ?></td></tr>
                    </table>
                    <div id="deskripsi_container">
                        <?php if($tipe_profil == "j") { ?>
                            <p id="title_deskripsi"><b>Deskripsi Toko</b></p>
                            <?php if(!$result['deskripsi_penjual']) { ?>
                                <p><i>Penjual belum mempunyai deskripsi.</i></p>
                            <?php } else { ?>
                                <p><?= $result['deskripsi_penjual']; ?></p>
                            <?php } ?>
                        <?php } else if($tipe_profil == "b") { ?>
                            <p id="title_deskripsi"><b>Alamat</b></p>
                            <p><?= $result['alamat']; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right -->
        <div class="detail_toko_child" id="detail_toko_right">
            <?php if($isMyProfile != "true") { ?>
                <button class="button_right" onclick="window.open('https://wa.me/62<?= $result['no_telepon']  ?>')">
                    <img src="img/logo/logo_wa.webp">
                    <span>Hubungi Whatsapp</span>
                </button>
            <?php } ?>
            <button class="button_right" id="btn_immersive" onclick="immersive_scene();">
                <img src="img/icon/immersive.webp">
                <span>Immersive Showroom</span>
            </button>
            <div id="black_fade"></div>
            <?php if($isMyProfile == "true") { ?>
                <button class="button_right" onclick="open_edit_profil()">
                    <img src="img/icon/edit.webp">
                    <span>Edit Profil</span>
                </button>
                <button class="button_right" onclick="window.location.href = 'logout.php'">
                    <img src="img/icon/logout.webp">
                    <span>Logout</span>
                </button>
            <?php } else { ?>
                <button class="button_right">
                    <span>Follow</span>
                </button>
            <?php } ?>
        </div>
    </div>

    <!-- PRODUK PENJUAL -->
    <?php if($tipe_profil == "j") { ?>
        <!-- Menu -->
        <div class="menu">
            <a>Beranda</a>
            <a>Semua Produk</a>
            <a>Promo</a>
        </div>
        <!-- Produk -->
        <div class="allproduk_container">
            <div class="allproduk_content">
                <div class="allproduk" >
                    


                    <!-- ============================================================================================== -->
                    <script>
                        var jum_scene_3d = 1;
                        var nama_file_gltf = [];
                    </script>
                    <?php
                    while($read = mysqli_fetch_assoc($result_produk)):?>
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
                    <?php endwhile; ?>
                    <script src="js/scene_3d_multi.js?v=<?php echo time(); ?>" type="module"></script>
                    <!-- ============================================================================================== -->




                </div>
            </div>
        </div>
    <?php } ?>


    <!-- Iframe - Foto Profil -->
    <button onclick="close_foto_profil();" class="iframe_container" id="foto_profil_container">
        <iframe src="frame/profile_picture.php?id=<?= $id_profil; ?>&type=<?= $tipe_profil; ?>"
        id="foto_profil" frameborder="0"></iframe>
    </button>

    <!-- Iframe - Edit Profil -->
    <?php if($isMyProfile == "true") { ?>
        <button onclick="close_edit_profil();" class="iframe_container" id="edit_profil_container">
            <iframe src="frame/edit_profile.php?id=<?= $id_profil; ?>" id="edit_profil" frameborder="0"></iframe>
        </button>
    <?php } ?>

    <!-- Footer -->
    <?php include 'footer.html'; ?>

    <!-- Floating Button -->
    <?php include "floating_button.php"; ?>

</body>
</html>




<script>
    var foto_profil = document.getElementById('foto_profil_container');
    var edit_profil = document.getElementById('edit_profil_container');
    var black_fade = document.getElementById('black_fade');
    var header_container = document.getElementById('header_container');

    function open_foto_profil() {foto_profil.style.display = "flex";}
    function close_foto_profil() {foto_profil.style.display = "none";}
    function open_edit_profil() {edit_profil.style.display = "flex";}
    function close_edit_profil() {edit_profil.style.display = "none"; window.location.reload();}


    function immersive_scene() {
        black_fade.style.animation = "black_fade 1.4s forwards";
        header_container.style.transition = ".7s";
        header_container.style.filter = "brightness(0%)";
        setTimeout(() => {
            btn_immersive.style.animation = "btn_to_black .7s forwards";
        }, 2400);
        setTimeout(() => {
            window.location.href = "immersive_scene.php?idj=<?= $id_profil; ?>";
        }, 4000);
    }
</script>