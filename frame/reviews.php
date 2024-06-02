<?php
    include "../koneksi.php";

    $id_produk = $_GET['id'];
    $sql_ulasan_all = mysqli_query($conn, "SELECT * FROM tbl_ulasan
        WHERE id_produk = '$id_produk' ORDER BY rating DESC");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/semua_ulasan.css?v=<?php echo time(); ?>">
    <title>Upload Produk</title>
</head>
<body class="ulasan">
    <h3>Rating Produk <?php
        $ulasan_jumlah = mysqli_num_rows($sql_ulasan_all);
        if($ulasan_jumlah > 0) {echo "(" . $ulasan_jumlah . " Ulasan)";}
    ?></h3>
    <?php
        if(mysqli_num_rows($sql_ulasan_all) == 0) {
    ?>
        <div id="blm_ada_ulasan">
            <p>Belum Ada Ulasan.<br>Beli produk untuk memberikan ulasan!</p>
        </div>
    <?php } else { $i = 0; ?>
        <div id="ulasan_container">
            <?php while ($result_ulasan = mysqli_fetch_assoc($sql_ulasan_all)) { ?>
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
            <?php } if(mysqli_num_rows($sql_ulasan_all) > 3) { ?>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>