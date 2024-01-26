<?php
	include ('../inc/conn.php');

	date_default_timezone_set("Asia/Colombo");
	$date=date('Y-m-d');
	$time = date("h:i:s A");
	
	if(isset($_POST['msg'])){		
		$msg = addslashes($_POST['msg']);
		$id = $_POST['id'];
		mysqli_query($conn,"insert into `nova_class_question` (nova_sub_class_id, nova_student_id, answer, answer_date, answer_time) values (1200, 3034, '$msg', '$date' , '$time')") or die(mysqli_error());
	}
?> 

<?php
	if(isset($_POST['res'])){
		$id = $_POST['id'];
	?>
	<?php
		$query=mysqli_query($conn,"select nova_class_question_id,nova_sub_class_id,nova_student_id,question,question_date,question_time,answer,answer_date,answer_time,status from `nova_class_question` order by question_time desc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
			
			$que = $row['question'];
	if(!empty($que)){
	?>	
	
	
		<div style="color:red; margin-bottom: 5px; float:right; width:100%">
			<?php echo $row['question_date'];   ?>
			<?php echo $row['question_time'];   ?>
			<h3><?php  ?>: <?php echo $row['question']; ?></h3>
		</div>
        <div style="color:blue; margin-bottom: 5px; float:left; width:100%">
			<?php echo $row['answer_date'];   ?>
			<?php echo $row['answer_time'];   ?>
			<h3><?php  ?>: <?php echo $row['answer']; ?></h3>
		</div>
		<br>
	<?php
}else{
	?>	
	
	
        <div style="color:blue; margin-bottom: 5px; float:left; width:100%">
			<?php echo $row['answer_date'];   ?>
			<?php echo $row['answer_time'];   ?>
			<h3><?php  ?>: <?php echo $row['answer']; ?></h3>
		</div>
		<br>
	<?php
}

		}
	}	
?>

