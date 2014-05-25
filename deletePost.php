<?php
require("ClassesAndDB.php");
$PostID;
if (isset($_POST['UserPostID']))
	$PostID = json_decode($_POST['UserPostID']);
if (!empty($_POST['UserPostID']))
{
	$deletePostQuery = sprintf("DELETE FROM UserPosts
	WHERE UserPostID = '%d'", $PostID);
	if(mysql_query($deletePostQuery))
	{
		echo true;
        die;
	}
}
echo false;
die;
?>

