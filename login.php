<?php
session_start();
require 'function/login.php';

if (isset($_SESSION['uid'])) {
    // Redirect to index.php if already logged in
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : false;

    // Sanitize user input
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Hash the password using md5 (not recommended for production use, consider using password_hash)
    $hashedPassword = md5($password);

    // Retrieve user from the database
    $query = "SELECT * FROM `user` WHERE `username`='$username' AND `password`='$hashedPassword'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // username found, set session variables
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $username;

        if ($remember) {
            // Create a remember me cookie
            $token = md5(uniqid(rand(), true));
            $expiry = time() + (60 * 60 * 24 * 30); // 30 days

            // Store the token in the database
            $query = "UPDATE `user` SET `token`='$token', `expiry`='$expiry' WHERE `username`='$username'";
            $conn->query($query);

            // Set the token as a cookie
            setcookie("remember_token", $token, $expiry);
        }

        header("Location: index.php");

        exit;
    } else {
        // Invalid username or password
        $error = "Invalid username or password.";
    }

    $conn->close();
}

if (isset($_POST["register"])) {
    if (adduser($_POST) > 0) {
        echo "<script>
        alert('Registration successful!');
        </script>";
    } else {
        echo "<script>
        alert('Registration Failed!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="frame">
            <div class="nav">
                <ul class="links">
                    <li class="signin-active"><a class="btn">Existing User</a></li>
                    <li class="signup-inactive"><a class="btn">New User</a></li>
                </ul>
            </div>
            <div ng-app ng-init="checked = false">
                <!-- Login -->
                <form class="form-signin" action="" method="post" name="form">
                    <label for="username">Username</label>
                    <input class="form-styling" type="text" name="username" placeholder="" required />
                    <label for="password">Password</label>
                    <input class="form-styling" type="password" name="password" placeholder="" required />
                    <input type="checkbox" id="checkbox" name="remember" />
                    <label for="checkbox"><span class="ui"></span>Keep me signed in</label>
                    <div>
                        <button name="login" class="btn-animate"><a class="btn-signin">Login to your account</a></button>
                    </div>
                </form>
                <!-- Register -->
                <form class="form-signup" action="" method="post" name="form">
                    <label for="username">Username</label>
                    <input class="form-styling" type="text" name="username" placeholder="" required />
                    <label for="email">Email</label>
                    <input class="form-styling" type="email" name="email" placeholder="" required />
                    <label for="password">Create password</label>
                    <input class="form-styling" type="password" name="password" placeholder="" required />
                    <button name="register" ng-click="checked = !checked" class="btn-signup"><a>REGISTER</a></button>
                </form>
                <div class="success">
                    <svg width="270" height="270" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60" id="check" ng-class="checked ? 'checked' : ''">
                        <path fill="#ffffff" d="M40.61,23.03L26.67,36.97L13.495,23.788c-1.146-1.147-1.359-2.936-0.504-4.314 c3.894-6.28,11.169-10.243,19.283-9.348c9.258,1.021,16.694,8.542,17.622,17.81c1.232,12.295-8.683,22.607-20.849,22.042 c-9.9-0.46-18.128-8.344-18.972-18.218c-0.292-3.416,0.276-6.673,1.51-9.578" />
                    </svg>
                    
                </div>
            </div>
            <div class="forgot"><a href="#">Forgot your password?</a></div>
        </div>
    </div>
    <script src="js/login.js"></script>
</body>

</html>