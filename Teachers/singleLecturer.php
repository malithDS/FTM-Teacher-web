<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

include ('function.php');
include "../inc/conn.php";


if($_SERVER['REQUEST_METHOD'] == 'GET'){
  $lecturer_id = $_GET['lecturer_id'];
    $app_id =  $_GET['app_id'];
    $verify =  $_GET['verify'];

    getCountLecAcademyListById($lecturer_id);
    getLecturerById($app_id,$lecturer_id,$verify);
    getHighlightsByLecId($lecturer_id);
    getLecAcademyListById($lecturer_id);
    getWorkingExpListById($lecturer_id);
    getLecNotification();
    getCountLecNotificationById();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Screen</title>
</head>
<body>
  
  <ul>
    <li><a href="">Home</a></li>
    <li><a href="">Payment History</a></li>
    <li><a href="aboutUs.php">About Us</a></li>
    <li><a href="">Contact Us</a></li>
    <li><a href="">Share App</a></li>
  </ul>
</body>
</html>