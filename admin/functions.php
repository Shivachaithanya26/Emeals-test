<?php
include_once('../includes/connection.php');

function get_total_sales(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM orders");
    $selected = mysqli_fetch_array($select);
    $total = 0;
    foreach($select as $selected){
        $total += $selected['quantity'] * $selected['price'];
    }
    echo "£ " . number_format($total, 2);
}


function get_total_orders(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM order_table");
    $selected = mysqli_num_rows($select);
    if($selected > 0){
    echo $selected . " Orders";
    }else{
    echo "0 Orders";
    }
}



function get_total_guest_users(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM guest_table");
    $num = mysqli_num_rows($select);
    echo $num . " Users";
}


function get_total_food(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM food_table");
    $num = mysqli_num_rows($select);
    echo $num . " Foods";
}



function get_total_vat(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM orders");
    $selected = mysqli_fetch_array($select);
    $sub_total = 0;
    $vat = 0;
    foreach($select as $selected){
        $sub_total += $selected['price'] * $selected['quantity'];
    }
    $vat = $sub_total * 0.075;
    echo "£ " . number_format($vat, 2);
}


function get_new_orders(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM order_table WHERE status = 'pending'");
    $selected = mysqli_num_rows($select);
    if($selected > 0){
    echo $selected . " Order(s)";
    }else{
    echo "0 Order(s)";
    }
}



function get_daily_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM orders WHERE DATE(time) = DATE(NOW())");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    foreach($select as $selected){
        $total += $selected['quantity'] * $selected['price'];
    }
    echo "£ " . number_format($total, 2);
}



function get_weekly_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM orders WHERE time >= DATE(NOW()) - INTERVAL 7 DAY");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    foreach($select as $selected){
        $total += $selected['quantity'] * $selected['price'];
    }
    echo "£ " . number_format($total, 2);
}



function get_monthly_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM orders WHERE MONTH(time) = MONTH(NOW())");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    foreach($select as $selected){
        $total += $selected['quantity'] * $selected['price'];
    }
    echo "£ " . number_format($total, 2);
}



function get_yearly_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM orders WHERE YEAR(time) = YEAR(NOW())");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    foreach($select as $selected){
        $total += $selected['quantity'] * $selected['price'];
    }
    echo "£ " . number_format($total, 2);
}




function get_daily_orders(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM order_table WHERE DATE(time) = DATE(NOW())");
    $selected = mysqli_num_rows($select);
    if($selected > 0){
    echo $selected . " Order(s)";
    }else{
    echo "0 Order(s)";
    }
}




function get_weekly_orders(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM order_table WHERE time >= DATE(NOW()) - INTERVAL 7 DAY");
    $selected = mysqli_num_rows($select);
    if($selected > 0){
    echo $selected . " Order(s)";
    }else{
    echo "0 Order(s)";
    }
}



function get_monthly_orders(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM order_table WHERE MONTH(time) = MONTH(NOW())");
    $selected = mysqli_num_rows($select);
    if($selected > 0){
    echo $selected . " Order(s)";
    }else{
    echo "0 Order(s)";
    }
}



function get_yearly_orders(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM order_table WHERE YEAR(time) = YEAR(NOW())");
    $selected = mysqli_num_rows($select);
    if($selected > 0){
    echo $selected . " Order(s)";
    }else{
    echo "0 Order(s)";
    }
}



function delete_food(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_food')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
            
            $selected = mysqli_num_rows($select);
            
            if($selected == 1){
                mysqli_query($db, "DELETE FROM food_table WHERE id = '$id'");
                mysqli_query($db, "DELETE FROM trending WHERE id = '$id'");
                $_SESSION['msg'] = "<div class='success'>Food has been successfully deleted!</div>";
                header('Location:food.php');
            }
        }
    }
}


function delete_category(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_category')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM categories_table WHERE id = '$id'");
            
            $selected = mysqli_num_rows($select);
            
            if($selected == 1){
                mysqli_query($db, "DELETE FROM categories_table WHERE id = '$id'");
                $_SESSION['msg'] = "<div class='success'>Category has been successfully deleted!</div>";
                header('Location:add_food_category.php');
            }
        }
    }
}




function delete_order(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_order')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM order_table WHERE id = '$id'");
            $selected = mysqli_fetch_array($select);
            $order_id = $selected['order_id'];
            $num = mysqli_num_rows($select);
            
            if($num == 1){
                mysqli_query($db, "DELETE FROM order_table WHERE id = '$id'");
                mysqli_query($db, "DELETE FROM orders WHERE order_id = '$order_id'");
                $_SESSION['msg'] = "<div class='success'>Order has been successfully deleted!</div>";
                header('Location:order.php');
            }
        }
    }
}


function delete_user(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_user')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM guest_table WHERE id = '$id'");
            //$selected = mysqli_fetch_array($select);
            //$order_id = $selected['order_id'];
            $num = mysqli_num_rows($select);
            
            if($num == 1){
                mysqli_query($db, "DELETE FROM guest_table WHERE id = '$id'");
                $_SESSION['msg'] = "<div class='success'>User has been successfully deleted!</div>";
                header('Location:users.php');
            }
        }
    }
}





function delete_admin(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_admin')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM admin_users WHERE id = '$id'");
            //$selected = mysqli_fetch_array($select);
            //$order_id = $selected['order_id'];
            $num = mysqli_num_rows($select);
            
            if($num == 1){
                mysqli_query($db, "DELETE FROM admin_users WHERE id = '$id'");
                $_SESSION['msg'] = "<div class='success'>User has been successfully deleted!</div>";
                header('Location:settings.php');
            }
        }
    }
}


function delete_review(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_review')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM review_table WHERE id = '$id'");
            //$selected = mysqli_fetch_array($select);
            //$order_id = $selected['order_id'];
            $num = mysqli_num_rows($select);
            
            if($num == 1){
                mysqli_query($db, "DELETE FROM review_table WHERE id = '$id'");
                $_SESSION['msg'] = "<div class='success'>User review has been successfully deleted!</div>";
                header('Location:review.php');
            }
        }
    }
}



function delete_feedback(){
    global $db;
    if(isset($_GET['action']) && ($_GET['action'] == 'delete_feedback')){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $select = mysqli_query($db, "SELECT * FROM feedback_table WHERE id = '$id'");
            //$selected = mysqli_fetch_array($select);
            //$order_id = $selected['order_id'];
            $num = mysqli_num_rows($select);
            
            if($num == 1){
                mysqli_query($db, "DELETE FROM feedback_table WHERE id = '$id'");
                $_SESSION['msg'] = "<div class='success'>User feedback has been successfully deleted!</div>";
                header('Location:feedback.php');
            }
        }
    }
}

?>