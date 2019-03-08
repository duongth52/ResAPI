<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once "../config/database.php";
    include_once "../object/product.php";

    $database = new  Database();
    $db = $database->getConnection();
    $product = new  Product($db);

    $data = json_decode(file_get_contents("php://input"));
    $product->id = $data->id;

    /*set product property value*/
    $product->name = $data->name;
    $product->description = $data->description;
    $product->price = $data->price;
    $product->category_id = $data->category_id;

    /*update product*/
    if($product->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Product was updated."));
    }
    else {
        http_response_code(503);
        echo json_decode(array("message" => "Unable to update product."));

    }

?>