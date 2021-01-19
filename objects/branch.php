<?php
class Branch{
 
    // database connection and table name
    private $conn;
    private $table_name = "branches";
 
    // object properties
    public $id;
    public $branch_name;
    public $category_id;
    public $product_id;
    public $stock;
    public $modified;
 
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
                id=:id,
                branch_name=:branch_name,
                category_id=:category_id,
                product_id=:product_id, 
                stock=:stock,
                modified=:modified";
       
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->branch_name=htmlspecialchars(strip_tags($this->branch_name));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id)); 
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->stock=htmlspecialchars(strip_tags($this->stock));
        $this->modified=htmlspecialchars(strip_tags($this->modified));
      
        // bind values
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":modified", $this->modified);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":branch_name", $this->branch_name);
      
        // execute query
        if($stmt->execute()){
            return true;
        }
      
        return false;
          
    }
    
    // delete the product
    function delete(){
     
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
     
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
            branch_name=:branch_name,
            category_id=:category_id,
            product_id=:product_id, 
            stock=:stock,
            modified=:modified
            WHERE
            id=:id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id)); 
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->modified=htmlspecialchars(strip_tags($this->modified));
        $this->stock=htmlspecialchars(strip_tags($this->stock));
        $this->branch_name=htmlspecialchars(strip_tags($this->branch_name));
      
        // bind values
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":modified", $this->modified);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":branch_name", $this->branch_name);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    



}
?>