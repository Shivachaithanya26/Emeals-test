<?php
$host = 'localhost';
$user = 'root';
$password = '12345';
$database = 'emeals_db';

$db = mysqli_connect($host, $user, $password, $database);

if(!$db){
    die("Error, database connectivity failed!");
}
?>
