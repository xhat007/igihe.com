<?php
session_start();
include('controller/check_auth.php');
include('controller/functions.php');
include('model/chat.php');
/*External models includes  begin*/
include('model/profile.php');
/*External models includes  end*/

$page_title='';
if(isset($_GET['uid']) OR isset($_POST['uid'])){
	if(isset($_GET['uid'])){
		$friend_id = (int) $_GET['uid'];
	}
	else{
		$friend_id = (int) $_POST['uid'];
	}
	$friend_list=getFriends();	
	//Check if this user exists
	if(check_if_user_exists($friend_id)){
		//Check if this relationship doesn't have a blocked status
		if(check_block_status($_SESSION['user_auth'],$friend_id))
		{
			if(isset($_GET['action'])){
				$action=htmlspecialchars($_GET['action']);
				switch($action){
					case 'send_message';
						$message_to = get_user_names($friend_id);
						$avatar = get_user_avatar($friend_id);
						if(isset($_POST['message']) AND isset($_POST['subject'])){
							/*SHOULD ADD EXTRA VERIFICATIONS HERE TO ENSURE ALL DATA HAS BEEN ENTERED CORRECTELLY */
							$message = htmlspecialchars($_POST['message']);
							$from = $_SESSION['user_auth'];
							$to = $friend_id;
							$subject = htmlspecialchars($_POST['subject']);
							$message_type='new_thread';
							$thread_id=0;							
							//Send the message
							if(send_chat_message($message,$from,$to,$subject,$message_type,$thread_id)){
								$success_message_sent=true;
								header('location:account.php');
							}
							else
							{
								$error_message_sent=true;
							}
						}
						else{					
							$include_message_form=true;							
							include('view/chat.php');
						}
					break;
					case 'reply':
						$thread_id=(int) $_GET['thread_id'];
						$message_id=(int) $_GET['message_id'];
						
						/*MARK CURRENT MESSAGE AS READ AND FETCH THREAD SUBJECT */
						mark_message_as_read($message_id);
						$thread_subject = get_thread_subject($thread_id);
						/* SHOULD ADD EXTRA VERIFICATIONS HERE FOR THE THREAD ID*/							
						if(isset($_POST['message'])){
							$message=htmlspecialchars($_POST['message']);
							$from=$_SESSION['user_auth'];
							$to=$friend_id;
							$subject = 'Re : '.$thread_subject;
							$message_type='reply';
							//Add reply to the database
							if(send_chat_message($message,$from,$to,$subject,$message_type,$thread_id)){
								//Message sending success
								$chat_history=get_chat_history($thread_id);
								include('view/chat.php');
							}
							else{
								//Message sending failed
								echo 'error message sending failed';
								$error_message_sending_failed=true;
							}
						}
						else{
							$chat_history=get_chat_history($thread_id);
							include('view/chat.php');
						}
					break;
					default:

					break;
				}
			}
			else{
				$error_action_missing=true;
			}
		}
		else{
			$error_relationship_block=true;
		}
	}
	else{
		$error_user_no_exist=true;
	}
}
else{
	$data_error=true;
}
?>
