<?php
if(isset($error_data_missing)){
	echo 'Sorry there are some data missing';
}
else{
	?>
	
		<html>
			<head>
				<style type="text/css">
					.articletools{
						background-color: rgb(255, 255, 255);
						background-position: 0% 0%;
						background-repeat: no-repeat;
						border-bottom-color: rgb(218, 218, 218);
						border-bottom-style: solid;
						border-bottom-width: 1px;
						border-image-outset: 0px;
						border-image-repeat: stretch;
						border-image-slice: 100%;
						border-image-source: none;
						border-image-width: 1;
						border-left-color: rgb(218, 218, 218);
						border-left-style: solid;
						border-left-width: 1px;
						border-right-color: rgb(218, 218, 218);
						border-right-style: solid;
						border-right-width: 1px;
						border-top-color: rgb(218, 218, 218);
						border-top-style: solid;
						border-top-width: 1px;
						color: rgb(128, 128, 128);
						cursor: auto;
						display: block;
						font-family: 'Trebuchet MS', Helvetica, sans-serif;
						font-size: 10px;
						font-style: normal;
						font-weight: bold;
						height: 11px;
						margin-top: 3px;
						outline-color: rgb(128, 128, 128);
						outline-style: none;
						outline-width: 0px;
						padding-bottom: 3px;
						padding-left: 23px;
						padding-top: 3px;
						text-align: left;
						text-decoration: none;
						vertical-align: baseline;
						width: 115px;
					}
				</style>
			</head>
			<body>
				<!-- ArticleTools -->
				<a href="#" class="articletools" style="background-image:url(http://igihe.com/squelettes/igihe_imgs/gh_icons_views.gif);background-repeat:no-repeat;background-position:left top">VISITS : <?php echo $number_of_visits; ?></a>
				<a href="#" class="articletools" style="background-image:url(http://igihe.com/squelettes/igihe_imgs/gh_icons_comments.gif);background-repeat:no-repeat;background-position:left top">COMMENTS :<?php echo $number_of_comments; ?></a>
				<!-- End ArticleTools -->
			</body>
		</html>			
	
	<?php
}
?>
