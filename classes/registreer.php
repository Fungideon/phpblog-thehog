<?php
    include "dbconnect.php";
        $database = new MysqlDb();
    function checkIfUsersExists($gebruikersnaam)
    {
        global $database;
        $resultaten = $database->checkUsername($gebruikersnaam);
        if(count($resultaten) == 1) {
            return true;
        }else {
            return false;
        }

    }

    function registreer($gebruikersnaam, $wachtwoord, $email, $voornaam, $tussenvoegsel, $achternaam, $bedrijf)
    {
        global $database;
        $database->createUser($gebruikersnaam, $wachtwoord, $email, $voornaam, $tussenvoegsel, $achternaam, $bedrijf);
    }