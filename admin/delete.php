<?php
include_once('../includes/connections.php');
session_start();

include_once('functions.php');


delete_food();

delete_category();

delete_order();

delete_user();

delete_admin();

delete_review();

delete_feedback();


?>