<?php
class Card
{
    public $CardID;
    public $Name;
    public $Toughness;
    public $Power;
    public $Loyalty;
    public $RarityID;
    public $Costs;
    public $Rule;
    public $Ability;
    public $SetID;
    public function __construct($cID, $n, $t, $p, $l, $r, $c, $ru, $a, $s){
        $this->CardID = $cID;
        $this->Name = $n;
        $this->Toughness = $t;
        $this->Power = $p;
        $this->Loyalty = $l;
        $this->RarityID = $r;
        $this->Costs = $c;
        $this->Rule = $ru;
        $this->Ability = $a;
        $this->SetID = $s;
    }
    public function jsonSerialize() {
        $arr = array();
        // Represent your object using a nested array or stdClass,
        // in the way you want it arranged in your API
        $returnVal = array();
        $arr ['CardID'] = $this->CardID;
        $arr ['Name'] = $this->Name;
        $arr ['Toughness'] = $this->Toughness;
        $arr ['Power'] = $this->Power;
        $arr ['Loyalty'] = $this->Loyalty;
        $arr ['RarityID'] = $this->RarityID;
        $arr ['Costs'] = $this->Costs;
        $arr ['Rule'] = $this->Rule;
        $arr ['Ability'] = $this->Ability;
        $arr ['SetID'] = $this->SetID;
        
        $returnVal ['Card'] = $arr;
        
        return $returnVal;
    }
    public function getCard ()
    {
        return $this;
    }
}
class Deck
{
    public $DeckName;
    public $UserDeckID;
    public $UserID;
    public $UserName;
    public function __construct($name, $userID, $udID, $un)
    {
        $this->DeckName = $name;
        $this->UserID = $userID;
        $this->UserDeckID = $udID;
        $this->UserName = $un;
    }
    public function jsonSerialize() {
        $arr = array();
        // Represent your object using a nested array or stdClass,
        // in the way you want it arranged in your API
        $returnVal = array();
        $arr ['DeckName'] = $this->DeckName;
        $arr ['UserID'] = $this->UserID;
        $arr ['UserDeckID'] = $this->UserDeckID;
        $arr ['UserName'] = $this->UserName;
        $returnVal ['Deck'] = $arr;
        
        return $returnVal;
    }
}
class Post
{
    public $UserName;
    public $UserID;
    public $UserDeckID;
    public $Body;
    public $Subject;
    public $UserPostID;
    public $DatePosted;
    
    public function __construct($un, $UID, $udID, $b, $s, $upID, $dp)
    {
        $this->UserName = $un;
        $this->UserID = $UID;
        $this->UserDeckID = $udID;
        $this->Body = $b;
        $this->Subject = $s;
        $this->UserPostID = $upID;
        $this->DatePosted = $dp;
    }
    public function jsonSerialize() {
        $arr = array();
        // Represent your object using a nested array or stdClass,
        // in the way you want it arranged in your API
        $returnVal = array();
        $arr ['UserName'] = $this->UserName;
        $arr ['UserID'] = $this->UserID;
        $arr ['UserDeckID'] = $this->UserDeckID;
        $arr ['Body'] = $this->Body;
        $arr ['Subject'] = $this->Subject;
        $arr ['UserPostID'] = $this->UserPostID;
        $arr ['DatePosted'] = $this->DatePosted;
        
        $returnVal ['Post'] = $arr;
        
        return $returnVal;
    }
}
$serverName = 'localhost:3306';
$userName = 'student5';
$password = 'qqqqqq6';
$databaseName = 'student5_MTG';
$connection = mysql_connect($serverName, $userName, $password) or die (mysql_error());
$database = mysql_select_db($databaseName, $connection);
?>