<?php
// Initialize the session
session_start();
require_once "../config.php";

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
    header("location: login.php");
    exit;
}

$source = "";
$planet = "";
$remaining = "";
$score = ($mysqli -> query("SELECT score FROM users WHERE id = ".$_SESSION["id"]) -> fetch_array())['score'];

if (isset($_POST["increment_x"])){
    $mysqli -> query("UPDATE users SET score = score + 1 WHERE id = ".$_SESSION["id"]);
} 

if ($score < 30){
    $source = "../assets/images/Mercury.png";
    $planet = "Mercury";
    $remaining = (30 - $score)." left until Venus";
} else if ($score < 70){
    $source = "../assets/images/Venus.png";
    $planet = "Venus";
    $remaining = (70 - $score)." left until Earth";
} else if ($score < 200){
    $source = "../assets/images/Earth.png";
    $planet = "Earth";
    $remaining = (200 - $score)." left until Mars";
} else if ($score < 500){
    $source = "../assets/images/Mars.png";
    $planet = "Mars";
    $remaining = (500 - $score)." left until Ceres";
} else if ($score < 1000){
    $source = "../assets/images/Ceres.png";
    $planet = "Ceres";
    $remaining = (1000 - $score)." left until Jupiter";
} else if ($score < 3000){
    $source = "../assets/images/Jupiter.png";
    $planet = "Jupiter";
    $remaining = (3000 - $score)." left until Saturn";
} else if ($score < 10000){
    $source = "../assets/images/Saturn.png";
    $planet = "Saturn";
    $remaining = (10000 - $score)." left until Uranus";
} else if ($score < 20000){
    $source = "../assets/images/Uranus.png";
    $planet = "Uranus";
    $remaining = (50000 - $score)." left until Neptune";
} else if ($score < 50000){
    $source = "../assets/images/Neptune.png";
    $planet = "Neptune";
    $remaining = (50000 - $score)." left until Pluto";
} else if ($score < 100000){
    $source = "../assets/images/Pluto.png";
    $planet = "Pluto";
    $remaining = (100000 - $score)." left until Haumea";
} else if ($score < 200000){
    $source = "../assets/images/Haumea.png";
    $planet = "Haumea";
    $remaining = (200000 - $score)." left until Makemake";
} else if ($score < 500000){
    $source = "../assets/images/Makemake.png";
    $planet = "Makemake";
    $remaining = (500000 - $score)." left until Eris";
} else if ($score < 10000000){
    $source = "../assets/images/Eris.png";
    $planet = "Eris";
    $remaining = (10000000 - $score)." left until Proxima Centauri";
} else {
    $source = "../assets/images/Proxima-centauri.png";
    $planet = "Proxima Centauri";
    $remaining = "How did you get here?? (It is not a planet btw)";
}

?>

<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8"/>
            <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no"/>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="icon" type="image/x-icon" href="../assets/images/logo.ico">
            <title>Click</title>
            <link rel="stylesheet" href="../global.css"/>
            <style>
                input {
                    margin: auto; 
                    width: min(50vw, 20rem);
                    user-drag: none;
                    -webkit-user-drag: none;
                    user-select: none;
                    -moz-user-select: none;
                    -webkit-user-select: none;
                    -ms-user-select: none;
                }
                .links {
                    text-align: center; 
                    justify-content: center;
                    display: flex;
                    font-size: max(1vw, 2vh);
                    gap: 5vw;
                }
                a {
                    color: #fff;
                }
                @media screen and (max-width: 1000px){
                    .links {
                        display: grid;
                        gap: 1vw;
                    }
                }
                h1 {
                    font-size: min(10vw, 10vh);
                }
            </style>
    </head>
    <body>
        <div class="wrapper">
            <h1 style="margin-top: 5vh;"><?php echo($planet.".")?></h1>
            <iframe name="votar" style="display:none;"></iframe>
            <form method="POST">
                <?php echo("<input type='image' name='increment' id='increment' value='1' alt='Loading..' src='".$source."' /><br/>
                <h3 id='score'>$score</h3><h6 id='remaining'>$remaining</h6><br/>")?>
                <div class="links">
                    <a href="logout.php"><h6>Sign Out of Your Account</h6></a>
                    <a href="leaderboard.php"><h6>Leaderboard</h6></a>
                </div>      
            </form>
        </div>
    </body>
</html>