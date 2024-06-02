<?php
    include "../koneksi.php"; include "../session.php";
    $id_produk = $_GET['id_produk'];

    $sql_produk = "SELECT * FROM tbl_produk WHERE id_produk = '$_GET[id_produk]'";
    $result_produk = mysqli_query($conn, $sql_produk);
    $read_produk = mysqli_fetch_assoc($result_produk);

    $sql_kategori = "SELECT * FROM tbl_kategori";
    $result_kategori = mysqli_query($conn, $sql_kategori);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/upload_produk.css?v=<?php echo time(); ?>">
    <title>Edit Produk</title>
</head>
<body onload="set_cek_cacat();">

    <div class="title_img_container">
        <img src="../img/avga/jual_produk.webp">
    </div>
    <h2 id="title">Edit Produkmu</h2>
    <p id="subtitle">Yuk, buat produkmu lebih menarik!</p>

    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="nama">Nama Produk</label></td>
                <td><input type="text" name="nama" id="nama" autofocus required value="<?= $read_produk['nama']; ?>"></td>
            </tr>
            <tr>
                <td><label for="harga">Harga</label></td>
                <td><input type="number" name="harga" id="harga" required value="<?= $read_produk['harga']; ?>"></td>
            </tr>
            <tr>
                <td><label for="stok">Stok </label></td>
                <td><input type="number" name="stok" id="stok" required value="<?= $read_produk['stok']; ?>"></td>
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
                        <option value="Baru" <?php if($read_produk['kondisi'] == "Baru") {echo "selected";} ?>>Baru</option>
                        <option value="Bekas" <?php if($read_produk['kondisi'] == "Bekas") {echo "selected";} ?>>Bekas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="berat">Berat (Kg)</label></td>
                <td><input type="number" name="berat" value="<?= $read_produk['berat']; ?>"></td>
            </tr>
            <tr>
                <td>
                    <label for="deskripsi">Deskripsi </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"><?= $read_produk['deskripsi']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <input type="checkbox" name="adaCacat" id="cek_cacat" <?php if($read_produk['cacat'] != "") {echo "checked";} ?>
                        onclick="set_cek_cacat()">
                    <label for="adaCacat">Ada cacat</label>
                    <textarea name="cacat" id="cacat" class="label_textarea" rows="4" disabled><?= $read_produk['cacat']; ?>
                    </textarea>
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
                        <button type="submit" name="edit" id="edit">Ubah</button>
                        <button type="reset" id="batal" onclick="window.parent.close_edit_produk()">Batalkan</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>







<script>
    var teks_cacat = "<?php echo ($read_produk['cacat']); ?>";

    function set_cek_cacat() {
        var checkbox = document.getElementById('cek_cacat');
        var textarea_cacat = document.getElementById('cacat');
        if(checkbox.checked) {
            textarea_cacat.value = teks_cacat;
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
    if(isset($_POST['edit'])) {
        $sql = "";

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
            $sql = "UPDATE tbl_produk SET
            nama = '$nama',
            deskripsi = '$deskripsi',
            harga = '$harga',
            stok = '$stok',
            visual = '$new_file_name',
            format_visual = '$file_type',
            jenis_produk = '$kategori',
            kondisi = '$kondisi',
            berat = '$berat',
            cacat = '$cacat'
            WHERE id_produk = '$id_produk'";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE tbl_produk SET
            nama = '$nama',
            deskripsi = '$deskripsi',
            harga = '$harga',
            stok = '$stok',
            jenis_produk = '$kategori',
            kondisi = '$kondisi',
            berat = '$berat',
            cacat = '$cacat'
            WHERE id_produk = '$id_produk'";
            mysqli_query($conn, $sql);
        }
        
        echo "<script>window.parent.location.reload();</script>";
    }   
?>