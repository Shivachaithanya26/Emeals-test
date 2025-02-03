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
                        <span class="fas fa-user-alt"></span> <span>Signed in as</span> <?php echo $user?>
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
                <a href="index.php" class="back-btn">Back to home</a>
                <div class="box-content-heading">All Orders</div>
                
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
                            <th>Name</th>
                            <th>Order Id</th>
                            <th>Order Status</th>
                            <th>Order Detials</th>
                            <th>Update Status</th>
                            <th>Delete Order</th>
                        </tr>
                        
                        <?php
                        
                            if(isset($_GET['page']) && $_GET['page'] != ""){
                                $page = $_GET['page'];
                             }else{
                                $page = 1;
                             }
                             $results_per_page = 6;
                             $pick = mysqli_query($db, "SELECT * FROM order_table");
                             $total_results = mysqli_num_rows($pick);
                             $total_page_num = ceil($total_results/$results_per_page);
                             $offset = ($page - 1) * $results_per_page;

                            $select = mysqli_query($db, "SELECT * FROM order_table LIMIT $offset, $results_per_page");
                            $num = mysqli_num_rows($select);
                        
                            $num = mysqli_num_rows($select);
                        
                            if($num > 0){
                                $selected = mysqli_fetch_array($select);
                                foreach($select as $selected){
                                $fullname = $selected['fname'] . " " . $selected['lname'];
                                $order_id = $selected['order_id'];
                                $status = $selected['status'];
                                $id = $selected['id'];
                        ?>
                        
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $fullname; ?></td>
                            <td><?php echo $order_id; ?></td>
                            <td style="text-transform:capitalize;"><?php echo $status; ?></td>
                            <td><a href="order_details.php?id=<?php echo $order_id; ?>" class="far fa-file"></a></td>
                            <td><a href="edit_order.php?id=<?php echo $id; ?>" class="far fa-edit"></a></td>
                            <td><a href="delete.php?action=delete_order&id=<?php echo $id; ?>" class="fas fa-trash" onclick="return confirm('Are you sure?')"></a></td>
                        </tr>
                        
                        <?php
                                }
                            }else{
                        ?>
                        
                        <tr>
                            <td></td>
                            <td><?php echo "No Records Available"; ?></td>
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
                        <?php include_once('includes/orders_table_pagination.php'); ?>
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