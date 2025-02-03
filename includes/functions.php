<?php

function cart_num_display(){
    global $db;
    if(!empty($_SESSION['cart'])){
        $total = 0;
        $total_quantity = 0;
        foreach($_SESSION['cart'] as $keys => $value){
        $total = $total + ($value['quantity'] * $value['price']);
        $total_quantity = $total_quantity + ($value['quantity']);
        }
    }
    if(!empty($total_quantity)){
        echo $total_quantity;
    }else{
        echo 0;
    }
}



function username_display(){
    global $db;
    if(isset($_SESSION['email'])){
        $user_email = $_SESSION['email'];
        $select = mysqli_query($db, "SELECT * FROM guest_table WHERE email = '$user_email'");
        $selected = mysqli_fetch_array($select);
         
        $selected['username'];
        echo "<li style='text-transform:capitalize'><a class='links' id='active' href='profile.php'><i class='fas fa-user'></i> {$selected['username']}</a></li>";
    }
}


function display_logout_link(){
    global $db;
    if(isset($_SESSION['email'])){
        echo "<li><a href='logout.php' class='links'>Logout <i class='fas fa-sign-out-alt'></i></a></li>";
    }
}








function return_back_to_cart(){
    global $db;
    
    if(empty($_SESSION['cart'])){
        $_SESSION['emptyCartErr'] = '<div class="danger">Cart is empty!</div>';
        header('Location:cart.php');
    }
    if(!empty($_SESSION['cart']) && !isset($_SESSION['email'])){
        $_SESSION['acctErr'] = '<div class="danger">Please sign in first or sign up as a new user!</div>';
        header('Location:account.php');
    }else{
        if(!empty($_SESSION['cart']) && isset($_SESSION['email'])){
            $_SESSION['acctErr'] = '';
        }
    }
}


function cancel_order(){
    global $db;
    if((isset($_GET['action']) && $_GET['action'] == 'cancel')  && isset($_SESSION['cart'])){
        unset($_SESSION['cart']);
        $_SESSION['quantity'] = 0;
        $total = 0;
        $_SESSION['error'] = '<div class="danger">All products have been removed from cart!</div>';
        header('location:cart.php');
    }
}



function delete_order(){
    global $db;
    if((isset($_GET['action']) && $_GET['action'] == 'del')){
        if(isset($_GET['id'])){
        $order_id = $_GET['id'];
        }
        
        $select = mysqli_query($db, "SELECT * FROM order_table WHERE order_id = '$order_id'");
        $num = mysqli_num_rows($select);
        
        if($num > 0){
            mysqli_query($db, "UPDATE order_table SET status = 'cancelled' WHERE order_id = '$order_id'");
            $_SESSION['msg'] = '<div class="success">Order has been cancelled and will be deleted soon!</div>';
            header('location:profile.php');
        }
    }
}


?>