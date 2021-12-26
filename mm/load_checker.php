<?php
$load_main = sys_getloadavg();
echo $load_main[0].' | '.$load_main[1].' | '.$load_main[2].'<br/>';
?>
