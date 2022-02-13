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
));

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id='" . $id . "'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$row = $result[0];

$amazon = new Amazon($row['amazonPrice']);
$flipkart = new Flipkart($row['flipkartPrice']);
$bigbasket = new Bigbasket($row['bigbasketPrice']);
$grofers = new Grofers($row['grofersPrice']);

if($row['amazon'] != ''){
    $amazon->getPrice($row['amazon'] , $handle, $connect);
    addToChart(1,$row['id'],$amazon->price,$connect);
}
if($row['flipkart'] != ''){
    $flipkart->getPrice($row['flipkart'] , $handle, $connect);
    addToChart(2,$row['id'],$flipkart->price,$connect);
}
if($row['bigbasket'] != ''){
    $bigbasket->getPrice($row['bigbasket'] , $handle, $connect);
    addToChart(3,$row['id'],$bigbasket->price,$connect);
}
if($row['grofers'] != ''){
    $grofers->getPrice($row['grofers'] , $handle, $connect);
    addToChart(4,$row['id'],$grofers->price,$connect);
}

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

$ret = array(
    'amazon'    =>  $amazon->price,
    'flipkart'  =>  $flipkart->price,
    'bigbasket' =>  $bigbasket->price,
    'grofers'   =>  $grofers->price,
);

echo json_encode($ret);

curl_close($handle);
?>