<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");


    include_once "../config/database.php";
    include_once "../object/product.php";
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    $keywwords = isset($_GET["s"]) ? $_GET["s"] : "";
    $stmt = $product->search($keywwords);

    $num = $stmt->rowCount();

    if($num > 0){

        $product_arr = array();
        $product_arr["records"] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $product_item = array(
              "id"=>$id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
                "category_id" => $category_id,
                "category_name" => $category_name
            );
            array_push($product_arr["records"], $product_item);
        }
        http_response_code(200);
        echo json_encode($product_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message"=>"product not found"));

    }

?>