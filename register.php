<?php
//menyertakan file program koneksi.php pada register
require('koneksi.php');
//inisialisasi session
session_start();

$error = '';
$validate = '';
//mengecek apakah form registrasi di submit atau tidak
if( isset($_POST['submit']) ){
        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $name     = stripslashes($_POST['name']);
        $name     = mysqli_real_escape_string($con, $name);
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $repass   = stripslashes($_POST['repassword']);
        $repass   = mysqli_real_escape_string($con, $repass);
        //cek nilai pada form kosong apa tidak
        if(!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){
            //mengecek apakah password sama atau tidak dengan repass baru
            if($password == $repass){
                //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
                if( cek_nama($name,$con) == 0 ){
                    //hashing password sebelum disimpan didatabase
                    $pass  = password_hash($password, PASSWORD_DEFAULT);
                    //meambahkan data ke data base
                    $query = "INSERT INTO dbregis (username,name,email, password ) VALUES ('$username','$nama','$email','$pass')";
                    $result   = mysqli_query($con, $query);
                    // jika input data benar maka di pinndahkan ke index.php dan menyimpan data baru ke DB
                    if ($result) {
                        $_SESSION['username'] = $username;
                        
                        header('Location: index.php');
                    
                    //pesan untuk menampilkan kegagalan pengimputan username dan pass
                    } else {
                        $error =  'Register User Gagal !!';
                    }
                }else{
                        $error =  'Username sudah terdaftar !!';
                }
            }else{
                $validate = 'Password tidak sama !!';
            }
            
        }else {
            $error =  'Data tidak boleh kosong !!';
        }
    } 
    //fungsi untuk mengecek apakah akun sudah terdaftar atau belums
    function cek_nama($username,$con){
        $nama = mysqli_real_escape_string($con, $username);
        $query = "SELECT * FROM dbregis WHERE username = '$nama'";
        if( $result = mysqli_query($con, $query) ) return mysqli_num_rows($result);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    
<form class="container" action="register.php" method="POST">
            <h4 > Sign-Up </h4>
            <?php if($error != ''){ ?>
                        <?= $error; ?>
                        <?php } ?>
                    
                        <label for="name">Nama</label>
                        <input type="text"  id="name" name="name" placeholder="Masukkan Nama">
                    
                        <label for="InputEmail">Alamat Email</label>
                        <input type="email"  id="InputEmail" name="email" aria-describeby="emailHelp" placeholder="Masukkan email">
                    
                        <label for="username">Username</label>
                        <input type="text"  id="username" name="username" placeholder="Masukkan username">
                    
                        <label for="InputPassword">Password</label>
                        <input type="password" id="InputPassword" name="password" placeholder="Password">
                        <?php if($validate != '') {?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php }?>
                        
                        <label for="InputPassword">Re-Password</label>
                        <input type="password"  id="InputRePassword" name="repassword" placeholder="Re-Password">
                        <?php if($validate != '') {?>
                            <p ><?= $validate; ?></p>
                        <?php }?>
                    
                        <button type="submit" name="submit" >Register</button>
                    
                        <p> Sudah punya account? <a href="login.php">Login</a></p>
                    
                </form>
</body>
</html>