<?php
session_start();
$arnbr = $_GET['id_article']; 
$counter_name = "squelettes/v5inclure/ctr/art_". $arnbr .".txt";
// Check if a text file exists. If not create one and initialize it to zero.
if (!file_exists($counter_name)) {
  $f = fopen($counter_name, "w");
  fwrite($f,"1");
  fclose($f);
}

// Read the current value of our counter file
$f = fopen($counter_name,"r");
$counterVal = fread($f, filesize($counter_name));
fclose($f);
// Has visitor been counted in this session?
// If not, increase counter value by one
//if(!isset($_SESSION['hasVisited_'. $arnbr .''])){
//  $_SESSION['hasVisited_'. $arnbr .'']="yes";
  $counterVal++;
  $f = fopen($counter_name, "w");
  fwrite($f, $counterVal);
  fclose($f); 
//}

## LIKES COUNTER INITIALISATION ##

$like_counter = "squelettes/v5inclure/ctr/like_". $arnbr .".txt";
if (!file_exists($like_counter)) {
  $f = fopen($like_counter, "w");
  fwrite($f,"0");
  fclose($f);
} 
$f = fopen($like_counter,"r");
$likeVal = fread($f, filesize($like_counter));
fclose($f);

## // LIKES COUNTER INITIALISATION ##


## DISLIKES COUNTER INITIALISATION ##

$dlike_counter = "squelettes/v5inclure/ctr/dlike_". $arnbr .".txt";
if (!file_exists($dlike_counter)) {
  $f = fopen($dlike_counter, "w");
  fwrite($f,"0");
  fclose($f);
} 
$f = fopen($dlike_counter,"r");
$dlikeVal = fread($f, filesize($dlike_counter));
fclose($f);

## // DISLIKES COUNTER INITIALISATION ##


//echo $counterVal .' - '. $arnbr;
//echo "You are visitor number ". $counterVal ." to this site";
?>