<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
include_once('includes/add_guest_user.php');
include_once('includes/guest_login.php');
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
                    <?php echo display_logout_link(); ?>
                    <?php echo username_display(); ?>
                </ul>
            </div>
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
        </div>    
    
    
    <!-- Account Container -->
    <div class="account-container" id="account-container">
        <div class="backlink wow fadeIn">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> Account</span>
        </div>
        
        
        <?php
            if(!empty($emailErr)){echo $emailErr; }
            if(!empty($passErr)){echo $passErr; }
            if(!empty($message)){echo $message; }

            if(!empty($_SESSION['acctErr'])){
                echo $_SESSION['acctErr'];
                unset($_SESSION['acctErr']);
            }
        ?>
        
        <div class="form-container wow bounceIn">
            <div class="sign-up-form">
                <div class="sign-up-header wow fadeInDown" data-wow-delay='1s'>Create Account</div>
                <form method="post" action="">
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <input type="text" name="username" placeholder="Username" required>
                        <span class="fas fa-user"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <input type="email" name="email" placeholder="Email" required>
                        <span class="fas fa-envelope"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="fas fa-key"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <input type="password" name="cpassword" placeholder="Confirm Password" required>
                        <span class="fas fa-lock"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='1s'>
                        <button type="submit" name="register" class="wow fadeInUp" data-wow-delay='1s'>Sign Up</button>
                    </div>
                </form> 
            </div>
            
            <div class="sign-up-message">
                <div class="overlay">
                    <div class="hello-message wow fadeInDown" data-wow-delay='.5s'>Hello, User!</div>        
                    <div class="btn-message wow fadeInDown" data-wow-delay='.5s'>Click the below button to login if you're not a new user.</div>        
                    <div class="btn-btn wow fadeInUp" data-wow-delay='.5s'>SIGN IN</div>        
                </div>    
            </div>
            
            
            
            <div class="login-message">
                <div class="overlay">
                    <div class="hello-message wow fadeInDown" data-wow-delay='.5s'>Welcome, back!</div>        
                    <div class="btn-message wow fadeInDown" data-wow-delay='.5s'>Click the below button to sign up as a new user.</div>        
                    <div class="btn-btn wow fadeInUp" data-wow-delay='.5s'>SIGN UP</div>
                </div>    
            </div>
            <div class="login-form">
                <div class="login-header wow fadeInDown" data-wow-delay='.5s'>Sign In</div>
                <form method="post" action="">
                    <div class="form-group wow fadeIn" data-wow-delay='.5s'>
                        <input type="email" name="email" placeholder="Email" required>
                        <span class="fas fa-envelope"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='.5s'>
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="fas fa-lock"></span>
                    </div>
                    <div class="form-group wow fadeIn" data-wow-delay='.5s'>
                        <a href="reset.php" style="color:#EE3C26; font-size:13px;">Forgotten Password?</a>
                        <button type="submit" name="login">Sign In</button>
                    </div>
                </form>
            </div>
            
            
            
        </div>
        
    </div>
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php')?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php')?>
</html>