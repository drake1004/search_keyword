<?php

namespace library;

class curl{
    
    /**
     * Url
     * @var type 
     */
    private $link;
    
    public function __construct($link) {
        $this->link = $link;
        
    }
    
    public function returnData($type="html"){
        switch($type){
            case "html":
                $ch = curl_init();
                $timeout = 3;
                curl_setopt($ch, CURLOPT_URL, $this->link);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                curl_setopt($ch, CURLOPT_HEADER, TRUE);
                curl_setopt($ch, CURLOPT_REFERER, "http://www.google.pl/");
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/20.0");
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );  

                $last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); 
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                $acceptHTTP = array(
                    'HTTP/1.0 200',
                    'HTTP/1.0 201',
                    'HTTP/1.0 202',
                    'HTTP/1.0 204',
                    'HTTP/1.0 301',
                    'HTTP/1.0 302',
                    'HTTP/1.0 304',
                    'HTTP/1.1 100',
                    'HTTP/1.1 101',
                    'HTTP/1.1 100',
                    'HTTP/1.1 110',
                    'HTTP/1.1 111',
                    'HTTP/1.1 200',
                    'HTTP/1.1 201',
                    'HTTP/1.1 202',
                    'HTTP/1.1 203',
                    'HTTP/1.1 204',
                    'HTTP/1.1 205',
                    'HTTP/1.1 206'
                );
                if(!in_array($httpCode, $acceptHTTP)) {
                    return false;
                }else{
                    $data = curl_exec($ch);            
                    curl_close($ch);
                    return $data;
                }
            break;
            case "rss":
                return simplexml_load_file($this->link);
            break;    
        }
        
    }
    
}
