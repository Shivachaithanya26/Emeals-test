<?php
$name = "";
$price = "";
$image = "";
$description = "";
$category = "";
$availability = "";
$imageSizeErr = "";
$imageTypeErr = "";
$message = "";

if(isset($_POST['add_food'])){
$name = mysqli_real_escape_string($db, $_POST['name']);
$price = mysqli_real_escape_string($db, $_POST['price']);
$description = mysqli_real_escape_string($db, $_POST['description']);
$image = $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_dir = $_FILES['image']['tmp_name'];
$image_type = pathinfo($image, PATHINFO_EXTENSION);
$image_loc = "../assets/css/images/" .$image;
$category = mysqli_real_escape_string($db, $_POST['category']);
$availability = mysqli_real_escape_string($db, $_POST['availability']);
$trend = 0;

if($image_size > 1000024){
    $imageSizeErr = "<div class='danger'>Image msut be less than 1mb!</div>";
    //$_SESSION['imageSizeErr'] = $imageSizeErr;
    //header('location:food.php');
}
if($image_type != "jpeg" && $image_type != "jpg" && $image_type != "png"){
    $imageTypeErr = "<div class='danger'>File must be jpeg, jpg or png format!</div>";
    //$_SESSION['imageTypeErr'] = $imageTypeErr;
    //header('location:food.php');
}

$select = mysqli_query($db, "SELECT * FROM food_table WHERE name = '$name' LIMIT 1");
$num = mysqli_num_rows($select);

if($num != 1 && !$imageSizeErr && !$imageTypeErr){
    move_uploaded_file($image_dir, $image_loc);
    
    mysqli_query($db, "INSERT INTO food_table(name, price, image, description, category, status)VALUES('$name', '$price', '$image', '$description', '$category', '$availability')");
    
    mysqli_query($db, "INSERT INTO trending(name, trend)VALUES('$name', '$trend')");
    $message = "<div class='success'>Food Added Successfully!</div>";
    //header('location:food.php');
}elseif($num == 1 && !$imageSizeErr && !$imageTypeErr){
    $message = "<div class='danger'>Sorry, this food already exists!</div>";;
    //header('location:food.php');
}

}
?>