<?php
include("../inc/conn.php");
include '../Students/student_function.php';

studentRegister();

$mobile_verify = mobile_verification();
$web_verify = web_verification();

?>


<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Public Chat</title>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      

  
</head>

<body>

  <div class="form">
    <h2>Create an account</h2>
    <form name="form_register" method="post" action="./student_register.php" enctype="multipart/form-data">
      <input type="text" placeholder="index_no" name="index_no" required="required" />
      <input type="text" placeholder="name" name="name" required="required" />
      <input type="email" placeholder="email" name="email" required="required" />
      <input type="text" placeholder="nic" name="nic" required="required" />
      <input type="text" placeholder="mobile_1" name="mobile_1" />
      <input type="text" placeholder="mobile_2" name="mobile_2" />
      <input type="file" name="profile" class="box" accept="file/pdf">
      <input type="text" placeholder="username" name="username" />
      <input type="password" placeholder="password" name="password" />
      <input type="hidden" placeholder="mobile_verification" name="mobile_verification" value="<?php echo $mobile_verify?>"/>
      <input type="hidden" placeholder="web_verification" name="web_verification" value="<?php echo $web_verify?>"/>
      <input type="hidden" placeholder="date" name="date" value="<?php echo $date?>"/>
      <input type="hidden" placeholder="time" name="time" value="<?php echo $time?>"/>
      <select name="location" id="location">
      <option value=''>Select location</option>
        <?php
          $sql = "select location_id,location from location";
          $result = mysqli_query($conn, $sql);

          while($row=mysqli_fetch_assoc($result)){
            $location_id= $row['location_id'];
            $location = $row['location'];
            echo "<option value='$location_id'>$location</option>";
          }
        
        ?>
      
    </select>
    
    <select id="sub_location" name='sub_location'>
      <option selected disabled>Select sub location</option>
    </select>
    <input type="file" name="nic_front" class="box" accept="file/pdf">
    <input type="file" name="nic_back" class="box" accept="file/pdf">
   
      <button>Register</button>
      <a href="./student_index.php"></a>
    </form>
  </div>
  
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script>

$('#location').on('change', function() {
    var location_id = this.value;
    $.ajax({
        url: '../ajax/sub_location.php',
        type: "POST",
        data: {
            location_data: location_id
        },
        success: function(result) {
            $('#sub_location').html(result);
        }
    })
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>
