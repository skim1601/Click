<?php 

// Start the session
session_start();

// If user is logged in, redirect to welcome page
if (isset($_SESSION["login"]) && $_SESSION["login"] === true){
    header("location: game.php");
    exit;
}
 
require_once "../config.php";
$username = "";
$password = "";
$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (strlen($_POST['username']) < 1 || strlen($_POST['password']) < 1){
        $alert = "Enter your username and password";
    } else {
        $stmt = $mysqli -> prepare("SELECT id, username, password FROM users WHERE username = ?");
        if ($stmt){
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);
            
            $stmt -> bind_param("s", $username);

            // Execute the statement
            if ($stmt -> execute()){
                $stmt -> store_result();
                
                // Check if username already exists
                if ($stmt -> num_rows == 1){                    
                    // Bind result variables
                    $stmt -> bind_result($id, $username, $hashed_password);

                    if ($stmt -> fetch()){
                        if (password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            $_SESSION['login'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;                                                      
                            
                            header("location: game.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $alert = "Invalid username or password";
                        }
                    }
                } else {
                    // Password is not valid, display a generic error message
                    $alert = "Invalid username or password";
                }
            } else {
                // Password is not valid, display a generic error message
                $alert = "Invalid username or password";
            }

            // Close statement
            $stmt -> close();
        }
    }
    $mysqli -> close();
}

?>
<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
            <link rel="icon" type="image/x-icon" href="../assets/images/logo.ico">
            <title>Click</title>
            <link rel="stylesheet" href="../global.css"/>
    </head>
    <body>
        <div class="wrapper">
            <h1 style="margin-top: 15vh;">Log In</h1>
            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" id="nam"/><br/><br/>
                <label>Password</label>
                <input type="password" name="password" id="id_1723"/><br/><br/><br/>
                <input class="my-button" type="submit" value="Log In" style="margin: 0 min(1vw, 1vh);"/>
                <a class="my-button" href="../index.html">Cancel</a><br/><br/><br/>
                <a href="./signup.php"><h6>Don't have an account? Sign Up</h6></a>
                <?php
                    if ($alert !== false){
                        echo('<p style="color: red;">'.$alert."</p>");
                    }
                ?>
            </form>
        </div>
    </body>
</html>
