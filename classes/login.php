<?php
    include "dbconnect.php";
$database = new MysqlDb();
    function login($username, $password){
        global $database;
        $database = new MysqlDb();
        $resultaten = $database->checkUserPassword($username, $password);
        if((count($resultaten) == 1)){
            return true;
        }else {
            return false;
        }
    }