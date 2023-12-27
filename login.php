<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <h1>LOG IN</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
        <label>username:</label>
        <input type="text" name="username"/><br>
        <label>password:</label>
        <input type="password" name="password"/ pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
        <input type="submit" name="submit" value="Log in">
        <a href="signup.php">Sign up</a>
    </form>
</body>
</html>

<?php
    include 'functions.php';

    if (!isset($_SESSION['user']))
        $_SESSION['user'] = null;
    
    if (isset($_GET['submit'])) {
        if (isset($_GET['username']) && !empty($_GET['username']) && isset($_GET['password']) && !empty($_GET['password'])) {
            $conn = dbConfig();
            $username = $_GET['username'];
            $password = $_GET['password'];

            $result = $conn->query("SELECT password from users WHERE user = '$username'");
            if($result->num_rows > 0) {
                foreach($result as $row) 
                    $hashed_password = $row['password'];

                if (password_verify($password, $hashed_password)) {
                    $result = $conn->query("SELECT user, surname, name, birthdate from users WHERE user = '$username'");

                    if($result->num_rows > 0) {
                        foreach($result as $row) {
                            $_SESSION['user'] = $row['user'];
                            $_SESSION['surname'] = $row['surname'];
                            $_SESSION['name'] = $row['name'];
                            $_SESSION['birthdate'] = $row['birthdate'];
                        }

                        $fk_user = $_SESSION['user'];
                        $result = $conn->query("INSERT INTO accesses (login_datetime, logout_datetime, fk_user) VALUES (NOW(), NULL, '$fk_user')");
                    } 
                }
                else
                    echo "username or password mismatch";
            } else
                echo "username or password mismatch";
        }
    }
    
    if ($_SESSION['user'] != null) 
        header("Location: user.php");
?>