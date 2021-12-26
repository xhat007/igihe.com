<?php
function show_events($user){
	$sql=mysql_query('SELECT * FROM inshuti_user_events WHERE user="'.$user.'" AND status=0 ORDER BY event_id DESC') or die('ERROR SQL 1 :'.mysql_error());
	return $sql;
}
function get_event_info($event){
	$sql=mysql_query('SELECT * FROM inshuti_user_events WHERE event_id='.$event) or die('ERROR SQL 2 :'.mysql_error());
	return $sql;
}
function add_event($event_name,$from,$to,$where,$description,$user,$date,$status){
	$q=mysql_query('INSERT INTO inshuti_user_events VALUES("","'.$event_name.'","'.$from.'","'.$to.'","'.$where.'","'.$description.'","'.$user.'","'.$date.'","'.$status.'")') or die('ERROR SQL 3' .mysql_error()) ;
	if($q){
		return true;
	}
	else{
		return false;
	}
}
function edit_event($event_name,$from,$to,$where,$description,$event){
	if(mysql_query('UPDATE inshuti_user_events SET event_name="'.$event_name.'",from="'.$from.'",to="'.$to.'",where="'.$where.'",description="'.$description.'" WHERE event_id='.$event)){
		return true;
	}
	else{
		return false;
	}
}

function delete_event($event){
	$q=mysql_query('UPDATE inshuti_user_events SET status=1 WHERE event_id='.$event) or die('ERROR SQL 4 ' .mysql_error());
	if($q){
		return true;
	}
	else{
		return false;
	}
}
?>
