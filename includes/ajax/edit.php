<?php
set_time_limit(0);

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {    
	die( header( 'location: ac.php' ) );
}

include "../DBConnection.php";

session_start();
 
if(isset($_SESSION['user_id']))
{
    if(strpos($_POST['amazon'],'amazon.in') === false && $_POST['amazon']!=''){
        $ret = array(
            'error'         =>  1,
            'message'       =>  'Amazon Link is not valied',
        );
        echo json_encode($ret);
        return;
    }
    if(strpos($_POST['bigbasket'],'bigbasket.com') === false && $_POST['bigbasket']!=''){
        $ret = array(
            'error'         =>  1,
            'message'       =>  'Bigbasket Link is not valied',
        );
        echo json_encode($ret);
        return;
    }
    if(strpos($_POST['flipkart'],'flipkart.com') === false && $_POST['flipkart']!=''){
        $ret = array(
            'error'         =>  1,
            'message'       =>  'Flipkart Link is not valied',
        );
        echo json_encode($ret);
        return;
    }
    if(strpos($_POST['grofers'],'grofers.com') === false && $_POST['grofers']!=''){
        $ret = array(
            'error'         =>  1,
            'message'       =>  'Grofers Link is not valied',
        );
        echo json_encode($ret);
        return;
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $amazon = $_POST['amazon'];
    $flipkart = $_POST["flipkart"];
    $bigbasket = $_POST["bigbasket"];
    $grofers = $_POST['grofers'];
    $price = $_POST['price'];

    $query = "UPDATE products SET
        name='$name', 
        amazon='$amazon',
        flipkart='$flipkart',
        bigbasket='$bigbasket',
        grofers='$grofers',
        price='$price'
    WHERE id='$id'";

    $statement = $connect->prepare($query);
                
    $statement->execute();

    $ret = array(
        'error'     =>  0,
    );

    echo json_encode($ret);
}

?>