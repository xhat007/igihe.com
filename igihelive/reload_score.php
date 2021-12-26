<?php 
require('admin/config.php');
include('../willy_classes/caching.php');
//$id_game = 1;
$id_game = (int) $_GET['id_game']; //'#SOUSTITRE';
$req='reload_score_temp_'.$id_game;
$cache = new api_cache;
$cache->req=$req;
$cache->refresh=100;  
if($cache->check()){
//if(1){
    //The cache is still active                               
    $cache->read();
}
else{
    //The cache has expired                
    ob_start();                
        $score = getLiveScore($id_game); 
        $verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE id_game = ? LIMIT 0,20'); 
        $verify3 -> execute([$id_game]); 
        $gudata = $verify3 -> fetch(); 
        $team_1 = getTeamName($gudata['team_1']);
        $team_2 = getTeamName($gudata['team_2']);
        $game_names = $gudata['game_names']; 
        $headertitle = $team_1 .' '. $score .' '. $team_2;
        echo $headertitle;
        $cache->contents=ob_get_contents();
    ob_end_clean();
    $cache->write();
    echo $cache->contents;
}
?>