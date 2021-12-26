<?php
require "sdk/vendor/autoload.php";
require "dom.php";
use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Elements;
use Facebook\InstantArticles\Transformer;

define("KAPP_TABLE","spip_fcbk_ia");

$api_settings = array(
            "app_id"    => "",
            "page_id"   => "",
            "token"     => "",
            "secret"    => ""
        );


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

    global $api_settings;
    try {
        $ia_client = Client::create(
            $api_settings["app_id"],
            $api_settings["secret"],
            $api_settings["token"],
            $api_settings["page_id"]
            ,
            false
        );

        $file = file_get_html( 'http://igihe.com/spip.php?page=fb_article&id_article='.$_GET['id_article'].'&url_reload='.(rand(2,130)) , true );
        $link;
        if($file === false){
            http_response_code(404);
            die("ARTICLE NOT FOUND");
            return;
        }

        $data = parseDoc($file,$link);
        libxml_use_internal_errors(true);

        $parser = new \Facebook\InstantArticles\Parser\Parser();

        $article = $parser->parse($data);
        $id = $ia_client->importArticle($article,true,false);
        $flux = "";

        //LATER IF NEEDED
        //sql_insertq(KAPP_TABLE, array(
        //        "article_id"    => intval($_GET['id_article']),
        //        "article_url"   => $link,
        //        "published"     => 1
        //    ));
        if($id>0){
            die("Article Submitted");
        }else {
            http_response_code(400);
            die("Unable to publish article on facebook Api");
        }
    }catch(Exception $ex){
        http_response_code(400);
        die($ex->getMessage());
    }

}

function parseDoc(&$file,&$link)
{
    $centers = $file->find("center");
    $iframes = $file->find("iframe");
    $links = $file->find("link");

    foreach($links as $ln)
    {
        if($ln->rel == "canonical")
        {
            $link = $ln->href;
            break;
        }
    }

    $H2 = $file->find("header")[0]->childnodes(1);

    if(count($iframes) > 0 ){
        $c = '<figure class="op-interactive">';
        $x = 0;

        foreach ($iframes as $key=>$iframe)
        {
        	if($x==count($iframes)) break;

            $newIframe  = '<figure class="op-interactive"><iframe src="'.$iframe->src.'" width="'.$iframe->width.'" height="'.$iframe->height.'"></iframe></figure>';
            $file->find("iframe")[$key]->outertext = $newIframe;
        }

    }

    $file->find("header")[0]->childnodes(1)->innertext= $H2->children(0)->innertext;

    foreach($centers as $key=> $center){
        $img = $center->children(0)->children(0);
        $caption  = $center->children(0)->lastchild();
        $caption = $caption->innertext;
        $newimg =  "<figure><img src='http://igihe.com/".$img->src."' />".(strlen($caption) > 0 ? "<figcaption>{$caption}</figcaption>" : "")."</figure>";
        $file->find("center")[$key]->outertext = $newimg;
    }

    return $file->save();
}

function kapp_setup()
{
    //FOR LATER
    sql_create(KAPP_TABLE,
        array(
            "id_fa_article" => "int NOT NULL AUTO_INCREMENT",
            "article_id"=> "int NOT NULL default '0'",
            "article_url"=> "varchar(200) NOT NULL default ''",
            "published"=> "tinyint NOT NULL default '0'"
        ),
        array(
            'PRIMARY KEY' => "id_fa_article"
        )
        );

    sql_create("spip_fcbk_ia_settings",
        array(
            "app_id"    => "varchar(100) NOT NULL default '0'",
            "page_id"   => "varchar(200) NOT NULL default ''",
            "token"     => "text NOT NULL default ''",
            "secret"    => "varchar(240) NOT NULL default ''"
        ),
        array()
        );

    $res = sql_select('*', 'spip_fcbk_ia_settings');
    if($res && sql_count($res) >  0)
    {
        global $api_settings;

        if($setting = sql_fetch($res))
        {
            $api_settings = array(
            "app_id"    => $setting['app_id'],
            "page_id"   => $setting['page_id'],
            "token"     => $setting['token'],
            "secret"    => $setting['secret']
        );
        }

    }

}


kapp_setup();