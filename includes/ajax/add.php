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

    $data = array(
        ':name'		=>	$_POST["name"],
        ':amazon'	=>	$_POST['amazon'],
        ':flipkart'	=>	$_POST["flipkart"],
        ':bigbasket'=>  $_POST["bigbasket"],
        ':grofers'	=>  $_POST['grofers'],
        ':price'	=>  $_POST['price']
    );

    $query = "
        INSERT INTO products 
        (name , amazon , flipkart , bigbasket , grofers , price) 
        VALUES (:name , :amazon , :flipkart , :bigbasket , :grofers , :price)
    ";

    $statement = $connect->prepare($query);
                
    $statement->execute($data);

    $id = $connect->lastInsertId();

    $ret = array(
        'error'     =>  0,
        'id'        =>  $id,
    );

    echo json_encode($ret);


}

?>