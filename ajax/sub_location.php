<?php
include ("../inc/conn.php");


 $location_id =   $_POST['location_data'];

 $sql = "SELECT sub_location_id,sub_location_name FROM sub_location WHERE location_id = $location_id";

 $result = mysqli_query($conn, $sql);
 $output = '<option value="">Select sub location</option>';
 while ($row = mysqli_fetch_assoc($result)) {
     $output .= '<option value="' . $row['sub_location_name'] . '">' . $row['sub_location_name'] . '</option>';
 }
 echo $output;


?>