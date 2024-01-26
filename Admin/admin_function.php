<?php
//register admin
function registerAdmin(){
    global $conn;
    if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if(empty(trim($name))){
        return error422('Enter your Name');
    }elseif(empty(trim($username))){
        return error422('Enter your Username');
    }elseif(empty(trim($password))){
        return error422('Enter your Password');
    }elseif(empty(trim($status))){
        return error422('Enter your status');
    }else{

        $query = "INSERT INTO admin(name,username,password,status)VALUES('$name', '$username','$password','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Admin created successfully",
        
            ];
            header("HTTP/1.0 201 Admin created successfully");
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
}

//login admin
function loginAdmin(){
    global $conn;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = $_POST['username'];
            $password = $_POST['password'];
         
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
                $select = mysqli_query($conn, "SELECT admin_id,name,username,password FROM `admin` WHERE username = '$username' AND password = '$password'") or die('query failed');
         
                if(mysqli_num_rows($select) > 0){
                   $row = mysqli_fetch_assoc($select);
                   
                            $admin_id = $row['admin_id'];
                            header("Location: admin.php?admin_id=$admin_id");
                    
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

//Insert blog category
function insertBlog(){
    global $conn;
    if($_SERVER["REQUEST_METHOD"] == "POST"){

    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

   

        $query = "INSERT INTO admin(category,status)VALUES('$category','$status')";

        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' =>  "Blog category created successfully",
        
            ];
            header("HTTP/1.0 201 Blog category created successfully");
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
    
};

//display blog category by id
function getBlogCategoryById(){

    global $conn;
        
        $blog_category_id = $_POST['blog_category_id'];

        $query = "SELECT category FROM blog_category where blog_category_id = '$blog_category_id'";
        $result = mysqli_query($conn, $query);

        if($result){
            if(mysqli_num_rows($result)>0){

                $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $mess= [
                    'resultStatus'=>"SUCCESS", 
                    'httpStatus'=>"OK",
                    'httpCode'=>  "200", 
                    'msg'=>"Blog category found", 
                    'data'=>null, 
                    'status'=>"1"        
                ];
                header("HTTP/1.0 200 Blog category found successfully");
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
                    'msg'=>"No blog category details found", 
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

//update blog category
function updateBlogCategory(){
    global $conn;

    $blog_category_id=$_GET['blog_category_id'];

    $sql="select blog_category_id, category from `blog_category` where blog_category_id=$blog_category_id";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);

    $category=$row['category'];

    
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if($requestMethod == "POST"){

        
        $category = mysqli_real_escape_string($conn, $_POST['category']);
            
            $query = "UPDATE `blog_category` SET category='$category' WHERE blog_category_id='$blog_category_id'";

            $result = mysqli_query($conn, $query);

            if($result){
                $mess = [
                        'resultStatus'=>"SUCCESS", 
                        'httpStatus'=>"OK",
                        'httpCode'=>  "201", 
                        'msg'=>"Blog category updated successfully", 
                        'data'=>null, 
                        'status'=>"1"        
                    ];
                    header("HTTP/1.0 201 Blog Updated successfull");
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

?>