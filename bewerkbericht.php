<?php
    include "classes/login.php";
    session_start();
    if(login($_SESSION['username'], $_SESSION['password'])){
        if(isset($_POST['selectedbericht'])){
            $resultaat = $database->getBericht($_POST['selectedbericht']);
            $currentuser = $database->getUser($_SESSION['username']);
            if($resultaat['gebruikersnaam'] == $_SESSION['username'] || $currentuser['idrol'] == 'admin' || $currentuser['idrol'] == 'moderator'){
                if(isset($_POST['knop'])){
                    if($_POST['knop'] == "wijzigen"){
                        if (strlen(trim($_POST['bericht']))){
                            $database->updateBericht((htmlspecialchars($_POST['bericht'])), $_POST['selectedbericht']);
                            echo "<h1>BERICHT SUCCESVOL GEWIJZIGD</h1>";
                            echo $_POST['bericht'];
                            echo '<script type="text/javascript"> setTimeout(function(){window.location = "../"}, 4000) </script>';
                            die();
                        }else{
                            $message = "vul gegevens in";
                        }
                    }elseif($_POST['knop'] == "verwijderbericht"){
                        $database->deleteBericht($_POST['selectedbericht']);
                        echo "<h1>BERICHT VERWIJDERD</h1>";
                        echo '<script type="text/javascript"> setTimeout(function(){window.location = "../"}, 4000) </script>';
                        die();
                    }
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
                    <input type="hidden" name="selectedbericht" value="<?php echo $_POST['selectedbericht']; ?>">
                    <textarea id="bericht" name="bericht" form="berichtform" style="width: 500px; height: 200px;"><?php echo $resultaat['berichtinhoud']; ?></textarea><br>
                    <input type="submit" name="knop" value="wijzigen">
                    <input type="submit" name="knop" value="verwijderbericht">
                </form>
                </body>
                </html>
                <?php
            }else{
                header("Location: ../");
            }
        }else{
            header("Location: ../");
        }
    }else{
    header("Location: ../");
}