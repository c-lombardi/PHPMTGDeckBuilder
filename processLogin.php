<?php
if (!empty($_POST['UserName']))
{
	$username = mysql_real_escape_string($_POST['UserName']);
}
if (!empty($_POST['Password']))
{
	$password = mysql_real_escape_string($_POST['Password']);
}
if (!empty($_POST['Password']) && !empty($_POST['UserName']))
{
	$checkIfAdminQuery = sprintf("SELECT *
		FROM Users
		WHERE UserName = '%s'
		AND Password = '%s'
        AND RoleID = '%d'", $username, $password, 1);
	$checkIfAdmin = mysql_query($checkIfAdminQuery);
	while ($ifAdmin = mysql_fetch_assoc($checkIfAdmin))
	{
		$_SESSION['admin'] = true;
		$_SESSION['username'] = $ifAdmin['UserName'];
        $_SESSION['userID'] = $ifAdmin['UserID'];
		header('Location: index.php?action=deck');
		exit;	
	} 
	if (!$ifAdmin)
	{
		$checkIfRowExistsQuery = sprintf("SELECT *
		FROM Users
		WHERE Password = '%s' 
		AND UserName = '%s'
        AND RoleID = '%d'", $password, $username, 2);
		$checkIfRowExists = mysql_query($checkIfRowExistsQuery);
		while ($exists = mysql_fetch_assoc($checkIfRowExists))
		{
			$_SESSION['username'] = $exists['UserName'];
			$_SESSION['user'] = true;
            $_SESSION['userID'] = $exists['UserID'];
			header('Location: index.php?action=deck');
			exit;
		}
	}
}
header('Location: index.php?action=login');
exit;
?>

