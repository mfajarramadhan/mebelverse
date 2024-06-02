<?php
    $id_hapus = $_GET['idh'];
?>

<head>
    <link rel="stylesheet" href="../styles/confirm_delete.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- <div class="title_img_container">
        <img src="../img/avga/clean_1.webp">
    </div> -->
    <h2>Yakin hapus produk?</h2>
    <p>
        Produk yang telah dihapus tidak bisa dipuhlikan. Data-data produk tidak bisa dikembalikan.
    </p>
    <br><br><br>
    <a class="btn" href="delete_product.php?idh=<?= $id_hapus; ?>">Hapus</a>
    <button class="btn" id="btn_batal_hapus" onclick="window.parent.close_yakin_hapus()">Batal</button>
</body>