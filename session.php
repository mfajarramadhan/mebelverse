<?php
    session_start();

    if(isset($_POST['logout'])){
        echo "<script>alert('yakin?');</script>";
        session_destroy();
        header("location: login.php");
    }
?>