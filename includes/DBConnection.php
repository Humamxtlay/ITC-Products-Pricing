<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {    
	die( header( 'location: ac.php' ) );
}

$connect = new PDO("mysql:host=localhost;dbname=sanjeevpandit23_itc;charset=utf8mb4","root", "");

?>