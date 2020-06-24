<?php
class DrainageModel{
 
    // database connection and table name
    private $conn;
    private $table_name = "drainage";
 
    // object properties
    public $id;
    public $temperature;
    public $humidity;
    public $water_level;
    public $water_flow;
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
                    temperature=:temperature, humidity=:humidity, water_level=:water_level, water_flow=:water_flow";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->temperature=htmlspecialchars(strip_tags($this->temperature));
        $this->humidity=htmlspecialchars(strip_tags($this->humidity));
        $this->water_level=htmlspecialchars(strip_tags($this->water_level));
        $this->water_flow=htmlspecialchars(strip_tags($this->water_flow));
     
        // bind values
        $stmt->bindParam(":temperature", $this->temperature);
        $stmt->bindParam(":humidity", $this->humidity);
        $stmt->bindParam(":water_level", $this->water_level);
        $stmt->bindParam(":water_flow", $this->water_flow);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
     
    }
}