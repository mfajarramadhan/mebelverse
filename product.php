<?php
    include "koneksi.php"; include "session.php";
    $id_produk = $_GET['id'];
    $isMyProduct = "";

    $sql = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_produk = '$id_produk'");
    $result = mysqli_fetch_assoc($sql);
    if(!empty($_SESSION)) {
        if($_SESSION['tipe_login'] == "Penjual" && $_SESSION['id_login'] == $result['id_penjual']) {
            $isMyProduct = "true";
        } else {$isMyProduct = "false";}
    } else {$isMyProduct = "false";}

    $sql_publisher = mysqli_query($conn, "SELECT * FROM tbl_penjual WHERE id_penjual = '$result[id_penjual]'");
    $result_publisher = mysqli_fetch_assoc($sql_publisher);

    $sql_kategori = mysqli_query($conn, "SELECT nama FROM tbl_kategori WHERE id_kategori = '$result[jenis_produk]'");
    $read_kategori = mysqli_fetch_assoc($sql_kategori);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/detail_produk.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/product_item.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <title><?= $result['nama']; ?> | <?= $result_publisher['nama'] ?></title>
</head>

<body onload="click_deskripsi()">
    <!-- header -->
    <?php include "header.php"; ?>

    <!-- Body Content -->
    <div class="body_content">

        <!-- Container -->
        <div id="container">
            <!-- Detail -->
            <div class="detail interactive2">
                <div class="gambar" id="scene">
                    <?php if($result['format_visual'] != "3d") {
                        if($result['visual'] == "") {?>
                                <img src="img/avga/unknown_product.webp" />
                            <?php } else { ?>
                                <img src="<?php echo 'img/produk/'.$result['visual']; ?>" />
                        <?php } ?>
                    <?php } else {
                        // include "js/scene_3d.php";
                    ?>
                        <script>var nama_file = "<?php echo $result['visual']; ?>";</script>
                        <script type="module" src="js/scene_3d.js?v=<?php echo time();?>"></script>
                        
                    <?php } ?>
                </div>
                <div class="produk_container">
                    <div>
                        <h1 id="produk_nama"><?= $result['nama']; ?></h1>
                        <h1 id="produk_harga">Rp<?= number_format($result['harga'], 2, ',', '.'); ?>,-</h1>
                        <p><?= $result['stok'] ?> tersedia</p>
                        <div class="set">
                            <button id="btn_deskripsi" onclick="click_deskripsi();">Deskripsi</button>
                            <button id="btn_ulasan" onclick="click_spesifikasi();">Spesifikasi</button>
                        </div>
                        <div id="spek_container">
                            <div class="spek" id="spek">
                                <p id="deskripsi_area">
                                    <?php
                                        if($result['deskripsi'] != "") {echo $result['deskripsi'];}
                                        else {echo "<i>Penjual tidak mencantumkan deskripsi</i>";}
                                    ?>
                                </p>
                                <div id="spek_area">
                                    <table>
                                        <tr><td><p><b>Kategori</b></p></td><td><p>
                                            <?= $read_kategori['nama']; ?>
                                        </p></td></tr>
                                        <tr><td><p><b>Kondisi</b></p></td><td><p><?= $result['kondisi']; ?></p></td></tr>
                                        <tr><td><p><b>Berat</b></p></td><td><p><?= $result['berat']; ?> Kg</p></td></tr>
                                        <tr><td><p><b>Cacat</b></p></td><td><p>
                                            <?php if($result['cacat'] == "") {echo "Tidak Ada";}
                                            else {echo $result['cacat'];} ?>
                                        </p></td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($isMyProduct != "true") { ?>
                        <div class="pesan">
                            <div id="set_pesan">
                                <button onclick="minus();" id="minus"><h3>-</h3></button>
                                <input type="number" id="jumlah_pesan" value="1">
                                <button onclick="plus();" id="plus"><h3>+</h3></button>
                            </div>
                            <form method="post">
                                <input type="number" name="jumlah_pesan" id="input_imaginer">
                                <button onclick="pesan();" id="btn_pesan" type="submit" name="pesan_produk">
                                    <img src="img/icon/cart.webp">
                                    Pesan Produk
                                </button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="pesan">
                            <div id="set_pesan">
                                <div id="jumlah_pesan" style="display: none;"></div>
                                <button id="btn_myproduct" onclick="open_edit_produk();">Edit Produk</button>
                                <button id="btn_myproduct" onclick="open_yakin_hapus();">Hapus Produk</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Right -->
            <div class="right">
                <div id="publisher" class="interactive" href="profil_penjual.php?">
                    <a id="publisher_direct" href="profile.php?id=<?= $result['id_penjual'] ?>&type=j">
                        <?php if($result_publisher['foto_profil'] != "") { ?>
                            <img src="img/profpic/<?= $result_publisher['foto_profil']; ?>" id="profpic">
                        <?php } else { ?>
                            <img src="img/avga/unknown_profile.webp" id="profpic">
                        <?php } ?>
                        <div>
                            <h3><?php if($isMyProduct == "true") {echo "Anda";} else {echo $result_publisher['nama'];} ?></h3>
                            <?php
                                $sql_jumlah = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_penjual = '$result_publisher[id_penjual]'");
                            ?>
                            <p>Menjual <?php echo mysqli_num_rows($sql_jumlah); ?> Produk</p>
                        </div>
                    </a>
                    <button class="interactive"><img src="img/logo/logo_wa.webp"
                        onclick=
                        "window.open('https://wa.me/62<?= $result_publisher['no_telepon'] ?>');">
                    </button>
                </div>
    
                <div class="ulasan interactive">
                    <?php
                        $sql_ulasan_all = mysqli_query($conn, "SELECT * FROM tbl_ulasan
                            WHERE id_produk = '$id_produk' ORDER by rating DESC");
                        $sql_ulasan = mysqli_query($conn, "SELECT * FROM tbl_ulasan
                        WHERE id_produk = '$id_produk' ORDER by rating DESC LIMIT 4");
                    ?>
                    <h3>Rating Produk <?php
                        $ulasan_jumlah = mysqli_num_rows($sql_ulasan_all);
                        if($ulasan_jumlah > 0) {echo "(" . $ulasan_jumlah . " Ulasan)";}
                    ?></h3>
                    <?php
                        if(mysqli_num_rows($sql_ulasan) == 0) {
                    ?>
                        <div id="blm_ada_ulasan">
                            <img src="img/avga/tidak_ada_hasil.webp">
                            <h3>Belum ada ulasan</h3><p>Beli produk untuk memberikan ulasan!</p>
                        </div>
                    <?php } else { $i = 0; ?>
                        <div id="ulasan_container">
                            <?php while ($result_ulasan = mysqli_fetch_assoc($sql_ulasan)) {
                                if($i < 3) { ?>
                                <div class="ulasan_item interactive2">
                                    <div class="rating_container">
                                        <p><b><?= $result_ulasan['rating'] ?>/5</b></p>
                                        <?php
                                            $a = 0;
                                            while ($a < 5) {
                                                
                                        ?>
                                        <svg height="12px" width="12px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                            viewBox="0 0 47.94 47.94" xml:space="preserve">
                                            <path style="fill:<?php if($a < $result_ulasan['rating'])
                                                {echo "#ED8A19";} else {echo "#888";}
                                            ?>;"
                                            d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757
                                            c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042
                                            c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685
                                            c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528
                                            c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956
                                            C22.602,0.567,25.338,0.567,26.285,2.486z"/>
                                        </svg>
                                        <?php  $a++; } ?>
                                    </div>
                                    <p><?= $result_ulasan['ulasan'] ?></p>
                                </div>
                            <?php } $i++;} if(mysqli_num_rows($sql_ulasan) > 3) { ?>
                            <!-- <form action="" method="post"> -->
                            <button onclick="open_semua_ulasan()" name="lihat_semua_ulasan">Lihat Semua Ulasan</button>
                            <!-- </form> -->
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Additional -->
        <div id="additional">
            <div class="allproduk_container">
                <?php
                    $result_addition = mysqli_query($conn,
                    "SELECT * FROM tbl_produk WHERE id_penjual = '$result[id_penjual]' ORDER BY RAND()");
                ?>
                <?php if(mysqli_num_rows($result_addition) > 1) { ?>
                    <h2>Produk lainnya dari <?php if($isMyProduct == "true") {echo "Anda";}
                        else {echo $result_publisher['nama'];} ?></h2>
                <?php } ?>
                <div class="allproduk_content">
                    <div class="allproduk" >

                <!-- ============================================================================================== -->
                <script>
                    var jum_scene_3d = 1;
                    var nama_file_gltf = [];
                </script>
                <?php
                while($read_addition = mysqli_fetch_assoc($result_addition)):
                    if($read_addition['id_produk'] == $id_produk) {} else { ?>
                <a class="produk_item">
                    <div class="pi_detail">
                        <?php if($read_addition['format_visual'] != "3d") { ?>
                            <div class="pi_gambar">
                                <img src="<?php
                                    if($read_addition['visual'] == "") {echo "img/avga/unknown_product.webp";}
                                    else {echo 'img/produk/'.$read_addition['visual'];}
                                ?>">
                            </div>
                        <?php } else { ?>
                            <script>
                                document.write("<div class='pi_gambar pi_3d' id='scene_" + jum_scene_3d + "'></div>");
                                nama_file_gltf[jum_scene_3d] = "<?= $read_addition['visual'] ?>";
                            </script>
                            <script>jum_scene_3d++;</script>
                        <?php } ?>
                        <div class="pi_deskripsi">
                            <div class="pi_nama">
                                <p><?= $read_addition['nama']; ?></p>
                            </div>
                            <div class="pi_harga">
                                <p>Rp<?= number_format($read_addition['harga'], 0, ',', '.'); ?>,-</p>
                                <div class="pi_rate">
                                    <?php if($read_addition['rating'] > .1) { ?>
                                        <p><?= round($read_addition['rating'], 1); ?></p>
                                        <?php include 'img/svg/star.svg'; ?>
                                    <?php } else { ?>
                                        <p style="visibility: hidden;">0</p>
                                        <?php include 'img/svg/star_inactive.svg'; ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="product_btn_container">
                                <button class="product_btn" onclick="window.location.href = 'product.php?id=<?php echo $read_addition['id_produk']; ?>'">Lihat</button>
                            </div>
                        </div>
                    </div>
                </a>
                <?php } endwhile; ?>
                <script src="js/scene_3d_multi.js?v=<?php echo time(); ?>" type="module"></script>
                <!-- ============================================================================================== -->



                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Iframe Review -->
    <button onclick="close_semua_ulasan();" class="iframe_container" id="semua_ulasan_container">
        <iframe src="frame/reviews.php?id=<?= $id_produk; ?>" id="semua_ulasan" frameborder="0"></iframe>
    </button>
    <!-- Yakin Hapus Produk -->
    <?php if($isMyProduct == "true") { ?>
        <button onclick="close_yakin_hapus();" class="iframe_container" id="yakin_hapus">
            <iframe src="frame/confirm_delete.php?idh=<?= $id_produk; ?>" id="semua_ulasan" frameborder="0"></iframe>
        </button>
    <?php } ?>
    <!-- Iframe edit produk -->
    <?php if($isMyProduct == "true") { ?>
        <button onclick="close_edit_produk();" class="iframe_container" id="edit_produk_container">
            <iframe src="frame/edit_product.php?id_produk=<?= $id_produk; ?>" id="edit_produk" frameborder="0"></iframe>
        </button>
    <?php } ?>

    <!-- Footer -->
    <?php include "footer.html"; ?>

    <!-- Floating Button -->
    <?php include "floating_button.php"; ?>

</body>
</html>



<?php
    if(isset($_POST['pesan_produk'])) {
        if(empty($_SESSION)) {
            echo "<script>open_keranjang();</script>";
        }
        else {
            $id_pelanggan_pesan = $_SESSION['id_login'];
            $tipe_pelanggan = $_SESSION['tipe_login'];
            $id_produk_pesan = $result['id_produk'];
            $jumlah = $_POST['jumlah_pesan'];
            if(!is_numeric($jumlah)) {$jumlah = 1;}
            date_default_timezone_set('Asia/Jakarta');
            $time_now = date("Y-m-d h:i:s");
            $total_harga = $result['harga'] * $jumlah;
    
            $sql_pesan = "INSERT INTO tbl_pemesanan
            (id_pelanggan, tipe_pelanggan, id_produk, jumlah, waktu_pemesanan, total_harga, status) VALUES
            ('$id_pelanggan_pesan', '$tipe_pelanggan', '$id_produk_pesan', $jumlah, '$time_now', '$total_harga', 'Keranjang')";
            mysqli_query($conn, $sql_pesan);
            echo "<script>open_keranjang();</script>";
        }
    }
?>





<script>

    var btn_deskripsi = document.getElementById('btn_deskripsi');
    var deskripsi = document.getElementById('deskripsi_area');
    var spesifikasi = document.getElementById('spek_area');
    var btn_spesifikasi = document.getElementById('btn_ulasan');
    var jumlah_value = parseInt(document.getElementById('jumlah_pesan').value);
    var spek = document.getElementById('spek');
    
    function click_deskripsi() {
        btn_deskripsi.style.borderBottom = '2px solid blue';
        deskripsi.style.filter = "opacity(1)";
        btn_spesifikasi.style.borderBottom = '2px solid transparent';
        spesifikasi.style.filter = "opacity(0)";
        spek.style.transform = "translateX(calc(0%))";
    }
    function click_spesifikasi() {
        btn_deskripsi.style.borderBottom = '2px solid transparent';
        deskripsi.style.filter = "opacity(0)";
        btn_spesifikasi.style.borderBottom = '2px solid blue';
        spesifikasi.style.filter = "opacity(1)";
        spek.style.transform = "translateX(calc(-50%))";
    }


    function pesan() {
        // window.location.href = "pesan_produk.php";
    }
    function plus() {
        jumlah_value++;
        document.getElementById('jumlah_pesan').value = jumlah_value;
        document.getElementById('input_imaginer').value = jumlah_value;
    }
    function minus() {
        if(jumlah_value > 1) {jumlah_value--;}
        document.getElementById('jumlah_pesan').value = jumlah_value;
        document.getElementById('input_imaginer').value = jumlah_value;
    }

    var semua_ulasan = document.getElementById('semua_ulasan_container');
    function open_semua_ulasan() {semua_ulasan.style.display = "flex";}
    function close_semua_ulasan() {semua_ulasan.style.display = "none";}

    edit_produk = document.getElementById("edit_produk_container");
    function open_edit_produk() {edit_produk.style.display = "flex";}
    function close_edit_produk() {edit_produk.style.display = "none"; window.location.reload();}

    yakin_hapus = document.getElementById('yakin_hapus');
    function open_yakin_hapus() {yakin_hapus.style.display = "flex";}
    function close_yakin_hapus() {yakin_hapus.style.display = "none";}

</script>