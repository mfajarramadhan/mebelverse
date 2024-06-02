<?php
    $id_penjual_uploaded = $_GET['id_uploader'];
?>


<head>
    <style>
        @import '../styles/font.css';
        @import '../styles/root.css';

        body {
            background: white;
            width: 100%; height: 100%; padding: 0; margin: 0;
            align-items: center; justify-content: center; display: flex; flex-direction: column;
        }
        h2 {margin: 0px; color: blue; text-shadow: 0px 0px 10px rgba(217, 248, 253, 0.5);}
        p {margin: 10px; max-width: 300px; text-align: center;}
        .title_img_container {
            background-color: white;
            width: 100%; height: 35vh; padding: 20px 0px;
            align-items: center; justify-content: center; display: flex; flex-direction: column;
        }
        .title_img_container img {
            height: 100%;
        }
        button {
            all: unset; cursor: pointer;
            box-shadow: var(--boxShadow1);
            background: var(--blue_gradient2); color: white;
            margin-top: 20px; padding: 8px 20px; border-radius: 100vh;
            transition: .12s;
        }
        button:hover {
            transform: scale(1.02); filter: brightness(120%);
        }
    </style>
</head>
<body>
    <div class="title_img_container">
        <img src="../img/avga/jual_produk.webp">
    </div>
    <h2>Upoad Berhasil!</h2>
    <p>
        Tunggu orang-orang melihat produk anda dan membelinya ya!
    </p>
    <button onclick="window.parent.location.href = '../profile.php?id=<?= $id_penjual_uploaded; ?>&type=j'">
        Lihat Semua Produk
    </button>
</body>