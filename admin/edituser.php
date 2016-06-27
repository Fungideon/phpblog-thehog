<?php
    include "../classes/login.php";
    session_start();
    if(login($_SESSION["username"], $_SESSION["password"])){
    $userrol = $database->getUser($_SESSION['username']);
    if($userrol['idrol'] == "admin") {
        if (isset($_POST['selecteduser'])) {
            if($_POST['selecteduser'] == null){
                header("Location: ../");
            }else{
                // TODO: allow the admin to edit users. need to look into what kind of data.
                ?>
<html>
    <head>
    </head>
<body>
    <h1><?php echo $message; ?></h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        Gebruikersnaam* <input type="text" name="inlognaam" value=""><br>
        Wachtwoord* <input type="password" name="wachtwoord" value=""><br>
        email* <input type="text" name="email" value=""><br>
        voornaam* <input type="text" name="voornaam" value=""><br>
        tussenvoegsel <input type="text" name="tsvoegsel" value=""><br>
        achternaam* <input type="text" name="achternaam" value=""><br>
        bedrijf <input type="text" name="bedrijf" value=""><br>
        woonplaats* <input type="text" name="woonplaats" value=""><br>
        <input type="submit" name="knop" value="verstuur">
    </form>
</body>
</html>
        <?php
            }
        }else{
            header("Location: ../");
        }
    }else{
        header("Location: ../");}
    }