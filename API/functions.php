<?php

function addToChart($store , $product , $price , $connect){

    $data = array(
        ':product_id' =>	$product,
        ':store_id'	  =>	$store,
        ':price'	  =>	$price,
    );

    $query = "
        INSERT INTO chart_data 
        (product_id , store_id , price) 
        VALUES (:product_id , :store_id , :price)
    ";

    $statement = $connect->prepare($query);
                
    $statement->execute($data);
}

?>