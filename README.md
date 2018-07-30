# XMMysqli
Simple PHP Mysqli Class

List of functions;

```php
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


/*
Update(
    $TableName, 
    $RequestArray,
    $Where, 
    $whereByID = true
);
*/


/*
Insert(
    $TableName, 
    $RequestArray
);
*/

/*
Mysqli Escape

CleanStr(
    $str
);
*/

/*
MultiSelect(
    $TableName,
    $Selection = "*",
    $Where = null,
    $whereByID = true, 
    $bIsAssoc = true
);
*/


/*
Select(
    $TableName,
    $Selection = "*",
    $Where = null,
    $whereByID = true,
    $bIsAssoc = true  //fecth or assoc
);
*/


/*
    Connect(        
    ); //no param
*/

/*
    Disconnect(        
    ); //no param
*/

/*
    DestroySelf(
    );
*/

/*
Truncate(
	$TableName
);
*/

```
