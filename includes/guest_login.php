<?php
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, md5($_POST['password']));

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>E-mail is invalid</div>";
        $message = "";
    }
    
    $select = mysqli_query($db, "SELECT * FROM guest_table WHERE email = '$email' && password = '$password'");
    $num = mysqli_num_rows($select);

    if($num == 1 && !$emailErr){
        $_SESSION['email'] = $email;
        header('Location:checkout.php');
    }elseif($num != 1 && !$emailErr){
        $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Invalid user details!</div>";
    }

}
?>