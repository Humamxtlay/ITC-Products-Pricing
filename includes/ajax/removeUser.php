<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {    
	die( header( 'location: ac.php' ) );
}

include "../DBConnection.php";

session_start();

if(isset($_SESSION['user_id']))
{
    $id = $_POST['id'];

    $query = "DELETE FROM `users` WHERE id=$id";

    $statement = $connect->prepare($query);
                
    $statement->execute();

    $ret = array(
        'error'         =>  0,
    );

    echo json_encode($ret);
}

?>