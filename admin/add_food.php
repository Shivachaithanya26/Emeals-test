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
    <title>E-Meals - Admin/Food</title>
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
    
    <div class="admin-dashboard-container wow fadeIn">
        
        <div class="admin-nav wow fadeInLeft">
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
                        <li style="background-color:var(--active-color);">
                            <a href="food.php" style="color:var(--bg-color); width: 100%;">
                                <i class="fas fa-hamburger" style="color:var(--bg-color);"></i>
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
                                Review
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
        
        
        
        
        <div class="admin-content-display wow fadeInDown">
            <div class="admin-content-header">
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span class="fas fa-user-alt"></span> <span>Hello</span> <?php echo $user; ?>
                    </div>
                    
                    <div class="logout-box">
                        <a href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
                
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span>Dashboard</span> - Food
                    </div>
                </div>
            </div>
            
            
            <div class="admin-content-box">
                <div class="admin-nav-bar">
                    <ul>
                        <li class='menu-list-btn wow fadeInLeft'><a href="food.php">Food Details</a></li>
                        <li class='menu-list-btn wow fadeInLeft' data-wow-delay='.5s'><a href="add_food.php" class="active">Add New Food</a></li>
                        <li class='menu-list-btn wow fadeInLeft' data-wow-delay='1s'><a href="add_food_category.php">Food Categories</a></li>
                    </ul>
                </div>
            </div>

            
            <div class="admin-content-box">
                <a href="food.php" class="back-btn">Back to Home</a>
                <div class="box-content-heading">Add New Food</div>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                
                <?php include_once('includes/add_new_food.php');?>
                
                <?php
                    if(!empty($message)){
                        echo $message;
                    }

                    if(!empty($imageSizeErr)){
                        echo $imageSizeErr;
                    }

                    if(!empty($imageTypeErr)){
                        echo $imageTypeErr;
                    }
                ?>
                
                <div class="add-food-form-container">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="box-1">
                        
                        <div class="form-group">
                            <div class="form-label">Name</div>
                            <input type="text" name="name" placeholder="" required>
                            <span class="fas fa-hamburger"></span>
                        </div>

                        <div class="form-group">
                            <div class="form-label">Price: Pounds (£)</div>
                            <input type="text" name="price" placeholder="" required>
                            <span class="fas fa-donate"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-label">Description</div>
                            <textarea name="description" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-label">Category</div>
                            <select name="category" required style="text-transform:capitalize;">
                                <option value="">-- Select Category --</option>
                                <?php
                                    $select = mysqli_query($db, "SELECT categories_name FROM categories_table");
                                    $selected = mysqli_fetch_assoc($select);
                                    foreach($select as $selected){      
                                ?>
                                    <option value="<?php echo $selected['categories_name']; ?>"><?php echo $selected['categories_name']; ?></option>  
                                <?php
                                    }
                                ?>
                            </select>
                            <span class="fas fa-angle-down"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-label">Availability</div>
                            <select name="availability" required>
                                <option value="">-- Select Availability --</option>
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                            <span class="fas fa-angle-down"></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="add_food">Add</button>
                        </div>
                    </div>
                    
                    <div class="box-2">
                        <div class="upload-notice">Upload Food Image</div>
                        <div class="form-image"><img src="../assets/css/images/placeholder.png" alt="food-image" id="displayImg"/></div>
                        <div class="form-group-file">
                            <input type="file" name="image" placeholder="" required onchange="loadfile(event)">
                            <span class="fas fa-upload"></span>
                        </div>
                    </div>
                    </form>
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
<script type="text/javascript">
function loadfile(event){
    var output = document.getElementById('displayImg');
    output.src = URL.createObjectURL(event.target.files[0]);
}    
</script>
<script>
new WOW().init();
</script>
</html>