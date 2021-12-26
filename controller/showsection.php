<?php
session_start();
include('model/showsection.php');
include('controller/functions.php');
if(isset($_GET['section_id'])){
	$section_id=(int) $_GET['section_id'];
	$sectionNews=get_sectionContent($section_id);
	include('view/showsection.php');
}
else{
	$section_id=0;
	$sectionNews=get_sectionContent($section_id);
	include('view/showsection.php');
}

?>
