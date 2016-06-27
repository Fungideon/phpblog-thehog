<?php
    include "classes/login.php";
    if($_GET['registratie'] === 'succesvol'){
        $message = "Registratie Succesvol";
    }
    if(isset($_POST["knop"])) {
        if(login($_POST["inlognaam"], $_POST["wachtwoord"])){
            session_start();
            $_SESSION["username"] = $_POST["inlognaam"];
            $_SESSION["password"] = $_POST["wachtwoord"];
            header("Location: index.php");
        }else {
            $message = "Verkeerde gerbruikersnaam / wachtwoord";
        }
    }
?>
<html>
    <body>
        <h1><?php echo $message; ?></h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            Inlognaam <input type="text" name="inlognaam" value="">
            Wachtwoord <input type="password" name="wachtwoord" value="">
            <input type="submit" name="knop" value="verstuur">
        </form>
    geen account? klik <a href="registratie.php">hier</a> om een account aan te maken.
    </body>
</html>