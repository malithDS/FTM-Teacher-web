<?php
  include("../inc/conn.php");
  include ('./student_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifications</title>
    <script src="../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/notification.css">
</head>

<body>
     <?php
       getStdnotification();


     ?>
        
                    <!-- bell icon -->
                    <i class="fa fa-bell"   id="over" data-value ="<?php echo $count_active;?>">Notification</i>
                    <?php if(!empty($count_active)){?>
                    <!-- show unread notification count -->
                    <div class="round" id="bell-count" data-value ="<?php echo $count_active;?>"><span><?php echo $count_active; ?></span></div>
                    <?php }?>
                     
                    <?php if(!empty($count_active)){?>
                      <div id="list">
                       <?php
                          foreach($notifications_data as $list_rows){?>
                            <li id="message_items">
                            <div class="message alert alert-warning" data-id=<?php echo $list_rows['nova_student_notification_id'];?>>
                              <span><?php echo $list_rows['topic'];?></span>
                              <div class="msg">
                                <p><?php 
                                  echo $list_rows['notification'];
                                ?></p>
                              </div>
                            </div>
                            </li>
                         <?php }
                       ?> 
                       </div> 
                     <?php }else{?>
                        <!--old Messages-->
                        <div id="list">
                        <?php
                          foreach($deactive_notifications_dump as $list_rows){?>
                            <li id="message_items">
                            <div class="message alert alert-danger" data-id=<?php echo $list_rows['nova_student_notification_id'];?>>
                              <span><?php echo $list_rows['topic'];?></span>
                              <div class="msg">
                                <p><?php 
                                  echo $list_rows['notification'];
                                ?></p>
                              </div>
                            </div>
                            </li>
                         <?php }
                       ?>
                        <!--old Messages-->
                     
                     <?php } ?>
                     
                     </div>

              
    
</body>

<script src="./script.js"></script>

</html>