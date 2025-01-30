<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();

$error = "";
$success = "";

if(isset($_POST['add'])){
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'], "id");
        if(!in_array($_GET['id'], $item_array_id)){
            $count = count($_SESSION['cart']);
            $item_array = array(
                'id' => $_GET['id'],
                'name' => $_POST['hidden_name'],
                'price' => $_POST['hidden_price'],
                'quantity' => $_POST['qty'],
                'image' => $_POST['hidden_image'],
                'spice_level' => $_POST['spice_level'],
            );
            $_SESSION['cart'][$count] = $item_array;
            $success = '<div class="success">Food was successfully added to cart!</div>';
            $_SESSION['success'] = $success;
        }else{
             $error = '<div class="danger">Food is already added to cart!</div>';
            $_SESSION['error'] = $error;
        }
    }else{
        $item_array = array(
                'id' => $_GET['id'],
                'name' => $_POST['hidden_name'],
                'price' => $_POST['hidden_price'],
                'quantity' => $_POST['qty'],
                'image' => $_POST['hidden_image'],
                'spice_level' => $_POST['spice_level'],
            );
            $_SESSION['cart'][0] = $item_array;
    }
}


if(isset($_GET['action'])){
    if($_GET['action'] == 'delete'){
    foreach($_SESSION['cart'] as $keys => $value){
        if(isset($_GET['id']) && $value['id'] == $_GET['id']){
            unset($_SESSION['cart'][$keys]);
            $error = '<div class="danger">Food has been removed from cart!</div>';
            $_SESSION['error'] = $error;
            }
        }
    }
}


if(isset($_POST['empty-cart']) && isset($_SESSION['cart'])){
    unset($_SESSION['cart']);
    $_SESSION['quantity'] = 0;
    $total = 0;
    $_SESSION['error'] = '<div class="danger">All products have been removed from cart!</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Cart</title>
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
                    <li><a href="contact.php" class='links'>Contact</a></li>
                    <li><a href="cart.php" class='links' id='active'>Cart <i class="fas fa-shopping-cart"> <?php echo cart_num_display(); ?></i></a></li>
                    <?php echo display_logout_link(); ?>
                    <?php echo username_display(); ?>
                </ul>
            </div>
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
        </div>    
    
    
    <!-- Cart Container -->
    <div class="cart-container">
        <div class="backlink wow fadeInLeft">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> Shopping Cart</span>
        </div>
        
        
        <?php
            if(isset($_SESSION['success'])){
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['emptyCartErr'])){
                echo $_SESSION['emptyCartErr'];
                unset($_SESSION['emptyCartErr']);
            }
            if(isset($_SESSION['order_success'])){
                echo $_SESSION['order_success'];
                unset($_SESSION['order_success']);
            }
        ?>
        
        
        <div class="cart-table-heading wow fadeIn">
            <p>Product</p>
            <p>Price</p>
            <p>Quantity</p>
            <p>Total</p>
            <p>Action</p>
        </div>
        
        <?php
                                
            if(!empty($_SESSION['cart'])){
                $total = 0;
                $total_quantity = 0;
                foreach($_SESSION['cart'] as $keys => $value){
        ?>
        <div class="cart-table-content">
            
            <div class='cart-details'>
                <div class="food-image"><img src="assets/css/images/<?php echo $value['image']; ?>"></div>
                <div class="food-name"><?php echo $value['name']; ?></div>
            </div>
            <div class='cart-details' id="price">£ <?php echo number_format($value['price'], 2); ?></div>
            <div class='cart-details' id="quantity"><?php echo $value['quantity']; ?></div>
            <div class='cart-details' id="gross">£ <?php echo number_format($value['quantity'] * $value['price'], 2); ?></div>
            <a href="cart.php?action=delete&id=<?php echo $value['id']; ?>" class='cart-details' id="delete-icon"><i class="fas fa-trash"></i></a>
            
        </div>
        <?php
                $total = $total + ($value['quantity'] * $value['price']);
                $_SESSION['total'] = $total;

                $total_quantity = $total_quantity + ($value['quantity']);
                $_SESSION['quantity'] = $total_quantity;
                    
                $vat = $total * 0.075;
                    
                $net_total = $total * 1.075;
                    
                $_SESSION['net_total'] = $net_total;
                    }     
                }else{
                 echo  "<div style='padding-bottom: 20px; text-align: center; color: black;' class='nothing'>Nothing has been entered into cart!</div>";   
                }          
        ?>
        
        <div class="cart-action wow fadeIn">
            <div class="cont-shopping">
                <a href="store.php">Continue Shopping</a>
            </div>
            <div class="empty-cart">
                <form method="post" action='cart.php'>
                <button type='submit' name="empty-cart">Empty Cart</button>
                </form>
            </div>
        </div>
        
        <div class="proceed-action wow bounceInLeft">
            <div class="box-1">
                
            </div>
            <div class="box-2">
                <div class="box-2-content">
                    <div class="heading">CART TOTAL</div>
                    <div class="sub-total-container">
                        <div class="sub-total">Subtotal</div>
                        <div class="sub-total-amount"><?php 
                            if(!empty($total)){echo "£ " . number_format($total, 2);}else{echo "£ 0.00";}
                        ?></div>
                    </div>
                    
                    <div class="vat-container">
                        <div class="vat-total">VAT @7.5% (+)</div>
                        <div class="vat-amount"><?php 
                            if(!empty($vat)){echo "£ " . number_format($vat, 2);}else{echo "£ 0.00";}
                        ?></div>
                    </div>
                    
                    <div class="total-container">
                        <div class="total">Total</div>
                        <div class="amount"><?php 
                            if(!empty($net_total)){echo "£ " . number_format($net_total, 2);}else{echo "£ 0.00";}
                        ?></div>
                    </div>
                    
                    <div class="proceed-btn">
                        <a href="checkout.php">Proceed To Checkout</a>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
    
    
    <!-- Section Four Container -->
    <div class="section-four">
        <div class="overlay">
            <div class="overlay-content">
            
            </div>
            <div class="overlay-content">
                <div class="text-1 wow fadeInRight" data-wow-delay='.5s'>Contact Us!</div>
                <div class="text-2 wow fadeInRight" data-wow-delay='1s'>Place your order with just one call!</div>
                <div class="text-3 wow fadeInRight" data-wow-delay='1.5s'>Click the buttons below to contact us!</div>
                <div class="text-4 wow fadeIn" data-wow-delay='2s'><a href="contact.php"><span class="fas fa-angle-left"></span> &nbsp; Contact Us</a></div>
            </div>
        </div>
    </div>
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
</html>