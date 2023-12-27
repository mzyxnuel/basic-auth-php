<?php
    include 'functions.php';
    session_start();

    if (isset($_GET['logout'])) {
        $conn = dbConfig();
        $user = $_SESSION['user'];

        $result = $conn->query("SELECT MAX(login_datetime) AS max_login_datetime FROM accesses WHERE fk_user = '$user';");
    
        foreach($result as $row) 
            $max_login_datetime = $row['max_login_datetime'];

        $conn->query("UPDATE accesses SET logout_datetime = NOW() WHERE login_datetime = '$max_login_datetime' AND fk_user = '$user'");
        session_unset();
    }
        
    header("Location: login.php");
?>