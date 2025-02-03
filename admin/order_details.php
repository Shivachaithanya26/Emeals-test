<?php
include_once('../includes/connection.php');
session_start();

include_once('functions.php');
if(!isset($_SESSION['u_email'])){
    header('Location:home.php');
}else{
    $u_email = $_SESSION['u_email'];
    
    $select = mysqli_query($db, "SELECT * FROM admin_users WHERE email = '$u_email' || username = '$u_email'");
    $selected = mysqli_fetch_array($select);
    
    $user = $selected['username'];
}
if(!isset($_GET['id'])){
    header('Location:order.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Admin/Orders</title>
    <?php include_once('../includes/admin_head_section.php'); ?>
</head>
<body>
    
    <div class="phone-view">
            <h2 class="logo">
                <a href="index.php"><i class="fas fa-hamburger"></i> E-Meals</a>
            </h2>
                <span id="open" class="fas fa-list"></span>
                <span id="close" class="fas fa-times"></span>
    </div>
    
    <div class="admin-dashboard-container">
        
        <div class="admin-nav">
                <h2 class="logo">
                    <a href="index.php"><i class="fas fa-hamburger"></i> E-Meals</a>
                </h2>
            
                <div class="admin-nav-menu">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="food.php">
                                <i class="fas fa-hamburger"></i>
                                Food
                            </a>
                        </li>
                        <li style="background-color:var(--active-color);">
                            <a href="order.php" style="color:var(--bg-color); width: 100%;">
                                <i class="fas fa-cart-plus" style="color:var(--bg-color);"></i>
                                Order
                            </a>
                        </li>
                        <li>
                            <a href="users.php">
                                <i class="fas fa-users"></i>
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="review.php">
                                <i class="fas fa-mail-bulk"></i>
                                Reviews
                            </a>
                        </li>
                        <li>
                            <a href="feedback.php">
                                <i class="fas fa-mail-bulk"></i>
                                Feedback
                            </a>
                        </li>
                        <li>
                            <a href="settings.php">
                                <i class="fas fa-cog"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
        </div>
        
        
        
        
        <div class="admin-content-display">
            <div class="admin-content-header">
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span class="fas fa-user-alt"></span> <span>Hello</span> <?php echo $user?>
                    </div>
                    
                    <div class="logout-box">
                         <a href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
                
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span>Dashboard</span> - Order
                    </div>
                </div>
            </div>

            
            
                <?php

                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                    }    

                ?>
            <div class="admin-content-box">
                <a href="order.php" class="back-btn">Back to Home</a>
                <div class="box-content-heading">Order #ID - <?php echo $id; ?></div>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                <div class="order-details-container">
                    <div class="box-one">
                        <?php
                            
                        if(isset($_GET['id'])){
                            $id = $_GET['id'];
                            $choose = mysqli_query($db, "SELECT * FROM orders WHERE order_id = '$id'");
                            $chosen = mysqli_fetch_assoc($choose);
                            if($chosen){
                                foreach($choose as $chosen){
                                $order_id = $chosen['order_id'];
                                $food_id = $chosen['food_id'];
                                
                                $run = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$food_id'");
                                $ran = mysqli_fetch_array($run);
                        ?>   
                        <div class="box-one-holder">
                            <div class="order-img"><img src="../assets/css/images/<?php echo $ran['image'];?>"/></div>
                            <div class="order-fn">Name: <?php echo $ran['name'];?></div>
                            <div class="order-fp">Price: £ <?php echo number_format($chosen['price'], 2);?></div>
                            <div class="order-fp">Spice Level: <?php echo $chosen['spice'];?></div>
                            <div class="order-fq">Qauntity: <?php echo $chosen['quantity'];?></div>
                        </div>
                        <?php
                                }
                            }
                        }
                        
                        ?>
                        
                    </div>
                    <div class="box-two">
                        <?php
                            if(isset($_GET['id'])){
                            $id = $_GET['id'];
                            $choose = mysqli_query($db, "SELECT * FROM order_table WHERE order_id = '$id'");
                            $chosen = mysqli_fetch_assoc($choose);
                            if($chosen){
                                $time = date('D d M, Y - h:i:s A', strtotime($chosen['time']));
                                $fullname = $chosen['fname'] . " " . $chosen['lname'];
                                $email = $chosen['email'];
                                $phone = $chosen['phone'];
                                $address = $chosen['address'] . " " . $chosen['state'];
                                $special_notes = $chosen['special_notes'];
                                
                                $select = mysqli_query($db, "SELECT * FROM orders WHERE order_id = '$id'");
                                $selected = mysqli_fetch_assoc($select);
                                
                                $num = mysqli_num_rows($select);
                                $quantity = 0;
                                $sub_total = 0;
                                
                                foreach($select as $selected){
                                    $quantity += $selected['quantity'];
                                    $sub_total += $selected['quantity'] * $selected['price'];
                                }
                                $vat = $sub_total * 0.075;
                                $total = $sub_total + $vat;
                        ?>
                        <div class="box-two-holder">
                            <div class="order-ot">Order Date: <?php echo $time; ?></div>
                            <!--<div class="order-tp">Order Time: <?php //echo date('h:i a', time($time)); ?></div>-->
                            <div class="order-tp">Name: <?php echo $fullname; ?></div>
                            <div class="order-tp">Email: <?php echo $email; ?></div>
                            <div class="order-tp">Tel: <?php echo $phone; ?></div>
                            <div class="order-tp">Address: <?php echo $address; ?></div>
                            <div class="order-tp">Special Request: <?php echo $special_notes; ?></div>
                            <!-- <div class="order-tp">Number of products: <?php //echo $num; ?></div>-->
                            <div class="order-tq">Total Quantity: <?php echo $quantity; ?></div>
                            <div class="order-st">Subtotal: $ <?php echo number_format($sub_total, 2); ?></div>
                            <div class="order-v">Vat @7.5%: $ <?php echo number_format($vat, 2); ?></div>
                            <div class="order-t">$ <?php echo number_format($total, 2); ?></div>
                            <a class="order-tp" href="edit_order.php?id=<?php echo $chosen['id']; ?>">Order Status</a>
                        </div>
                        <?php
                            }
                        }      
                        ?>
                    </div>
                </div>
                
            </div>
            
        </div>
        
        
    </div>
    
</body>

<script src="../assets/js/libraries/slick.js"></script>
<script src="../assets/js/libraries/jquery.magnific-popup.js"></script>
<script src="../assets/js/libraries/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="../assets/js/style.js"></script>
<script type="text/javascript">
function loadfile(event){
    var output = document.getElementById('displayImg');
    output.src = URL.createObjectURL(event.target.files[0]);
}    
</script>
</html>