<?php
session_start();
define('connection', true); 
require 'functions.php';
$msg = '';
if(isset($_POST['submit'])){
    try{
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user_login = !empty($_POST['username']) ? ($_POST['username']) :null;
        $passwordAttempt = $_POST['password'];

        $sql = "SELECT username, password FROM logreg WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $user_login);

        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user === false){
            echo '<script>alert("Username atau Password Tidak terdaftar")</script>';
        }else{
            $validPassword = password_verify($passwordAttempt,$user['password']);
            echo $validPassword;

            if($validPassword){
                $_SESSION['user'] = $user_login;
                echo $user_login;
                echo '<script>alert("Anda Berhasil Login !")</script>';
                echo '<script>window.location.replace("read.php")</script>';               
            }else{
                echo '<script>alert("Username atau Password Salah!")</script>';
            }
        }
    }catch(PDOException $e){
        $error = "Error : ".$e->getMessage();
            echo '<script>alert(:'.$error.'");</script>';
        }
}
?>
<?=template_header('Read')?>
<div class="content read">
    <div class="content update">
	<h2>Silahkan Login Sebelum Mengedit Tim</h2>
    <form action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Silahkan Masukkan Username yang Terdaftar">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Silahkan Masukkan Password Anda">
        <input type="submit" name="submit" value = "Login">
        <a href="registrasi.php" class="create-contact">Registrasi</a>
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>
