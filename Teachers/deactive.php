<?php
include("../inc/conn.php");

    $id = array();
    $id = $_POST["id"];
    
    
    $deactive = "UPDATE ftm_lec_notification SET status=0 where lec_notification_id= '$id' ";
    
    $result = mysqli_query($conn,$deactive);
    echo mysqli_error($conn);

    
?>