<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.scss">
    <title>User Page</title>
</head>
<body>

    <?php
        session_start();
        include 'functions.php';
        $conn = dbConfig();
        
        if (!isset($_SESSION['user']) || $_SESSION['user'] == null)
            header("Location: login.php");
        else {
            $latestLog = getLatestLog($_SESSION['user'], $conn);
            echo "<h1>Nice to see you <span> 
                <br>username: " . $_SESSION['user'] . 
                "<br>surname: " . $_SESSION['surname'] . 
                "<br>name: " . $_SESSION['name'] .
                "<br>birthdate: " . $_SESSION['birthdate'] .
                "<br>latest log: " . $latestLog .
                "</span></h1>";
        }
    ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="submit" value="Print backlog" name="backlog">
    </form><br>
    <form action="logout.php" method="get">
        <input type="submit" value="Log Out" name="logout">
    </form><br>
</body>
</html>

<?php
    if (isset($_GET['backlog'])) {
        $header = array("Login", "Logout");

        echo "<table><tr>";
        foreach ($header as $h)
            echo "<th>$h</th>";
        echo "</tr>";

        $user = $_SESSION['user'];
        $result = $conn->query("SELECT login_datetime, logout_datetime FROM accesses WHERE fk_user = '$user'");

        foreach($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['login_datetime'] . "</td>" . "<td>" . $row['logout_datetime'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
?>
