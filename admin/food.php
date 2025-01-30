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
                        <li class='menu-list-btn'><a href="food.php" class="active">Food Details</a></li>
                        <li class='menu-list-btn'><a href="add_food.php">Add New Food</a></li>
                        <li class='menu-list-btn'><a href="add_food_category.php">Food Categories</a></li>
                    </ul>
                </div>
            </div>
            
            
            <div class="admin-content-box">
                <?php
                    if(!empty($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <div class="food-display-table">
                    <div id="table-heading">
                        <div class="serial-number">S/N</div>
                        <div class="food-image">Image</div>
                        <div class="food-name">Name</div>
                        <div class="food-price">Price</div>
                        <div class="action">Action</div>
                    </div>
                    
                    <?php
                        if(isset($_GET['page']) && $_GET['page'] != ""){
                            $page = $_GET['page'];
                         }else{
                            $page = 1;
                         }
                         $results_per_page = 4;
                         $pick = mysqli_query($db, "SELECT * FROM food_table");
                         $total_results = mysqli_num_rows($pick);
                         $total_page_num = ceil($total_results/$results_per_page);
                         $offset = ($page - 1) * $results_per_page;
                        
                        $select = mysqli_query($db, "SELECT * FROM food_table LIMIT $offset, $results_per_page");
                        $num = mysqli_num_rows($select);
                    
                        if($num > 0){
                        $selected = mysqli_fetch_assoc($select);
                        $id = 0; 
                        foreach($select as $selected){
                            $id += 1;
                            $image = $selected['image'];
                            $name = $selected['name'];
                            $price = $selected['price'];
                            $food_id = $selected['id'];
                    ?>
            
                    <div id="table-content">
                        <div class="serial-number"><?php echo $food_id; ?></div>
                        <div class="food-image"><img src="../assets/css/images/<?php echo $image; ?>"/></div>
                        <div class="food-name"><?php echo $name; ?></div>
                        <div class="food-price">£ <?php echo number_format($price, 2); ?></div>
                        <div class="action"><a href="edit_food.php?id=<?php echo $food_id; ?>" class="far fa-edit"></a> <a href="delete.php?action=delete_food&id=<?php echo $food_id;?>" class="fas fa-trash" onclick="return confirm('Are you sure you want to delete food?')"></a></div>
                    </div>
                    
                    <?php
                        }    
                    }else{
                    ?>
                    
                    <div id="table-content">
                        <div class="serial-number">No food has been added yet!</div>
                        <div class="food-image"></div>
                        <div class="food-name"></div>
                        <div class="food-price"></div>
                        <div class="action"></div>
                    </div>
                    
                    <?php
                        }
                    ?>
                    
                    
                </div>
                
                <div class="pagination">
                    <ul>
                        <?php include_once('food_table_pagination.php'); ?>
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
</html>