<?php
session_start();
include('controller/check_auth.php');
include('controller/functions.php');
include('model/user_messages.php');
/*External models includes  begin*/
include('model/chat.php');
/*External models includes  end*/
$page_title='';
$messages=get_unread_messages($_SESSION['user_auth']);
include('view/user_messages.php');
include('model/sql_close.php');
?>
