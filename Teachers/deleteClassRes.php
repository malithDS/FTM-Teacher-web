<?php
include ('function.php');
include "../inc/conn.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $id = $_GET['ftm_sub_class_res_id'];

    $sql = "delete from `ftm_sub_class_res` where ftm_sub_class_res_id = $id";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        header("location: classResources.php");
    }
}



?>