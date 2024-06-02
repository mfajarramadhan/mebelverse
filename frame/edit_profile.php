<?php
    include "../koneksi.php"; include "../session.php";
    $tipe_editprofil = $_SESSION['tipe_login'];

    $sql = "";
    if($tipe_editprofil == "Penjual") {
        $sql = "SELECT * FROM tbl_penjual WHERE id_penjual = '$_SESSION[id_login]'";
    }
    else if($tipe_editprofil == "User") {
        $sql = "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$_SESSION[id_login]'";
    }
    $result = mysqli_query($conn, $sql);
    $read_profil = mysqli_fetch_assoc($result);
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
    <h2 id="title">Edit Profil</h2>
    <p id="subtitle">Yuk, buat profilmu lebih menarik untuk dilihat!</p>

    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="foto_profil">Foto Profil</label></td>
                <td><input type="file" name="foto_profil"></td>
            </tr>
            <tr>
                <td><label for="nama">Nama</label></td>
                <td><input type="text" name="nama" value="<?= $read_profil['nama']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="no_telepon">No. Telepon</label></td>
                <td><input type="text" name="no_telepon" value="<?= $read_profil['no_telepon']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td>
                    <textarea name="alamat" rows="4"><?= $read_profil['alamat']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td><label for="kota">Kota</label></td>
                <td><input type="text" name="kota" value="<?= $read_profil['kota']; ?>" required></td>
            </tr>
            <!-- Deskripsi Toko -->
            <?php if($tipe_editprofil == "Penjual") { ?>
                <tr>
                    <td><label for="deskripsi_penjual">Deskripsi Toko</label></td>
                    <td>
                        <textarea name="deskripsi_penjual" rows="4"><?= $read_profil['deskripsi_penjual']; ?>
                        </textarea>
                    </td>
                </tr>
            <?php }?>

            <tr>
                <td>
                    <div class="submit_form">
                        <button type="submit" name="edit" id="upload">Edit</button>
                        <button type="reset" id="batal" onclick="window.parent.close_edit_profil()">Batalkan</button>
                    </div>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>


<?php
    if(isset($_POST['edit'])) {
        $nama = $_POST['nama'];
        $no_telepon = $_POST['no_telepon'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $deskripsi_penjual = $_POST['deskripsi_penjual'];


        $file_name = $_FILES['foto_profil']['name'];
        $directory = "../img/profpic/";
        $sql = "";

        if($tipe_editprofil == "Penjual") {
            if($file_name != "") {
                $new_file_name = date('YmdHis').'-'.$file_name;
                move_uploaded_file($_FILES['foto_profil']['tmp_name'], $directory.$new_file_name);
                $sql = "UPDATE tbl_penjual SET
                    foto_profil='$new_file_name', nama='$nama', no_telepon='$no_telepon', alamat='$alamat',
                    kota='$kota', deskripsi_penjual='$deskripsi_penjual' WHERE id_penjual = '$_SESSION[id_login]'";
            }
            else {
                $sql = "UPDATE tbl_penjual SET
                    nama='$nama', no_telepon='$no_telepon', alamat='$alamat', kota='$kota',
                    deskripsi_penjual='$deskripsi_penjual' WHERE id_penjual = '$_SESSION[id_login]'";
            }
        }
        else if($tipe_editprofil == "User") {
            if($file_name != "") {
                $new_file_name = date('YmdHis').'-'.$file_name;
                move_uploaded_file($_FILES['foto_profil']['tmp_name'], $directory.$new_file_name);
                $sql = "UPDATE tbl_pelanggan SET
                    foto_profil='$new_file_name', nama='$nama', no_telepon='$no_telepon', alamat='$alamat',
                    kota='$kota' WHERE id_pelanggan = '$_SESSION[id_login]'";
            }
            else {
                $sql = "UPDATE tbl_pelanggan SET
                    nama='$nama', no_telepon='$no_telepon', alamat='$alamat', kota='$kota'
                    WHERE id_pelanggan = '$_SESSION[id_login]'";
            }
        }
        
        mysqli_query($conn, $sql);
        echo "<script>window.location.href = 'edit_profile_succeed.html'</script>";
    }
?>