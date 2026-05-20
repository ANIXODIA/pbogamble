<?php 
    require_once('tugas/database.php');
    if(isset($_POST['submit'])){
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = hash('sha256',$_POST['password']);
        $sql = "INSERT INTO user (nama, email, password) VALUES ('".$nama."','".$email."','".$password."')";
        $connection->query($sql);
        header("location: library/login.php");
    }
?>
<html>
    <?php include 'library/header.php'; ?>

    <body>
        <h1>Register Form</h1>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter password" name="password">
                <small id="passwordHelp" class="form-text text-muted">We'll never share your password with anyone else.</small>
            </div>               
            <div class="form-group">
                <label for="nama">nama lengkap</label>
                <input type="nama lengkap" class="form-control" id="nama" aria-describedby="namalengkapHelp" placeholder="Enter nama lengkap" name="nama">
                <small id="namalengkapHelp" class="form-text text-muted">We'll never share your nama lengkap with anyone else.</small>
            </div>                
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form> 
    </body>
</html>