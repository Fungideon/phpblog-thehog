<?php
    include "classes/login.php";
    session_start();
    if(login($_SESSION["username"], $_SESSION["password"])){
        $loggedin = true;
    }else{
        $loggedin = false;
    }
    $user = $database->getUser($_SESSION['username']);
    if($user['idrol'] == "admin") {
        $isadmin = true;
    }else{
        $isdamin = false;
    }
    if($user['idrol'] == "moderator"){
        $ismoderator = true;
    }else{
        $ismoderator = false;
    }
    if(isset($_GET['page'])){
        $page = $_GET['page'] + 1;
    }
    ?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    </head>
    <body>
        <nav>

            <a href="index.php"><img src="hog.gif"></a>
            <?php
                if($loggedin){
                    echo "Hallo" . " ". $user['voornaam'] . " " . $user['tussenvoegsel'] . " " . $user['achternaam'];
                    echo "<a href=\"logout.php\">logout</a>";
                    echo "<a href=\"maakbericht.php\">bericht maken</a>";
                }else{
                    echo "<a href=\"login.php\">Login</a>";
                }
                if($isadmin){
                    echo "<a href=\"admin/admin.php\">Admin</a>";
                }
            ?>
        </nav>
        <div id="container" style="display: inline; width: 100%;">
        <?php
            $lastpostid;
            $highpostid;
            $posts;
            if(isset($_GET['lastpost'])){
                $berichten = $database->getBerichtenFromId($_GET['lastpost']);
                foreach($berichten as $bericht){
                    $berichtschrijver = $database->getUser($bericht['gebruikersnaam']);
                    echo "<div style=\"max-width: 560px; min-height: 250px; min-width: 150px; background-color: aqua\" id=\"bericht\">";
                    if($bericht['gebruikersnaam'] == $_SESSION['username'] ||
                        $isadmin || $ismoderator){
                        ?>
                        <div style="background-color: aliceblue;"><?php echo $bericht['berichtid'] . " Geschreven Door : " . $berichtschrijver['voornaam'] . " " . $berichtschrijver['tussenvoegsel'] . " " . $berichtschrijver['achternaam'] ?>
                            <form action="bewerkbericht.php" method="POST">
                                <input type="hidden" value="<?php echo $bericht['berichtid'] ?>" name="selectedbericht">
                                <a href="javascript:void(0);" onclick="$(this).closest('form').submit();">Bewerk Bericht</a>
                            </form>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div style="background-color: aliceblue"><?php echo $bericht['berichtid'] . " Geschreven Door : " . $berichtschrijver['voornaam'] . " " . $berichtschrijver['tussenvoegsel'] . " " . $berichtschrijver['achternaam'] ?></div>
                        <?php
                    }
                    $posts++;
                    ?>
                    <div><?php echo (nl2br($bericht['berichtinhoud'])); ?></div>
                    </div>
                    <?php
                        $lastpostid = $bericht['berichtid'];
                }
            }else{
                $berichten = $database->getAllBerichten();
                foreach($berichten as $bericht){
                    $berichtschrijver = $database->getUser($bericht['gebruikersnaam']);
                    echo "<div style=\"max-width: 560px; min-height: 250px; min-width: 150px; background-color: aqua\" id=\"bericht\">";
                    if($bericht['gebruikersnaam'] == $_SESSION['username'] ||
                    $isadmin || $ismoderator){
                        ?>
                        <div style="background-color: aliceblue;"><?php echo $bericht['berichtid'] . " Geschreven Door : " . $berichtschrijver['voornaam'] . " " . $berichtschrijver['tussenvoegsel'] . " " . $berichtschrijver['achternaam'] ?>
                            <form action="bewerkbericht.php" method="POST">
                                <input type="hidden" value="<?php echo $bericht['berichtid'] ?>" name="selectedbericht">
                                <a href="javascript:void(0);" onclick="$(this).closest('form').submit();">Bewerk Bericht</a>
                            </form>
                        </div>
                        <?php
                    }else {
                        ?>
                        <div style="background-color: aliceblue"><?php echo $bericht['berichtid'] . " Geschreven Door : " . $berichtschrijver['voornaam'] . " " . $berichtschrijver['tussenvoegsel'] . " " . $berichtschrijver['achternaam'] ?></div>
                    <?php
                    }
                    $posts++;
                    ?>
                        <div><?php echo (nl2br($bericht['berichtinhoud'])); ?></div>
                    </div>
                     <?php
                        $lastpostid = $bericht['berichtid'];
                }
            }
                    echo "</div>";
            if($posts == 10) {
                $berichtenleft = $database->getBerichtenFromId($lastpostid);
                if(!count($berichtenleft) < 1){
                    if (isset($_REQUEST['page'])) {
                        echo "<a href=\"index.php?page=$page&lastpost=$lastpostid\">next page</a>";
                    } else {
                        $page = 2;
                        echo "<a href=\"index.php?page=$page&lastpost=$lastpostid\">next page</a>";
                    }
                }
            }
        ?>
    </body>
</html>