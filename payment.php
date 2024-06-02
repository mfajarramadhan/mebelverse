<?php namespace Midtrans; ?>

<!-- DATABASE READ -->
<?php
    include "koneksi.php"; include "session.php";
    $id_order = $_GET['idp'];
    $isBeingPaid = false;

    $result_order = mysqli_query($conn, "SELECT * FROM tbl_pemesanan WHERE id_pemesanan = $id_order");
    $read_order = mysqli_fetch_assoc($result_order);
    if($read_order['id_pelanggan'] != $_SESSION['id_login']) {
        echo "<script>window.location.href = 'index.php'</script>";
    }

    $result_produk = mysqli_query($conn, "SELECT * FROM tbl_produk WHERE id_produk = $read_order[id_produk]");
    $read_produk = mysqli_fetch_assoc($result_produk);

    $result_penjual = mysqli_query($conn, "SELECT nama, alamat FROM tbl_penjual WHERE id_penjual = $read_produk[id_penjual]");
    $read_penjual = mysqli_fetch_assoc($result_penjual);

    $result_pelanggan = "";
    $alamat = "";
    if($read_order['tipe_pelanggan'] == "Penjual") {
        $alamat = $read_penjual['alamat'];
    } else if($read_order['tipe_pelanggan'] == "User") {
        $result_alamat_buyer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT alamat FROM tbl_pelanggan WHERE id_pelanggan = $read_order[id_pelanggan]"));
        $alamat = $result_alamat_buyer['alamat'];
    }
?>


<!-- VARIABLE DECLARATION -->
<?php
    $nama_produk = $read_produk['nama'];
    $nama_penjual = $read_penjual['nama'];
    $harga_satuan = $read_produk['harga'];
    $jumlah = $read_order['jumlah'];
    $total_bayar = $read_order['total_harga'];
?>


<!-- PAYMENT GATEWAY -->
<?php
    // This is just for very basic implementation reference, in production, you should validate
    // the incoming requests and implement your backend more securely.
    // Please refer to this docs for snap popup: https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

    require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';
    Config::$serverKey = 'SB-Mid-server-4EQ-SrQ4uYIAvYGJb3BQIW7C';
    Config::$clientKey = 'SB-Mid-client-MFmW1YpwfVYA-3uf';

    printExampleWarningMessage();

    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Required
    $transaction_details = array(
        'order_id' => rand(),
        'gross_amount' => $jumlah, // no decimal allowed for creditcard
    );

    // Optional
    $item1_details = array(
        'id' => $id_order,
        'price' => $harga_satuan,
        'quantity' => $jumlah,
        'name' => $nama_produk
    );

    // Optional
    $item_details = array ($item1_details);

    // Fill transaction details
    $transaction = array(
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
    );

    $snap_token = '';
    try {
        $snap_token = Snap::getSnapToken($transaction);
    }
    catch (\Exception $e) {
        echo $e->getMessage();
    }

    function printExampleWarningMessage() {
        if (strpos(Config::$serverKey, 'your ') != false ) {
            echo "<code>";
            echo "<h4>Please set your server key from sandbox</h4>";
            echo "In file: " . __FILE__;
            echo "<br>";
            echo "<br>";
            echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-4EQ-SrQ4uYIAvYGJb3BQIW7C\';');
            die();
        } 
    }
?>







<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/payment.css?v=<?php echo time(); ?>">
        <title>Bayar Pesanan</title>
    </head>
    <body>
        <div class="detail_container">
            <div class="detail_title">
                <img src="img/avga/clean_1.webp">
                <h2 id="title">Bayar Pesananmu!</h2>
                <p id="subtitle">Pesananmu akan segera diproses setelah kamu membayarnya</p>
            </div>
            <div class="detail">
                <table>
                    <tr>
                        <td>Produk</td>
                        <td>:</td>
                        <td><?= $nama_produk; ?></td>
                    </tr>
                    <tr>
                        <td>Penjual</td>
                        <td>:</td>
                        <td><?= $nama_penjual; ?></td>
                    </tr>
                     <tr>
                        <td>Harga Satuan</td>
                        <td>:</td>
                        <td><?= $harga_satuan; ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td><?= $jumlah; ?></td>
                    </tr>
                    <tr>
                        <td>Total bayar</td>
                        <td>:</td>
                        <td><?= $total_bayar; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat pengiriman</td>
                        <td>:</td>
                        <td><?= $alamat; ?></td>
                    </tr>
                </table>
            </div>
            <div class="submit_container">
                <button id='checkout'>Checkout</button>
                <button id="batal">Batal</button>
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
            </div>
        </div>

        
        <script type="text/javascript">
            document.getElementById('checkout').onclick= function (){
                snap.pay('<?php echo $snap_token?>', {
                    onSuccess: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    onPending: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    onError: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            }

            document.getElementById('batal').onclick = function(){
                window.location.href = "home.php";
            }
        </script>
    </body>
</html>
