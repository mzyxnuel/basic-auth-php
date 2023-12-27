<h1>SIGN UP</h1>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
    <label for="">username: </label>
    <input type="text" name="username"> <br>
    <label for="">password: </label>
    <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
    <label for="">surname: </label>
    <input type="text" name="surname"><br>
    <label for="">name: </label>
    <input type="text" name="name"><br>
    <label for="">birthdate: </label>
    <input type="date" name="birthdate"><br>
    <input type="submit" value="Sign up" name="signup">
    <a href="login.php">Login page</a>
</form>

<?php
    include 'functions.php';
    if (isset($_GET['signup'])) {
        if (
            isset($_GET['username']) && !empty($_GET['username']) && 
            isset($_GET['password']) && !empty($_GET['password']) &&
            isset($_GET['surname']) && !empty($_GET['surname']) &&
            isset($_GET['name']) && !empty($_GET['name']) &&
            isset($_GET['birthdate']) && !empty($_GET['birthdate']) 
        ) {
            $username = $_GET['username'];
            $password = $_GET['password'];
            $surname = $_GET['surname'];
            $name = $_GET['name'];
            $birthdate = $_GET['birthdate'];

            if (strlen($password) >= 8 && strlen($password) <= 15) {
                $bcrypt_options = [
                    'cost' => 12
                ];
                $password = password_hash($_GET['password'], PASSWORD_BCRYPT, $bcrypt_options);

                $conn = dbConfig();

                $result = $conn->query("SELECT (user) from users WHERE user = '$username'");
                if($result->num_rows <= 0) {
                    $result = $conn->query("INSERT INTO users VALUES('$username', '$password', '$surname', '$name', '$birthdate')");
                    if(is_bool($result))
                        if($result) {
                            echo "Account created";
                            header("Location: login.php");
                        } else
                            echo "Error while creating the account";
                }
                else
                    echo "Username already taken";
            }
            else
                echo "Password too weak or over 15 characters";
        }
    }
?>