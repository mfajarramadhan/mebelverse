<?php
    include "../koneksi.php"; include "../session.php";
    if(!$_SESSION) {
        echo "<script>window.location.href = 'need_login.html'</script>";
    }
    else {
        $id_pelanggan = $_SESSION['id_login'];
        $tipe_pelanggan = $_SESSION['tipe_login'];

        $sql_pemesanan = "SELECT * FROM tbl_pemesanan
            WHERE id_pelanggan='$_SESSION[id_login]'
            AND tipe_pelanggan='$tipe_pelanggan'
            AND status='Keranjang'";
        $result_pemesanan = mysqli_query($conn, $sql_pemesanan);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/keranjang.css?v=<?php echo time(); ?>">
    <title>Upload Produk</title>
    <!-- midtrans paymentGetway -->
    <script type="text/javascript"
        src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-MFmW1YpwfVYA-3uf">
    </script>
    <!-- end midtrans paymentGetway -->
</head>
<body>
    <div class="keranjang_container">

        <div class="title_img_container">
            <img src="../img/avga/cart.webp">
            <div>
                <h2 id="title">Keranjangmu</h2>
                <p id="subtitle">Yuk, bayar pesananmu!</p>
            </div>
        </div>

        <?php
            $index = 1;
            while ($read_keranjang = mysqli_fetch_assoc($result_pemesanan)) {

                // query produk
                $sql_keranjang_produk = mysqli_query($conn,
                "SELECT nama, harga, id_penjual, visual FROM tbl_produk WHERE id_produk='$read_keranjang[id_produk]'");
                $read_produk = mysqli_fetch_assoc($sql_keranjang_produk);
                
                // query nama penjual
                $sql_keranjang_penjual = mysqli_query($conn,
                "SELECT * FROM tbl_penjual WHERE id_penjual = '$read_produk[id_penjual]'");
                $read_penjual = mysqli_fetch_assoc($sql_keranjang_penjual);
                $total_harga = $read_produk['harga'] * $read_keranjang['jumlah'];
        ?>
            <div class="keranjang_item">
                <div class="keranjang_left">
                    <?php if($read_produk['visual'] != "") { ?>
                        <img src="../img/produk/<?= $read_produk['visual']; ?>">
                    <?php } else { ?>
                        <img src="../img/avga/unknown_product.webp">
                    <?php }?>
                </div>
                <div class="keranjang_center">
                    <div>
                        <!-- Nama produk -->
                        <p id="nama_container"><?= $read_produk['nama']; ?></p>

                        <!-- Nama penjual -->
                        <p><?= $read_penjual['nama']; ?></p>
                    </div>
                    <!-- Total harga -->
                    <p>Total Rp<?= number_format($total_harga, 0, ',', '.'); ?>,-</p>
                </div>
                <div class="keranjang_right">
                    <div>
                        <div class="set_pesan">
                            <button onclick="minus(<?=$index;?>)" id="minus"><h3>-</h3></button>
                            <!-- Jumlah Produk -->
                            <input type="text" id="jumlah_pesan_<?=$index;?>" value="<?= $read_keranjang['jumlah']; ?>">
                            <button onclick="plus(<?=$index;?>)" id="plus"><h3>+</h3></button>
                        </div>

                        <?php 

                              $pelanggan   = mysqli_query($conn, "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$_SESSION[id_login]'");
                              $read_alamat = mysqli_fetch_assoc($pelanggan);
                              
                        ?>
                        <!-- lanjut ke halaman pembayaran -->
                            <button class="lanjut_beli" id="checkout-button"
                                 onclick="window.parent.location.href = '../payment.php?idp=<?= $read_keranjang['id_pemesanan']; ?>'">
                                Lanjut Bayar
                            </button>
                      
                    </div>
                </div>
            </div>
        <?php $index++;} ?>
    </div>

    <script>
        function plus(index) {
            jumlah_value = parseInt(document.getElementById('jumlah_pesan_'+index).value);
            jumlah_value++;
            document.getElementById('jumlah_pesan_'+index).value = jumlah_value;
        }
        function minus(index) {
            jumlah_value = parseInt(document.getElementById('jumlah_pesan_'+index).value);
            if(jumlah_value > 1) {jumlah_value--;}
            document.getElementById('jumlah_pesan_'+index).value = jumlah_value;
        }
    </script>
</body>
</html>



<?php
    }
?>