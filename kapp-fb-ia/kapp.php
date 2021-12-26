<?php
require "sdk/vendor/autoload.php";
require "dom.php";
use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Elements;
use Facebook\InstantArticles\Transformer;

define("KAPP_TABLE","spip_fcbk_ia");


function kapp_add_scripts($flux)
{
    $flux["data"] .= "<script src=\"".(url_absolue(find_in_path('assets/js/kapp.js')))."\" type=\"text/javascript\"></script>";
    return $flux;
}

function kapp_add_styles($flux)
{
    $flux .= "<link rel='stylesheet' href='".(url_absolue(find_in_path('assets/css/style.css')))."' />";
    return $flux;
}

function kapp_submit_article($flux){

    if(!isset($_GET['publish_ia']) || !isset($_GET['id_article'])) return $flux;

    try {
        $ia_client = Client::create(
            '112068259515857',
            'ea3323c1f57634e265db746ef935cc9c',
            'EAABl7OzMjdEBALh72XoPWWpZC8oTcLcUOxdaev5ZAZCGifmssoNZAqnAcG9DPoABEODHVmckZBSuUhFjNyyy5GqNkvShAwvGIlU1H9C2jwBKzdU9QgPnMCj56bZCjFmxZCbZBzjU30QUaHn0a7joZC3wWRHEZCBNHI82RMjNHDwE3BCwZDZD',
            '171343222113',
            false
        );

        $file = file_get_html( 'http://igihe.com/spip.php?page=fb_article&id_article='.$_GET['id_article'].'&url_reload=54' , true );
        $data = parseDoc($file);

        libxml_use_internal_errors(true);

        $parser = new \Facebook\InstantArticles\Parser\Parser();

        $article = $parser->parse($data);

        $ia_client->importArticle($article,true,false);
        $flux = "";
        die(200);
    }catch(Exception $ex){
        die(200);
    }

}

function parseDoc(&$file)
{

    $centers = $file->find("center");
    $H2 = $file->find("header")[0]->childnodes(1);

    $file->find("header")[0]->childnodes(1)->innertext= $H2->children(0)->innertext;

    foreach($centers as $key=> $center){
        $img = $center->children(0)->children(0);
        $caption  = $center->children(0)->lastchild();
        $caption = $caption->innertext;

        $newimg =  "<figure><img src='http://igihe.com/".$img->src."' />".(strlen($caption)>0? "<figcaption>{$caption}</figcaption>" : "")."</figure>";
        $file->find("center")[$key]->outertext = $newimg;
    }

    return $file->save();
}

function kapp_setup()
{
    //FOR LATER
    //sql_create(KAPP_TABLE,
    //    array(
    //        "id_fa_article" => "int NOT NULL AUTO_INCREMENT",
    //        "article_id"=> "int NOT NULL default '0'",
    //        "article_url"=> "varchar(200) NOT NULL default ''",
    //        "published"=> "tinyint NOT NULL default '0'"
    //    ),
    //    array(
    //        'PRIMARY KEY' => "id_fa_article"
    //    )
    //    );
}

kapp_setup();