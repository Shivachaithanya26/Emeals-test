<?php
include_once('../includes/connection.php');
session_start();

$u_email = "";
$password = "";
$msg = "";
if(isset($_POST['login'])){
    $u_email = mysqli_real_escape_string($db, $_POST['u_email']);
    $password = mysqli_real_escape_string($db, md5($_POST['password']));
    
    $select = mysqli_query($db, "SELECT * FROM admin_users WHERE username = '$u_email' && password = '$password'");
    $num = mysqli_num_rows($select);
    
    $choose = mysqli_query($db, "SELECT * FROM admin_users WHERE email = '$u_email' && password = '$password'");
    $num_2 = mysqli_num_rows($choose);
    
    if($num == 1 || $num_2 == 1){
        $_SESSION['u_email'] = $u_email;
        header('Location:index.php');
    }else{
        $msg = "<div class='danger'>Invalid Credentials!</div>";
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
        <div class="login-form wow fadeIn">
            <div class="login-image">
                <div class="overlay">
                    <div class="header wow fadeIn" data-wow-delay='1s'><span class="fas fa-hamburger"></span> EMEALS ADMIN</div>
                </div>
            </div>
            <!-- <div>Successful!</div> -->
            <?php
                if(!empty($msg)){echo $msg; }
            ?>
            <div class="login-welcome wow fadeInLeft" data-wow-delay='1s'>Get right back into action</div>
            <form method="post" action="" class="form-container">
                <div class="form-group">
                    <input type="text" name="u_email" placeholder="Username or Email" required> <span class="fas fa-user"></span>
                    <label class="label">Username or Email</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required> <span class="fas fa-lock"></span>
                    <label class="label">Password</label>
                </div>
                <div class="form-group">
                    <button type="submit" name="login">LOG IN</button>
                    <a href="forgotten_password.php">Forgot Password?</a>
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