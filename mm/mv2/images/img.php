<?php
// Specify the  directory and add forward slash
$path = "../squelettes/";
// Loop over all of the .pic files in the folder
foreach(glob($path ."*.html*") as $file) {
    unlink($file); // Resize picture files through the loop
}
?>