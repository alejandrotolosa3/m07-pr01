<?php 

class DBconn {

    public $dbname = 'icb0006_uf4_pr01';
    public $conn = FALSE;
    
    private $serverName = 'localhost';
    private $userName = 'root';
    private $password = '';


    public function connect(){
        try{
            $this->conn = new PDO('mysql:host='.$this->serverName.';dbname='.$this->dbname,$this->userName,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // print_r([
            //     'status' => "Connected",
            //     'conn' => $this->conn
            // ]);
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }

    public function disconnect(){
        $this->conn = NULL;
        echo "Disconnected succesfully";
    }   
}

// $conn = new DBconn();
// $conn->connect();

// $conn->disconnect();

