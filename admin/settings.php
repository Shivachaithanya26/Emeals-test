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
                        <li class='menu-list-btn'><a href="settings.php" class="active">Users Table</a></li>
                        <li class='menu-list-btn'><a href="add_user.php">Add User</a></li>
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
                <a href="index.php" class="back-btn">Back to home</a>
                <div class="box-content-heading">All Admin</div>
                
                <!--
                    <div class="danger">Successful!</div>
                -->
                
                    <?php
                            if(!empty($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                    ?>
                
                <div class="admin-order-container">
                    <table>
                        <tr>
                            <th>#ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Integrity</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete Order</th>
                        </tr>
                        
                        <?php
                        
                            if(isset($_GET['page']) && $_GET['page'] != ""){
                                $page = $_GET['page'];
                             }else{
                                $page = 1;
                             }
                             $results_per_page = 5;
                             $pick = mysqli_query($db, "SELECT * FROM admin_users");
                             $total_results = mysqli_num_rows($pick);
                             $total_page_num = ceil($total_results/$results_per_page);
                             $offset = ($page - 1) * $results_per_page;

                            $select = mysqli_query($db, "SELECT * FROM admin_users LIMIT $offset, $results_per_page");
                            $num = mysqli_num_rows($select);
                        
                            $num = mysqli_num_rows($select);
                        
                            if($num > 0){
                                $selected = mysqli_fetch_array($select);
                                foreach($select as $selected){
                                $username = $selected['username'];
                                $email = $selected['email'];
                                $integrity = $selected['integrity'];
                                $created_at = date('d-m-Y | h:i A', strtotime($selected['created_at']));
                                $id = $selected['id'];
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $email; ?></td>
                            <td>
                                <?php 
                                    if($integrity == 1){
                                    echo "Admin";
                                    }else{
                                    echo "Staff";
                                    }
                                ?>
                            </td>
                            <td><?php echo $created_at; ?></td>
                            <td><a href="edit_user.php?id=<?php echo $id; ?>" class="far fa-edit"></a></td>
                            <td><a href="delete.php?action=delete_admin&id=<?php echo $id; ?>" class="fas fa-trash" onclick="return confirm('Are you sure about this action?')"></a></td>
                        </tr>
                        <?php
                                }
                            }else{
                        ?>
                        <tr>
                            <td colspan="7"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
                
                <div class="pagination">
                    <ul>
                        <?php include_once('includes/settings_table_pagination.php'); ?>
                    </ul>
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