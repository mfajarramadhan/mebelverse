<?php
    include "../Koneksi.php"; include "../session.php";
    
    $id_produk = $_GET['idpr'];
    $id_pembeli = $_SESSION['id_login'];
    $tipe_login = $_SESSION['tipe_login'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/upload_review.css?v=<?php echo time(); ?>">
    <title>Upload Review</title>
</head>
<body onload="getStars(0)">
    <div id="rate_produk_container">
        <h3>Beri Ulasan Untuk Produk Ini!</h3>
        <div id="rate">
            <!-- RATING STARS - BUILT BY JAVASCRIPT -->
        </div>
        <p id="require_rating">Berikan rate untuk produk ini</p>
    </div>
    <form method="post">
        <input type="text" name="rate" id="rate_num" style="display: none;">
        <textarea name="ulasan" id="ulasan" rows="5"
            placeholder="Beri ulasan terbaik untuk produk ini!"></textarea>
        <div id="submit_container">
            <button onclick="return validate()" name="upload_ulasan">Kirim Ulasan</button>
            <button onclick="close(); window.parent.close_upload_review();">Batal</button>
        </div>
    </form>

<script>
    var rate = document.getElementById('rate');

    function close() {
        setRate(0); document.getElementById('ulasan').value = "";
    }

    function getStars(active_num) {
        var rate_stars = "";
        for(var i = 1; i <= 5; i++) {
            rate_stars += "<button class='star' onclick='setRate(" + i + ")'><svg height='28px' width='28px' version='1.1' id='Capa_1' " +
            "xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 47.94 47.94' xml:space='preserve'>";
            if(i <= active_num) {rate_stars += "<path style='fill:#ffa000' ";} else {rate_stars += "<path style='fill:#aaa' ";}
            rate_stars += "d='M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757" +
            "c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042 " +
            "c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685 " +
            "c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528 " +
            "c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956" +
            "C22.602,0.567,25.338,0.567,26.285,2.486z'/></svg></button>";
        } rate.innerHTML = rate_stars;
    }

    function setRate(i) {
        document.getElementById('rate_num').value = i;
        getStars(i);
    }

    function validate() {
        if(document.getElementById('rate_num').value < 1) {
            var require_rating = document.getElementById('require_rating');
            require_rating.style.visibility = "visible";
            require_rating.style.filter = "opacity(100%)";
            require_rating.style.transform = "translateY(0px)";
            return false;
        } else {return true;}
    }
</script>

</body>
</html>


<?php
    if(isset($_POST['upload_ulasan'])) {
        $rate = $_POST['rate'];
        $ulasan = $_POST['ulasan'];

        $sql_insert_review = "INSERT INTO tbl_ulasan (id_produk, id_pembeli, tipe_pembeli, ulasan, rating)
            VALUES ('$id_produk', '$id_pembeli', '$tipe_login', '$ulasan', '$rate')";
        mysqli_query($conn, $sql_insert_review);
        echo "<script>window.location.href = 'thanks_for_review.html'</script>";
        
        $rate_sum = 0; $rate_num = 0;
        $sql_read_rate = mysqli_query($conn, "SELECT rating FROM tbl_ulasan WHERE id_produk = '$id_produk'");
        while ($result_reviews = mysqli_fetch_assoc($sql_read_rate)) {
            $rate_sum += $result_reviews['rating'];
            $rate_num++;
        }
        $rate_average = $rate_sum / $rate_num;
        mysqli_query($conn, "UPDATE tbl_produk SET rating = '$rate_average' WHERE id_produk = '$id_produk'");
    }
?>