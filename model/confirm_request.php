<?php
include('model/sql_connect.php');
include('model/functions.php');
function confirm_request($req_id,$req_by){
	//Verify if these two are not yet friends....
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_friendslist WHERE (friendship_list='.$_SESSION['user_auth'].' AND friend_id='.$req_by.') OR (friendship_list='.$req_by.' AND friend_id='.$_SESSION['user_auth'].')') or die(mysql_error());
	$num_q=mysql_fetch_assoc($q);
	if($num_q['nb_rows']!=0){	
		return false;		
	}
	else{
		//Let add this new friendship in both users friendship list	
		if(mysql_query('INSERT INTO inshuti_friendslist(friendship_id,friendship_list,friend_id,friendship_date,friendship_status) VALUES("",'.$_SESSION['user_auth'].','.$req_by.','.time().',0)')){
			if(mysql_query('UPDATE inshuti_requests SET request_status=1 WHERE request_id='.$req_id))
			{
			//Then we add the requestee to the requester's friend's list
			mysql_query('INSERT INTO inshuti_friendslist(friendship_id,friendship_list,friend_id,friendship_date,friendship_status) VALUES("",'.$req_by.','.$_SESSION['user_auth'].','.time().',0)');
			return true;
			}
			else{
				//Undo the friend insertion and return false
				mysql_query('DELETE FROM inshuti_friendship WHERE friendship_id='.mysql_insert_id());
				return false;
			}
		}
		else
		{
			die(mysql_error());
			return false;
		}	
	}
}
function decline_request($req_id){
	if(mysql_query('UPDATE inshuti_requests SET request_status=-1 WHERE request_id='.$req_id))
	{
		//request has been declined
		return true;
	}
	else{
		return false;
	}
}
?>
