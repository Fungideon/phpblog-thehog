<?php
    include "classes/login.php";
    session_start();
    if(login($_SESSION["username"], $_SESSION["password"])){
        if(isset($_POST['knop'])){
            if (strlen(trim($_POST['bericht']))){
                $database->createBericht($_SESSION['username'], (htmlspecialchars($_POST['bericht'])));
                echo "<h1>BERICHT SUCCESVOL GEPLAATST</h1>";
                echo $_POST['bericht'];
                echo '<script type="text/javascript"> setTimeout(function(){window.location = "../"}, 4000) </script>';
                die();
            }else{
                $message = "Vul een bericht in om te sturen";
            }
            echo "<br>";
        }
        ?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
    <body>
        <h1><?php echo $message ?></h1>
        <a href="index.php">Terug naar Beginpagina</a><br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="berichtform">

            <textarea id="bericht" name="bericht" form="berichtform" style="width: 500px; height: 200px;"></textarea>
            <input type="submit" name="knop" value="versturen"">
        </form>
    </body>
</html>
<?php
    }else{
        header("Location: ../");
    }
?>