<?php
set_time_limit(0);
ini_set('max_execution_time', 0);

class Amazon{

    public $price;
    public $Log;

    function __construct($price){
        $this->price = $price;
        $this->Log = '';
    }

    public function getPrice($url,$handle){

        $html = $this->getHTML($url, $handle);
        $productId = $this->getProductId($url);

        if($html == 'error') return;

        $ordinary = $this->explodeThreeMethods($html,'<table class="a-lineitem">','<tr','₹',2);
        if($ordinary!=''){
            $this->price = $ordinary;
            $this->Log = $this->Log . 'new Price is: ' . $ordinary . ', ';
            return;
        }

        $select = $this->explodeTowMethods($html,'data-defaultAsin="' . $productId . '"' , '₹',1);
        if($select!=''){
            $this->price = $select;
            $this->Log = $this->Log . 'new Price is: ' . $select . ', ';
            return;
        }

        $otherWays = $this->explodeTowMethods($html,'id="almMultiOfferEgress"','₹',1);
        if($otherWays!=''){
            $this->price = $otherWays;
            $this->Log = $this->Log . 'new Price is: ' . $otherWays . ', ';
            return;
        }

        $this->Log = $this->Log . 'No price was found, ';

        return;
    }

    public function getHTML($url,$handle){

        curl_setopt($handle, CURLOPT_URL, $url);

        $response = curl_exec($handle);

        $httpcode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if($httpcode != 200){
            $this->Log = $this->Log . $httpcode . 'Error, ';
            return 'error';
        }
        else 
            return $response;
    }

    function getProductId($url){
        $product = explode("/product/", $url);
        $dp = explode("/dp/", $url);
        $ret = '';
        
        $arr = '';

        if(sizeof($product) > 1) 
            $arr = $product[1];
        elseif(sizeof($dp) > 1)
            $arr = $dp[1];
        else{
            $this->Log = $this->Log . "No such id for this product, ";
            return;
        }
        
        for($i = 0 ; $i<strlen($arr) && $arr[$i] != '/'; $i++)
            $ret = $ret . $arr[$i];
        
        return $ret;
    }

    function explodeTowMethods($html,$first,$second,$type){
        $ret = '';
        $html = explode((string)$first , (string)$html);

        if(sizeof($html)>1){
            $html = explode($second , $html[1]);

            if(sizeof($html) > 1){
                
                $html = $html[$type];

                for($i = 0 ; $i<strlen($html) && $html[$i] != '<' && $html[$i] != '.'; $i++){
                    if($html[$i] == " " || $html[$i] == ",") continue;
                    $ret = $ret . $html[$i];
                }
    
           }
        }

        return $ret;
    }

    function explodeThreeMethods($html,$first,$second,$third,$type){
        $ret = '';
        $html = explode($first , $html);

        if(sizeof($html)>1){
            $html = explode($second , $html[1]);

            if(sizeof($html) > 1){
                if(sizeof($html) > $type)
                    $html = explode($third , $html[$type]);
                else
                    $html = explode($third , $html[1]);
                
                if(sizeof($html) > 1){
                    $html = $html[1];
    
                    for($i = 0 ; $i<strlen($html) && $html[$i] != '<' && $html[$i] != '.'; $i++){
                        if($html[$i] == " " || $html[$i] == ",") continue;
                        $ret = $ret . $html[$i];
                    }
        
               }
           }
        }

        return $ret;
    }
}

/*
// other ways to buy
https://www.amazon.in/gp/product/B07M8NF5WL/ref=pd_alm_al_1_11_mr_mr_dsk_dl_mw_img_bbsvd?fpw=alm&almBrandId=More&pd_rd_r=b1e6e7c6-ab0d-45cc-80d8-5bae47d2d9bd&pd_rd_w=xZLh4&pd_rd_wg=NEt1B&pd_rd_i=B07M8NF5WL&pf_rd_r=8Q45CP9TA3Z0YTBSMR24&pf_rd_p=10d1009b-8d4e-4a8f-8e0c-ef43ae71c9b9
https://www.amazon.in/gp/product/B01MYED6CZ/ref=pd_alm_al_1_5_mr_mr_dsk_dl_mw_img_bbsvd?fpw=alm&almBrandId=More&pd_rd_r=b1e6e7c6-ab0d-45cc-80d8-5bae47d2d9bd&pd_rd_w=xZLh4&pd_rd_wg=NEt1B&pd_rd_i=B01MYED6CZ&pf_rd_r=8Q45CP9TA3Z0YTBSMR24&pf_rd_p=10d1009b-8d4e-4a8f-8e0c-ef43ae71c9b9
https://www.amazon.in/Sunfeast-Dark-Fantasy-Choco-Fills/dp/B00GM1WF22/ref=sr_1_2?almBrandId=More&dchild=1&fpw=alm&keywords=sunfeast+dark+fantasy+choco+fills+rs+30&qid=1604131566&s=more&sr=1-2

for this use: id="almMultiOfferEgress" then ₹

// ordenary buy
https://www.amazon.in/gp/product/B08CYRFX24/ref=s9_acss_bw_cg_header_2b1_w?pf_rd_m=A1K21FY43GMZF8&pf_rd_s=merchandised-search-3&pf_rd_r=W86WW3GJ61N4TZMAFQHE&pf_rd_t=101&pf_rd_p=2b4fe5b3-996b-4ba4-9a8c-3ea34b66107e&pf_rd_i=976392031
https://www.amazon.in/gp/product/B00GM1WF22/ref=afx_dp_ingress?ie=UTF8&almBrandId=ctnow&fpw=alm
https://www.amazon.in/gp/product/B07SVZ86KS/ref=s9_acss_bw_cg_header_2a1_w?pf_rd_m=A1K21FY43GMZF8&pf_rd_s=merchandised-search-3&pf_rd_r=W86WW3GJ61N4TZMAFQHE&pf_rd_t=101&pf_rd_p=2b4fe5b3-996b-4ba4-9a8c-3ea34b66107e&pf_rd_i=976392031
https://www.amazon.in/gp/product/B07P7KM4Y6/ref=s9_acss_bw_cg_header_2d1_w?pf_rd_m=A1K21FY43GMZF8&pf_rd_s=merchandised-search-3&pf_rd_r=W86WW3GJ61N4TZMAFQHE&pf_rd_t=101&pf_rd_p=2b4fe5b3-996b-4ba4-9a8c-3ea34b66107e&pf_rd_i=976392031

for this use: <table class="a-lineitem"> then <tr [2] then ₹

// select
https://www.amazon.in/Aashirvaad-Atta-Superior-10kg-Bag/dp/B075757RDZ/ref=sr_1_2?almBrandId=More&crid=2RF5QNN5GAP7C&dchild=1&fpw=alm&keywords=aashirvaad+atta+10kg+wheat&qid=1604124325&sprefix=aashirvaad+atta%2Caps%2C485&sr=8-2
https://www.amazon.in/Aashirvaad-Superior-MP-Atta-5kg/dp/B00K0LUSSS/ref=sr_1_1?almBrandId=More&dchild=1&fpw=alm&keywords=aashirvaad+popular+atta+5kg+wheat&qid=1604128353&s=more&sr=1-1
https://www.amazon.in/gp/product/B00N2WI082/ref=pd_alm_al_1_3_mr_mr_dsk_dl_mw_img_bbsvd?fpw=alm&almBrandId=More&pd_rd_r=b1e6e7c6-ab0d-45cc-80d8-5bae47d2d9bd&pd_rd_w=xZLh4&pd_rd_wg=NEt1B&pd_rd_i=B00N2WI082&pf_rd_r=8Q45CP9TA3Z0YTBSMR24&pf_rd_p=10d1009b-8d4e-4a8f-8e0c-ef43ae71c9b9

for this use: data-defaultasin="B075757RDZ" then get ₹

// no price
https://www.amazon.in/Sunfeast-Magic-Biscuit-Cashew-Almond/dp/B00XJERARA/ref=sr_1_2?almBrandId=More&dchild=1&fpw=alm&keywords=Sunfeast+Mom%27s+Magic+Cashew+Almond+Rs+10&qid=1604131476&s=more&sr=1-2
https://www.amazon.in/gp/product/B089DSWYXQ/ref=pd_alm_al_1_14_mr_mr_dsk_dl_mw_img_bbsvd?fpw=alm&almBrandId=More&pd_rd_r=b1e6e7c6-ab0d-45cc-80d8-5bae47d2d9bd&pd_rd_w=xZLh4&pd_rd_wg=NEt1B&pd_rd_i=B089DSWYXQ&pf_rd_r=8Q45CP9TA3Z0YTBSMR24&pf_rd_p=10d1009b-8d4e-4a8f-8e0c-ef43ae71c9b9
https://www.amazon.in/Yippee-Noodles-Magic-Masala-60gm/dp/B08C24DCMH/ref=sr_1_3?almBrandId=More&dchild=1&fpw=alm&keywords=Noodles+Yippee+Magic+Masala&qid=1604144797&s=more&sr=1-3
*/


?>