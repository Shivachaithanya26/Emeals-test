<?php
//Left Angle
if(isset($_GET['page']) && $_GET['page'] != 1){
    $prev_page = $_GET['page'] - 1;
    echo "<li><a href='profile.php?page={$prev_page}' class='fas fa-angle-left'></a></li>";
}

//Page Numbers
for($page = 1; $page <= $total_page_num; $page++){
    if($num > 0){
    echo "<li><a href='profile.php?page={$page}'>{$page}</a></li>";
    }
}


//Right Angle
if(isset($_GET['page']) && $_GET['page'] != $total_page_num){
    $next_page = $_GET['page'] + 1;
    echo "<li><a href='profile.php?page={$next_page}' class='fas fa-angle-right'></a></li>";
}
?>