<?php
    $tipe_profil_header = "";
    if(!empty($_SESSION)) {
        if($_SESSION['tipe_login'] == "Penjual") {
            $tipe_profil_header = "j";
        } else if ($_SESSION['tipe_login'] == "User") {
            $tipe_profil_header = "b";
        }
    }
?>

<head>
    <link rel="stylesheet" href="styles/header.css?v=<?php echo time(); ?>">
</head>
<div class="header_layouter"></div>
<div class="header_container" id="header_container">
    <!-- <h2 class="header_title">Detail Produk</h2> -->
    <div class="header_nav">
        <div class="header_icon_container">
            <div class="header_icon search_form">
                <a href="home.php" class="icon_item"><img src="img/icon/home.webp" alt="beranda"><p>Beranda</p></a>
                <!-- <input type="search" name="keyword" id=""> -->
                <form class="header_icon search_form" action="home.php" method="post">
                    <input type="text" placeholder="Cari Produk" name="keyword" class="search_input" autocomplete="off">
                    <button type="submit" id="btn_search" name="search">
                        <img src="img/icon/search.webp">
                    </button>
                </form>
            </div>
            <div class="header_icon">
                <!-- JUAL PRODUK -->
                <?php if(!empty($_SESSION)) { if($_SESSION['tipe_login'] == "Penjual") { ?>
                    <a onclick="open_upload_produk()" class="icon_item"><img src="img/icon/upload_2.webp"><p>Jual</p></a>
                <?php }} ?>

                <!-- KERANJANG -->
                <a onclick="open_keranjang()" class="icon_item"><img src="img/icon/cart.webp"><p>Keranjang</p></a>
                
                <!-- AKTIVITAS -->
                <?php if(!empty($_SESSION)) { ?>
                    <a href="orders.php" class="icon_item"><img src="img/icon/order.webp"><p>Aktivitas</p></a>
                <?php } else { ?>
                    <a onclick="open_keranjang()" class="icon_item"><img src="img/icon/order.webp"><p>Aktivitas</p></a>
                <?php } ?>

                <!-- PROFIL / LOGIN -->
                <?php if(empty($_SESSION)) { ?>
                    <a href="login.php" class="icon_item">
                        <img src="img/icon/login.webp"><p>Login</p>
                    </a>
                <?php } else { ?>
                    <a href="profile.php?id=<?= $_SESSION['id_login']; ?>&type=<?= $tipe_profil_header; ?>" class="icon_item">
                        <img src="img/icon/person.webp"><p>Anda</p>
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>
</div>

<!-- Iframe -->
<button onclick="close_upload_produk();" class="iframe_container" id="upload_produk_container">
    <iframe src="frame/upload_product.php?id_uploader=<?= $_SESSION['id_login']; ?>" id="upload_produk" frameborder="0"></iframe>
</button>
<!-- Iframe -->
<button onclick="close_keranjang();" class="iframe_container" id="keranjang_container">
    <iframe src="frame/cart.php" id="keranjang" frameborder="0"></iframe>
</button>






<script>
    var upload_produk = document.getElementById('upload_produk_container');
    var keranjang = document.getElementById('keranjang_container');

    function open_keranjang() {keranjang.style.display = "flex";}
    function close_keranjang() {keranjang.style.display = "none";}

    function open_upload_produk() {upload_produk.style.display = "flex";}
    function close_upload_produk() {upload_produk.style.display = "none";}
</script>



