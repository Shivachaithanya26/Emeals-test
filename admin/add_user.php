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
                <div class="box-content-heading">Add New Admin</div>
                
                <?php
                
                    $username = '';
                    $email = '';
                    $password = '';
                    $cpassword = '';
                    $message = '';
                    $integrity = '';
                    $emailErr = '';
                    $passErr = '';
                    
                    if(isset($_POST['add_user'])){
                        $username = mysqli_real_escape_string($db, $_POST['username']);
                        $email = mysqli_real_escape_string($db, $_POST['email']);
                        $password = mysqli_real_escape_string($db, md5($_POST['password']));
                        $cpassword = mysqli_real_escape_string($db, md5($_POST['cpassword']));
                        $integrity = mysqli_real_escape_string($db, $_POST['integrity']);
                        
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $emailErr = "<div class='danger' style='text-align:left;'>E-mail is invalid</div>";
                        }
                    if($password != $cpassword){
                        $passErr = "<div class='danger' style='text-align:left;'>Passwords do not match!</div>";
                    }

                    $select = mysqli_query($db, "SELECT * FROM admin_users WHERE email = '$email' ||  username = '$username' LIMIT 1");
    
                    $num = mysqli_num_rows($select);

                    if($num != 1 && !$emailErr && !$passErr){
                        mysqli_query($db, "INSERT INTO admin_users(username, email, password, integrity)VALUES('$username', '$email', '$password', '$integrity')");
                        $message = "<div class='success' style='text-align:left;'>User Added Successfully!</div>";
                    }elseif($num == 1 && !$emailErr && !$passErr){
                        $message = "<div class='danger' style='text-align:left;'>Sorry, this user already exists!</div>";
                        }
                    }
                
                ?>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                <?php
                    if(!empty($emailErr)){ echo $emailErr; }
                    if(!empty($passErr)){ echo $passErr; }
                    if(!empty($message)){ echo $message; }
                ?>
                
                <div class="add-food-form-container">
                    <form method="post" action="">
                        <div class="box-1">
                        
                        <div class="form-group">
                            <div class="form-label">Username</div>
                            <input type="text" name="username" placeholder="" required>
                            <span class="fas fa-user"></span>
                        </div>
                            
                        <div class="form-group">
                            <div class="form-label">Email</div>
                            <input type="email" name="email" placeholder="" required>
                            <span class="fas fa-envelope"></span>
                        </div>

                        <div class="form-group">
                            <div class="form-label">Password</div>
                            <input type="password" name="password" placeholder="" required>
                            <span class="fas fa-key"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-label">Confirm Password</div>
                            <input type="password" name="cpassword" placeholder="" required>
                            <span class="fas fa-lock"></span>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-label">User Integrity</div>
                            <select name="integrity" required>
                                <option value="">-- Select Integrity --</option>
                                <option value="1">Admin</option>
                                <option value="0">User</option>
                            </select>
                            <span class="fas fa-angle-down"></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="add_user">Add User</button>
                        </div>
                    </div>
                    
                    <div class="box-2">
                        
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