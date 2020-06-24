<?php
class AlcoholicModel{
 
    // database connection and table name
    private $conn;
    private $table_name = "alcoholic";
 
    // object properties
    public $id;
    public $license_number;
    public $name;
    public $address;
    public $alcohol_level;
    public $created_at;
    public $updated_at;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function read($limit){
     
        // select all query
        $query = "SELECT  * from
                    " . $this->table_name . " ORDER BY
                    created_at DESC limit ". $limit;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    function readId($id){
     
        // select all query
        $query = "SELECT  * from
                    " . $this->table_name . " where `id`= ". $id." ORDER BY
                    created_at DESC limit 1";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    function readLicense($lisence_number){
     
        // select all query
        $query = "SELECT  * from
                    " . $this->table_name . " where `license_number`= ". $lisence_number." ORDER BY
                    created_at DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    function readbydate($startdate, $enddate){
     
        // select all query
        $query = "SELECT * from
                    ". $this->table_name . " 
                   where created_at <= '".$enddate."' 
                   and created_at >= '".$startdate."'
                    ORDER BY
                    created_at DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                license_number=:license_number, name=:name, address=:address, alcohol_level=:alcohol_level";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->license_number=htmlspecialchars(strip_tags($this->license_number));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->alcohol_level=htmlspecialchars(strip_tags($this->alcohol_level));
     
        // bind values
        $stmt->bindParam(":license_number", $this->license_number);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":alcohol_level", $this->alcohol_level);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
     
    }
    
     function update($id){
 
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                license_number=:license_number, name=:name, address=:address, alcohol_level=:alcohol_level,
                updated_at=NOW() 
                where id=".$id;
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->license_number=htmlspecialchars(strip_tags($this->license_number));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->alcohol_level=htmlspecialchars(strip_tags($this->alcohol_level));
     
        // bind values
        $stmt->bindParam(":license_number", $this->license_number);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":alcohol_level", $this->alcohol_level);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
     
    }
    
    function delete($id){
 
        // query to insert record
        $query = "DELETE FROM 
                    " . $this->table_name . "
                Where id=".$id;
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
     
    }
    
    
}