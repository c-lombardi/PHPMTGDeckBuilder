<?php
require "ClassesAndDB.php";
$AllCards = array();
if (isset($_POST['DeckID']))
{
    $DeckID = json_decode($_POST['DeckID']);

    $getCardsQuery = sprintf("SELECT * 
        FROM Cards AS c
        INNER JOIN Decks AS d
        WHERE c.CardID = d.CardID
        AND d.UserDeckID = '%d'", $DeckID);
    $getCards = mysql_query($getCardsQuery);
    While($cards = mysql_fetch_assoc($getCards))
    {
        $GetSetNameQuery = sprintf("SELECT SetName
        FROM Sets
        WHERE SetID = '%d'", $cards['SetID']);
        $getSetName = mysql_query($GetSetNameQuery);
        While($SetName = mysql_fetch_assoc($getSetName))
        {
            array_push($AllCards, new Card($cards['CardID'],$cards['Name'],$cards['Toughness'],$cards['Power'],$cards['Loyalty'],$cards['RarityID'],$cards['Costs'],$cards['Rule'],$cards['Ability'],$SetName['SetName']));
        }
    }
    echo (json_encode($AllCards));
}
else
{
    $getCardsQuery = sprintf("SELECT * 
        FROM Cards");
    $getCards = mysql_query($getCardsQuery);
    While($cards = mysql_fetch_assoc($getCards))
    {
        $GetSetNameQuery = sprintf("SELECT SetName
        FROM Sets
        WHERE SetID = '%d'", $cards['SetID']);
        $getSetName = mysql_query($GetSetNameQuery);
        While($SetName = mysql_fetch_assoc($getSetName))
        {
            array_push($AllCards, new Card($cards['CardID'],$cards['Name'],$cards['Toughness'],$cards['Power'],$cards['Loyalty'],$cards['RarityID'],$cards['Costs'],$cards['Rule'],$cards['Ability'],$SetName['SetName']));
        }
    }
    echo (json_encode($AllCards));
}
?>