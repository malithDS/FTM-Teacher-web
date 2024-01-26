<?php
	include ('../inc/conn.php');

	date_default_timezone_set("Asia/Colombo");
	$date=date('Y-m-d');
	$time = date("h:i:s A");
	
	if(isset($_POST['msg'])){		
		$msg = addslashes($_POST['msg']);
		$id = $_POST['id'];
		mysqli_query($conn,"insert into `nova_group_chat` (nova_sub_class_id, nova_student_id, message, date, time) values (1200, 3034, '$msg', '$date' , '$time')") or die(mysqli_error());
	}
?>
<?php
	if(isset($_POST['res'])){
		$id = $_POST['id'];
	?>
	<?php
		$query=mysqli_query($conn,"select nova_group_chat_id,nova_sub_class_id,nova_student_id,message,date,time,status
		 from `nova_group_chat` order by date and time asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
			
	?>	
	
		<div style=" margin-bottom: 5px; float:left; width:100%">
			<?php echo $row['date'];   ?>
			<?php echo $row['time'];   ?>
			<h3><?php  ?>: <?php echo $row['message']; ?></h3>
		</div>
		<br>
	<?php


		}
	}	
?>

