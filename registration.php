<?php
    session_start(); session_destroy();
    include "koneksi.php"; include "session.php";

    if(isset($_POST['registrasi'])){
        $pilih_akun             = $_POST['pilih_akun'];
        // $password = password_hash($password, PASSWORD_DEFAULT);
        $password               = $_POST['password'];

        // Daftar akun penjual
        if ($pilih_akun == "penjual") {
            $nama          = $_POST['nama'];
            $email         = $_POST['email'];
            $password      = mysqli_real_escape_string($conn, $_POST['password']);
            $no_telepon    = $_POST['no_telepon'];
            $alamat        = $_POST['alamat'];
            $kota        = $_POST['kota'];
            $pilih_akun    = $_POST['pilih_akun'];
            // Check for existing email
            $emailCheck = mysqli_query($conn, "SELECT * FROM tbl_penjual WHERE email = '$email'");
            if (mysqli_fetch_assoc($emailCheck)) {
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $query = mysqli_query($conn, "INSERT INTO tbl_penjual
                    (nama, email, password, no_telepon, alamat, kota)
                    VALUES ('$nama', '$email', '$hashedPassword', '$no_telepon', '$alamat', '$kota')");
                $query_login = mysqli_query($conn, "SELECT * FROM tbl_penjual WHERE email='$email'");
                $result_login = mysqli_fetch_assoc($query_login);
                $_SESSION['tipe_login'] = "Penjual"; $_SESSION['id_login'] = $result_login['id_penjual'];
                echo "<script>location.href = 'home.php';</script>";
            }
        }

        // Daftar akun pelanggan
        if ($pilih_akun == "user") {
            $nama          = $_POST['nama'];
            $email         = $_POST['email'];
            $password      = mysqli_real_escape_string($conn, $_POST['password']);
            $no_telepon    = $_POST['no_telepon'];
            $alamat        = $_POST['alamat'];
            $kota          = $_POST['kota'];
            $pilih_akun    = $_POST['pilih_akun'];
            // Check for existing email
            $emailCheck = mysqli_query($conn, "SELECT * FROM tbl_pelanggan WHERE email = '$email'");
            if (mysqli_fetch_assoc($emailCheck)) {
                echo "<script>alert('Email anda sudah terdaftar!'); </script>";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $query = mysqli_query($conn, "INSERT INTO tbl_pelanggan
                    (nama, email, password, no_telepon, alamat, kota)
                    VALUES ('$nama', '$email', '$hashedPassword', '$no_telepon', '$alamat', '$kota')");
                $query_login = mysqli_query($conn, "SELECT * FROM tbl_pelanggan WHERE email='$email'");
                $result_login = mysqli_fetch_assoc($query_login);
                $_SESSION['tipe_login'] = "User"; $_SESSION['id_login'] = $result_login['id_pelanggan'];
                echo "<script>location.href = 'home.php';</script>";
            }
        }
    }
?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mebelverse | Registrasi</title>
    <link rel="stylesheet" href="styles/registration.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
    <section class="home">
        <div class="content">
            <div>
                <h2>Aggregator Digital VRVS</h2>
                <p>
                    Beli produk-produk furniture kearifan lokal, dengan kualitas terjamin!
                    Kamu bisa melihat-lihat produk dari segala sisi dan Immersive dengan teknologi Virtual Reality!
                </p>
                <a href="home.php">Masuk Tanpa Login</a>
            </div>
        </div>

        <div class="wrapper-login">
            <h2>Registrasi</h2>
            <form action="" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="pencil"></ion-icon></span>
                    <input type="text" name="nama" id="nama" required>
                    <label for="nama">Masukkan nama</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="email" id="email" required>
                    <label for="email">Masukkan email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label for="password">Masukkan password</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="call"></ion-icon></span>
                    <input type="number" name="no_telepon" required>
                    <label for="no_telepon">Masukkan nomor telepon</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="location"></ion-icon></span>
                    <input type="text" name="alamat" required>
                    <label for="alamat">Masukkan alamat</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="location"></ion-icon></span>
                    <input type="text" name="kota" required>
                    <label for="alamat">Kota</label>
                </div>

                <br>
                <h3 id="pilih_tipe_title">Pilih tipe akun</h3>
                <div class="input-box pilih_akun_container">
                    <a id="tipe_pembeli" onclick="setType('Pembeli')">
                        <img src="img/avga/cart.webp"><h3 id="teks_pembeli">Pembeli</h3>
                    </a>
                    <a id="tipe_penjual" onclick="setType('Penjual')">
                        <img src="img/avga/jual_produk.webp"><h3 id="teks_penjual">Penjual</h3>
                    </a>
                </div>
                <br>

                <div class="input-btn" id="submit_container">
                    <input type="text" name="pilih_akun" id="pilih_akun">
                    <button type="submit" class="btn" id="btn_reg" name="registrasi"></button>
                    <div class="register-link">
                        <p>Sudah punya akun? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        var tipe_pembeli = document.getElementById('tipe_pembeli');
        var teks_pembeli = document.getElementById('teks_pembeli');
        var tipe_penjual = document.getElementById('tipe_penjual');
        var teks_penjual = document.getElementById('teks_penjual');
        var submit_container = document.getElementById('submit_container');
        var input_pilih_akun = document.getElementById('pilih_akun');
        var btn_reg = document.getElementById('btn_reg');

        function setType(type) {
            submit_container.style.visibility = "visible";
            submit_container.style.filter = "opacity(100%)";
            if(type == "Pembeli") {
                tipe_penjual.style.background = "lightgrey";
                teks_penjual.style.color = "rgb(100, 100, 100)";
                tipe_pembeli.style.background = "var(--blue_gradient2)";
                teks_pembeli.style.color = "white";
                btn_reg.innerHTML = "Daftar Sebagai <b>Pembeli</b>";
                input_pilih_akun.value = "user";
            } else if(type == "Penjual") {
                tipe_pembeli.style.background = "lightgrey";
                teks_pembeli.style.color = "rgb(100, 100, 100)";
                tipe_penjual.style.background = "var(--blue_gradient2)";
                teks_penjual.style.color = "white";
                btn_reg.innerHTML = "Daftar Sebagai <b>Penjual</b>";
                input_pilih_akun.value = "penjual";
            }
        }
    </script>
</body>
</html>