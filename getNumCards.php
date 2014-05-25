<?php
require "ClassesAndDB.php";

$cardCount = PerformQuery("SELECT COUNT(*) 
    FROM Cards");
echo (json_encode($cardCount));
?>