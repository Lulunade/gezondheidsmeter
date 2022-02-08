<?php
class Dbconfig {
    // The information for the online server
    // private $host = "sql201.hostingdiscounter.nl";
    // private $db_name = "gezondheidsmeter";
    // private $username = "admin_GM";
    // private $password = "cEV6x5YJpG";

    // personal sql server in XAMMP
    private $host = "";
    private $db_name = "gezondheidsmeter";
    private $username = "root";
    private $password = "";
    public $conn;


    // Public function to start the database connection
    public function getConnection() {
        // $ this for means that its ment for the public $conn in db.php (this file)
        $this->conn = null;

        // try so if fails we can see what goes wrong
        try{
            // this connection variable start a PDO connection with the sql server
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

        // If there is an error it gets catched 
        }catch(PDOException $exception){
            // echo what is wrong with the connection
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    } 
} 
?>