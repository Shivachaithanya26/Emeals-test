<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - All Food</title>
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
                    <li><a href="index.php" class='links'>Home</a></li>
                    <li><a href="store.php" class='links' id='active'>All Food</a></li>
                    <li><a href="account.php" class='links'>Account</a></li>
                    <li><a href="contact.php" class='links'>Contact</a></li>
                    <li><a href="cart.php" class='links'>Cart <i class="fas fa-shopping-cart"> <?php echo cart_num_display();?></i></a></li>
                    <?php echo display_logout_link(); ?>
                    <?php echo username_display(); ?>
                </ul>
            </div>
            
            
            <!-- Mobile View Button Display -->
            <?php include_once('includes/mobile_btn_display.php'); ?>
            
        </div>    
    
    
    <!-- Store Container -->
    <div class="store-container" id="store-container">
        <div class="backlink wow fadeInLeft">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span><i class="fas fa-angle-right"></i> Store</span>
        </div>
        
        <div class="category-btn"><a href="#store-container" class="fas fa-list-alt"></a></div>
        
        <div class="store-box">
            
            <form class='search-form wow bounceIn' method='post' action="search.php">
                <input type="text" placeholder="Search" name="food_search" required>
                <button type="submit" name="search"><i class="fas fa-search"></i></button>
            </form>
            
            <div class="store-category-header wow fadeInLeft">
                CATEGORIES
                <hr>
            </div>
            
            <div class="store-category-list">
                <div class="list-name wow fadeInDown"><a href="store.php?categories=all">All</a></div>
                
                <?php
                    $select = mysqli_query($db, "SELECT * FROM categories_table ORDER BY categories_name ASC");
                    $selected = mysqli_fetch_assoc($select);
                    foreach($select as $selected){
                        $link_page = $selected['categories_name'];
                ?>
                <div class="list-name wow fadeInDown"><a href="store.php?categories=<?php echo $link_page; ?>" class='cat-link'><?php echo $link_page; ?></a></div>
                <?php
                    }
                ?>
                
            </div>
            
        </div>
        
        <div class="store-box-2">
            
            <div class="food-search-result wow fadeInDown">
                <?php
                    if(isset($_GET['categories'])){
                        echo "CATEGORIES - {$_GET['categories']}";
                    }else{
                        echo "CATEGORIES - All";
                    }
                ?>
            </div>
            
            <?php
                if(isset($_GET['categories']) && $_GET['categories'] != "all"){
                    $categories = $_GET['categories'];

                    $pick = mysqli_query($db, "SELECT * FROM food_table WHERE category = '$categories' ORDER BY name ASC");
                    $picked = mysqli_fetch_assoc($pick);
                    foreach($pick as $picked){
                        $id = $picked['id'];
                        $image = $picked['image'];
                        $category = $picked['category'];
                        $name = $picked['name']; 
                        $price = number_format($picked['price'], 2);
            ?>
                <div class="meal-box">
                    <div class="image-container">
                        <a href='details.php?id=<?php echo $id ?>'>
                            <img src="assets/css/images/<?php echo $image ?>" alt="food-image"/>
                            <div class="featured-category"><?php echo $category ?></div>
                            <div class="featured-food-name"><?php echo $name ?></div>
                            <div class="featured-food-price">£ <?php echo $price ?></div>
                            <div class="featured-food-btn">BUY</div>
                        </a>
                    </div>
                </div>
                
            <?php
                    }
                }elseif((isset($_GET['categories']) && $_GET['categories'] == "all") || !isset($_GET['categories'])){
                    $pick = mysqli_query($db, "SELECT * FROM food_table ORDER BY name ASC");
                    $picked = mysqli_fetch_assoc($pick);
                    foreach($pick as $picked){
                        $id = $picked['id'];
                        $image = $picked['image'];
                        $category = $picked['category'];
                        $name = $picked['name'];
                        $price = number_format($picked['price'], 2);
            ?>
                <div class="meal-box">
                    <div class="image-container">
                        <a href='details.php?id=<?php echo $id ?>'>
                            <img src="assets/css/images/<?php echo $image ?>" alt="food-image"/>
                            <div class="featured-category"><?php echo $category ?></div>
                            <div class="featured-food-name"><?php echo $name ?></div>
                            <div class="featured-food-price">£ <?php echo $price ?></div>
                            <div class="featured-food-btn">BUY</div>
                        </a>
                    </div>
                </div>
              
             <?php
                        }
                    }
                ?>
            
            
        </div>
        
    </div>
    
    
    <!-- Section Four Container -->
    <div class="section-four">
        <div class="overlay">
            <div class="overlay-content">
            
            </div>
            <div class="overlay-content">
                <div class="text-1 wow fadeInRight" data-wow-delay='.5s'>Hurry Up!</div>
                <div class="text-2 wow fadeInRight" data-wow-delay='1s'>Call in for your Favourite Meals</div>
                <div class="text-3 wow fadeInRight" data-wow-delay='1.5s'>Click the buttons below to see our contact details!</div>
                <div class="text-4 wow fadeIn" data-wow-delay='2s'><a href="contact.php"><span class="fas fa-angle-left"></span> &nbsp; Shop Now</a></div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
</html>