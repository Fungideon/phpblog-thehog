<?php
    if(isset($_POST['knop'])){
        if($_POST['inlognaam'] == ""){
            $message = "Fout: Controller of je alle benodigde vlakken hebt ingevult";
        }elseif($_POST['wachtwoord'] == ""){
            $message = "Fout: Controller of je alle benodigde vlakken hebt ingevult";
        }elseif($_POST['email'] == ""){
            $message = "Fout: Controller of je alle benodigde vlakken hebt ingevult";
        }elseif($_POST['voornaam'] == ""){
            $message = "Fout: Controller of je alle benodigde vlakken hebt ingevult";
        }elseif($_POST['achternaam'] == ""){
            $message = "Fout: Controller of je alle benodigde vlakken hebt ingevult";
        }else{
            include "classes/registreer.php";
            if(checkIfUsersExists($_POST["inlognaam"])){
                $message = "gebruiker/gebruikersnaam bestaat al";
            }else{
                if(strlen($_POST['inlognaam']) > 16){
                    $message = "Fout: Gebruikersnaam mag maximaal 16 tekens zijn";
                }elseif(strlen($_POST['wachtwoord']) > 18) {
                    $message = "Fout: Wachtwoord mag maximaal 18 tekens zijn";
                }elseif(strlen($_POST['email']) > 45){
                    $message = "Fout: Email mag maximaal 45 tekens zijn";
                }elseif(strlen($_POST['voornaam']) > 16){
                    $message = "Fout: Voornaam mag maximaal 16 tekens zijn";
                }elseif(strlen($_POST['tsvoegsel']) > 10){
                    $message = "Fout: Tussenvoegsel mag maximaal 10 tekens zijn";
                }elseif(strlen($_POST['achternaam']) > 20){
                    $message = "Fout: Achternaam mag maximaal 20 tekens zijn";
                }elseif(strlen($_POST['bedrijf']) > 20){
                    $message = "Fout: Bedrijf mag maximaal 20 tekens zijn";
                }else{
                    registreer($_POST['inlognaam'],
                        $_POST['wachtwoord'],
                        $_POST['email'],
                        $_POST['voornaam'],
                        $_POST['tsvoegsel'],
                        $_POST['achternaam'],
                        $_POST['bedrijf']);
                    header("Location: login.php?registratie=succesvol");
                }
            }
        }
    }
?>
<html>
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
    <input type="submit" name="knop" value="verstuur">
</form>
</body>
</html>
