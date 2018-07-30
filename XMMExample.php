<?php

require("XMMysqli.php");

$dbserver = "datebasehost.com";
$dbuser = "dbusername";
$dbpass = "dbpass";
$dbname = "datebasename";

/*
Init construct

XMMysqli(
	$mysql_server,
	$mysql_username,
	$mysql_password,
	$mysql_datebase,
	$mysql_connect = true,
	$ShowErrors = true
);
*/

$XMMysqliHelper = new XMMysqli($dbserver,$dbuser,$dbpass,$dbname, false, false);

/*
    Connect(        
    ); //no param
*/

$XMMysqliHelper->Connect();    

/*
Select(
    $TableName,
    $Selection = "*",
    $Where = null,
    $whereByID = true,
    $bIsAssoc = true  //fecth or assoc
);
*/

$XMObj = $XMMysqliHelper->Select("users","*",array("id" => $uid)); //select by id

$XMObj = $XMMysqliHelper->Select("users","*",array("username" => "XMaze"), false); //select by name

/*
MultiSelect(
    $TableName,
    $Selection = "*",
    $Where = null,
    $whereByID = true, 
    $bIsAssoc = true
);
*/

$XMObjArray = $XMMysqliHelper->MultiSelect("users","*",array("point" => 100));

$XMObjArray = $XMMysqliHelper->MultiSelect("users","*",array("language" => "TR"), false);

$XMObjArray = $XMMysqliHelper->MultiSelect("users","*");

/*
Delete(
    $TableName,
    $Where, 
    $whereByID = true
);
*/

$XMObjArray = $XMMysqliHelper->Delete("users",array("id" => 10));

$XMObjArray = $XMMysqliHelper->Delete("users",array("username" => "XMaze"), false);

/*
Mysqli Escape

CleanStr(
    $str
);
*/

$XMMysqliHelper->CleanStr("'!+^'!a_+!d^%?");

/*
Insert(
    $TableName, 
    $RequestArray
);
*/

$XMMysqliHelper->Insert("users",array("id" => 10,"username" => "XMaze", "language" => "TR", "point" => 999));

/*
Update(
    $TableName, 
    $RequestArray,
    $Where, 
    $whereByID = true
);
*/

$XMMysqliHelper->Update("users", array("language" => "EN", "point" => 100000), array("username" => "XMaze"), false);

$XMMysqliHelper->Update("users", array("language" => "EN", "point" => 100000), array("id" => 10));

/*
Truncate(
	$TableName
);
*/

$XMMysqliHelper->Truncate("users");

/*
    DestroySelf(
    );	//no param
*/

$XMMysqliHelper->DestroySelf();
 

/*
    Disconnect(
    );	//no param
*/

$XMMysqliHelper->Disconnect();

?> 
