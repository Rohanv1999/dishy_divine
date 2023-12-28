<?php
$uname = mysqli_real_escape_string($conn,$_POST['username']);
        $pass = mysqli_real_escape_string($conn,$_POST['password']);
$res = mysqli_query($conn,"select * from admin");
        while ($data = mysqli_fetch_array($res)) {
            if(strcmp($uname, $data['user_name']) == 0 && strcmp($pass, $data['password']) == 0) {
                $_SESSION['user'] = $uname;
                $_SESSION['user_type']= 'admin';
                header("location:index.php");
                exit;
            } else {
                $_SESSION['error'] = "Wrong Username or Password";
                header("location:login.php");
                exit;
            }
        }
    



?>