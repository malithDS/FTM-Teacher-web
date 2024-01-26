<?php
	include('../inc/conn.php');

?>
<!DOCTYPE html>
<html>
<head>
<title>Public Chat</title>
<script src="../js/jquery-3.1.1.js"></script>	
<script type="text/javascript">

$(document).keypress(function(e){ //using keyboard enter key
	displayResult();
	/* Send Message	*/	
	
		if(e.which === 13){ 
				if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "Lecturer_group_send_message.php",
					data: {
						msg: $msg,
						id: $id,
					},
					success: function(){
						displayResult();
						$('#msg').val(''); //clears the textarea after submit
					}
				});
			}	

			
		} 
	}
); 


$(document).ready(function(){ //using send button
	displayResult();
	/* Send Message	*/	
		
		$('#send_msg').on('click', function(){
			if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "Lecturer_group_send_message.php",
					data: {
						msg: $msg,
						id: $id,
					},
					success: function(){
						displayResult();
						$('#msg').val(''); //clears the textarea after submit
					}
				});
			}	
		});
	/* END */
	});
	
	function displayResult(){
		$id = $('#id').val();
		$.ajax({
			url: 'Lecturer_group_send_message.php',
			type: 'POST',
			async: false,
			data:{
				id: $id,
				res: 1,
			},
			success: function(response){
				$('#result').html(response);
			}
		});
	}
</script>

</head>

<body>
<table id="chat_room" style="align:center">
	<tr>
	<th><h4>Hi, <?php //echo $urow['username']; ?></a>  </h4></th>
	</tr>
	<?php
		$query=mysqli_query($conn,"select nova_group_chat_id,nova_sub_class_id,nova_student_id,message,date,time from `nova_group_chat`");
		$row=mysqli_fetch_array($query);
	?>
			<tr>
				<td>
				<div id="result" style="overflow-y:scroll; height:300px; width: 605px;"></div>
				<form class="form">
					<!--<input type="text" id="msg">--><br/>
					<textarea id="msg" rows="4" cols="85"></textarea><br/>
					<input type="hidden" value="<?php echo $row['nova_sub_class_id']; ?>" id="id">
					<button type="button" id="send_msg" class="button button2">Send</button>
				</form>
				</td>
			</tr>

</table>

</body>
</html>