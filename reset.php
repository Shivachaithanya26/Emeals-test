<?php
include('Mail.php'); // includes the PEAR Mail class, already on your server.
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Account</title>
    <?php include_once('includes/css_links.php')?>
</head>
<body>
    
    <!-- Header Menu -->
        <div class='header-menu'>
            <div class='header-logo'>
                <h2 class="wow fadeInLeft"><a href="index.html"><i class="fas fa-hamburger"></i> E-Meals</a></h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php" class='links'>Home</a></li>
                    <li><a href="store.php" class='links'>All Food</a></li>
                    <li><a href="account.php" class='links' id='active'>Account</a></li>
                    <li><a href="contact.php" class='links'>Contact</a></li>
                    <li><a href="cart.php" class='links'>Cart <i class="fas fa-shopping-cart"> <?php echo cart_num_display(); ?></i></a></li>
                    <?php username_display(); ?>
                    <?php display_logout_link(); ?>
                </ul>
            </div>
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
        </div>    
    
    
    <!-- Account Container -->
    <div class="account-container" id="account-container">
        <div class="backlink wow fadeIn">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> Forgot Password</span>
        </div>
        
        <?php
            $email = "";
            $message = "";
            $emailErr = "";
            $token = "0123456789qwertyuiopasdfghjklzxcvbnm";
            $token_shuffle = str_shuffle($token);

        if(isset($_POST['reset'])){
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $password = substr($token_shuffle, 0, 10);
            $db_password = md5($password);

            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>E-mail is invalid</div>";
            }

            $select = mysqli_query($db, "SELECT * FROM guest_table WHERE email = '$email'");
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
                mysqli_query($db, "UPDATE guest_table SET password = '$db_password' WHERE email = '$email'");
                $message = "<div class='success wow fadeInDown' data-wow-duration='1s'>Password reset successful, visit your email for new password!</div>";
            }else{
                $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Failed, Check Connection!</div>";    
                }
            }elseif($num != 1 && !$emailErr){
                $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Email doesn't exist!</div>";
                }
            }
        
        ?>
        
        <?php
            if(!empty($emailErr)){echo $emailErr; }
            if(!empty($message)){echo $message; }

            if(!empty($_SESSION['acctErr'])){
                echo $_SESSION['acctErr'];
                unset($_SESSION['acctErr']);
            }
        ?>
        
        <div class="form-container wow bounceIn">
            <div class="sign-up-form">
                <div class="sign-up-header wow fadeInDown" data-wow-delay='1s' style='margin-top: 120px;'>Reset Password</div>
                <form method="post" action="">
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <input type="email" name="email" placeholder="Email" required>
                        <span class="fas fa-envelope"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <button type="submit" name="reset" class="wow fadeInUp" data-wow-delay='1s'>Reset</button>
                    </div>
                </form> 
            </div>
            
            <div class="sign-up-message">
                <div class="overlay">
                    <div class="hello-message wow fadeInDown" data-wow-delay='1s'>Hello, User!</div>        
                    <div class="btn-message wow fadeInDown" data-wow-delay='1s'>Click the below button to login.</div>        
                    <div class="wow fadeInUp" data-wow-delay='1s'><a style="color:white; display:block; text-align:center; margin:10px auto; border-radius:20px; border: 1px solid white; padding: 8px; font-size: 13px;" href="account.php">LOG IN</a></div>        
                </div>    
            </div>
            
            
            <!--
            <div class="login-message">
                <div class="overlay">
                    <div class="hello-message">Welcome, back!</div>        
                    <div class="btn-message">Click the below button to sign up as a new user.</div>        
                    <div class="btn-btn">SIGN UP</div>
                </div>    
            </div>
            <div class="login-form">
                <div class="login-header">Sign In</div>
                <form method="post" action="">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                        <span class="fas fa-envelope"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="fas fa-lock"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login">Sign In</button>
                    </div>
                </form>
            </div>
            -->
            
            
        </div>
        
    </div>
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php')?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php')?>
</html>