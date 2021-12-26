<?php
if(isset($error_data_missing)){
	echo 'Sorry there are some data missing';
}
else{
	?>
	<html>
	<body width="20" height="20" style="color:#FFF;padding:0;margin:0;font-size:12px;">
		<?php echo $number_of_comments; ?>
	</body>
	</html>
	<?php
}
?>
