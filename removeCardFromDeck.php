<?php
require("ClassesAndDB.php");
if (isset($_POST['UserDeckID']))
	$DeckID = json_decode($_POST['UserDeckID']);
if (isset($_POST['UserID']))
    $UserID = json_decode($_POST['UserID']);
if (isset($_POST['CardID']))
    $CardID = json_decode($_POST['CardID']);
if (!empty($_POST['UserDeckID']) && !empty($_POST['UserID']) && !empty($_POST['CardID']) )
{
    $checkIfUserOwnsDeckQuery = sprintf("SELECT UserID
    FROM UserDecks
    WHERE UserDeckID = '%d'", $DeckID);
    $checkIfUserOwnsDeck = mysql_query($checkIfUserOwnsDeckQuery);
    while($exists = mysql_fetch_assoc($checkIfUserOwnsDeck))
    {
        if ($exists['UserID'] == $UserID)
        {
            $removeCardFromDeckQuery = sprintf("DELETE FROM Decks
	        WHERE UserDeckID = '%d'
            AND CardID = '%d'
            LIMIT 1", $DeckID, $CardID);
	        if(mysql_query($removeCardFromDeckQuery))
	        {
		        echo true;
		        die;
	        }
        }
    }
}
echo false;
die;
?>