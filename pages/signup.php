<?php 

require_once "../config.php";

$username = "";
$password = "";
$alert = "";

function isParameterEmpty(){
    return (strlen(trim($_POST['username'])) < 1 || strlen(trim($_POST['password'])) < 1 || strlen(trim($_POST['cpassword'])) < 1);
}

// Process the data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isParameterEmpty()){
        $alert = "Enter your username and password";
    } else if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))){
        $alert = "Username can only contain letters, numbers, and underscores"; 
    } else {
        if ($_POST['password'] == $_POST['cpassword']){  
            if (strlen(trim($_POST["password"])) >= 6){

                $stmt = $mysqli -> prepare("SELECT id FROM users WHERE username = ?");
                if ($stmt){
                    // Bind variables to the prepared statement as parameters
                    $stmt -> bind_param("s", trim($_POST["username"]));
                    
                    // Attempt to execute the prepared statement
                    if ($stmt -> execute()){
                        $stmt -> store_result();
                        
                        if($stmt -> num_rows == 1){
                            $alert = "This username is already taken.";
                        } else {
                            $username = trim($_POST["username"]);
                            $password = trim($_POST["password"]);

                            $stmt = $mysqli -> prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                            if ($stmt){
                                // Bind variables to the prepared statement as parameters
                                $stmt -> bind_param("ss", $username, password_hash($password, PASSWORD_DEFAULT));
                                if ($stmt -> execute()){
                                    // Redirect to login page
                                    header("location: login.php");
                                } else {
                                    $alert = "Oops! Something went wrong. Please try again later.";
                                }
                                // Close statement
                                $stmt -> close();
                            }
                        }
                    } else {
                        $alert = "Oops! Something went wrong. Please try again later.";
                    }
                    // Close connection
                    $mysqli -> close();
                }
            } else {
                $alert = "Username and password not accepted";
            }
        }
        else {
            $alert = "Passwords did not match";
        }
    }
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
            <style>
                .my-button {
                    margin: 0 min(1vw, 1vh);
                }
            </style>
    </head>
    <body>
        <div class="wrapper">
            <h1 style="margin-top: 15vh;">Sign Up</h1>
            <form method="POST">
                <label for="nam">Username</label>
                <input type="text" name="username" id="nam"/><br/><br/>
                <label for="id_1723">Password</label>
                <input type="password" name="password" id="id_1723"/><br/><br/>
                <label for="id_1723">Confirm Password</label>
                <input type="password" name="cpassword" id="id_1723"/><br/><br/><br/>
                <input class="my-button" type="submit" value="Sign Up" style="margin: 0 min(1vw, 1vh);"/>
                <a class="my-button" href="../index.html">Cancel</a><br/><br/><br/>
                <a href="./login.php"><h6>Already have an account? Log in</h6></a>
                <?php
                    if ($alert !== false){
                        echo('<p style="color: red;">'.$alert."</p><br/>");
                    }
                ?>
            </form>
        </div>
    </body>
</html>