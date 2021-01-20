<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
 
    // object properties
    public $product_id;
    public $category_id;
    public $product_name;
    public $description;
    public $price;
    public $category_name;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

function read(){

    // select all query
    $query = "SELECT * FROM
                " . $this->table_name . " ";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    
    // execute query
    $stmt->execute();
    
    return $stmt;
}

// create product
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
            product_id=:product_id, category_id=:category_id, product_name=:product_name, description=:description, price=:price, category_name=:category_name";
   
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id)); 
    $this->product_name=htmlspecialchars(strip_tags($this->product_name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->category_name=htmlspecialchars(strip_tags($this->category_name));
  
    // bind values
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":product_name", $this->product_name);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":category_name", $this->category_name);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE product_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->product_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
        SET
            category_id=:category_id, 
            product_name=:product_name, 
            description=:description,
            price=:price, 
            category_name=:category_name
            WHERE
            product_id = :product_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id)); 
    $this->product_name=htmlspecialchars(strip_tags($this->product_name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->category_name=htmlspecialchars(strip_tags($this->category_name));
  
    // bind values
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":product_name", $this->product_name);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":category_name", $this->category_name);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


// search products
function search($keywords){
 
    // select all query
    $query = "SELECT * FROM
                " . $this->table_name . " 
            WHERE
            product_name LIKE ? OR description LIKE ? ";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// used when filling up the update product form
function readOne(){
  
    // query to read single record
    $query = "SELECT * FROM
                " . $this->table_name . "
            WHERE
            product_id = ?
            LIMIT
                0,1";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->product_id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->product_id = $row['product_id'];
    $this->category_id = $row['category_id'];
    $this->product_name = $row['product_name'];
    $this->description = $row['description'];
    $this->price = $row['price'];
    $this->category_name = $row['category_name'];
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT * FROM
                " . $this->table_name . " 
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}



}
?>