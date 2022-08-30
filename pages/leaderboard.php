<?php
// Initialize the session
session_start();
require_once "../config.php";

function getPlanet($score){
    if ($score < 30){
        return "Mercury";
    } else if ($score < 70){
        return "Venus";
    } else if ($score < 200){
        return "Earth";
    } else if ($score < 500){
        return "Mars";
    } else if ($score < 1000){      
        return "Ceres";
    } else if ($score < 3000){
        return "Jupiter";
    } else if ($score < 10000){
        return "Saturn";
    } else if ($score < 20000){
        return "Uranus";
    } else if ($score < 50000){
        return "Neptune";
    } else if ($score < 100000){
        return "Pluto";
    } else if ($score < 200000){
        return "Haumea";
    } else if ($score < 500000){
        return "Makemake";
    } else if ($score < 10000000){
        return "Eris";
    } else {
        return "Proxima Centauri";
    }
}

$result = $mysqli -> query("SELECT username, score FROM users ORDER BY score DESC LIMIT 10");
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
            <form method="POST">
                    <h2>Leaderboard</h2>
                    <?php
                        // Display leaderboard
                        for ($i = 1; $i <= $result -> num_rows; $i++){
                            $row = $result -> fetch_array();
                            echo "<h6>".$i.". ".$row['username'].": ".$row['score']." --- ".getPlanet($row['score'])."</h6>";
                        }
                    ?>
                    <a href="game.php"><h6>Back to game</h6></a>
            </form>
        </div>
    </body>
</html>