<?php
set_time_limit(0);

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {    
	die( header( 'location: ac.php' ) );
}

include "../DBConnection.php";

session_start();
 
if(isset($_SESSION['user_id']))
{
    if($_POST['product'] == 0 || $_POST['store'] == 0){
        $ret = array(
            'error'         =>  1,
            'message'       =>  'Please insert valid data',
        );
        echo json_encode($ret);
        return;
    }

    $pid = $_POST['product'];
    $sid = $_POST['store'];
    $ds = $_POST['startDate'];
    $de = $_POST['endDate'];

    $query = "SELECT * FROM chart_data WHERE product_id=$pid AND (date BETWEEN '$ds'AND '$de') AND store_id=$sid";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $query = "SELECT price FROM products WHERE id=$pid";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result1 = $statement->fetchAll();
    $price = '';

    foreach($result1 as $p){
        $price = $p['price'];
    }

    $ret = array(
        'error'     =>  0,
        'data'      =>  $result,
        'price'     =>  $price
    );

    echo json_encode($ret);
}

?>