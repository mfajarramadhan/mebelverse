<?php
    session_start();
    session_destroy();
    include "koneksi.php"; include "session.php";

    $error = "";
    
    if(isset($_POST['login'])){
        // pilih akun sebagai pelanggan
        $email      = $_POST['email'];
        $password   = $_POST['password'];
        
        $result_pembeli     = mysqli_query($conn, "SELECT * FROM tbl_pelanggan WHERE email = '$email'");
        $result_penjual     = mysqli_query($conn, "SELECT * FROM tbl_penjual WHERE email = '$email'");

        if($result_penjual){
            if(mysqli_num_rows($result_penjual)){
                $row = mysqli_fetch_assoc($result_penjual);
                if(password_verify($password, $row['password'])){
                        $_SESSION['tipe_login'] = "Penjual";
                        $_SESSION['id_login'] = $row['id_penjual'];
                    echo "<script>location.href = 'home.php'</script>";
                }   
            }
        } else if($result_pembeli){
            if(mysqli_num_rows($result_pembeli)){
                $row = mysqli_fetch_assoc($result_pembeli);
                if(password_verify($password, $row['password'])){
                        $_SESSION['tipe_login'] = "User";
                        $_SESSION['id_login'] = $row['id_pelanggan'];
                    echo "<script>location.href = 'home.php'</script>";
                }   
            }
        }
        // else {
            $error = true;
        // }
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
    <section class="home">
        <div class="content">
            <!-- <img src="img/avga/butuh_login.webp"> -->
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
            <h2>Login</h2>
            <form action="" method="post">
                <?php if($error): ?>
                <i style="color: red;">email / password salah</i>
                <?php endif; ?>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label for="#">Masukkan email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label for="#">Masukkan password</label>
                </div>
                <div class="remember-forgot">
                    <label for=""><input type="checkbox">Ingat saya</label>
                    <a href="">Lupa password</a>
                </div>
                <button type="submit" class="btn" name="login">Login</button>
                <div class="register-link">
                    <p>Belum punya akun? <a href="registration.php">Registrasi</a></p>
                </div>
            </form>
        </div>
    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>