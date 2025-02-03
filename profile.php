<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
if(!isset($_SESSION['email'])){
    header('location:account.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Profile</title>
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
                    <li><a href="cart.php" class='links'>Cart <i class="fas fa-shopping-cart"> <?php echo cart_num_display(); ?></i></a></li>
                    <?php display_logout_link(); ?>
                    <?php username_display(); ?>
                </ul>
            </div>
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
            
        </div>    
    
    
    <!-- Cart Container -->
    <div class="contact-container">
        <div class="backlink wow fadeInLeft">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> User Profile</span>
        </div>
        
        <?php
        $message = "";
        $passErr = "";
        $current_passErr = "";
        $old_password = "";
        $password = "";
        $confirm_password = "";
        
        if(isset($_POST['update_password'])){
            $old_password = mysqli_real_escape_string($db, md5($_POST['old_password']));
            $password = mysqli_real_escape_string($db, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($db, md5($_POST['confirm_password']));
            
            if($password != $confirm_password){
                $passErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Passwords do not match!</div>";
            }

            $select = mysqli_query($db, "SELECT * FROM guest_table WHERE email = '{$_SESSION['email']}'");
            $selected = mysqli_fetch_assoc($select);
            
            
            if($old_password != $selected['password']){
                $current_passErr = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Your current password is incorrect!</div>";
            }
            
            $num = mysqli_num_rows($select);

    if($num == 1 && !$passErr && !$current_passErr && $old_password != $password){
        mysqli_query($db, "UPDATE guest_table SET password = '$password' WHERE email =  '{$_SESSION['email']}'");
        $message = "<div class='success wow fadeInDown' data-wow-duration='1s'>Password Updated Successfully!</div>";
    }elseif($num == 1 && !$current_passErr && !$passErr && $old_password == $password){
        $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>No changes made!</div>";
        }elseif($num != 1 && !$current_passErr && !$passErr && $old_password != $password){
        $message = "<div class='danger wow fadeInDown' data-wow-duration='1s'>Error!</div>";
        }
    }
        
        
        ?>
        
        
        <?php
            if(!empty($passErr)){echo $passErr; }
            if(!empty($current_passErr)){echo $current_passErr; }
            if(!empty($message)){echo $message; }
        
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>
        
        
        <div class="contact-box">
            
            <div class="contact-box-heading wow bounceInDown">USER PROFILE</div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-cart-plus'></i> <a href="profile.php" class='main-title'>All Orders</a></div>
                <div class="main-content">
                    View all orders
                </div>
            </div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-lock'></i> <a href="profile.php?action=edit_user" class='main-title'>Change Password</a></div>
                <div class="main-content">
                    Update your password
                </div>
            </div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-user'></i> <span class='main-title'>Username</span></div>
                <div class="main-content" style="text-transform:capitalize">
                    <?php
                        $select = mysqli_query($db, "SELECT * FROM guest_table WHERE email = '{$_SESSION['email']}'");
                        $selected = mysqli_fetch_assoc($select);
                        echo $selected['username'];
                    ?>
                </div>
            </div>
            
            <div class="contact-box-holder wow fadeInLeft" data-wow-delay='.5s'>
                <div class="title"><i class='fas fa-envelope'></i> <span class='main-title'>Email</span></div>
                <div class="main-content"><?php echo $_SESSION['email']; ?></div>
            </div>
            
        </div>
        
        <div class="contact-box wow fadeInRight">
            
            <?php
                if(!isset($_GET['action'])){
            ?>
            
            <div class="contact-box-heading wow bounceInDown">ALL ORDERS</div>
            
            <div class="table-container">
                <table>
                    <tr> 
                       <th>Order_Id</th>  
                       <th>Date</th> 
                       <th>Status</th>
                       <th>Action</th>
                    </tr>
                    
                    <?php
                        
                        if(isset($_GET['page']) && $_GET['page'] != ""){
                            $page = $_GET['page'];
                         }else{
                            $page = 1;
                         }
                         $results_per_page = 6;
                         $pick = mysqli_query($db, "SELECT * FROM order_table");
                         $total_results = mysqli_num_rows($pick);
                         $total_page_num = ceil($total_results/$results_per_page);
                         $offset = ($page - 1) * $results_per_page;
                        
                    
                    
                        $logged_email = $_SESSION['email'];
                        $select = mysqli_query($db, "SELECT * FROM order_table WHERE email = '$logged_email' LIMIT $offset, $results_per_page");
                        $selected = mysqli_fetch_assoc($select);
                        $num = mysqli_num_rows($select);
                    
                        if($num > 0){
                            foreach($select as $selected){
                    ?>
                    
                    <tr> 
                        <td>EM-<?php echo $selected['order_id'];?></td>  
                        <td><?php echo date('d M, y - h:i a', strtotime($selected['time']));?></td> 
                        <td>
                            <?php
                              if($selected['status'] == 'confirmed'){
                                  echo "<a href='profile.php?action=order&id={$selected['order_id']}' style='color: green;'>Confirmed</a>";
                              }elseif($selected['status'] == 'pending'){
                                  echo "<a href='profile.php?action=order&id={$selected['order_id']}' style='color: red;'>Pending</a>";
                              }elseif($selected['status'] == 'cancelled'){
                                  echo "<a style='color: #222;'>Cancelled</a>";
                              }  
                            ?>
                        </td>
                       <td>
                           <?php
                              if($selected['status'] == 'pending'){  
                            ?>
                           <a href="cancel.php?action=del&id=<?php echo $selected['order_id'];?>" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</a>
                           <?php
                              }else{
                                  echo "Closed";
                              }
                            ?>
                        </td> 
                    </tr>
                    
                    <?php
                      }    
                        }else{
                    ?>
                    
                    <tr> 
                       <td colspan="5" style="padding: 20px 0">You haven't placed any orders yet!</td> 
                    </tr>
                        
                    
                    <?php
                        }          
                    ?>
                    
                </table>
                
                <div class="pagination">
                    <ul>
                        <?php include_once('includes/profile_table_pagination.php'); ?>
                    </ul>
                </div>
                
                
            </div>
            
            <?php
                }elseif(isset($_GET['action']) && $_GET['action'] == 'edit_user'){
            ?>
            
            <div class="contact-box-heading wow bounceInDown">CHANGE PASSWORD</div>
            
            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <input type="password" name="old_password" placeholder="Current Password" required>
                    </div>
                    
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <input type="password" name="password" placeholder="New Password" required>
                    </div>
                    
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                    </div>
                    
                    <div class="form-group wow fadeInRight" data-wow-delay='.5s'>
                        <button type="submit" name="update_password">UPDATE</button>
                    </div>
                </form>
            </div>
            
            <?php
                }elseif(isset($_GET['action']) && $_GET['action'] == 'order'){
            ?>
            
            
            <div class="contact-box-heading wow bounceInDown">ORDER DETAILS - <?php echo "EM " . $_GET['id'];?></div>
            
            <div class="order-table-container">
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price (£)</th>
                        <th>Qty</th>
                        <th>Total (£)</th>
                    </tr>
                    
                    <?php
                        if(isset($_GET['id'])){
                            $id = $_GET['id'];
                            $total = 0;
                            $subtotal = 0;
                            $select = mysqli_query($db, "SELECT * FROM orders WHERE order_id = '$id'");
                            $selected = mysqli_fetch_assoc($select);
                            if($selected){   
                                foreach($select as $selected){
                                    $subtotal += $selected['price'] * $selected['quantity'];
                    ?>
                    
                    <tr>
                            <?php
                                $make = mysqli_query($db, "SELECT * FROM food_table WHERE id = '{$selected['food_id']}'");
                                $decide = mysqli_fetch_array($make);
                                //echo $decide['image'];
                            ?>
                        <td class='tab-image'><img src="assets/css/images/<?php echo $decide['image']; ?>"></td>
                        <td><?php echo $decide['name'];?></td>
                        <td><?php echo number_format($selected['price'], 2);?></td>
                        <td><?php echo $selected['quantity'];?></td>
                        <td><?php echo number_format($selected['price'] * $selected['quantity'], 2); ?></td>
                    </tr>
                    
                    <?php
                                }
                                
                            }
                        }
                    ?>
                </table>
            </div>
            
            <div class="summary-container">
                <h3>Order Total</h3>
                <div class="subtotal"><span style='font-family:Montserrat-Bold;color:var(--bg-color);'>Subtotal</span>: <?php echo number_format($subtotal, 2); ?></div>
                <div class="vat"><span style='font-family:Montserrat-Bold;color:var(--bg-color);'>Vat @7.5% (+)</span>: <?php echo number_format($subtotal * 0.075, 2); ?></div>
                <div class="total"><span style='font-family:Montserrat-Bold;color:var(--bg-color);'>Total</span>: <?php echo number_format($subtotal * 1.075, 2); ?></div>
                <div class="status"><span style='font-family:Montserrat-Bold;color:var(--bg-color);'>Order Status</span>: 
                    <?php
                        $select = mysqli_query($db, "SELECT * FROM order_table WHERE order_id = '{$_GET['id']}'");
                        $selected = mysqli_fetch_assoc($select);
                        if($selected['status'] == 'confirmed' || $selected['status'] == 'cancelled'){
                            echo "Closed";
                        }elseif($selected['status'] == 'pending'){
                            echo "<span style='color: red;'>Pending</span>";
                        }
                    ?>
                </div>
                <div class="notify"> 
                    <?php
                        $select = mysqli_query($db, "SELECT * FROM order_table WHERE order_id = '{$_GET['id']}'");
                        $selected = mysqli_fetch_assoc($select);
                        if($selected['status'] == 'pending'){
                            echo "Delivery on the way!";
                        }
                    ?>
                </div>
                <div class="cancel-btn-btn"> 
                    <?php
                        $select = mysqli_query($db, "SELECT * FROM order_table WHERE order_id = '{$_GET['id']}'");
                        $selected = mysqli_fetch_assoc($select);
                        if($selected['status'] == 'pending'){
                        ?>                    
                            <a href="cancel.php?action=del&id=<?php echo $selected['order_id']?>" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</a>;
                    <?php
                        }
                    ?>
                </div>
            </div>
            
            <?php
                }
            ?>
        </div>
        
        
    </div>
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
</html>