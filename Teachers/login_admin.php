<?php /*
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

require '../inc/conn.php';


  session_start();
  if($_SERVER["REQUEST_METHOD"] == "POST") { 


    if(isset($_POST['username']) && ($_POST['password'])){

      function validate($info){
         $info = trim($info);
         $info = stripcslashes($info);
         $info = htmlspecialchars($info);
   
         return $info;
      }
         $username = validate($_POST['username']);
         $password = validate($_POST['password']); 
      if(empty($username)){
         return error422('Enter your username');
      }
      elseif(empty($password)){
         return error422('Enter your password');
      }
      else{
         $sql = "SELECT * FROM `ftm_lecturer` WHERE username = '$username' AND password = '$password'";
         $result = mysqli_query($conn, $sql);
         
         if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);

            getLecturerList();
            getLocationList();
            getSubLocationList();
            getCareerHighlightList();
            getLecAcademyList();
            getLecNotificationList();
            getWorkingExpList();
          
  

         }else{
           return error422('Check your username or password');
         }
      }
   }
  }

  
function getLecturerList(){

    global $conn;

    $query = "SELECT * FROM ftm_lecturer";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){

            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => "Lecturer List Fetched Successfully",
                'data' => $res
        
            ];
            header("HTTP/1.0 200 Lecturer List Fetched Successfully");
            echo json_encode($data);

        }else{
            $data = [
                'status' => 404,
                'message' => "No Lecturer Found",
        
            ];
            header("HTTP/1.0 404 No Lecturer Found");
            return json_encode($data);
        }

    }else{
        $data = [
            'status' => 500,
            'message' =>  "Internal Server Error",
    
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
};
function getLocationList(){

      global $conn;
  
      $query = "SELECT * FROM location";
      $result = mysqli_query($conn, $query);
  
      if($result){
          if(mysqli_num_rows($result)>0){
  
              $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
  
              $data = [
                  'status' => 200,
                  'message' => "Location List Fetched Successfully",
                  'data' => $res
          
              ];
              header("HTTP/1.0 200 Location List Fetched Successfully");
              echo json_encode($data);
  
          }else{
              $data = [
                  'status' => 404,
                  'message' => "No Location Found",
          
              ];
              header("HTTP/1.0 404 No Location Found");
              return json_encode($data);
          }
  
      }else{
          $data = [
              'status' => 500,
              'message' =>  "Internal Server Error",
      
          ];
          header("HTTP/1.0 500 Internal Server Error");
          return json_encode($data);
      }
};
function getSubLocationList(){

  global $conn;

  $query = "SELECT * FROM sub_location";
  $result = mysqli_query($conn, $query);

  if($result){
      if(mysqli_num_rows($result)>0){

          $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

          $data = [
              'status' => 200,
              'message' => "Sub location List Fetched Successfully",
              'data' => $res
      
          ];
          header("HTTP/1.0 200 Sub location List Fetched Successfully");
          echo json_encode($data);

      }else{
          $data = [
              'status' => 404,
              'message' => "No Sub location Found",
      
          ];
          header("HTTP/1.0 404 No Sub location Found");
          return json_encode($data);
      }

  }else{
      $data = [
          'status' => 500,
          'message' =>  "Internal Server Error",
  
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
  }
};
function getCareerHighlightList(){

  global $conn;

  $query = "SELECT * FROM ftm_career_highlight";
  $result = mysqli_query($conn, $query);

  if($result){
      if(mysqli_num_rows($result)>0){

          $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

          $data = [
              'status' => 200,
              'message' => "Career highlight List Fetched Successfully",
              'data' => $res
      
          ];
          header("HTTP/1.0 200 Career highlight List Fetched Successfully");
          echo json_encode($data);

      }else{
          $data = [
              'status' => 404,
              'message' => "No Career highlight Found",
      
          ];
          header("HTTP/1.0 404 No Career highlight Found");
          return json_encode($data);
      }

  }else{
      $data = [
          'status' => 500,
          'message' =>  "Internal Server Error",
  
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
  }
};
function getLecAcademyList(){

  global $conn;

  $query = "SELECT * FROM ftm_lec_academy";
  $result = mysqli_query($conn, $query);

  if($result){
      if(mysqli_num_rows($result)>0){

          $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

          $data = [
              'status' => 200,
              'message' => "Lec academy List Fetched Successfully",
              'data' => $res
      
          ];
          header("HTTP/1.0 200 Lec academy List Fetched Successfully");
          echo json_encode($data);

      }else{
          $data = [
              'status' => 404,
              'message' => "No Lec academy Found",
      
          ];
          header("HTTP/1.0 404 No Lec academy Found");
          return json_encode($data);
      }

  }else{
      $data = [
          'status' => 500,
          'message' =>  "Internal Server Error",
  
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
  }
};
function getLecNotificationList(){

  global $conn;

  $query = "SELECT * FROM ftm_lec_notification";
  $result = mysqli_query($conn, $query);

  if($result){
      if(mysqli_num_rows($result)>0){

          $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

          $data = [
              'status' => 200,
              'message' => "Lec Notification List Fetched Successfully",
              'data' => $res
      
          ];
          header("HTTP/1.0 200 Lec Notification List Fetched Successfully");
          echo json_encode($data);

      }else{
          $data = [
              'status' => 404,
              'message' => "No Lec Notification Found",
      
          ];
          header("HTTP/1.0 404 No Lec Notification Found");
          return json_encode($data);
      }

  }else{
      $data = [
          'status' => 500,
          'message' =>  "Internal Server Error",
  
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
  }
};
function getWorkingExpList(){

  global $conn;

  $query = "SELECT * FROM ftm_working_exp";
  $result = mysqli_query($conn, $query);

  if($result){
      if(mysqli_num_rows($result)>0){

          $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

          $data = [
              'status' => 200,
              'message' => "Working Experience List Fetched Successfully",
              'data' => $res
      
          ];
          header("HTTP/1.0 200 Working Experience List Fetched Successfully");
          echo json_encode($data);

      }else{
          $data = [
              'status' => 404,
              'message' => "No Working Experience Found",
      
          ];
          header("HTTP/1.0 404 No Working Experience Found");
          return json_encode($data);
      }

  }else{
      $data = [
          'status' => 500,
          'message' =>  "Internal Server Error",
  
      ];
      header("HTTP/1.0 500 Internal Server Error");
      return json_encode($data);
  }
};
*/
?> 