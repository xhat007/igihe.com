<?php
if ($_GET['randomId'] != "AJNUpVS0e94yMWkd2uT9GicQSlm2IE2BD5XktgQaJr29CZeSD59t3AmxSEyww0O9") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
