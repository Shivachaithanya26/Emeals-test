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
    header('Location:order.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>E-Meals - Admin/Orders</title>
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
                        <li style="background-color:var(--active-color);">
                            <a href="order.php" style="color:var(--bg-color); width: 100%;">
                                <i class="fas fa-cart-plus" style="color:var(--bg-color);"></i>
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
                         <a href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
                
                <div class="header-welcome-box">
                    <div class="name-box">
                        <span>Dashboard</span> - Order
                    </div>
                </div>
            </div>

            
            <div class="admin-content-box">
                <a href="order.php" class="back-btn">Order Table</a>
                <div class="box-content-heading">Confirm/Pend Order</div>
                
                <?php
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                    }
                    
                    $status = "";
                    $err = "";
                
                    if(isset($_POST['update_status'])){
                        $status = mysqli_real_escape_string($db, $_POST['status']);
                        $select = mysqli_query($db, "SELECT * FROM order_table WHERE id = '$id'");
                        $num = mysqli_num_rows($select);
                        $selected = mysqli_fetch_assoc($select);

                        if($status == $selected['status']){
                            $err = "<div class='danger'>No changes made!</div>";
                        }

                        if($num == 1 && $err){
                            $message = "";
                        }else{
                        if($num == 1 && !$err){
                            mysqli_query($db, "UPDATE order_table SET status = '$status' WHERE id = '$id'");
                            
                            $message = "<div class='success'>Status has been updated successfully!</div>";
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
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                
                <div class="add-food-form-container">
                    <form method="post" action="">
                        <div class="box-1">
                        
                        <div class="form-group">
                            <div class="form-label">Change Status</div>
                            <select name="status" required>
                                <option value="">-- Change Status --</option>
                                <option value="pending">Pend</option>
                                <option value="confirmed">Confirm</option>
                            </select>
                            <span class="fas fa-angle-down"></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="update_status">Update</button>
                        </div>
                    </div>
                    
                    <div class="box-2">
                        <div class="upload-notice">Current Status</div>
                        <div class="categories-list">
                            <ul>
                                <?php
                                    if(isset($_GET['id'])){
                                        $id = $_GET['id'];
                                    $select = mysqli_query($db, "SELECT * FROM order_table WHERE id = '$id'");
                                    $selected = mysqli_fetch_assoc($select);
                                        if($selected){          
                                ?>
                                    <li style="text-transform:capitalize;"><span><?php echo $selected['status'];?></span></li>
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