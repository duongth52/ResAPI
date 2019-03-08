<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once "../config/database.php";
    include_once "../object/product.php";

    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    $product->id = isset($_GET['id']) ? $_GET['id'] : die();
    $product->read_one();
    if($product->name != NULL){


        $product_arr = array(
            "id" => $product->id,
            'price' => $product->price,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "category_name" => $product->category_name,
            "created" => $product->created
        );

        http_response_code(200);

        echo json_encode($product_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "Product does not exist."));

    }


?>