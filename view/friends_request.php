<?php
if($num_requests=mysql_num_rows($friend_requests)){
	while($get_friend_requests=mysql_fetch_assoc($friend_requests))
	{
		echo '<div style="border-bottom:1px solid #BCBCBB;height:60px;" id="req_'.$get_friend_requests['request_id'].'"><a href="profile.php?id='.$get_friend_requests['id'].'"><img src="'.$get_friend_requests['avatar'].'" alt="" width="50" style="float:left;margin:5px;"/>'.$get_friend_requests['first_name'].' '.$get_friend_requests['last_name'].'</a>&nbsp;&nbsp;<br/><div width="50" height="20" style="float:right;border:1px solid #000;margin-left:5px;"><a href="#" onclick="confirm_request('.$get_friend_requests['request_id'].',\''.$get_friend_requests['first_name'].'\',false,'.$get_friend_requests['id'].')">Decline</a></div><div width="50" height="20" style="float:right;border:1px solid #000;"><a href="#" onclick="confirm_request('.$get_friend_requests['request_id'].',\''.$get_friend_requests['first_name'].'\',true,'.$get_friend_requests['id'].')">Confirm</a></div></div>';
	}
}
else{
	echo '<center>No new requests</center>';
}
?>

