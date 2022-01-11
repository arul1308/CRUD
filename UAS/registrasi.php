<?php
define('connection', true); 
require 'functions.php';
$msg='';
 if(isset($_POST['submit'])){  
        try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
         $user = $_POST['username'];
         $email = $_POST['email'];
         $pass = $_POST['password'];
         
         $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
          
         $sql = "SELECT COUNT(username) AS num FROM logreg WHERE username = :username";
         $stmt = $pdo->prepare($sql);

         $stmt->bindValue(':username', $user);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         if($row['num'] > 0){
             echo '<script>alert("Username Sudah Dipakai!")</script>';
        }
        
       else{

    $stmt = $dsn->prepare("INSERT INTO logreg (username, email, password) 
    VALUES (:username,:email, :password)");
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);
    
    

   if($stmt->execute()){
    echo '<script>alert("Akun Berhasil Dibuat")</script>';
    echo '<script>window.location.replace("login.php")</script>';
     
   }else{
       echo '<script>alert("An error occurred")</script>';
   }
}
}catch(PDOException $e){
    $error = "Error: " . $e->getMessage();
    echo '<script type="text/javascript">alert("'.$error.'");</script>';
}
     }

?>
<?=template_header('Read')?>
<div class="content read">
    <div class="content update">
	<h2>Silahkan Mendaftar</h2>
    <form action="register.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Silahkan Masukkan Username yang Ingin Didaftarkan">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Silahkan Masukkan Email yang Ingin Didaftarkan">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Silahkan Masukkan Password Anda">
                    <tr>
                <td colspan = "3">
                    <button type="submit" name="submit" >Registrasi</button>
                </td>
            </tr>
        <a href="login.php" class="create-contact">Login</a>
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>