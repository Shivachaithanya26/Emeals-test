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
    header('location:add_food.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Admin/Food</title>
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
                        <span class="fas fa-user-alt"></span> <span>Signed in as</span> <?php echo $user; ?>
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
                        <li class='menu-list-btn'><a href="food.php">Food Details</a></li>
                        <li class='menu-list-btn'><a href="edit_food.php" class="active">Edit Food</a></li>
                        <li class='menu-list-btn'><a href="add_food_category.php">Food Categories</a></li>
                    </ul>
                </div>
            </div>

            
            <div class="admin-content-box">
                <a href="food.php" class="back-btn">Back to Home</a>
                <div class="box-content-heading">Edit Food</div>
                
                <?php include_once('includes/edit_existing_food.php'); ?>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
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
                
                    if(!empty($err)){
                        echo $err;
                    }
                ?>
                
                
                <?php        
                
                    if(isset($_GET['id'])){
                    $id = $_GET['id'];
                        
                    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
                    $selected = mysqli_fetch_assoc($select);
                    
                    $name = $selected['name'];
                    $image = $selected['image'];
                    $price = $selected['price'];
                    $description = $selected['description'];
                    $category = $selected['category'];
                    $status = $selected['status'];
                    
                ?>
                    
                
                <div class="edit-food-form-container">
                    <div class="flex-form-container">
                        <div class="box-1">
                            <form method="post" action="">
                                <div class="form-group-2">
                                    <div class="form-label">Name</div>
                                    <input type="text" name="name" value="<?php echo $name; ?>" required class="form-input">
                                    <span class="fas fa-hamburger"></span>
                                </div>
                                
                                <div class="form-group-2">
                                    <button type="submit" name="update_name">Edit Food</button>
                                </div>
                            </form>
                            
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-label">Image</div>
                                <div class="form-image"><img src="../assets/css/images/<?php echo $image; ?>" alt="food-image" id="displayImg"/></div>
                                <div class="form-group-file-2">
                                    <input type="file" name="image" value="<?php echo $image; ?>" required onchange="loadfile(event)">
                                    <span class="fas fa-upload"></span>
                                </div>
                                <div class="form-group-2">
                                    <button type="submit" name="update_image">Change Image</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="box-2">
                            <form method="post" action="">
                                <div class="form-group-2">
                                    <div class="form-label">Price in Pounds (£)</div>
                                    <input type="text" name="price" value="<?php echo $price; ?>" required class="form-input">
                                    <span class="fas fa-donate"></span>
                                </div>
                                
                                <div class="form-group-2">
                                    <button type="submit" name="update_price">Edit Price</button>
                                </div>
                            </form>
                            
                            <form method="post" action="">
                                <div class="form-group-2">
                                    <div class="form-label">Description</div>
                                    <textarea name="description" required class="form-textarea"><?php echo $description; ?></textarea>
                                </div>
                                
                                <div class="form-group-2">
                                    <button type="submit" name="update_description">Edit Description</button>
                                </div>
                            </form>
                            
                            <form method="post" action="">
                                <div class="form-group-2">
                                    <div class="form-label">Category</div>
                                    <select name="category" required style="text-transform:capitalize;" class="form-select">
                                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
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
                                
                                <div class="form-group-2">
                                    <button type="submit" name="update_category">Change Category</button>
                                </div>
                            </form>
                            
                            <form method="post" action="">
                                <div class="form-group-2">
                                    <div class="form-label">Status</div>
                                    <select name="availability" required style="text-transform:capitalize;" class="form-select">
                                    <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                    <option value="available">Available</option>
                                    <option value="unavailable">Unavailable</option>
                                    </select>
                                    <span class="fas fa-angle-down"></span>
                                </div>
                                
                                <div class="form-group-2">
                                    <button type="submit" name="update_status">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                
                <?php    
                    }
                ?>
                
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