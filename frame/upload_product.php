<?php
    include "../koneksi.php"; include "../session.php";
    $sql_kategori = "SELECT * FROM tbl_kategori";
    $result_kategori = mysqli_query($conn, $sql_kategori);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/upload_produk.css?v=<?php echo time(); ?>">
    <title>Upload Produk</title>
</head>
<body>

    <div class="title_img_container">
        <img src="../img/avga/jual_produk.webp">
    </div>
    <h2 id="title">Mau Jual Produk?</h2>
    <p id="subtitle">Yuk, siapin data-data dibawah!</p>

    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="nama">Nama Produk</label></td>
                <td><input type="text" name="nama" id="nama" autofocus required></td>
            </tr>
            <tr>
                <td><label for="harga">Harga </label></td>
                <td><input type="number" name="harga" id="harga" required></td>
            </tr>
            <tr>
                <td><label for="stok">Stok </label></td>
                <td><input type="number" name="stok" id="stok" required></td>
            </tr>
            <tr>
                <td><label for="kategori">Kategori Produk</label></td>
                <td>
                    <select name="kategori">
                        <!-- <option value="" selected disabled>Pilih</option> -->
                        <?php
                            while ($read_kategori = mysqli_fetch_assoc($result_kategori)) {
                        ?>
                            <option value="<?= $read_kategori['id_kategori']; ?>">
                                <?= $read_kategori['nama']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="kondisi">Kondisi</label></td>
                <td>
                    <select name="kondisi">
                        <option value="Baru" selected>Baru</option>
                        <option value="Bekas">Bekas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="berat">Berat (Kg)</label></td>
                <td><input type="number" name="berat"></td>
            </tr>
            <tr>
                <td>
                    <label for="deskripsi">Deskripsi </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <input type="checkbox" name="adaCacat" id="cek_cacat" onclick="set_cek_cacat()">
                    <label for="adaCacat">Ada cacat</label>
                    <textarea name="cacat" id="cacat" class="label_textarea" rows="4" disabled></textarea>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <label for="visual" class="label_textarea"><p>Upload Gambar / Objek Produk</p></label>
                    <input type="file" name="visual" id="visual">
                </td>
            </tr>

            <tr>
                <td>
                    <div class="submit_form">
                        <button type="submit" name="upload" id="upload">Upload</button>
                        <button type="reset" id="batal" onclick="window.parent.close_upload_produk()">Batalkan</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>

<script>
    function set_cek_cacat() {
        var checkbox = document.getElementById('cek_cacat');
        var textarea_cacat = document.getElementById('cacat');
        if(checkbox.checked) {
            textarea_cacat.disabled = false;
            textarea_cacat.placeholder = "Jelaskan cacat/minus dari produk ini";
            textarea_cacat.focus();
        }
        else {
            textarea_cacat.value = "";
            textarea_cacat.disabled = true;
            textarea_cacat.placeholder = "";
        }
    }
</script>

<?php
    if(isset($_POST['upload'])) {
        $sql = "";

        $id_penjual = $_GET['id_uploader'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $kategori = $_POST['kategori'];
        $kondisi = $_POST['kondisi'];
        $berat = $_POST['berat'];
        $deskripsi = $_POST['deskripsi'];
        $cacat = "";
        if(isset($_POST['cacat'])) {$cacat = $_POST['cacat'];}


        $file_name = $_FILES['visual']['name'];
        $directory = "";
        $file_type = "";
        if($file_name != "") {
            $new_file_name = date('YmdHis').'-'.$file_name;
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if($file_extension != "glb") { // KALAU BUKAN OBJEK 3D
                $directory = "../img/produk/";
                $file_type = "img";
            }
            else { // KALAU OBEK 3D
                $directory = "../img/produk_gltf/";
                $file_type = "3d";
            }
            move_uploaded_file($_FILES['visual']['tmp_name'], $directory.$new_file_name);
            $sql = "INSERT INTO tbl_produk VALUES
            ('', '$id_penjual', '$nama','$deskripsi', '$harga', '$stok','$new_file_name', '$file_type', '',
            '$kategori', '$kondisi', '$berat', '$cacat')";
            mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO tbl_produk VALUES
            ('', '$id_penjual', '$nama','$deskripsi', '$harga', '$stok','$file_name', '$file_type', '',
            '$kategori', '$kondisi', '$berat', '$cacat')";
            mysqli_query($conn, $sql);
        }
        

        echo "<script>window.location.href = 'upload_product_succeed.php?id_uploader=$id_penjual'</script>";
    }   
?>