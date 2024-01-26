<?php

include '../inc/conn.php';

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,
        
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}


//response message -------
function responseMessage($resultStatus, $httpStatus, $httpCode, $msg, $data, $status) {
    // $resultStatus - SUCCESSFUL,FAILED
    // $httpStatus - OK, BAD_REQUEST, 
    // $httpCode - 200, 406- invalid request type,
    // $msg - message 
    // $data - json data
    // $status - status
        $mess= [
            "resultStatus" => $resultStatus, 
            "httpStatus" => $httpStatus, 
            "httpCode" => $httpCode, 
            "msg" => $msg, 
            "data" => $data, 
            "status" => $status
        ];
        echo json_encode($mess);
        exit();
    }
    
// login as a lecturer -------
function loginLecturer(){
    global $conn;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = $_POST['username'];
            $password = $_POST['password'];
            $check = $_POST['check'];
         
            if(empty(trim($username))){
                $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your username", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
            }
            elseif(empty(trim($password))){
                $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your password", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
            }else{
                $select = mysqli_query($conn, "SELECT lecturer_id FROM `ftm_lecturer` WHERE username = '$username' AND password = '$password'") or die('query failed');
         
                if(mysqli_num_rows($select) > 0){
                   $row = mysqli_fetch_assoc($select);
                   
                    if(empty($check)){
                        $mess = [
                            'resultStatus'=>"FAILED", 
                            'httpStatus'=>"UNAUTHORIZED",
                            'httpCode'=>  "401", 
                            'msg'=>"Please check our terms and conditions", 
                            'data'=>null, 
                            'status'=>"2"        
                        ];
                        header("HTTP/1.0 401 Unauthorized request");
                        echo json_encode($mess);
                    }else{
                            $app_id = "NovaTechZone_Teachers";
                            $lecturer_id = $row['lecturer_id'];
                            $verify = mobile_verification();
                            header("Location: singleLecturer.php?lecturer_id=$lecturer_id&app_id=$app_id&verify=$verify");
                    }
                   
                   /*$mess = [
                    'resultStatus'=>"SUCCESS", 
                    'httpStatus'=>"OK",
                    'httpCode'=>  "200", 
                    'msg'=>"Login success", 
                    'data'=>null, 
                    'status'=>"1"        
                   ];*/
                //header("HTTP/1.0 200 OK");
                //echo json_encode($mess);

                }else{
    
                    $mess = [
                        'resultStatus'=>"FAILED", 
                        'httpStatus'=>"UNAUTHORIZED",
                        'httpCode'=>  "401", 
                        'msg'=>"Invalid username or password", 
                        'data'=>null, 
                        'status'=>"2"        
                    ];
                    header("HTTP/1.0 401 Unauthorized request");
                    echo json_encode($mess);
                     
                }
            }
            
       }
};
//read lecturer details by lec id ---------
function getLecturerById($app_id,$lecturer_id,$verify){

    global $conn;
    $app_id = $app_id;
    $lecturer_id = $lecturer_id;
    $verify =$verify;

    $query = "SELECT username, name, nic, mobile_1, email,mobile_verification,profile_image FROM `ftm_lecturer` where lecturer_id='$lecturer_id'";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Lecturer details found", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Lecturer details fetched successfully");
            echo json_encode($mess);

            $data= [
                'data'=> $row    
            ];
            echo json_encode($data);

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
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};
//read Location by location id ----------
function getLocationById(){

    global $conn;
        
        $location_id = $_POST['location_id'];

        $query = "SELECT location FROM location where location_id = '$location_id'";
        $result = mysqli_query($conn, $query);

        if($result){
            if(mysqli_num_rows($result)>0){

                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $mess= [
                    'resultStatus'=>"SUCCESS", 
                    'httpStatus'=>"OK",
                    'httpCode'=>  "200", 
                    'msg'=>"Location found", 
                    'data'=>null, 
                    'status'=>"1"        
                ];
                header("HTTP/1.0 200 Location found successfully");
                echo json_encode($mess);
    
                $data= [
                    'data'=> $res    
                ];
                echo json_encode($data);

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
            }

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"INTERNAL SERVER ERROR",
                'httpCode'=>  "500", 
                'msg'=>"Internal server error", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 500 Internal server error");
            echo json_encode($mess);
        }       

};
//read career highlights by lec id --------
function getHighlightsByLecId($lecturer_id){

    global $conn;
    $lecturer_id = $lecturer_id;
    
    $query = "SELECT career_highlight_id, career FROM `ftm_career_highlight` where lecturer_id='$lecturer_id'";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Career highlight details found", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Career highlight details fetched successfully");
            echo json_encode($mess);

            $data= [
                'data'=> $row    
            ];
            echo json_encode($data);

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"NOT FOUND",
                'httpCode'=>  "404", 
                'msg'=>"No Career highlight details found", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($mess);
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};
//read lec academy details by lec id----------
function getLecAcademyListById($lecturer_id){

    global $conn;
    $lecturer_id = $lecturer_id;

    $query = "SELECT lecturer_id, academy FROM ftm_lec_academy where lecturer_id='$lecturer_id'";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){

            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Lecturer academy details found", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Lecturer academy details fetched successfully");
            echo json_encode($mess);

            $data= [
                'data'=> $res    
            ];
            echo json_encode($data);

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"NOT FOUND",
                'httpCode'=>  "404", 
                'msg'=>"No Lecturer academy details found", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($mess);
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};
//read working experience details-----------
function getWorkingExpListById($lecturer_id){

    global $conn;
    $lecturer_id = $lecturer_id;

    $query = "SELECT experience FROM ftm_working_exp where lecturer_id='$lecturer_id'";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){

            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Lecturer experience list found", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Lecturer experience list fetched successfully");
            echo json_encode($mess);

            $data= [
                'data'=> $res    
            ];
            echo json_encode($data);

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"NOT FOUND",
                'httpCode'=>  "404", 
                'msg'=>"No Lecturer experience found", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($mess);
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};
//count lec academy list by lec id-----------
function getCountLecAcademyListById($lecturer_id){

    global $conn;
    $lecturer_id = $lecturer_id;

    $query = "SELECT lecturer_id, academy FROM ftm_lec_academy where lecturer_id='$lecturer_id'";
    $result = mysqli_query($conn, $query);

    if($result){
        if($countLecAcedemy = mysqli_num_rows($result)){

            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Number of courses successfully counted", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Number of courses successfully counted");
            echo json_encode($mess);

            echo $countLecAcedemy;            

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"NOT FOUND",
                'httpCode'=>  "404", 
                'msg'=>"Cources not available ", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($mess);
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};
//read lec notification details by lecturer id----------
function getLecNotification(){

    global $conn;

    $query = "SELECT topic,notification FROM ftm_lec_notification";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){

            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Lecturer notification found", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Lecturer notification fetched successfully");
            echo json_encode($mess);

            $data= [
                'data'=> $res    
            ];
            echo json_encode($data);

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"NOT FOUND",
                'httpCode'=>  "404", 
                'msg'=>"No Lecturer notification found", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($mess);
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};
//count lec academy list by lec id-----------
function getCountLecNotificationById(){

    global $conn;

    $query = "SELECT topic, notification FROM ftm_lec_notification";
    $result = mysqli_query($conn, $query);

    if($result){
        if($countNotification = mysqli_num_rows($result)){

            $mess= [
                'resultStatus'=>"SUCCESS", 
                'httpStatus'=>"OK",
                'httpCode'=>  "200", 
                'msg'=>"Number of notifications successfully counted", 
                'data'=>null, 
                'status'=>"1"        
            ];
            header("HTTP/1.0 200 Number of notifications successfully counted");
            echo json_encode($mess);

            echo $countNotification;            

        }else{
            $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"NOT FOUND",
                'httpCode'=>  "404", 
                'msg'=>"notifications not available ", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 404 Not found");
            echo json_encode($mess);
        }

    }else{
        $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
    }
};


function getExLecnotification(){
    global $conn;
    
    $find_notifications = "Select * from ftm_lec_notification where status = 1";
    $result = mysqli_query($conn,$find_notifications);
    $count_active = '';
    $notifications_data = array(); 
    $deactive_notifications_dump = array();
     while($rows = mysqli_fetch_assoc($result)){
             $count_active = mysqli_num_rows($result);
             $notifications_data[] = array(
                         "lec_notification_id" => $rows['lec_notification_id'],
                         "topic"=>$rows['topic'],
                         "notification"=>$rows['notification']
             );
     }
     //only five specific posts
     $deactive_notifications = "Select * from ftm_lec_notification where status = 0 ORDER BY lec_notification_id DESC LIMIT 0,5";
     $result = mysqli_query($conn,$deactive_notifications);
     while($rows = mysqli_fetch_assoc($result)){
       $deactive_notifications_dump[] = array(
                   "lec_notification_id" => $rows['lec_notification_id'],
                   "topic"=>$rows['topic'],
                   "notification"=>$rows['notification']
       );
     }

}

//generate mobile verification ---------
function mobile_verification(){
    $randomNumber1 = rand(1000, 9999);

    return $randomNumber1;
};
//generate web verification -------
function web_verification(){
    
    $randomNumber2 = rand(1000, 9999);
    echo  $randomNumber2;
};

//current date ----------
function currentDate(){
    date_default_timezone_set('Asia/Colombo');
    $date = date('d/m/y');
    echo $date;
}
//current time ---------
function currentTime(){
    date_default_timezone_set('Asia/Colombo');
    $time = date('h:i:a');
    echo $time;
}



//read lecturer details ----------
/*
function getLecturerList(){

    global $conn;


    $query = "SELECT username,name,nic,mobile_1,email FROM ftm_lecturer";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            $data = [
                'status' => 200,
                'message' => "Lecturer List Fetched Successfully",
                'data' => $row
        
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
};*/
//create lecturer details ------------
function storeLecturer($lecturerInput){
    global $conn;

    $username = mysqli_real_escape_string($conn, $lecturerInput['username']);
    $notification_key = mysqli_real_escape_string($conn, $lecturerInput['notification_key']);
    $password = mysqli_real_escape_string($conn, $lecturerInput['password']);
    $name = mysqli_real_escape_string($conn, $lecturerInput['name']);
    $nic = mysqli_real_escape_string($conn, $lecturerInput['nic']);
    $mobile_1 = mysqli_real_escape_string($conn, $lecturerInput['mobile_1']);
    $mobile_2 = mysqli_real_escape_string($conn, $lecturerInput['mobile_2']);
    $email = mysqli_real_escape_string($conn, $lecturerInput['email']);
    $district = mysqli_real_escape_string($conn, $lecturerInput['district']);
    $city = mysqli_real_escape_string($conn, $lecturerInput['city']);
    $district_id = mysqli_real_escape_string($conn, $lecturerInput['district_id']);
    $city_id = mysqli_real_escape_string($conn, $lecturerInput['city_id']);
    $school = mysqli_real_escape_string($conn, $lecturerInput['school']);
    $academic_qualification = mysqli_real_escape_string($conn, $lecturerInput['academic_qualification']);
    $summary = mysqli_real_escape_string($conn, $lecturerInput['summary']);
    $profile_image = mysqli_real_escape_string($conn, $lecturerInput['profile_image']);

    if(empty(trim($username))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your username", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($notification_key))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your notification key", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($password))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your password", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($name))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your name", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($nic))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your nic", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($mobile_1))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your mobile 1", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($mobile_2))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your mobile 2", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($email))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your email", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($district))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your district", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($city))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your city", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($district_id))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your district id", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($city_id))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your city id", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($school))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please enter your school", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($academic_qualification))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please Enter your academic qualification", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }elseif(empty(trim($summary))){
        $mess = [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "401", 
                    'msg'=>"Please Enter your summary", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }
    else{
        
        $query = "INSERT INTO ftm_lecturer(username,notification_key,password,name,nic,mobile_1,mobile_2,email,district,city,
        district_id,city_id,school,academic_qualification,summary,profile_image)VALUES('$username', '$notification_key', 
        '$password','$name', '$nic', '$mobile_1','$mobile_2', '$email', '$district','$city','$district_id','$city_id',
        '$school','$academic_qualification','$summary','$profile_image')";

        $result = mysqli_query($conn, $query);

        if($result){
            $mess = [
                    'resultStatus'=>"SUCCESS", 
                    'httpStatus'=>"UNAUTHORIZED",
                    'httpCode'=>  "201", 
                    'msg'=>"Lecturer details inserted successfully", 
                    'data'=>null, 
                    'status'=>"1"        
                ];
                header("HTTP/1.0 201 Created successfull");
                echo json_encode($mess);
        }else{
            $mess= [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"INTERNAL SERVER ERROR",
            'httpCode'=>  "500", 
            'msg'=>"Internal server error", 
            'data'=>null, 
            'status'=>"0"        
        ];
        header("HTTP/1.0 500 Internal server error");
        echo json_encode($mess);
        }
    }
}


//read Location details ---------
/*
function getLocationList(){

    global $conn;

    $query = "SELECT location_id, location FROM location";
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
};*/
//create location details ----------
function storeLocation($locationInput){
    global $conn;

    $location = mysqli_real_escape_string($conn, $locationInput['location']);
    $status = mysqli_real_escape_string($conn, $locationInput['status']);

    if(empty(trim($location))){
        return error422('Enter your location');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO location(location,status)VALUES('$location', '$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Location created successfully",
        
            ];
            header("HTTP/1.0 201 Location created successfully");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' =>  "Internal Server Error",
        
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


//read sub location details
/*
function getSubLocationList(){

    global $conn;

    $query = "SELECT location_id, sub_location_name, lat, lon FROM sub_location";
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
};*/
//create sub location details
function storeSubLocation($SubLocationInput){
    global $conn;

    $location_id = mysqli_real_escape_string($conn, $SubLocationInput['location_id']);
    $sub_location_name = mysqli_real_escape_string($conn, $SubLocationInput['sub_location_name']);
    $lat = mysqli_real_escape_string($conn, $SubLocationInput['lat']);
    $lon = mysqli_real_escape_string($conn, $SubLocationInput['lon']);
    $status = mysqli_real_escape_string($conn, $SubLocationInput['status']);

    if(empty(trim($location_id))){
        return error422('Enter your location_id');
    }elseif(empty(trim($sub_location_name))){
        return error422('Enter your sub_location_name');
    }elseif(empty(trim($lat))){
        return error422('Enter your lat');
    }elseif(empty(trim($lon))){
        return error422('Enter your lon');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO sub_location(location_id,sub_location_name,lat,lon,status)VALUES('$location_id', '$sub_location_name','$lat','$lon','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Sub location created successfully",
        
            ];
            header("HTTP/1.0 201 Sub location created successfully");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' =>  "Internal Server Error",
        
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


//read all career highlight detail
/*
function getCareerHighlightList(){

    global $conn;

    $query = "SELECT lecturer_id,career FROM ftm_career_highlight";
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
};*/
//create career highlight details
function storeCareerHighlight($careerHighlightInput){
    global $conn;

    $lecturer_id = mysqli_real_escape_string($conn, $careerHighlightInput['lecturer_id']);
    $career = mysqli_real_escape_string($conn, $careerHighlightInput['career']);
    $date = mysqli_real_escape_string($conn, $careerHighlightInput['date']);
    $time = mysqli_real_escape_string($conn, $careerHighlightInput['time']);
    $status = mysqli_real_escape_string($conn, $careerHighlightInput['status']);

    if(empty(trim($lecturer_id))){
        return error422('Enter your lecturer_id');
    }elseif(empty(trim($career))){
        return error422('Enter your career');
    }elseif(empty(trim($date))){
        return error422('Enter your date');
    }elseif(empty(trim($time))){
        return error422('Enter your time');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO ftm_career_highlight(lecturer_id,career,date,time,status)VALUES('$lecturer_id','$career','$date','$time','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Career Highlight created successfully",
        
            ];
            header("HTTP/1.0 201 Career Highlight created successfully");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' =>  "Internal Server Error",
        
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


//read lec academy details
/*
function getLecAcademyList(){

    global $conn;

    $query = "SELECT lecturer_id, academy FROM ftm_lec_academy";
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
};*/
//create lec academy details
function storeLecAcademy($lecAcademyInput){
    global $conn;

    $lecturer_id = mysqli_real_escape_string($conn, $lecAcademyInput['lecturer_id']);
    $academy = mysqli_real_escape_string($conn, $lecAcademyInput['academy']);
    $date = mysqli_real_escape_string($conn, $lecAcademyInput['date']);
    $time = mysqli_real_escape_string($conn, $lecAcademyInput['time']);
    $status = mysqli_real_escape_string($conn, $lecAcademyInput['status']);

    if(empty(trim($lecturer_id))){
        return error422('Enter your lecturer_id');
    }elseif(empty(trim($academy))){
        return error422('Enter your academy');
    }elseif(empty(trim($date))){
        return error422('Enter your date');
    }elseif(empty(trim($time))){
        return error422('Enter your time');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO ftm_lec_academy(lecturer_id,academy,date,time,status)VALUES('$lecturer_id','$academy','$date','$time','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Lec academy created successfully",
        
            ];
            header("HTTP/1.0 201 Lec academy created successfully");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' =>  "Internal Server Error",
        
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


//read lec notification details
/*
function getLecNotificationList(){

    global $conn;

    $query = "SELECT ftmlecturer_id,topic,notification FROM ftm_lec_notification";
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
};*/
//create lec notification details
function storeLecNotification($lecNotificationInput){
    global $conn;

    $ftmlecturer_id = mysqli_real_escape_string($conn, $lecNotificationInput['ftmlecturer_id']);
    $topic = mysqli_real_escape_string($conn, $lecNotificationInput['topic']);
    $notification = mysqli_real_escape_string($conn, $lecNotificationInput['notification']);
    $date = mysqli_real_escape_string($conn, $lecNotificationInput['date']);
    $time = mysqli_real_escape_string($conn, $lecNotificationInput['time']);
    $status = mysqli_real_escape_string($conn, $lecNotificationInput['status']);

    if(empty(trim($ftmlecturer_id))){
        return error422('Enter your ftmlecturer id');
    }elseif(empty(trim($topic))){
        return error422('Enter your topic');
    }elseif(empty(trim($notification))){
        return error422('Enter your notification');
    }elseif(empty(trim($date))){
        return error422('Enter your date');
    }    elseif(empty(trim($time))){
        return error422('Enter your time');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO ftm_lec_notification(ftmlecturer_id,topic,notification,date,time,status)VALUES('$ftmlecturer_id','$topic','$notification','$date','$time','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Lec Notification created successfully",
        
            ];
            header("HTTP/1.0 201 Lec Notification created successfully");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' =>  "Internal Server Error",
        
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}


//read working experience details
/*
function getWorkingExpList(){

    global $conn;

    $query = "SELECT lecturer_id, experience FROM ftm_working_exp";
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
};*/
//create working experience details
function storeWorkingExp($workingExpInput){
    global $conn;

    $lecturer_id = mysqli_real_escape_string($conn, $workingExpInput['lecturer_id']);
    $experience = mysqli_real_escape_string($conn, $workingExpInput['experience']);
    $date = mysqli_real_escape_string($conn, $workingExpInput['date']);
    $time = mysqli_real_escape_string($conn, $workingExpInput['time']);
    $status = mysqli_real_escape_string($conn, $workingExpInput['status']);

    if(empty(trim($lecturer_id))){
        return error422('Enter your lecturer_id');
    }elseif(empty(trim($experience))){
        return error422('Enter your experience');
    }elseif(empty(trim($date))){
        return error422('Enter your date');
    }    elseif(empty(trim($time))){
        return error422('Enter your time');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO ftm_working_exp(lecturer_id,experience,date,time,status)VALUES('$lecturer_id','$experience','$date','$time','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Working Experience created successfully",
        
            ];
            header("HTTP/1.0 201 Working Experience created successfully");
            return json_encode($data);
        }else{
            $data = [
                'status' => 500,
                'message' =>  "Internal Server Error",
        
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }

}

//update lecturer details
function updateLecturer($lecturerInput){
    global $conn;

    $lecturer_id=$_GET['lecturer_id'];

    $sql="select lecturer_id, name, username from `ftm lecturer` where lecturer_id=$lecturer_id";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);

    $lecturer_id=$row['lecturer_id'];
    $name=$row['name'];
    $username=$row['username'];

    
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if($requestMethod == "POST"){

        
        $name = mysqli_real_escape_string($conn, $lecturerInput['name']);
        $nic = mysqli_real_escape_string($conn, $lecturerInput['nic']);
        $mobile_2 = mysqli_real_escape_string($conn, $lecturerInput['mobile_2']);
        $email = mysqli_real_escape_string($conn, $lecturerInput['email']);
        $district = mysqli_real_escape_string($conn, $lecturerInput['district']);
        $city = mysqli_real_escape_string($conn, $lecturerInput['city']);
        $school = mysqli_real_escape_string($conn, $lecturerInput['school']);
        $summary = mysqli_real_escape_string($conn, $lecturerInput['summary']);


            
            $query = "UPDATE `ftm_lecturer` SET name='$name', nic='$nic', mobile_2='$mobile_2', email='$email', 
            district='$district', city='$city', school='$school', summary='$summary' WHERE lecturer_id='$lecturer_id'";

            $result = mysqli_query($conn, $query);

            if($result){
                $mess = [
                        'resultStatus'=>"SUCCESS", 
                        'httpStatus'=>"OK",
                        'httpCode'=>  "201", 
                        'msg'=>"Lecturer details updated successfully", 
                        'data'=>null, 
                        'status'=>"1"        
                    ];
                    header("HTTP/1.0 201 Created successfull");
                    echo json_encode($mess);
            }else{
                $mess= [
                'resultStatus'=>"FAILED", 
                'httpStatus'=>"INTERNAL SERVER ERROR",
                'httpCode'=>  "500", 
                'msg'=>"Internal server error", 
                'data'=>null, 
                'status'=>"0"        
            ];
            header("HTTP/1.0 500 Internal server error");
            echo json_encode($mess);
            }

    }

    
}
//insert class resources
function insertClassRes(){
    global $conn;
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $class_id = mysqli_real_escape_string($conn, $_POST['nova_sub_class_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, ($_POST['description']));
        $status = mysqli_real_escape_string($conn, ($_POST['status']));
     
        $file = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_folder = '../file/'.$file;
     
       
              $insert = mysqli_query($conn, "INSERT INTO `ftm_sub_class_res`(nova_sub_class_id, title, description, download_file, status) VALUES('$class_id', '$title', '$description', '$file', '$status')") or die('query failed');
     
              if($insert){
                 move_uploaded_file($file_tmp_name, $file_folder);
                 $mess = [
                    'resultStatus'=>"SUCCESS", 
                    'httpStatus'=>"OK",
                    'httpCode'=>  "201", 
                    'msg'=>"Class Resources inserted successfully", 
                    'data'=>null, 
                    'status'=>"1"        
                ];
                header("HTTP/1.0 201 Created successfull");
                echo json_encode($mess);
              }
              else{
                $mess= [
                    'resultStatus'=>"FAILED", 
                    'httpStatus'=>"INTERNAL SERVER ERROR",
                    'httpCode'=>  "500", 
                    'msg'=>"Internal server error", 
                    'data'=>null, 
                    'status'=>"0"        
                ];
                header("HTTP/1.0 500 Internal server error");
                echo json_encode($mess);
              }
           }
        
}
// display class resources 
function displayClassRes(){

    global $conn; 

    $sql = "select ftm_sub_class_res_id,title,description,download_file from `ftm_sub_class_res`";
    $result = mysqli_query($conn, $sql);

    if($result){


        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['ftm_sub_class_res_id'];
          $title = $row['title'];
          $description = $row['description'];
          $file = $row['download_file'];
          $file_path = "../file/" . $row['download_file'];
          echo $title;
          echo "<br>";  
          echo $description;
          echo "<a href='deleteClassRes.php?ftm_sub_class_res_id=$id'><i class='fa fa-trash' aria-hidden='true'></i></a>";
          echo "<br>";  
          if(!empty($file)){
            ?>

              <a href="<?php echo $file_path; ?>"  download><i class="fa fa-arrow-down" aria-hidden="true"></i></a><br>
          
          <?php
          }
          
      }
  } 
    
}

/*
function deleteClassResById(){
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $id = $_GET['ftm_sub_class_res_id'];
    
        $sql = "delete from `ftm_sub_class_res` where ftm_sub_class_res_id = $id";
        $result = mysqli_query($conn, $sql);
        
        if($result){
            header("location: classResources.php");
        }
    }
    
}
*/

//display nova sub class
function displaySubClass(){
    global $conn;
    $lecturer_id=5000;
    //$lecturer_id=$_GET['lecturer_id'];

    $sql = "select nova_sub_class_id,nova_main_class_id,nova_admin_account_id,sub_class_name,class_date,
    class_start_time,class_end_time,detail,duration,class_type,start_date from nova_sub_class where lecturer_id=$lecturer_id";
    $result = mysqli_query($conn, $sql);

    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $sub_class_name = $row['sub_class_name'];
            $sub_class_name = $row['sub_class_name'];
            $class_date = $row['class_date'];
            $class_start_time = $row['class_start_time'];
            $class_end_time = $row['class_end_time'];
            $detail = $row['detail'];
            $duration = $row['duration'];
            $class_type = $row['class_type'];
            $start_date = $row['start_date'];

            echo $sub_class_name;
            
            echo $sub_class_name;
            echo $class_date;
            echo $class_start_time;
            echo $class_end_time;
            echo $detail;
            echo $duration;
            echo $class_type;
            echo $start_date;
            echo '<br>';


        }
    }
}
?>