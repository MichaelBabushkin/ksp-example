<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/branch.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare branch object
$branch = new Branch($db);

// query branch
$stmt = $branch->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $branch_arr=array();
    $branch_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $branch_item=array(
            "id" => $id,
            "branch_name" => $branch_name,
            "category_id" => $category_id,
            "product_id" => $product_id,
            "stock" => $stock,
            "modified" => $modified
        );

        array_push($branch_arr["records"], $branch_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($branch_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
 

?>