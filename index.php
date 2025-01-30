<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Home</title>
    <?php include_once('includes/css_links.php')?>
</head>
<body>
    
    
    <!-- Header Menu -->
        <div class='header-menu'>
            <div class='header-logo'>
                <h2 class="wow fadeInLeft"><a href="index.php"><i class="fas fa-hamburger"></i> E-Meals</a></h2>
            </div>
            
            <div class="menu">
                <ul>
                    <li><a href="index.php" class='links' id='active'>Home</a></li>
                    <li><a href="store.php" class='links'>All Food</a></li>
                    <li><a href="account.php" class='links'>Account</a></li>
                    <li><a href="contact.php" class='links'>Contact</a></li>
                    <li><a href="cart.php" class='links'>Cart <i class="fas fa-shopping-cart"> <?php echo cart_num_display(); ?></i></a></li>
                    <?php echo display_logout_link(); ?>
                    <?php echo username_display(); ?>
                </ul>
            </div>
            
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
        </div>
    
    <!-- Header Container -->
    <div class="header-container">
        <!-- Header Slide Container -->
        <div class="container">
            
            <!-- Header Slide One -->
            <div class='image-slide-container'>
                <img src="assets/css/images/nav-2.jpg" alt="slider image">
                <div class='overlay'>
                    <div class="welcome-box-1">
                        <div class="welcome-text wow fadeInLeft" data-wow-duration='2s' data-wow-delay='1s'>WELCOME TO E-MEALS</div>
                        <span class="welcome-subtext wow fadeInLeft" data-wow-duration='2s' data-wow-delay='2s'>Get all sorts of dishes, no matter your taste!</span><br>
                        <a class="welcome-link wow fadeInLeft" href="store.php" data-wow-duration='2s' data-wow-delay='3s'>BUY NOW</a>
                    </div>
                </div>
            </div>
            
            <!-- Header Slide Two -->
            <div class='image-slide-container'>
                <img src="assets/css/images/nav-3.jpg" alt="slider image">
                <div class='overlay'>
                    <div class="welcome-box-2">
                        <div class="welcome-text wow fadeInDown" data-wow-duration='2s' data-wow-delay='1s'>DELICIOUS MEALS!</div>
                        <span class="welcome-subtext">Click the buttons below to view all our food!</span><br>
                        <a class="welcome-link" href="#trending">Explore</a>
                    </div>
                </div>
            </div>
            
            <!-- Header Slide Three -->
            <div class='image-slide-container'>
                <img src="assets/css/images/nav-4.jpg" alt="slider image">
                <div class='overlay'>
                    <div class="welcome-box-3">
                        <div class="welcome-text wow fadeInright" data-wow-duration='2s' data-wow-delay='1s'>FAST SERVICE DELIVERY!</div>
                        <span class="welcome-subtext">We are always here to provide your needs!</span><br>
                        <a class="welcome-link" href="#">CONTACT US</a>
                    </div>
                </div>
            </div>
            
        </div>
        
            <!-- Header Slide Buttons -->
            <button type="button" class="prevBtn"><i class="fas fa-caret-left"></i></button>
            <button type="button" class="nextBtn"><i class="fas fa-caret-right"></i></button>
    </div>
    
    
    <!-- Featured Food Container -->
    <div class="featured-food-container" id="trending">
        <div class="trending-container">
            <h1 class="wow fadeInDown" data-wow-duration='.5s'>Trending Meals</h1>
            <p class="wow fadeInDown" data-wow-duration='.5s' data-wow-delay='1s'>These are the most purchased meals</p>
            <div class="trending-meals-wrapper">
                
            <?php
                        //This is used to display food result based on categories selected.
                        $select = mysqli_query($db, "SELECT * FROM  trending ORDER BY trend DESC LIMIT 6");
                        $selected = mysqli_fetch_assoc($select);
                        foreach($select as $selected){
                            $id = $selected['id'];
                            $choose = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
                            $chosen = mysqli_fetch_assoc($choose);
                            if($chosen){
            ?>
                
                <div class="meal-box wow fadeInDown" data-wow-duration='.5s' data-wow-delay='1s'>
                    <div class="image-container">
                        <a href="details.php?id=<?php echo $chosen['id']; ?>">
                            <img src="assets/css/images/<?php echo $chosen['image']; ?>" alt="food-image"/>
                            <div class="trend-text"><?php echo $chosen['name']; ?></div>
                            <div class="trend-text-heading"><?php echo "£ " . number_format($chosen['price'], 2);?></div>
                        </a>
                    </div>
                </div>
            <?php
                        }
                    }
            ?>
                
            </div>
        </div>  
    </div>
    
    <div class="section-three">
        <div class="featured-container">
            <h1 class="wow fadeInDown" data-wow-duration='.5s'>Our Featured Meals</h1>
            <hr class='line wow fadeInDown' data-wow-duration='.5s' data-wow-delay='.3s'>
            <p class="wow fadeInDown" data-wow-duration='.5s' data-wow-delay='.5s'>These are the most purchased meals</p>
            <div class="featured-meals-wrapper">
                
                <?php
                        //This is used to display food result based on categories selected.
                        $select = mysqli_query($db, "SELECT * FROM  food_table WHERE status = 'available' ORDER BY name ASC LIMIT 8");
                        $selected = mysqli_fetch_assoc($select);
                        foreach($select as $selected){
                ?>
                
                <div class="meal-box wow fadeInLeft" data-wow-duration='1s' data-wow-delay='1s'>
                    <div class="image-container">
                        <a href='details.php?id=<?php echo $selected['id']; ?>'>
                            <img src="assets/css/images/<?php echo $selected['image']; ?>" alt="food-image"/>
                            <div class="featured-category"><?php echo $selected['category']; ?></div>
                            <div class="featured-food-name"><?php echo $selected['name']; ?></div>
                            <div class="featured-food-price"><?php echo "£ " . number_format($selected['price'], 2);?></div>
                            <div class="featured-food-btn">BUY</div>
                        </a>
                    </div>
                </div>
                
                <?php
                    }    
                ?>
                
            </div>
        </div>  
    </div>
    
    
    
    <!-- Section Four Container -->
    <div class="section-four">
        <div class="overlay">
            <div class="overlay-content">
            
            </div>
            <div class="overlay-content">
                <div class="text-1 wow fadeInRight" data-wow-duration='1s' data-wow-delay='.5s'>Hurry Up!</div>
                <div class="text-2 wow fadeInRight" data-wow-duration='1s' data-wow-delay='1s'>Favourite Meals, Affordable Rate</div>
                <div class="text-3 wow fadeInRight" data-wow-duration='1s' data-wow-delay='1.5s'>Click the buttons below to see more available foods!</div>
                <div class="text-4 wow fadeIn" data-wow-duration='1s' data-wow-delay='2s'><a href="store.php"><span class="fas fa-angle-left"></span> &nbsp; Shop Now</a></div>
            </div>
        </div>
    </div>
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
</html>