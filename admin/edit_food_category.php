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
    header('location:add_food_category.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Admin/Food Category</title>
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
                        <span class="fas fa-user-alt"></span> <span>Hello</span> <?php echo $user; ?>
                    </div>
                    
                    <div class="logout-box">
                        <a href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
                
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span>Dashboard</span> - Food Categories
                    </div>
                </div>
            </div>
            
            
            <div class="admin-content-box">
                <div class="admin-nav-bar">
                    <ul>
                        <li class='menu-list-btn'><a href="food.php">Food Details</a></li>
                        <li class='menu-list-btn'><a href="add_food.php">Add New Food</a></li>
                        <li class='menu-list-btn'><a href="add_food_category.php" class="active">Food Categories</a></li>
                    </ul>
                </div>
            </div>

            
            <div class="admin-content-box">
                <a href="food.php" class="back-btn">Back to Home</a>
                <div class="box-content-heading">Edit Food Category</div>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                
                <?php
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                    }
                    
                    $category = "";
                    $err = "";
                
                    if(isset($_POST['update_category'])){
                        $category = mysqli_real_escape_string($db, $_POST['category']);
                        $select = mysqli_query($db, "SELECT * FROM categories_table WHERE id = '$id'");
                        $num = mysqli_num_rows($select);
                        $selected = mysqli_fetch_assoc($select);

                        if($category == $selected['categories_name']){
                            $err = "<div class='danger'>No changes made!</div>";
                        }

                        if($num == 1 && $err){
                            $message = "";
                        }else{
                        if($num == 1 && !$err){
                            mysqli_query($db, "UPDATE categories_table SET categories_name = '$category' WHERE id = '$id'");
                            
                            mysqli_query($db, "UPDATE food_table SET category = '$category' WHERE category = '$category'");
                            
                            $message = "<div class='success'>Category has been updated successfully!</div>";
                            }
                        }
                    }
                ?>
                
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
                
                
                <div class="add-food-form-container">
                    <form method="post" action="">
                        <div class="box-1">
                        <?php
                            if(isset($_GET['id'])){
                                $id = $_GET['id'];
                            }
                            
                            $select = mysqli_query($db, "SELECT * FROM categories_table WHERE id = '$id'");
                            $selected = mysqli_fetch_assoc($select);
                            $num = mysqli_num_rows($select);
                            
                            if($selected){
                        ?>   
                         
                            <div class="form-group">
                                <div class="form-label">Category</div>
                                <input type="text" name="category" value="<?php echo $selected['categories_name']; ?>" required>
                                <span class="fas fa-list-ol"></span>
                            </div>
                                  
                        <?php
                            }
                        ?>
                            <div class="form-group">
                                <button type="submit" name="update_category">Edit</button>
                            </div>
                    </div>
                    
                    <div class="box-2">
                        <div class="upload-notice">Exisiting Categories</div>
                        <div class="categories-list">
                            <ul>
                                <?php
                                
                                    $select = mysqli_query($db, "SELECT * FROM categories_table");
                                    $num = mysqli_num_rows($select);
                                    $selected = mysqli_fetch_assoc($select);
                                    
                                    if($num > 1){
                                        foreach($select as $selected){
                                ?>
                                
                                <li><span style="text-transform: capitalize;"><?php echo $selected['categories_name'];?></span></li>
                                
                                <?php
                                        }
                                    }else{
                                ?>
                                
                                <li>No Categories Added</li>
                                
                                <?php
                                    }
                                ?>
                            </ul>
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
<script type="text/javascript">
function loadfile(event){
    var output = document.getElementById('displayImg');
    output.src = URL.createObjectURL(event.target.files[0]);
}    
</script>
</html>