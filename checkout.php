<?php
include('Mail.php'); // includes the PEAR Mail class, already on your server.
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();

return_back_to_cart();
include_once('includes/check_out.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Checkout</title>
    <?php include_once('includes/css_links.php')?>
</head>
<body>
    
    <!-- Header Menu -->
        <div class='header-menu'>
            <div class='header-logo wow fadeInLeft'>
                <h2><a href="index.html"><i class="fas fa-hamburger"></i> E-Meals</a></h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php" class='links'>Home</a></li>
                    <li><a href="store.php" class='links'>All Food</a></li>
                    <li><a href="account.php" class='links'>Account</a></li>
                    <li><a href="contact.php" class='links'>Contact</a></li>
                    <li><a href="cart.php" class='links' id='active'>Cart <i class="fas fa-shopping-cart">  <?php echo cart_num_display(); ?></i></a></li>
                    <?php display_logout_link(); ?>
                    <?php username_display(); ?>
                </ul>
            </div>
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
            
        </div>    
    
    
    <!-- Checkout Container -->
    <div class="checkout-container" id="checkout-container">
        <div class="backlink wow fadeInLeft">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> Checkout</span>
        </div>
        
        
        <?php
            if(!empty($emailErr)){echo $emailErr; }
            if(!empty($passErr)){echo $passErr; }
            if(!empty($message)){echo $message; }
        ?>


    <form action="" method="post">
        
        <div class="checkout-box">
            
            <div class="bill-heading wow bounceInDown">Billing Details</div>

                <div class="form-container">

                    <?php
                        $u_email = $_SESSION['email'];
                        $select = mysqli_query($db, "SELECT * FROM order_table WHERE email = '$u_email'");
                        $selected = mysqli_fetch_array($select);
                        if($selected){
                    ?>

                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>First Name<span>**</span></label>
                    <input type="text" name="fname" value="<?php echo $selected['fname'];?>" required>
                </div>

                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>Last Name<span>**</span></label>
                    <input type="text" name="lname" value="<?php echo $selected['lname'];?>" required>
                </div>

                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>Email<span>**</span></label>
                    <input type="email" name="email" value="<?php echo $selected['email'];?>" required>
                </div>

                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>Phone<span>**</span></label>
                    <input type="tel" name="phone" value="<?php echo $selected['phone'];?>" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>Address<span>**</span></label>
                    <input type="text" name="address" value="<?php echo $selected['address'];?>" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>State<span>**</span></label>
                    <input type="text" name="state" value="<?php echo $selected['state'];?>" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>Order Notes <span>(Optional)</span></label>
                    <input type="text" name="order_notes" placeholder="Special delivery note">
                </div>

                <?php
                    }else{
                ?>
                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>First Name<span>**</span></label>
                    <input type="text" name="fname" placeholder="" required>
                </div>

                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>Last Name<span>**</span></label>
                    <input type="text" name="lname" placeholder="" required>
                </div>

                <div class="form-group-hw wow fadeIn" data-wow-delay='.5s'>
                    <label>Email<span>**</span></label>
                    <input type="email" name="email" value="<?php echo $u_email; ?>" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>Phone<span>**</span></label>
                    <input type="tel" name="phone" placeholder="" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>Address<span>**</span></label>
                    <input type="text" name="address" placeholder="" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>State<span>**</span></label>
                    <input type="text" name="state" placeholder="" required>
                </div>

                <div class="form-group-fw wow fadeIn" data-wow-delay='.5s'>
                    <label>Order Notes <span>(Optional)</span></label>
                    <input type="text" name="order_notes" placeholder="Special delivery note">
                </div>
            <?php
                }
            ?> 
            </div>
        </div>
        
        <div class="order-box wow fadeInRight" data-wow-delay='.5s'>
                    
                <div class="order-heading wow bounceInDown">Your Order</div>
                            
                <div class="product-list">
                    <div class="row-1">Product</div>
                    <div class="row-2">Total</div>
                    
                    <?php
                                if(!empty($_SESSION['cart'])){
                                    $total = 0;
                                    $total_quantity = 0;
                                    $num = 1;
                                    foreach($_SESSION['cart'] as $keys => $value){
                    ?>
                    <div class="row-food"><?php echo $num++ . ". " . $value['name']; ?></div>
                    <div class="row-price">£ <?php echo number_format($value['price'], 2); ?></div>
                    <?php
                                    $total = $total + ($value['quantity'] * $value['price']);
                                    $_SESSION['total'] = $total;
                    
                                    $total_quantity = $total_quantity + ($value['quantity']);
                                    $_SESSION['quantity'] = $total_quantity;
                                        
                                    $vat = $total * 0.075;
                                        
                                    $net_total = $total * 1.075;
                                        
                                    $_SESSION['net_total'] = $net_total;
                         }
                        }                      
                    ?>
                                <hr class="total-line">
                                        <div class="row-1">Subtotal</div>
                                        <div class="row-2">
                                        <?php
                                                if(!empty($total)){echo "£ " . number_format($total, 2);}else{echo "£ 0.00";}
                                        ?>
                                        </div>
                                    
                                        <div class="row-1">Vat @7.5%</div>
                                        <div class="row-2">
                                        <?php
                                                if(!empty($vat)){echo "£ " . number_format($vat, 2);}else{echo "£ 0.00";}
                                        ?>
                                        </div>
                                        
                                        <div class="row-1">Total</div>
                                        <div class="row-2">
                                        <?php
                                                if(!empty($net_total)){echo "£ " . number_format($net_total, 2);}else{echo "£ 0.00";}
                                        ?>
                                        </div>
                                        <hr class="total-line">
                </div>
            
                <div class="form-group-fw">
                    <button name="checkout" type="submit" class="checkout-btn">Checkout</button>
                    <a href="cancel.php?action=cancel"  type="submit" class="cancel-btn">Cancel Order</a>
                </div>
            </div>
        </form>
    </div>
    
    
    <!-- Section Four Container -->
    <div class="section-four">
        <div class="overlay">
            <div class="overlay-content">
            
            </div>
            <div class="overlay-content">
                <div class="text-1 wow fadeInRight" data-wow-delay='.5s'>Hurry Up!</div>
                <div class="text-2 wow fadeInRight" data-wow-delay='1s'>Favourite Meals, Affordable Rate</div>
                <div class="text-3 wow fadeInRight" data-wow-delay='1.5s'>Click the buttons below to see more available foods!</div>
                <div class="text-4 wow fadeIn" data-wow-delay='2s'><a href="#"><span class="fas fa-angle-left"></span> &nbsp; Shop Now</a></div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
</html>