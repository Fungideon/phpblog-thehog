<?php
    include "../classes/login.php";
    session_start();
    if(login($_SESSION["username"], $_SESSION["password"])){
        $userrol = $database->getUser($_SESSION['username']);
        if($userrol['idrol'] == "admin") {
            ?>
            <html>
                <head>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
                </head>
                <body>
                <a href="../">Terug naar Beginpagina</a><br>
            <?php
            if(isset($_POST['zoeken'])){
                $resultaat = $database->searchUser($_POST['searchbox']);
                foreach($resultaat as $user){
                    ?>
                    <form action="edituser.php" method="POST">
                        <input type="hidden" value="<?php echo $user['gebruikersnaam'] ?>" name="selecteduser">
                        <a href="javascript:void(0);" onclick="$(this).closest('form').submit();"><?php echo $user['voornaam'] . " " . $user['tussenvoegsel'] . " " . $user['achternaam'] ?></a>
                    </form>
                    <?php
                }
            }
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    Zoek een gebruiker om te wijzigen <br>
                Voornaam <input type="text" name="searchbox">
                Achternaam <input type="text" name="searchbox">
                Gebruikersnaam <input type="text" name="searchbox">
                Woonplaats <input type="text" name="searchbox">
                Bedrijf <input type="text" name="searchbox">
                <!-- TODO: add input areas for better search results -->
                <input type="submit" name="zoeken" value="verstuur">
            </form>
        <?php
        }else{
            $index = $_SERVER['HTTP_HOST'];
            header("Location: ../");
        }
    }else{
        header("Location: ../");
    }
?>
                </body>
</html>
