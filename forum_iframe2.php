<html>
	<head>
		<script type="text/javascript">
			window.onload = function() {
    			if (parent) {
        			var oHead = document.getElementsByTagName("head")[0];
        			var arrStyleSheets = parent.document.getElementsByTagName("style");
        			for (var i = 0; i < arrStyleSheets.length; i++)
            				oHead.appendChild(arrStyleSheets[i].cloneNode(true));
    				}
			}
		</script>
	</head>
	<body>

			<?php
			$root_call='forum_iframe2.php';
			include('wcontroller/forum2.php');
			?>

	</body>
</html>
