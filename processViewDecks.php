<?php
require "ClassesAndDB.php";
$AllDecks = array();
$UserID;
if (!empty($_POST['ID']))
{
    $UserID = json_decode($_POST['ID']);   
    $getDecksQuery = sprintf("SELECT *
    FROM UserDecks
    WHERE UserID = '%d';", $UserID);
    $getDecks = mysql_query($getDecksQuery);
    While($decks = mysql_fetch_assoc($getDecks))
    {
        array_push($AllDecks, new Deck($decks['DeckName'],$decks['UserID'],$decks['UserDeckID'], "This Account"));

    }
    echo (json_encode($AllDecks));
}
else{ 
    $getDecksQuery = sprintf("SELECT *
    FROM UserDecks");
    $getDecks = mysql_query($getDecksQuery);
    While($decks = mysql_fetch_assoc($getDecks))
    {
        $getDeckUserNameQuery = sprintf("SELECT UserName 
        FROM Users
        WHERE UserID='%d'", $decks['UserID']);
        $getUserName = mysql_query($getDeckUserNameQuery);
        While($UserName = mysql_fetch_assoc($getUserName))
        {
            array_push($AllDecks, new Deck($decks['DeckName'],$decks['UserID'],$decks['UserDeckID'],$UserName['UserName']));
        }

    }
    echo (json_encode($AllDecks));
}
?>