<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Contact</title>
    <?php include_once('includes/css_links.php')?>
</head>
<body>
    
    <!-- Header Menu -->
        <div class='header-menu'>
            <div class='header-logo wow fadeInLeft'>
                <h2><a href="index.php"><i class="fas fa-hamburger"></i> E-Meals</a></h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php" class='links'>Home</a></li>
                    <li><a href="store.php" class='links'>All Food</a></li>
                    <li><a href="account.php" class='links'>Account</a></li>
                    <li><a href="contact.php" class='links' id='active'>Contact</a></li>
                    <li><a href="cart.php" class='links'>Cart <i class="fas fa-shopping-cart"> <?php echo cart_num_display(); ?></i></a></li>
                    <?php echo display_logout_link(); ?>
                    <?php echo username_display(); ?>
                </ul>
            </div>
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
            
        </div>    
    
    <?php
            
            $name = "";
            $email = "";
            $message = "";
            $emailErr = "";
            $msg = "";
            
            if(isset($_POST['send'])){
                $name = mysqli_real_escape_string($db, $_POST['name']);            
                $email = mysqli_real_escape_string($db, $_POST['email']);            
                $message = mysqli_real_escape_string($db, $_POST['message']);
                
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $emailErr = "<div class='danger'>E-mail is invalid</div>";
                }
                
                $select = mysqli_query($db, "SELECT * FROM feedback_table WHERE name = '$name' && email = '$email' && message = '$message' LIMIT 1");
                $num = mysqli_num_rows($select);
                
                if($num == 1 && !$emailErr){
                    $msg = "<div class='danger'>We have already received your feedback/complaint, we'd get back to you shortly!</div>";
                }elseif($num != 1 && !$emailErr){
                    $msg = "<div class='success'>Feedback/complaint received. We'd get back to you shortly!</div>";
                    mysqli_query($db, "INSERT INTO feedback_table(name, email, message)VALUES('$name', '$email', '$message')");
                }
            }    
        
        ?>
        
    
    <!-- Cart Container -->
    <div class="contact-container">
        <div class="backlink wow fadeInLeft">
            <a href="index.html"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> Contact</span>
        </div>
            
        <?php if(!empty($msg)){ echo $msg; }?>
        <?php if(!empty($emailErr)){ echo $emailErr; }?>
        
        <div class="contact-box">
            <div class="contact-box-heading wow bounceInDown">CONTACT INFO</div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-map'></i> <span class='main-title'>Address</span></div>
                <div class="main-content">1 Castlehill Street, Aberdeem, AB11 5FD.</div>
            </div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-phone'></i> <span class='main-title'>Phone</span></div>
                <a href="tel:+447849299730" class="main-content">(+) 44 - 7849299730</a>
            </div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-envelope'></i> <span class='main-title'>Support</span></div>
                <a href="mailto:kingsley20th@gmail.com" class="main-content">kingsley20th@gmail.com</a>
            </div>
            
        </div>
        
        
        <div class="contact-box">
            <div class="contact-box-heading wow bounceInDown">LET'S GET YOUR FEEDBACK/COMPLAINT</div>
            
            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <input type="text" name="name" placeholder="Full Name" required>
                    </div>
                    
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <input type="text" name="message" placeholder="Message" required>
                    </div>
                    
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <button type="submit" name="send">SEND MESSAGE</button>
                    </div>
                </form>
            </div>
            
        </div>
    
    </div>
    
    
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
</html>