<?php
	include ('../inc/conn.php');

	date_default_timezone_set("Asia/Colombo");
	$date=date('Y-m-d');
	$time = date("h:i:s A");
	
	if(isset($_POST['msg'])){		
		$msg = addslashes($_POST['msg']);
		$id = $_POST['id'];
		mysqli_query($conn,"insert into `chat_with_lecturer` (nova_sub_class_id, nova_student_id, message, is_student, date, time) values (1200, 3034, '$msg', 0 , '$date' , '$time')") or die(mysqli_error());
	}
?>
<?php
	if(isset($_POST['res'])){
		$id = $_POST['id'];
	?>
	<?php
		$query=mysqli_query($conn,"select chat_with_lecturer_id,nova_sub_class_id,nova_student_id,message,is_student,date,time,status from `chat_with_lecturer` order by date and time asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
			$user=$row['is_student'];
			if($user == 1){
	?>	
	
		<div style="color:red; margin-bottom: 5px; width:100%">
			<?php echo $row['date'];   ?>
			<?php echo $row['time'];   ?>
			<h3><?php  ?>: <?php echo $row['message']; ?></h3>
		</div>
		<br>
	<?php
}else{
	?>	
	
		<div style="color:blue; ">
			<?php echo $row['date'];   ?>
			<?php echo $row['time'];   ?>
			<h3><?php  ?>: <?php echo $row['message']; ?></h3>
		</div>
		<br>
	<?php
}

		}
	}	
?>

