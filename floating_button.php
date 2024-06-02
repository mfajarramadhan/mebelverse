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
    <style>
        .floatingbtn_container {
            z-index: 210;
            position: fixed; bottom: 0px; left: 0px; width: 100%;
            color: white; text-align: center; font-size: .88em;
            align-items: center; justify-content: flex-end; display: none;
        }
        .floatingbtn_content {
            background: linear-gradient(-45deg, rgb(78, 221, 240), rgb(39, 151, 255));
            padding: 8px 16px; border-radius: 100vh;
            margin-bottom: 16px; margin-right: 16px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.25);
        }
        .header_icon_container {
            width: 95%;
            max-width: 1300px;
            align-items: center; justify-content: space-between; display: flex; gap: 6px;
        }
        .fbtn_icon_item {
            transform: scale(.95); filter: opacity(.8);
            transition: .12s;
            padding: 4px 12px;
            border-radius: 12px;
        }
        .fbtn_icon_item:hover {
            padding: 4px 12px; filter: opacity(1), brightness(140%);
            transform: scale(1.02);
        }
        img {height: 27px;}
        #btn_to_login {
            /*  */
        }

        @media screen and (max-width: 680px) {
            .floatingbtn_container {justify-content: center; display: flex;}
            .floatingbtn_content {margin-right: 0px;}
        }
        @media screen and (max-width: 600px) {
            .floatingbtn_content {transform: scale(.92);}
        }
        @media screen and (max-width: 340px) {
            .floatingbtn_content {transform: scale(.82);}
        }
        @media screen and (max-width: 280px) {
            .floatingbtn_content {transform: scale(.78);}
        }
    </style>
</head>


<div class="floatingbtn_container">
    <div class="floatingbtn_content">
        <div class="header_icon_container">
            <!-- JUAL PRODUK -->
            <?php if(!empty($_SESSION)) { if($_SESSION['tipe_login'] == "Penjual") { ?>
                <a onclick="open_upload_produk()" class="fbtn_icon_item"><img src="img/icon/upload_2.webp"><p>Jual</p></a>
            <?php }} ?>

            <!-- KERANJANG -->
            <a onclick="open_keranjang()" class="fbtn_icon_item"><img src="img/icon/cart.webp" alt="keranjang"><p>Keranjang</p></a>

            <!-- AKTIVITAS -->
            <?php if(!empty($_SESSION)) { ?>
                <a href="daftar_pesanan.php" class="fbtn_icon_item"><img src="img/icon/order.webp" alt="pesanan"><p>Aktivitas</p></a>            
            <?php } else { ?>
                <a onclick="open_keranjang()" class="fbtn_icon_item"><img src="img/icon/order.webp" alt="pesanan"><p>Aktivitas</p></a>            
            <?php } ?>

            <!-- PROFIL / LOGIN -->
            <?php if(empty($_SESSION)) { ?>
                <a href="login.php" class="fbtn_icon_item">
                    <img src="img/icon/login.webp"><p>Login</p>
                </a>
            <?php } else { ?>
                <a href="profile.php?id=<?= $_SESSION['id_login']; ?>&type=<?= $tipe_profil_header; ?>" class="fbtn_icon_item">
                    <img src="img/icon/person.webp"><p>Anda</p>
                </a>
            <?php } ?>

        </div>
    </div>
</div>