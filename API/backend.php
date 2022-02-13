<?php
set_time_limit(0);
ini_set('max_execution_time', 0);

include('../includes/DBConnection.php');
include('includes/simple_html_dom.php');

// stores
include('stores/amazon.php');
include('stores/flipkart.php');
include('stores/bigbasket.php');
include('stores/grofers.php');

//extra functions
include('functions.php');

$handle = curl_init();

curl_setopt_array($handle, array(
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER => false,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36 Edg/86.0.622.58',
    CURLOPT_CONNECTTIMEOUT  => 30,
    CURLOPT_TIMEOUT =>  30,
    CURLOPT_FOLLOWLOCATION  => 1,
    CURLOPT_SSL_VERIFYPEER  => 0,
    CURLOPT_HTTPHEADER, array(
        'Sec-Fetch-Mode: same-origin'
    )
));

$query = "SELECT * FROM products";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$query = "SELECT email FROM users WHERE role='1'";
$statement = $connect->prepare($query);
$statement->execute();
$emails = $statement->fetchAll();

foreach($result as $row){

    echo 'Debugging product: <strong>' . $row['name'] . '</strong></br>';

    $amazon = new Amazon($row['amazonPrice']);
    $flipkart = new Flipkart($row['flipkartPrice']);
    $bigbasket = new Bigbasket($row['bigbasketPrice']);
    $grofers = new Grofers($row['grofersPrice']);

    if($row['amazon'] != ''){
        $amazon->getPrice($row['amazon'] , $handle);
        addToChart(1,$row['id'],$amazon->price, $connect);
        echo 'amazon : ' . $amazon->Log . '</br>';
    }
    if($row['flipkart'] != ''){
        $flipkart->getPrice($row['flipkart'] , $handle);
        addToChart(2,$row['id'],$flipkart->price, $connect);
        echo 'flipkart : ' . $flipkart->Log . '</br>';    
    }
    if($row['bigbasket'] != ''){
        $bigbasket->getPrice($row['bigbasket'] , $handle);
        addToChart(3,$row['id'],$bigbasket->price, $connect);
        echo 'bigbasket : ' . $bigbasket->Log . '</br>';    
    }
    if($row['grofers'] != ''){
        $grofers->getPrice($row['grofers'] , $handle);
        addToChart(4,$row['id'],$grofers->price, $connect);
        echo 'grofers : ' . $grofers->Log . '</br>';    
    }

    echo 'our store : ' . $row['price'] . '</br>';

    $id = $row['id'];

    $query = "UPDATE products SET 
            amazonPrice='$amazon->price',
            flipkartPrice='$flipkart->price',
            bigbasketPrice='$bigbasket->price',
            grofersPrice='$grofers->price'
        WHERE id='$id'";

    $statement = $connect->prepare($query);
    $statement->execute();

    // send sms and email here
    $store = '';
    $NewPrice = '';
    if(($amazon->price) < ($row['price']) && ($amazon->price)!=""){
        $store = "Amazon";
        $NewPrice = $amazon->price;    
    }
    if(($flipkart->price) < ($row['price']) && ($flipkart->price)!=""){
        $store = "Flipkart";
        $NewPrice = $flipkart->price;    
    }
    if(($bigbasket->price) < ($row['price']) && ($bigbasket->price)!=""){
        $store = "Bigbasket";
        $NewPrice = $bigbasket->price;    
    }
    if(($grofers->price) < ($row['price']) && ($grofers->price)!=""){
        $store = "Grofers";
        $NewPrice = $grofers->price;
    }

    if(strlen($store) > 0){
        $txt = "Hi, There is a price difference alert for " . $row['name'] . " in " . $store . "\nListed Price : Rs. " . $row['price'] . "\nActual Price : Rs. " . $NewPrice;
    
        foreach($emails as $email){
            $to = $email['email'];
            $subject = "Price Difference Alert";
            $headers = "From: itc@sanjeevpandit.com";
        
            $retval = mail($to,$subject,$txt,$headers);

            if( $retval == true ) {
                echo "Message sent successfully to " . $to;
            }else {
                echo "Message could not be sent to " . $to;
            }
            echo '</br>';
        }
    }

    // debugging
    echo '</br>--------------------------------------------------------------------------------------------------</br>';

    sleep(1);

}

curl_close($handle);
?>