<?php
require("ClassesAndDB.php");
if (isset($_POST['DeckName']))
	$DeckName = mysql_real_escape_string($_POST['DeckName']);

if (!empty($_SESSION['userID']) && !empty($DeckName))
{
	$addDeckQuery = sprintf("INSERT INTO UserDecks (UserID,DeckName)
	VALUES ('%d','%s')", $_SESSION['userID'], $DeckName);
	if(mysql_query($addDeckQuery))
	{
		header('Location: /MTGDeckBuilder/index.php?action=viewDecks');
		die;
	}
}
header('Location: /MTGDeckBuilder/index.php?action=createDeck');
die;
?>

