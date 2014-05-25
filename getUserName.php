<?php
    require "ClassesAndDB.php";
    if (isset($_POST['DeckID']))
    {
        $DeckID = json_decode($_POST['DeckID']);

        $getUserIDQuery = sprintf("SELECT UserID
        FROM UserDecks AS ud
        WHERE ud.UserDeckID = '%d'", $DeckID);
        $getUserID = mysql_query($getUserIDQuery);
        While($UserID = mysql_fetch_assoc($getUserID))
        {
            $getUserNameQuery = sprintf("SELECT UserName
        FROM Users AS u
        WHERE u.UserID = '%d'", $UserID['UserID']);
            $getUserName = mysql_query($getUserNameQuery);
            While ($UserName = mysql_fetch_assoc($getUserName))
            {
                echo (json_encode($UserName['UserName']));
            }
        }
    }
    echo false;
?>