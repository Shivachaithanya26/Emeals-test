<?php
$name = "";
$price = "";
$image = "";
$description = "";
$category = "";
$availability = "";
$imageSizeErr = "";
$imageTypeErr = "";
$err = "";
$message = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}


if(isset($_POST['update_name'])){
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id' && name = '$name' LIMIT 1");
    $num = mysqli_num_rows($select);
    
    if($num == 1){
        $message = "<div class='danger'>Oops! This food already exists!</div>";
    }else{
        mysqli_query($db, "UPDATE food_table SET name = '$name' WHERE id = '$id'");
        
        mysqli_query($db, "UPDATE trending SET name = '$name' WHERE id = '$id'");
        
        $message = "<div class='success'>Food has been updated successfully!</div>";
    }
}



if(isset($_POST['update_image'])){
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_dir = $_FILES['image']['tmp_name'];
    $image_type = pathinfo($image, PATHINFO_EXTENSION);
    $image_loc = "../assets/css/images/" .$image;
    
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
    
    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
    $num = mysqli_num_rows($select);
    
    if($num == 1 && !$imageSizeErr && !$imageTypeErr){
        move_uploaded_file($image_dir, $image_loc);
        mysqli_query($db, "UPDATE food_table SET image = '$image' WHERE id = '$id'");
        $message = "<div class='success'>Image has been updated successfully!</div>";
    }
}



if(isset($_POST['update_price'])){
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
    $num = mysqli_num_rows($select);
    $selected = mysqli_fetch_assoc($select);
    
    if($price == $selected['price']){
        $err = "<div class='danger'>No Changes Made!</div>";
    }
    
    if($num == 1 && $err){
        $message = "";
    }else{
    if($num == 1 && !$err){
        mysqli_query($db, "UPDATE food_table SET price = '$price' WHERE id = '$id'");
        $message = "<div class='success'>Price has been updated successfully!</div>";
        }
    }
}





if(isset($_POST['update_description'])){
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
    $num = mysqli_num_rows($select);
    $selected = mysqli_fetch_assoc($select);
    
    if($description == $selected['description']){
        $err = "<div class='danger'>No changes made!</div>";
    }
    
    if($num == 1 && $err){
        $message = "";
    }else{
    if($num == 1 && !$err){
        mysqli_query($db, "UPDATE food_table SET description = '$description' WHERE id = '$id'");
        $message = "<div class='success'>Description has been updated successfully!</div>";
        }
    }
}




if(isset($_POST['update_category'])){
    $category = mysqli_real_escape_string($db, $_POST['category']);
    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
    $num = mysqli_num_rows($select);
    $selected = mysqli_fetch_assoc($select);
    
    if($category == $selected['category']){
        $err = "<div class='danger'>No changes made!</div>";
    }
    
    if($num == 1 && $err){
        $message = "";
    }else{
    if($num == 1 && !$err){
        mysqli_query($db, "UPDATE food_table SET category = '$category' WHERE id = '$id'");
        $message = "<div class='success'>Category has been updated successfully!</div>";
        }
    }
}




if(isset($_POST['update_status'])){
    $availability = mysqli_real_escape_string($db, $_POST['availability']);
    $select = mysqli_query($db, "SELECT * FROM food_table WHERE id = '$id'");
    $num = mysqli_num_rows($select);
    $selected = mysqli_fetch_assoc($select);
    
    if($availability == $selected['status']){
        $err = "<div class='danger'>No changes made!</div>";
    }
    
    if($num == 1 && $err){
        $message = "";
    }else{
    if($num == 1 && !$err){
        mysqli_query($db, "UPDATE food_table SET status = '$availability' WHERE id = '$id'");
        $message = "<div class='success'>Status has been updated successfully!</div>";
        }
    }
}


?>