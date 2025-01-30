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
if($selected['integrity'] == 0){
    header('location:update.php');
}
if(!isset($_GET['id'])){
    header('location:settings.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Admin/Settings</title>
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
                        <li style="background-color:var(--active-color);">
                            <a href="settings.php" style="color:var(--bg-color); width: 100%;">
                                <i class="fas fa-cogs" style="color:var(--bg-color);"></i>
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
                        <span class="fas fa-user-alt"></span> <span>Signed in as</span> <?php echo $user?>
                    </div>
                    
                    <div class="logout-box">
                         <a href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
                
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span>Dashboard</span> - Settings
                    </div>
                </div>
            </div>

            
            
            <div class="admin-content-box">
                <div class="admin-nav-bar">
                    <ul>
                        <?php
                            $select = mysqli_query($db, "SELECT * FROM admin_users WHERE username = '$user'");
                            $selected = mysqli_fetch_assoc($select);
                        
                            if($selected['integrity'] == 1){
                        ?>
                        <li class='menu-list-btn'><a href="settings.php">Users Table</a></li>
                        <li class='menu-list-btn'><a href="add_user.php" class="active">Add User</a></li>
                        <li class='menu-list-btn'><a href="update.php" >Change Password</a></li>
                        <li class='menu-list-btn'><a href="#">About Page</a></li>
                        <?php
                            }else{
                        ?>
                        <li class='menu-list-btn'><a href="update.php">Change Password</a></li>            
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
            
            <div class="admin-content-box">
                <a href="settings.php" class="back-btn">Back to Home</a>
                <div class="box-content-heading">Update User's Integrity</div>
                
                <?php
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                    }
                    
                    $integrity = "";
                    $err = "";
                
                    if(isset($_POST['update_user'])){
                        $integrity = mysqli_real_escape_string($db, $_POST['integrity']);
                        $select = mysqli_query($db, "SELECT * FROM admin_users WHERE id = '$id'");
                        $num = mysqli_num_rows($select);
                        $selected = mysqli_fetch_assoc($select);

                        if($integrity == $selected['integrity']){
                            $err = "<div class='danger' style='text-align:left;'>No changes made!</div>";
                        }

                        if($num == 1 && $err){
                            $message = "";
                        }else{
                        if($num == 1 && !$err){
                            mysqli_query($db, "UPDATE admin_users SET integrity = '$integrity' WHERE id = '$id'");
                            
                            $message = "<div class='success' style='text-align:left;'>Status has been updated successfully!</div>";
                            }
                        }
                    }
                ?>
                
                        <?php
                            if(!empty($message)){
                                echo $message;
                            }

                            if(!empty($err)){
                                echo $err;
                            }
                        ?>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                
                <div class="add-food-form-container">
                    <form method="post" action="">
                        <div class="box-1">
                        
                     
                        <?php
                          if(isset($_GET['id'])){
                            $id = $_GET['id'];
                            $select = mysqli_query($db, "SELECT * FROM admin_users WHERE id = '$id'");
                            $num = mysqli_num_rows($select);
                            $selected = mysqli_fetch_assoc($select);
                        }  
                        ?>
                        <div class="form-group">
                            <div class="form-label">Username</div>
                            <input type="text" disabled placeholder="<?php echo $selected['username']; ?>">
                            <span class="fas fa-user"></span>
                        </div>
                            
                        <div class="form-group">
                            <div class="form-label">Email</div>
                            <input type="email" disabled placeholder="<?php echo $selected['email']; ?>">
                            <span class="fas fa-envelope"></span>
                        </div>
                            
                        <div class="form-group">
                            <div class="form-label">Change Integrity</div>
                            <select name="integrity" required>
                                <option value="">-- Select --</option>
                                <option value="1">Admin</option>
                                <option value="0">Staff</option>
                            </select>
                            <span class="fas fa-angle-down"></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="update_user">Update</button>
                        </div>
                    </div>
                    
                    <div class="box-2">
                        <div class="upload-notice">Current Status</div>
                        <div class="categories-list">
                            <ul>
                                <?php
                                    if(isset($_GET['id'])){
                                        $id = $_GET['id'];
                                    $select = mysqli_query($db, "SELECT * FROM admin_users WHERE id = '$id'");
                                    $selected = mysqli_fetch_assoc($select);
                                        if($selected){          
                                ?>
                                    <li style="text-transform:capitalize;">
                                        <span>
                                        <?php
                                            if($selected['integrity'] == 0){
                                                echo "Staff";
                                            }else{
                                                echo "Admin";
                                            }
                                        ?>
                                        </span>
                                    </li>
                                <?php
                                        }
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