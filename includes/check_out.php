<?php

$order_id = "";
$fname = "";
$lname = "";
$address = "";
$state = "";
$email = "";
$phone = "";
$order_notes = "None";
$food_id = "";
$username = "";
$price = "";
$quantity = "";
$rand = "0123456789";
$rand_shuffle = str_shuffle($rand);
$time = 4;
$trend = 0;

if(isset($_POST['checkout'])){
    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $order_notes = mysqli_real_escape_string($db, $_POST['order_notes']);
    $status = "pending";
    $order_id = substr($rand_shuffle, 0, 6);
    $u_email = $_SESSION['email'];
    $run = mysqli_query($db, "SELECT * FROM guest_table WHERE email='$u_email'");
    $ran = mysqli_fetch_assoc($run);
    $username = $ran['username'];
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = '<div class="danger">Please enter a valid mail!</div>';
    }
    
    
    if(!$emailErr){
    mysqli_query($db, "INSERT INTO order_table(order_id, fname, lname, email, phone, address, state, status, username, special_notes)VALUES('$order_id', '$fname', '$lname', '$email', '$phone', '$address', '$state', '$status', '$username', '$order_notes')");

    $decision = mysqli_query($db, "SELECT * from order_table WHERE status = 0");
    $num = mysqli_num_rows($decision);
    
        
    if(!empty($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $keys => $value){
            $id = $value['id'];
            $price = $value['price'];
            $quantity = $value['quantity'];
            $spice_level = $value['spice_level'];    
    
    $get = mysqli_query($db, "SELECT * FROM trending WHERE id = '$id'");
    $gotten = mysqli_fetch_array($get);
    
    foreach($get as $gotten){
    $trend = $quantity + $gotten['trend'];
    }    
            
            
    /* This is for the guest  email content */
    $host = 'localhost';
    $port = 25;
    $username = 'emeals@jeroxng.com'; // your email address
    $email_password = "Youaregreat@1"; // your email address password
            
    $from = 'emeals@jeroxng.com'; 
    $to = $email;
    $subject = "Message from Emeals";
    $sub = 'New order notification';
    $email_message = "One new order, your order id is " . $order_id . " visit emeals.jeroxng.com/profile.php to view order details" ;
    $headers = array ('From' => $from, 'To' => $to, 'Subject' => $sub); // the email headers
    $body = "From: $from\nSubject: $subject\nHeading: $sub\nMessage: $email_message";
    $smtp = Mail::factory('smtp', array ('host' =>'localhost', 'auth' => true, 'username' => $username, 'password' => $email_password, 'port' => $port)); // SMTP protocol with the username and password of an existing email account in your hosting account
    $mail = $smtp->send($to, $headers, $body); // sending the email
                    
            
            
    /* This is for the guest  email content */
    $owner_subject = "New Order Notification";
    $owner_email_message = "One new order, visit your admin dashboard to view order details!";
    $owner_from = 'emeals@jeroxng.com';
    $owner_to = "emeals@jeroxng.com";
    $owner_sub = 'Order Notification from Emeals Website';
    $owner_headers = array ('From' => $owner_from, 'To' => $owner_to, 'Subject' => $owner_sub); // the email headers
    $owner_body = "From: $owner_from\nSubject: $owner_subject\nHeading: $owner_sub\nMessage: $owner_email_message";
    $owner_smtp = Mail::factory('smtp', array ('host' =>'localhost', 'auth' => true, 'username' => $username, 'password' => $email_password, 'port' => $port)); // SMTP protocol with the username and password of an existing email account in your hosting account
    
    $user_mail = $owner_smtp->send($owner_to, $owner_headers, $owner_body); // sending the email        
    
            
    
    mysqli_query($db, "UPDATE trending SET trend = '$trend' WHERE id = '$id'");
    
            
    mysqli_query($db, "INSERT INTO orders(order_id, food_id, price, quantity, spice)VALUES('$order_id', '$id', '$price', '$quantity', '$spice_level')");
    
    $_SESSION['order_success'] = '<div class="success">Your order has been received! Delivery Time: ' . $time * $num . 'mins</div>';
    unset($_SESSION['cart']);
    header('location:cart.php');
            }
        }
    }else{
        $message = "";
    }
}
?>