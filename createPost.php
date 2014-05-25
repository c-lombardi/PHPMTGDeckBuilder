<?php
require("ClassesAndDB.php");
$DeckID;
$UserID;
$Subject;
$Body;
if (isset($_POST['UserDeckID']))
	$DeckID = $_POST['UserDeckID'];

if (isset($_POST['UserID']))
	$UserID = $_POST['UserID'];

if (isset($_POST['Subject']))
	$Subject = mysql_real_escape_string($_POST['Subject']);

if (isset($_POST['Body']))
	$Body = mysql_real_escape_string($_POST['Body']);
if (!empty($_POST['UserDeckID']) && !empty($_POST['UserID']) && !empty($_POST['Subject']) && !empty($_POST['Body']))
{
	$addPostQuery = sprintf("INSERT INTO UserPosts (UserDeckID, UserID, Subject, Body)
	VALUES ('%d', '%d', '%s', '%s')", $DeckID, $UserID, $Subject, $Body);
	if(mysql_query($addPostQuery))
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
        die;
	}
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
die;
?>

