<?php
include('Mail.php'); // includes the PEAR Mail class, already on your server.
include_once('../includes/connection.php');
session_start();
$email = "";
    $message = "";
    $emailErr = "";
    $token = "0123456789qwertyuiopasdfghjklzxcvbnm";
    $token_shuffle = str_shuffle($token);

if(isset($_POST['reset'])){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = substr($token_shuffle, 0, 10);
    $new_password = md5($password);


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>E-mail is invalid</div>";
    }

    $select = mysqli_query($db, "SELECT * FROM admin_users WHERE email = '$email'");
    $num = mysqli_num_rows($select);

    if($num == 1 && !$emailErr){

    /* This is for the guest  email content */
    $host = 'localhost';
    $port = 25;
    $username = 'emeals@jeroxng.com'; // your email address
    $email_password = 'Youaregreat@1'; // your email address password
    $from = 'emeals@jeroxng.com'; 
    $to = $email;
    $subject = "Account Password Reset Notification";
    $sub = 'Hello user, your password reset was successful';
    $email_message = $password;
    $email_message_2 = "Remember to change it after logging in!";
    $headers = array ('From' => $from, 'To' => $to, 'Subject' => $sub); // the email headers
    $body = "From: $from\nSubject: $subject\nHeading: $sub\nNew Password: $email_message\nMessage: $email_message_2";
    $smtp = Mail::factory('smtp', array ('host' =>'localhost', 'auth' => true, 'username' => $username, 'password' => $email_password, 'port' => $port)); // SMTP protocol with the username and password of an existing email account in your hosting account
    $mail = $smtp->send($to, $headers, $body); // sending the email


    if($mail){
        mysqli_query($db, "UPDATE admin_users SET password = '$new_password' WHERE email = '$email'");
        $message = "<div class='success wow fadeInDown' data-wow-duration='1s'>Password reset successful, visit your email for new password!</div>";
    }else{
        $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Failed, Check Connection!</div>";    
        }
    }elseif($num != 1 && !$emailErr){
        $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Email doesn't exist!</div>";
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome/css/brands.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome/css/brands.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/js/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/js/slick-theme.css" type="text/css">
    <link rel="stylesheet" href="../assets/css/js/slick.css" type="text/css">
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
</head>
    
<body>
    
    <div class="admin-login-container">
        <div class="login-form wow bounce">
            <div class="login-image">
                <div class="overlay">
                    <div class="header wow fadeIn" data-wow-delay='1s'><span class="fas fa-hamburger"></span> EMEALS ADMIN</div>
                </div>
            </div>
            <!-- <div>Successful!</div> -->
            <?php
                if(!empty($emailErr)){echo $emailErr; }
                if(!empty($message)){echo $message; }
            ?>
            <div class="login-welcome wow fadeInLeft" data-wow-delay='1s'>Fill up to reset password</div>
            <form method="post" action="" class="form-container">
                <div class="form-group wow fadeIn" data-wow-delay='1s'>
                    <input type="email" name="email" placeholder="Email" required> <span class="fas fa-envelope"></span>
                    <label class="label">Email</label>
                </div>
                <div class="form-group">
                    <button type="submit" name="reset">RESET</button>
                    <a href="home.php">&larr; Back to Login</a>
                </div>
            </form>
        </div>
    </div>
    
</body>

<script src="../assets/js/libraries/slick.js"></script>
<script src="../assets/js/libraries/jquery.magnific-popup.js"></script>
<script src="../assets/js/libraries/jquery.magnific-popup.min.js"></script>
<script src="../assets/js/libraries/wow.min.js"></script>
<script type="text/javascript" src="../assets/js/style.js"></script>
<script>
new WOW().init();
</script>
</html>