<?php
class Database{

    const server = "localhost";
    const user = "WebDiP2017x138";
    const password = "admin_hggb";
    const base = "WebDiP2017x138";

    private $connection = null;
    private $error = '';

    function connectDB(){
        $this->connection = new mysqli(self::server,self::user,self::password,self::base);
        if($this->connection->connect_errno){
            echo "Neuspješno povezivanje na bazu!".$this->connection->connect_errno.", "
            .$this->connection->connect_error;
            $this->error = $this->veza->connect_error;
        }

    }

    function closeConnection(){
        $this->connection->close();
    }

    function sqlQuery($query){
        $query_result = $this->connection->query($query);
        if ($this->connection->connect_errno) {
            echo "Greška kod upita: {$query} - " . $this->connection->connect_errno . ", " .
                $this->connection->connect_error;
            $this->error = $this->connection->connect_error;
        }
        if (!$query_result) {
            $query_result = null;
        }
        return $query_result;
    }

    function updateDB($query, $script = '') {
        $update_result = $this->connection->query($query);
        if ($this->connection->connect_errno) {
            echo "Greška kod upita: {$query} - " . $this->connection->connect_errno . ", " .
                $this->connection->connect_error;
            $this->error = $this->connection->connect_error;
        } else {
            if ($script != '') {
                header("Location: $script");
            }
        }

        return $update_result;
    }

    function pogreskaDB() {
        if ($this->error != '') {
            return true;
        } else {
            return false;
        }
    }


}