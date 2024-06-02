<?php include '../koneksi.php'; include '../session.php'; ?>

<?php
    $id_hapus = ""; $sql = "";
    if(isset($_GET['idh'])) {
        $id_hapus = $_GET['idh'];
        mysqli_query($conn, "DELETE FROM tbl_produk WHERE id_produk = '$id_hapus'");
        mysqli_query($conn, "DELETE FROM tbl_ulasan WHERE id_produk = '$id_hapus'");
        // mysqli_query($conn, "DELETE FROM tbl_pemesanan WHERE id_produk = '$id_hapus'");

        echo "<script>setTimeout(() => {window.parent.location.href = '../home.php'}, 300);</script>";
    }
?>


<style>
    @import '../styles/root.css';
    @import '../styles/font.css';
    body {
        padding: 0; margin: 0; width: 100%; height: 100%; background: white;
        align-items: center; justify-content: center; display: flex;
        color: rgb(108, 114, 122);
    }
</style>

<h3>Menghapus...</h3>