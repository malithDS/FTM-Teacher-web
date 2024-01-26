<?php
include("../inc/conn.php");
include './student_function.php';

    $id = array();
    $id = $_POST["id"];
    
    
    $deactive = "UPDATE nova_student_notification SET status=0 where nova_student_notification_id= '$id' ";
    
    $result = mysqli_query($conn,$deactive);
    echo mysqli_error($conn);


?>