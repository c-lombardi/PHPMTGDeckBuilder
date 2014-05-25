<?php
require("ClassesAndDB.php");
if (isset($_POST['UserDeckID']))
	$DeckID = json_decode($_POST['UserDeckID']);

if (!empty($_POST['UserDeckID']))
{
	$removeDeckQuery = sprintf("DELETE FROM UserDecks
	WHERE UserDeckID = '%d'", $DeckID);
	if(mysql_query($removeDeckQuery))
	{
		echo true;
		die;
	}
}
echo false;
die;
?>