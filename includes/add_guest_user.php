<?php
    $username = "";
    $email = "";
    $password = "";
    $cpassword = "";
    $message = "";
    $emailErr = "";
    $passErr = "";

if(isset($_POST['register'])){
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($db, md5($_POST['cpassword']));

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>E-mail is invalid</div>";
    }
    if($password != $cpassword){
        $passErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Passwords do not match!</div>";
    }

    $select = mysqli_query($db, "SELECT * FROM guest_table WHERE email = '$email' ||  username = '$username' LIMIT 1");
    $num = mysqli_num_rows($select);

    if($num != 1 && !$emailErr && !$passErr){
        mysqli_query($db, "INSERT INTO guest_table(username, email, password )VALUES('$username', '$email', '$password')");
        $message = "<div class='success wow fadeInDown' data-wow-duration='1s'>User Added Successfully!</div>";
        $_SESSION['email'] = $email;
        header('Location:checkout.php');
    }elseif($num == 1 && !$emailErr && !$passErr){
        $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Invalid user details!</div>";
        }
    }
?>