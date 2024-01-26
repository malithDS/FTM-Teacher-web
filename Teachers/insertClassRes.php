<?php

include '../inc/conn.php';
include './function.php';

insertClassRes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Insert Class Resources</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./form_style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
 
         <div class="flex">
            <div class="inputBox">
               <span>Class ID </span>
               <input type="text" name="nova_sub_class_id" placeholder="enter class id" class="box"></br>
               <span>Title </span>
               <input type="text" name="title" placeholder="enter title" class="box"></br>
               <span>Description </span>
               <input type="text" name="description" placeholder="enter description" class="box"></br>
               <span>File </span>
               <input type="file" name="file" class="box" accept="file/pdf"></br>
               <span>Status </span>
               <input type="text" name="status" placeholder="enter status" class="box">
               
            </div>
         </div>

      <input type="submit" name="submit" value="Register now" class="login_btn">
   </form>

</div>

</body>
</html>