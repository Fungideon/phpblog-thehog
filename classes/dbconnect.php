<?php
    interface Database {
        function getUsers();
        function checkUsername($gebruikersnaam);
        function checkUserPassword($gebruikersnaam, $wachtwoord);
        function createUser($gebruikersnaam, $wachtwoord, $email, $voornaam, $tussenvoegsel, $achternaam, $bedrijf);
        function getUser($gebruikersnaam);
        function searchUser($keyword);
        function getAllBerichten();
        function getBerichtenFromId($postid);
        function getBericht($berichtid);
        function createBericht($gebruikersnaam, $bericht);
        function updateBericht($bericht, $berichtid);
        function deleteBericht($berichtid);
    }

    class MysqlDb implements Database{

        var $stat = 'development';
        var $dbh;

        function __construct()
        {
            if ($this->stat == 'deployment') {
                $host = getenv('OPENSHIFT_MYSQL_DB_HOST');
                $port = getenv('OPENSHIFT_MYSQL_DB_PORT');
                $user = '';
                $pass = '';
                $db = 'php';

                try {
                    $this->dbh = new PDO('mysql:host='.$host.';dbname='.$db.';port='.$port , $user, $pass);
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
            } else if ($this->stat == 'development') {
                $host = 'localhost';
                $port = '3306';
                $user = 'root';
                $pass = 'toor';
                $db = 'blog';

                try {
                    $this->dbh = new PDO('mysql:host='.$host.';dbname='.$db.';port='.$port , $user, $pass);
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
            } else {
                echo "Error, stat is onbekend";
            }
        }

        function getUsers()
        {
            $gebruikers = ($this->dbh->query('SELECT gebruikersnaam, wachtwoord, idrol from gebruiker'));
            return $gebruikers;
        }

        function checkUsername($gebruikersnaam)
        {
            $stmt = $this->dbh->prepare('select gebruikersnaam from gebruiker where gebruikersnaam = :gebruikersnaam');
            $stmt->execute(array(':gebruikersnaam' => $gebruikersnaam));
            $resultaten = $stmt->fetchAll();
            return $resultaten;
        }

        function checkUserPassword($gebruikersnaam, $wachtwoord)
        {
            $stmttext = "select gebruikersnaam, wachtwoord from gebruiker where gebruikersnaam = :gebruikersnaam and wachtwoord = :wachtwoord";
            $stmt = $this->dbh->prepare($stmttext);
            $stmt->execute(array(':gebruikersnaam' => $gebruikersnaam, ':wachtwoord' => $wachtwoord));
            $resultaten = $stmt->fetchAll();
            return $resultaten;
        }

        function createUser($gebruikersnaam, $wachtwoord, $email, $voornaam, $tussenvoegsel, $achternaam, $bedrijf)
        {
            $stmttext = "INSERT INTO `blog`.`gebruiker` (`gebruikersnaam`, `wachtwoord`, `email`, `voornaam`, `tussenvoegsel`, `achternaam`, `bedrijf`) 
values (:gebruikersnaam, :wachtwoord, :email, :voornaam, :tussenvoegsel, :achternaam, :bedrijf)";
            $stmt = $this->dbh->prepare($stmttext);
            $stmt->execute(array(':gebruikersnaam' => $gebruikersnaam, ':wachtwoord' => $wachtwoord, ':email' => $email, ':voornaam' => $voornaam, ':tussenvoegsel' => $tussenvoegsel,
                    ':achternaam' => $achternaam, ':bedrijf' => $bedrijf));
        }

        function getUser($gebruikersnaam)
        {
            $stmttext = "select gebruikersnaam, idrol, email, voornaam, tussenvoegsel, achternaam, bedrijf from gebruiker where gebruikersnaam = :gebruikersnaam";
            $stmt = $this->dbh->prepare($stmttext);
            $stmt->execute(array(':gebruikersnaam' => $gebruikersnaam));
            $resultaten = $stmt->fetch();
            return $resultaten;
        }

        function searchUser($keyword)
        {
            // TODO: change query to a more accurate version
            $stmttext = "select gebruikersnaam, email, voornaam, tussenvoegsel, achternaam, bedrijf from gebruiker where gebruikersnaam like :keyword or email like :keyword
or voornaam like :keyword or tussenvoegsel like :keyword or achternaam like :keyword or bedrijf like :keyword";
            $stmt = $this->dbh->prepare($stmttext);
            $stmt->execute(array(':keyword' => "%" . $keyword . "%" ));
            $resultaten = $stmt->fetchAll();
            return $resultaten;
        }

        function getAllBerichten()
        {
            //$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $stmt = $this->dbh->prepare('select berichtid, gebruikersnaam, berichtinhoud from bericht order by berichtid desc limit 10');
            $stmt->execute();
            $resultaten = $stmt->fetchAll();
            //print_r($stmt->errorInfo());
            return $resultaten;
        }

        function getBerichtenFromId($postid)
        {
            $stmt = $this->dbh->prepare('select berichtid, gebruikersnaam, berichtinhoud from bericht where berichtid < :postid order by berichtid desc limit 10');
            $stmt->execute(array(':postid' => $postid));
            $resultaten = $stmt->fetchAll();
            return $resultaten;
        }

        function createBericht($gebruikersnaam, $bericht)
        {
            $stmt = $this->dbh->prepare('INSERT INTO `blog`.`bericht` (`gebruikersnaam`, `berichtinhoud`) values (:gebruikersnaam, :bericht)');
            $stmt->execute(array(':gebruikersnaam' => $gebruikersnaam, ':bericht' => $bericht));
        }

        function updateBericht($bericht, $berichtid)
        {
            //$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $stmt = $this->dbh->prepare('UPDATE `blog`.`bericht` SET berichtinhoud=:bericht WHERE berichtid=:berichtid');
            $stmt->execute(array(':bericht' => $bericht, ':berichtid' => $berichtid));
            //print_r($stmt->errorInfo());
        }

        function getBericht($berichtid)
        {
            //$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $stmt = $this->dbh->prepare('select berichtid, gebruikersnaam, berichtinhoud from bericht where berichtid = :berichtid');
            $stmt->execute(array(':berichtid' => $berichtid));
            $resultaten = $stmt->fetch();
            //print_r($stmt->errorInfo());
            return $resultaten;
        }

        function deleteBericht($berichtid)
        {
            //$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $stmt = $this->dbh->prepare('DELETE FROM `blog`.`bericht` WHERE berichtid=:berichtid');
            $stmt->execute(array(':berichtid' => $berichtid));
            //print_r($stmt->errorInfo());
        }
    }
?>