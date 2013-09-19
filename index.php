<?php 

/**
 * execute class 
 */

use library\curl;

require_once 'library\curl.php';

if(isset($_GET['keyword'])){
    
    $keyword = explode(" ",$_GET['keyword']);
    $keyword = str_replace(array("'",'"'),"",$keyword[0]);
    
    $url = "http://xlab.pl/feed/";

    $curl = new curl($url);
    $data = $curl->returnData("rss");

    if($data)
    {
        $items = $data->channel->item;
       
        $allItems = array();
       
        foreach($items as $item)
        {
            $description = $item->description;
            preg_match("/$keyword/Ui",$description,$results);
            if(count($results)>0){
                $allItems [] = $item->asXML();
            }

        }
        foreach($allItems as $itemContent){
            echo $itemContent;
        }
    }
    
}
