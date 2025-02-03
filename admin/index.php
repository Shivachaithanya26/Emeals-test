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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Admin</title>
    <?php include_once('../includes/admin_head_section.php'); ?>  
</head>
<body>
    
    <div class="phone-view wow fadeInDown">
            <h2 class="logo">
                <a href="index.php"><i class="fas fa-hamburger"></i> E-Meals</a>
            </h2>
                <span id="open" class="fas fa-list"></span>
                <span id="close" class="fas fa-times"></span>
    </div>
    
    <div class="admin-dashboard-container wow fadeInDown">
        
        <div class="admin-nav wow fadeInLeft">
                <h2 class="logo wow fadeIn">
                    <a href="index.php"><i class="fas fa-hamburger"></i> E-Meals</a>
                </h2>
            
                <div class="admin-nav-menu">
                    <ul>
                        <li style="background-color:var(--active-color);">
                            <a href="index.php" style="color:var(--bg-color); width: 100%;">
                                <i class="fas fa-home" style="color:var(--bg-color);"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="food.php">
                                <i class="fas fa-hamburger"></i>
                                Food
                            </a>
                        </li>
                        <li>
                            <a href="order.php">
                                <i class="fas fa-cart-plus"></i>
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
                         <a href="logout.php" class="wow fadeInRight"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
                
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span class="wow fadeInLeft">Dashboard</span> - Home
                    </div>
                </div>
            </div>
            
            
            <div class="admin-content-box wow bounceIn">
                
                <div class="total-sales-box">
                    
                    <div class="total-sales-number">
                    <span class="fas fa-donate"></span>
                    <p class="heading">TOTAL SALES</p>
                    <a href="order.php" class="details"><?php get_total_sales();?></a>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-cart-plus"></span>
                    <p class="heading">TOTAL ORDERS</p>
                    <a href="order.php" class="details"><?php get_total_orders(); ?></a>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-users"></span>
                    <p class="heading">TOTAL USERS</p>
                    <a href="users.php" class="details"><?php get_total_guest_users(); ?></a>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-hamburger"></span>
                    <p class="heading">TOTAL FOOD</p>
                    <a href="food.php" class="details"><?php get_total_food(); ?></a>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-donate"></span>
                    <p class="heading">TOTAL VAT</p>
                    <a href="order.php" class="details"><?php get_total_vat(); ?></a>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-cart-plus"></span>
                    <p class="heading">PENDING ORDER</p>
                    <a href="order.php" class="details"><?php get_new_orders(); ?></a>
                    </div>
                    
                </div>
                
            </div>
            
            
            <div class="admin-content-box">
                <div class="total-sales-box-2">
                    
                    <div class="total-sales-number">
                    <span class="fas fa-calendar-day"></span>
                    <p class="heading">TODAY</p>
                    <P class="details"><?php get_daily_total(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-calendar-week"></span>
                    <p class="heading">THIS WEEK</p>
                    <P class="details"><?php get_weekly_total(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-calendar-alt"></span>
                    <p class="heading">THIS MONTH</p>
                    <P class="details"><?php get_monthly_total(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="far fa-calendar"></span>
                    <p class="heading">THIS YEAR</p>
                    <P class="details"><?php get_yearly_total(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-calendar"></span>
                    <p class="heading">TOTAL SALES</p>
                    <P class="details"><?php get_total_sales(); ?></P>
                    </div>
                    
                </div>
                
                <div class="total-sales-box-2">
                    
                    <div class="total-sales-number">
                    <span class="fas fa-cart-arrow-down"></span>
                    <p class="heading">TODAY'S ORDERS</p>
                    <P class="details"><?php get_daily_orders(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-cart-plus"></span>
                    <p class="heading">THIS WEEK</p>
                    <P class="details"><?php get_weekly_orders(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-chart-bar"></span>
                    <p class="heading">THIS MONTH</p>
                    <P class="details"><?php get_monthly_orders(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-chart-line"></span>
                    <p class="heading">THIS YEAR</p>
                    <P class="details"><?php get_yearly_orders(); ?></P>
                    </div>
                    
                    <div class="total-sales-number">
                    <span class="fas fa-chart-pie"></span>
                    <p class="heading">TOTAL ORDERS</p>
                    <P class="details"><?php get_total_orders(); ?></P>
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
<script src="../assets/js/libraries/wow.min.js"></script>
<script>
new WOW().init();
</script>
</html>