<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../objects/branch.php';
  
$database = new Database();
$db = $database->getConnection();
  
// prepare branch object
$branch = new Branch($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->branch_name) &&
    !empty($data->category_id) &&
    !empty($data->product_id) &&
    !empty($data->stock) &&
    !empty($data->modified)
){
  
// set product property values
$branch->id = $data->id;
$branch->branch_name = $data->branch_name;
$branch->category_id = $data->category_id;
$branch->product_id = $data->product_id;
$branch->stock = $data->stock;
$branch->modified = $data->modified;
  
    // create the product
    if($branch->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Branch was created."));
    }
  
    // if unable to create the branch, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create branch."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create branch. Data is incomplete."));
}

?>