<?php
     include "koneksi.php"; include "session.php";
    
     $id_profil = $_GET['idj'];
     $sql_profil = "SELECT * FROM tbl_penjual WHERE id_penjual = $id_profil";
     $result_profil = mysqli_query($conn, $sql_profil);
     $read_profil = mysqli_fetch_assoc($result_profil);

     $sql_produk = "SELECT visual FROM tbl_produk WHERE id_penjual = $id_profil AND format_visual='3d'";
     $result_produk = mysqli_query($conn, $sql_produk);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/immersive_scene.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
    <title>Immersive - <?= $read_profil['nama']; ?></title>
</head>
<body>
    <div id="scene"></div>
    <div id="black_fade"><h3 id="loading_log">Waiting...</h3></div>
</body>
</html>

<script>
    var produk_items = [];
    <?php while ($read_produk = mysqli_fetch_assoc($result_produk)) { ?>
        produk_items.push('<?= $read_produk['visual']; ?>');
    <?php } ?>
</script>
<script type="module" src="js/immersive_showroom.js?v=<?php echo time(); ?>">
</script>