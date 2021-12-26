<?php
/* This file contain functions that can be use on various different models for processing certain informations from the database */
/*FUNCTION TO CHECK IF TWO USERS ARE FRIENDS IN THE DATABASE */
/* PROTECT AGAINST MULTIPLE INCLUDES and REDFINITIONS*/
if(!isset($functions_php_included)){
	$functions_php_included = true;
	function check_if_friends($user1,$user2){
		$is_friend = mysql_query('SELECT COUNT(*) AS is_friend FROM inshuti_friendslist WHERE ((friendship_list='.$user1.' AND friend_id='.$user2.') OR (friendship_list='.$user2.' AND friend_id='.$user1.'))') or die('Error function check_if_friends: '.mysql_error());
		$get_is_friend=mysql_fetch_assoc($is_friend);
		if($get_is_friend['is_friend']==2){
			//This two user have a friendship relationship status
			return true;
		}
		else{
			//These two users don't have a friendship relationship status
			return false;
		}	
	}
	/* FUNCTION TO CHECK IF A USER EXISTS IN THE DATABASE */
	function check_if_user_exists($user){
		$is_user = mysql_query('SELECT COUNT(*) AS does_exist FROM inshuti_users WHERE id='.$user) or die('Error function check_if_user_exists: '.mysql_error());
		$get_is_user=mysql_fetch_assoc($is_user);
		if($get_is_user['does_exist']==1){
			//The user does exist
			return true;
		}
		else{
			//The user doesn't exist
			return false;
		}	
	}
	/* FUNCTION TO CHECK IF A RELATIONSHIP DOESN'T HAVE A BLOCKED STATUS */
	function check_block_status($user1,$user2){
		$block_status = mysql_query('SELECT COUNT(*) AS is_blocked FROM inshuti_friendslist WHERE ((friendship_status=-1 AND friendship_list='.$user1.' AND friend_id='.$user2.') OR (friendship_status=-1 AND friendship_list='.$user2.' AND friend_id='.$user1.'))') or die('Error function check_block_status :'.mysql_error());
		$get_block_status=mysql_fetch_assoc($block_status);
		if($get_block_status['is_blocked']==0){
			//There is no block status
			return true;
		}
		else{
			//There is a block status
			return false;
		}	
	}
}
?>
