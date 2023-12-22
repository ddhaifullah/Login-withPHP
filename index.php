<?php
//inisialisasi session
session_start();

//mengecek username pada session
if( !isset($_SESSION['username']) ){
$_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <ce>

        <h1>Selamat anda berhasil Login/Registrasi</h1>
        <li>
            <a href="logout.php" class="nav-link text-light"> Log Out </a>
        </li>
    </ce nter>
</body>
</html>