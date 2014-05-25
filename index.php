<?php
session_start();

$serverName = 'localhost:3306';
$userName = 'student5';
$password = 'qqqqqq6';
$databaseName = 'student5_MTG';
$connection = mysql_connect($serverName, $userName, $password) or die (mysql_error());
$database = mysql_select_db($databaseName, $connection);

$user = false;
if (isset($_SESSION['user']))
{
	$user = true;
}
$admin = false;	
if (isset($_SESSION['admin']))
{
	$admin = true;	
}
ob_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
if (!empty($_GET['action']))
{
	$page = $_GET['action'];
}
else
{
	$page = "deck";
}
?>
<html>
<head>
    <title>Christopher Lombardi's MTG Deck Builder</title>
    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/knockout-min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.min.js"></script>
    <script src="http://momentjs.com/downloads/moment-with-langs.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="http://bootswatch.com/yeti/bootstrap.min.css" />
    <style>
        form {
            margin-bottom: 0px !important;
            margin: 0px !important;
        }
    </style>
</head>
<body>
    <div id="frame">
        <div id="page">
            <div class="page-header">
                <h1>
                    <?php
                    echo strtoupper("<h1 style='text-align:center'><b>Christopher Lombardi's MTG Deck Builder</b></div>");
                    ?>
                </h1>
            </div>
            <?php
            if(!empty($_SESSION['user']) || !empty($_SESSION['admin']))
            {
                echo "<span class='label label-primary' style='margin-bottom:10px;font-size:x-large;'>Hello ".$_SESSION['username']."</span><br />";	
            }
            ?>
            <div class="container" style="text-align:center;">
                    <?php
                    if ($admin)
                    {
                    ?>

                    <?php
                    }
                    if ($user)
                    {
                    ?>
                    <button class="btn btn-default" type=button onclick="window.location='index.php?action=createDeck'">Create Deck</button>
                    <button class="btn btn-default" type=button  onclick="window.location='index.php?action=viewDecks'">View Your Decks</button>
                    <?php
                    }
                    if (!$user && !$admin)
                    {
                    ?>
                    <button class="btn btn-default" type=button onclick="window.location='index.php?action=login'">Login</button>
                    <button class="btn btn-default" type=button onclick="window.location='index.php?action=createAccount'">Create Account</button>
                    <?php
                    }
                    ?>
                    <button class="btn btn-default" type=button onclick="window.location='index.php?action=viewAllDecks'">View All Decks</button>
                    <button class="btn btn-default" type=button onclick="window.location='index.php?action=deck'">Browse Cards</button>
                    <?php
                    if ($user || $admin)
                    {
                    ?>
                    <button type='button' class="btn btn-default" onclick="logout();">Log Out</button>
                <?php
                    }
                ?>
            </div>
        <hr>
        <div id="Title" style="text-align:center; font-size:xx-large" >
            <?php
            echo strtoupper($page);
            ?>
        </div>
        <div id="page" class="container-fluid">
            <?php

            /*  Why not just add a .php to the action? */

            switch ($page) {
                case "deck":
                    require "deck.php";
                    break;
                case "addCardsToDeck":
                    if($user)
                        require "deck.php";
                    break;
                case "login":
                    if(!$user && !$admin)
                        require "login.php";
                    break;
                case "createAccount":
                    if(!$user && !$admin)
                        require "createAccount.php";
                    break;
                case "processLogin":
                    if(!$user && !$admin)
                        require "processLogin.php";
                    break;
                case "logOut":
                    if($user || $admin)
                        require "logOut.php";
                    break;
                case "viewDecks":
                    require "viewDecks.php";
                    break;
                case "viewAllDecks":
                    require "viewDecks.php";
                    break;
                case "processCreateAccount":
                    if(!$user && !$admin)
                        require "processCreateAccount.php";
                    break;
                case "createDeck":
                    if($user)
                        require "createDeck.php";
                    break;
                case "processCreateDeck":
                    if($user)
                        require "processCreateDeck.php";
                    break;
                default:
                    break;
            }
            ?>

        </div>
        <hr>
        <div id="footer">All Magic Cards listed on this site are registered trademarks of Wizards of the Coast.</div>

        </div>
    </div>
</body>
</html>
<script>
    function logout() {
        $.ajax({
            url: "index.php?action=logOut",
            type: "POST",
            success: function () {
                window.location="index.php?action=login";
            },
        });
    };
</script>
