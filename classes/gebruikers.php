<?php

/**
 * Created by PhpStorm.
 * User: haged
 * Date: 25-5-2016
 * Time: 16:02
 */
class gebruikers
{
    var $username;
    var $password;
    var $voornaam;
    var $tussenvoegsel;
    var $achternaam;
    var $company;
    var $woonplaats;
    var $email;
    var $userlevel;

    function __construct($username, $password, $voornaam, $tussenvoegsel, $achternaam, $company, $woonplaats, $email, $userlevel)
    {
        $this->username = $username;
        $this->password = $password;
        $this->voornaam = $voornaam;
        $this->tussenvoegsel = $tussenvoegsel;
        $this->userlevel = 1;
    }

}