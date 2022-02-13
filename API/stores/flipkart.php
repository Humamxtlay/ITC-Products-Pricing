<?php
set_time_limit(0);
ini_set('max_execution_time', 0);

class Flipkart{

    public $price;
    public $Log;

    function __construct($price){
        $this->price = $price;
        $this->Log = '';
    }

    public function getHTML($url,$handle){

        curl_setopt($handle, CURLOPT_URL, $url);

        $response = curl_exec($handle);

        $httpcode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if($httpcode != 200){
            $this->Log = $httpcode;
            return 'error';
        }
        else 
            return str_get_html($response);
    }

    public function getPrice($url,$handle){
        
        $html = $this->getHTML($url , $handle);
        if($html == 'error'){
            $this->Log = $this->Log . ' HTML ERROR';
            return;
        }

        $html = explode('"price":',$html,2)[1];
        
        $ret = '';
        for($i=0;$html[$i] != ',';$i = $i + 1) 
            $ret = $ret . $html[$i];

        $this->price = $ret;

        $this->Log = 'new Price is: ' . $ret;

        return;
    }
}
?>