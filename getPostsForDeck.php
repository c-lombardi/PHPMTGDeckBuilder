<?php
require "ClassesAndDB.php";
$AllPosts = array();
$DeckID;
if (!empty($_POST['DeckID']))
{
    $DeckID = json_decode($_POST['DeckID']);   
    $getPostsQuery = sprintf("SELECT *
    FROM UserPosts
    WHERE UserDeckID = '%d'", $DeckID);
    $getPosts = mysql_query($getPostsQuery);
    While($posts = mysql_fetch_assoc($getPosts))
    {
        $getUserNameQuery = sprintf("SELECT UserName
        FROM Users
        WHERE UserID = '%d'", $posts['UserID']);
        $getUserName = mysql_query($getUserNameQuery);
        While($UserName = mysql_fetch_assoc($getUserName))
        {
            array_push($AllPosts, new Post($UserName['UserName'],$posts['UserID'],$posts['UserDeckID'],$posts['Body'],$posts['Subject'],$posts['UserPostID'],$posts['DatePosted']));
        }
    }
    echo (json_encode($AllPosts));
}
?>