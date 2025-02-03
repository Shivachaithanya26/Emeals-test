<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Food Details</title>
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
                    <li><a href="cart.php" class='links'>Cart <i class="fas fa-shopping-cart"> <?php cart_num_display(); ?></i></a></li>
                    <?php display_logout_link(); ?>
                    <?php username_display(); ?>
                </ul>
            </div>
            <div class="btn-container">
                <button class='nav-btn'><i class="fas fa-list"></i></button>
                <button class='close-btn'><i class="fas fa-times"></i></button>
                <button class='cart-btn'><i class="fas fa-shopping-cart">&nbsp;  <?php cart_num_display(); ?></i></button>
            </div>
        </div>    
    
    
    <!-- Food Details Container -->
    <div class="food-container">
        
        
        <?php
            if(isset($_GET['id'])){
                $food_id = $_GET['id'];

                $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$food_id'");
                $selected = mysqli_fetch_array($select);
                if($selected){        
        ?>
        
        <div class="backlink wow fadeIn">
            <a href="index.php"><i class="fas fa-home"></i> &nbsp;Home</a>
            <span style="text-transform: capitalize"><i class="fas fa-angle-right"></i> &nbsp;<?php echo $selected['category']; ?></span>
            <span style="text-transform: capitalize"><i class="fas fa-angle-right"></i> &nbsp;<?php echo $selected['name']; ?></span>
        </div>
        
        <div class="food-details-container">
            <div class="separator wow fadeInRight">
                <img src="assets/css/images/<?php echo $selected['image']; ?>" alt="food-image">
            </div>
            <div class="separator wow fadeIn">
                <form method="post" action="cart.php?action=add&id=<?php echo $selected['id']; ?>">
                    <div class="food-name wow fadeIn"><?php echo $selected['name']; ?></div>
                    <div style="font-family: Montserrat-Bold" class="food-brief">Category: <?php echo $selected['category']; ?></div>
                    <div class="food-price"><?php echo "£ " . number_format($selected['price'], 2);?></div>
                    <div class="food-description"><?php echo $selected['description']; ?></div>
                    
                    <div class="checkbox-select">
                        <span class='checkbox-label'>Spice Level</span>
                        <input type="radio" name="spice_level" value="none" class="box-input" checked id="none">
                        <label for="none" class='checkbox-label-value'>Non-Spicy</label><br>
                        <input type="radio" name="spice_level" value="moderate" class="box-input" id="moderate">
                        <label for="moderate" class='checkbox-label-value'>Moderate</label><br>
                        <input type="radio" name="spice_level" value="medium" class="box-input" id="medium">
                        <label for="medium" class='checkbox-label-value'>Medium</label><br>
                        <input type="radio" name="spice_level" value="high" class="box-input" id="high">
                        <label for="high" class='checkbox-label-value'>High</label><br>
                    </div>
                    
                    <div class="food-quantity">
                        <span class='qty-label'>Quantity:</span>
                        <input type="number" min="1" name="qty" value="1" class="qty-input">
                        <input type="hidden" value="<?php echo $selected['name']; ?>" name="hidden_name">
                        <input type="hidden" value="<?php echo $selected['image']; ?>" name="hidden_image">
                        <input type="hidden" value="<?php echo $selected['price']; ?>" name="hidden_price">
                        <button type="submit" name="add" class="add-to-cart-btn wow fadeInRight">ADD TO CART</button>
                    </div>
                </form>
            </div>
        </div>
            
        <?php
                }
            }else{
                header('location:store.php');
            }
        ?>
       
        
        
        <div class="review-container" id="review-container">
            <?php
                    $name = "";
                    $comment = "";
                    $stars = "";
                    $food_id = "";
                    $message = "";
            
                if(isset($_POST['submit_review'])){
                    $name = mysqli_real_escape_string($db, $_POST['name']);
                    $comment = mysqli_real_escape_string($db, nl2br($_POST['review']));
                    $stars = mysqli_real_escape_string($db, $_POST['rate']);
                    $food_id = $_GET['id'];
                    
                    $select = mysqli_query($db, "SELECT * FROM review_table WHERE name='$name' && comment='$comment' && stars = '$stars'");
                    $selected = mysqli_num_rows($select);
                    
                    if($selected != 1){
                        mysqli_query($db, "INSERT INTO review_table(name, comment, stars, food_id)VALUES('$name', '$comment', '$stars', '$food_id')");
                        $message = "<div class='success' style='text-align:left;'>Review Submitted!</div>";
                    }else{
                        $message = "<div class='danger' style='text-align:left;'>This review has been submitted already!</div>";
                    }
                }    
            
            ?>
            
            
            <div class="review-heading wow fadeInLeft">
                REVIEWS/RATINGS
            </div>
                
            <?php
                if(isset($_GET['id'])){
                    $food_id = $_GET['id'];
                    $select = mysqli_query($db, "SELECT * FROM review_table WHERE food_id = '$food_id' ORDER BY date DESC");
                    $selected = mysqli_fetch_assoc($select);
                    $num = mysqli_num_rows($select);
                    
                    if($num > 0){
                    foreach($select as $selected){
                    $name = $selected['name'];
                    $comment = $selected['comment'];
                    $stars = $selected['stars'];
                    $total_stars = 5;
                    $no_stars = $total_stars - $stars;
                    $date = date('d M, Y - h:i a',  strtotime($selected['date']));
            ?>            
            
            <div class="review-box">

                <div class="review-img-box wow fadeIn">
                    <span class="fas fa-user"></span>
                </div>
                <div class="review-content wow fadeInRight" id="review-content">
                        <div class="review-text" style="font-weight: 600"><?php echo $name; ?></div>
                        <div class="review-text"><?php echo $comment; ?></div>
                        <div class="review-star">
                            <?php
                                for($star = 0; $star < $stars; $star++){
                            ?>
                                <span class="fas fa-star yellow"></span>
                            <?php
                                }
                            ?>
                            <?php
                                for($star2 = 0; $star2 < $no_stars; $star2++){
                            ?>
                                <span class="fas fa-star grey"></span>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="review-date"><?php echo $date; ?></div>
                </div>

            </div>
            
            <?php
                        }
                    }else{
            ?>
            
            
            <div class="review-box wow fadeIn">
                
                <div class="review-content">
                        <div class="review-text" style="color:black;">No Reviews Yet!</div>
                        <div class="review-text"></div>
                        <div class="review-star">
                        </div>
                        <div class="review-date"></div>
                </div>

            </div>
            
            <?php            
                    }
                }
            ?>
            

            <div class="review-form wow fadeIn" id="review-container">
                <!-- Results -->
                <?php
                    if(!empty($message)){
                        echo $message;
                    }
                ?>
                    <h3>Let's get your reviews</h3>
                    <form action="#review-content" method="POST">
                            <div class="form-group wow fadeIn">
                                <label>Name</label>
                                <input type="text" name="name" placeholder="Let's get your name" required>
                            </div>
                            <div class="form-group wow fadeIn">
                                <label>Review</label>
                                <textarea name="review" placeholder="Let us know how you feel about this meal" required></textarea>
                            </div>
                            <div class="form-group wow fadeIn">
                                <label>Rating</label>
                                <input type="range" max="5" min="1" value="2" oninput="show_rating()" id="rateVal" name="rate">
                                <div id="display_rate">2 star(s)</div>
                            </div>
                            <div class="form-group wow fadeIn">
                                <button type="submit" name="submit_review" class="wow fadeInLeft">Submit</button>
                            </div>
                    </form>
            </div>

        </div>
        
        
    </div>
    
    
    <!-- Section Four Container -->
    <div class="section-four">
        <div class="overlay">
            <div class="overlay-content">
            
            </div>
            <div class="overlay-content">
                <div class="text-1 wow fadeInRight" data-wow-delay=".5s">Hurry Up!</div>
                <div class="text-2 wow fadeInRight" data-wow-delay="1s">Favourite Meals, Affordable Rate</div>
                <div class="text-3 wow fadeInRight" data-wow-delay="1.5s">Click the buttons below to see more available foods!</div>
                <div class="text-4 wow fadeIn" data-wow-delay="2s"><a href="#"><span class="fas fa-angle-left"></span> &nbsp; Shop Now</a></div>
            </div>
        </div>
    </div>
    
    
    <!-- Footer -->
    <?php include_once('includes/footer.php')?>
</body>

<?php include_once('includes/chat.php'); ?>
<?php include_once('includes/jquery.php'); ?>
<script>
var rateVal =  document.getElementById('rateVal');
var displayRate =  document.getElementById('display_rate');

function show_rating(){
    console.log(rateVal.value);
    displayRate.innerHTML = rateVal.value + " star(s)";
}
</script>
</html>