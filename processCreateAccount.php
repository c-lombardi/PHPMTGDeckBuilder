<?
require("ClassesAndDB.php");
if (isset($_POST['Password']))
	$LoginPassword = mysql_real_escape_string($_POST['Password']);
if (isset($_POST['UserName']))
	$UserName = mysql_real_escape_string($_POST['UserName']);

if (!empty($LoginPassword) && !empty($UserName))
{
	$checkIfAccountExistsQuery = sprintf("SELECT *
	FROM Users
	WHERE UserName = '%s'", $UserName);
	$checkIfAccount = mysql_query($checkIfAccountExistsQuery);
	while($exists = mysql_fetch_assoc($checkIfAccount))
	{
		header('Location: /MTGDeckBuilder/index.php?action=createAccount&error=ERROR:%20USERNAME%20OR%20EMAIL%20INFORMATION%20IS%20ALREADY%20TAKEN');
		die;
	}
	$addAccountQuery = sprintf("INSERT INTO Users (UserName, Password, RoleID)
	VALUES ('%s','%s','%d')",  $UserName,$LoginPassword, 2);
	if(mysql_query($addAccountQuery))
	{
		header('Location: /MTGDeckBuilder/index.php?action=login');
		die;
	}
}
header('Location: /MTGDeckBuilder/index.php?action=createAccount&error=ERROR:%20MISSING%20DATA%20ON%20CREATE%20ACCOUNT%20FORM');
 die;
?>