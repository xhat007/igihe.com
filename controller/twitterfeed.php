<?php
session_start();
require_once("twitteroauth-master/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 
$twitteruser = "igihe";
$notweets = 30;
$consumerkey = "j2gKDZE6OGx8fYleeSIf5Dokg";
$consumersecret = "01de1hFKOctNHiBBf7Zjusv3aNTsfpsq7Y1DxYbKCvTuV3DKYa";
$accesstoken = "183993972-4CSGCYb4n9rou47AX5sLbEsF4iR6jFKL2YbETZ7f";
$accesstokensecret = "yWcIYf89PbYBcXZh0cPgM1A0drCZmBz0AZzmJowHQF11h";
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
} 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
include('view/twitterfeed.php');
?>
