<?php
class TrackerModel{
 
    // database connection and table name
    private $conn;
    private $table_name = "location";
 
    // object properties
    public $id;
    public $latitude;
    public $longitude;
    public $car_shock;
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
                    latitude=:latitude, longitude=:longitude, car_shock=:car_shock";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->latitude=htmlspecialchars(strip_tags($this->latitude));
        $this->longitude=htmlspecialchars(strip_tags($this->longitude));
        $this->car_shock=htmlspecialchars(strip_tags($this->car_shock));
     
        // bind values
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":car_shock", $this->car_shock);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
     
    }
}