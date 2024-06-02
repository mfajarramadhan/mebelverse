<?php
    include "../koneksi.php";
    $id_penjual = $_GET['id'];
    $tipe_fotoprofil = $_GET['type'];

    $sql_foto = "SELECT foto_profil FROM tbl_penjual WHERE id_penjual='$id_penjual'";
    $result_foto = mysqli_query($conn, $sql_foto);
    $read_foto = mysqli_fetch_assoc($result_foto);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            padding: 0; margin: 0; width: 100%; aspect-ratio: 1/1; overflow: hidden;
            align-items: center; justify-content: center; display: flex; object-fit: cover;
            background-color: white;
        }
        img {width: 100%; aspect-ratio: 1/1; object-fit: cover;}
    </style>
</head>
<body>
    <?php if($read_foto['foto_profil'] != "") { ?>
        <img src="../img/profpic/<?= $read_foto['foto_profil']; ?>">
    <?php } else { if($tipe_fotoprofil == "j") { ?>
            <img src="../img/avga/unknown_profile.webp">
        <?php } else if($tipe_fotoprofil == "b") { ?>
            <img src="../img/avga/unknown_buyer.webp">
    <?php }} ?>
</body>
</html>