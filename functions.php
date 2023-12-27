<?php
    function dbConfig() {
        try {
            return new mysqli("localhost", "root", "", "users");
        } catch (\Throwable $th) {
            die("Error while connecting with the database: " . $th);
        }
    }

    function getLatestLog($user, $conn) {
        $result = $conn->query("SELECT MAX(login_datetime) as max_login_datetime FROM accesses WHERE fk_user = '$user'");
    
        foreach($result as $row) 
            return $row['max_login_datetime'];
    }
?>