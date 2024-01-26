<?php
include '../inc/conn.php';

date_default_timezone_set("Asia/Colombo");
$date=date('Y-m-d');
$time = date("h:i:s A");

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,
        
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

//generate mobile verification ---------
function mobile_verification(){
    $mobile_verify = rand(1000, 9999);

    return $mobile_verify;
};
//generate web verification -------
function web_verification(){
    
    $web_verify = rand(1000, 9999);
    return  $web_verify;
};


function studentRegister(){
    global $conn;

    

    if($_SERVER["REQUEST_METHOD"] == "POST"){

    $index_no=mysqli_real_escape_string($conn,$_POST['index_no']);
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $nic=mysqli_real_escape_string($conn,$_POST['nic']);
    $mobile_1=mysqli_real_escape_string($conn,$_POST['mobile_1']);
    $mobile_2=mysqli_real_escape_string($conn,$_POST['mobile_2']);
    $profile=mysqli_real_escape_string($conn,$_POST['profile']);
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $mobile_verification=mysqli_real_escape_string($conn,$_POST['mobile_verification']);
    $web_verification=mysqli_real_escape_string($conn,$_POST['web_verification']);
    $date=mysqli_real_escape_string($conn,$_POST['date']);
    $time=mysqli_real_escape_string($conn,$_POST['time']);
    $location=mysqli_real_escape_string($conn,$_POST['location']);
    $sub_location=mysqli_real_escape_string($conn,$_POST['sub_location']);



        $profile = $_FILES['profile']['name'];
        $profile_size = $_FILES['profile']['size'];
        $profile_tmp_name = $_FILES['profile']['tmp_name'];
        $profile_folder = './profile/'.$profile;

        $nic_front = $_FILES['nic_front']['name'];
        $nic_front_size = $_FILES['nic_front']['size'];
        $nic_front_tmp_name = $_FILES['nic_front']['tmp_name'];
        $nic_front_folder = './nic_front/'.$nic_front;

        $nic_back = $_FILES['nic_back']['name'];
        $nic_back_size = $_FILES['nic_back']['size'];
        $nic_back_tmp_name = $_FILES['nic_back']['tmp_name'];
        $nic_back_folder = './nic_back/'.$nic_back;

    if(empty(trim($index_no))){
        $mess = [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"UNAUTHORIZED",
            'httpCode'=>  "401", 
            'msg'=>"Please enter your Index no", 
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
            'msg'=>"Please enter your Name", 
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
            'msg'=>"Please enter your Email", 
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
            'msg'=>"Please enter your Mobile 1", 
            'data'=>null, 
            'status'=>"8"        
        ];
        header("HTTP/1.0 401 Unauthorized request");
        echo json_encode($mess);
    }elseif(empty(trim($username))){
        $mess = [
            'resultStatus'=>"FAILED", 
            'httpStatus'=>"UNAUTHORIZED",
            'httpCode'=>  "401", 
            'msg'=>"Please enter your Username", 
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
                    'msg'=>"Please enter your Password", 
                    'data'=>null, 
                    'status'=>"8"        
                ];
                header("HTTP/1.0 401 Unauthorized request");
                echo json_encode($mess);
    }else{
    $insert_query=mysqli_query($conn,"INSERT INTO nova_student_upload(index_no,name,email,nic,mobile_1,mobile_2,profile_image,username,
    password,mobile_verification,web_verification,register_date,register_time, district, city,nic_front,nic_back)VALUES
    ('$index_no','$name','$email','$nic','$mobile_1','$mobile_2','$profile','$username','$password','$mobile_verification',
    '$web_verification','$date','$time','$location','$sub_location','$nic_front','$nic_back')")or die(mysqli_error($conn));
   

    if($insert_query){
        move_uploaded_file($profile_tmp_name, $profile_folder);
        move_uploaded_file($nic_front_tmp_name, $nic_front_folder);
        move_uploaded_file($nic_back_tmp_name, $nic_back_folder);
        //move_uploaded_file($nic_back_tmp_name, $nic_back_folder);
        $mess = [
            'resultStatus'=>"SUCCESS", 
            'httpStatus'=>"UNAUTHORIZED",
            'httpCode'=>  "201", 
            'msg'=>"Student details inserted successfully", 
            'data'=>null, 
            'status'=>"1"        
        ];
        header("HTTP/1.0 201 Created successfull");
        echo json_encode($mess);
    }
  
    
    }
    }
}

function studentLogin(){
    global $conn;


    session_start();
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	$query=mysqli_query($conn,"select nova_student_id,username,password from `nova_student` where username='$username' and password='$password'");
	
	if (mysqli_num_rows($query)<1){
		
        header('location:student_index.php');
		
	}
	else{
		$row=mysqli_fetch_array($query);
		$_SESSION['nova_student_id']=$row['nova_student_id'];
		header('location:student_homepage.php');
	}
}


function getStdnotification(){
    global $conn;
    
    $find_notifications = "Select * from nova_student_notification where status = 1";
    $result = mysqli_query($conn,$find_notifications);
    $count_active = '';
    $notifications_data = array(); 
    $deactive_notifications_dump = array();
     while($rows = mysqli_fetch_assoc($result)){
             $count_active = mysqli_num_rows($result);
             $notifications_data[] = array(
                         "nova_student_notification_id" => $rows['nova_student_notification_id'],
                         "topic"=>$rows['topic'],
                         "notification"=>$rows['notification']
             );
     }
     //only five specific posts
     $deactive_notifications = "Select * from nova_student_notification where status = 0 ORDER BY nova_student_notification_id DESC LIMIT 0,5";
     $result = mysqli_query($conn,$deactive_notifications);
     while($rows = mysqli_fetch_assoc($result)){
       $deactive_notifications_dump[] = array(
                       "nova_student_notification_id" => $rows['nova_student_notification_id'],
                       "topic"=>$rows['topic'],
                       "notification"=>$rows['notification']
       );
     }
}

function toChatPage(){
    global $conn;

    session_start();

    if (!isset($_SESSION['nova_student_id']) ||(trim ($_SESSION['nova_student_id']) == '')) {
        header('location:student_index.php');
        exit();
        }else{
            echo "<a href='student_chat_page.php'>group chat</a>";
        }

}


function getIpAddress(){
    $ipaddress = '';
    if(isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLENT_IP'];
    elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    elseif(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    elseif(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    elseif(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
    $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function getMacAddress(){
    ob_start();
    system('ipconfig/all');
    $mycom = ob_get_contents();
    ob_clean();

    $findme = "Physical";
    $pmac = strpos($mycom,$findme);
    $mac = substr($mycom, ($pmac+36),17);
    return $mac;
}

?>