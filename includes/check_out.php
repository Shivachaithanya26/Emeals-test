<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/connection.php');

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure PHPMailer is installed via Composer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['checkout'])) {
    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $order_notes = mysqli_real_escape_string($db, $_POST['order_notes']);
    $status = "pending";
    $order_id = substr(str_shuffle("0123456789"), 0, 6);
    $u_email = $_SESSION['email'] ?? '';

    $run = mysqli_query($db, "SELECT username FROM guest_table WHERE email='$u_email'");
    $ran = mysqli_fetch_assoc($run);
    $username = $ran['username'] ?? 'Guest';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('<div class="danger">Please enter a valid email!</div>');
    }

    $insert_order = mysqli_query($db, "INSERT INTO order_table(order_id, fname, lname, email, phone, address, state, status, username, special_notes) 
                                       VALUES('$order_id', '$fname', '$lname', '$email', '$phone', '$address', '$state', '$status', '$username', '$order_notes')");
    if (!$insert_order) {
        die("Order Insertion Failed: " . mysqli_error($db));
    }

    // Send confirmation email
    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yourdomain.com'; // Change this to your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Your email
        $mail->Password = 'your-email-password'; // Your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your-email@example.com', 'Emeals');
        $mail->addAddress($email);
        $mail->Subject = "Order Confirmation";
        $mail->Body = "Thank you for your order! Your order ID is: " . $order_id;

        if (!$mail->send()) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        die("PHPMailer Exception: " . $mail->ErrorInfo);
    }

    $_SESSION['order_success'] = '<div class="success">Your order has been received!</div>';
    header('location:cart.php');
    exit();
}
?>
