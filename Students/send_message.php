<?php
	include ('../inc/conn.php');

	date_default_timezone_set("Asia/Colombo");
$date=date('Y-m-d');
$time = date("h:i:s A");
	
	session_start();
	if(isset($_POST['msg'])){		
		$msg = addslashes($_POST['msg']);
		$id = $_POST['id'];
		mysqli_query($conn,"insert into `nova_group_chat` (nova_sub_class_id,  nova_student_id, message, date, time) values (1, '".$_SESSION['nova_student_id']."', '$msg' , '$date' , '$time')") or die(mysqli_error());
	}
?>
<?php
	if(isset($_POST['res'])){
		$id = $_POST['id'];
	?>
	<?php
		$query=mysqli_query($conn,"select * from `nova_group_chat` left join `nova_student` on nova_student.nova_student_id=nova_group_chat.nova_student_id where nova_sub_class_id='$id' order by date asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
	?>	
		<div>
			<?php echo $row['date'];   ?><br>
			<?php echo $row['time'];   ?><br>
			<?php echo $row['username']; ?>: <?php echo $row['message']; ?><br>
		</div>
		<br>
	<?php
		}
	}	
?>

