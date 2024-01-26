<?php
/*
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");
*/
include ('function.php');
include "../inc/conn.php";


displayClassRes();  
  
        // $mess= [
        //     'resultStatus'=>"SUCCESS", 
        //     'httpStatus'=>"OK",
        //     'httpCode'=>  "200", 
        //     'msg'=>"Location found", 
        //     'data'=>null, 
        //     'status'=>"1"        
        // ];
        // header("HTTP/1.0 200 Location found successfully");
        // echo json_encode($mess);

        // $data= [
        //     'data'=> $res    
        // ];
        // echo json_encode($data);
/*
    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"NOT FOUND",
            'httpCode'=>  "404", 
            'msg'=>"No lecturer details found", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 404 Not found");
        echo json_encode($mess);
    }*/

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>class resources</title>
</head>
<body>
  
 

  <a href="./insertClassRes.php"><i class="fa fa-plus" aria-hidden="true"></i></a>
  
  
</body>
</html>