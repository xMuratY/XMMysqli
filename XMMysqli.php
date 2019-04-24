<?php

Class XMMysqli{
	private $ShowErrors     = true;
	private $mysql_server   = '';
	private $mysql_username = '';
	private $mysql_password = '';
	private $mysql_database = '';
	private $XM_ERR_OK	= 1;
	private $XM_ERR		= 0;
	
	private $m_Charset = '';
	
	private $IsInit = false;
	private $IsConnected = false;	
	
	private $MysqliObject = null;
	
	function __construct(
	$mysql_server,
	$mysql_username,
	$mysql_password,
	$mysql_database,
	$mysql_connect = true,
	$ShowErrors = false,
	$m_Charset = "utf8") {
		$this->ShowErrors = $ShowErrors;
		$this->mysql_server = $mysql_server;
		$this->mysql_username = $mysql_username;
		$this->mysql_password = $mysql_password;
		$this->mysql_database = $mysql_database;
		$this->m_Charset = $m_Charset;
		if($mysql_connect == true)
		{
			if($this->Connect() === $this->XM_ERR)
			{
				if($ShowErrors)				die("XMMysqli::Connect() Failed!");
				else						return $this->XM_ERR;
			}
		}
	}
	function __destruct()
	{
		$this->Disconnect();
		if($this->ShowErrors == true)
			return "XMMysqli::DestroySelf() Called!";
		return $this->XM_ERR_OK;
	}
	function DestroySelf()
	{		
		$this->__destruct();		
	}
	function Disconnect()
	{		
		if($this->MysqliObject->ping())
			$this->MysqliObject->close();
	}
	function Connect(){
		$mysqli = new mysqli($this->mysql_server, $this->mysql_username, $this->mysql_password, $this->mysql_database);
		if ($mysqli->connect_errno) {
			$mysqli->close();
			if($this->ShowErrors == true)
			{
				echo "Error: Failed to make a MySQL connection, error: \n";
				echo "Errno: " . $mysqli->connect_errno . "\n";
				echo "Error: " . $mysqli->connect_error . "\n";
				return $this->XM_ERR; 
			}else
			{				
				return $this->XM_ERR;
			}
		}else
		{			
			@$mysqli->set_charset($this->m_Charset);
			$this->MysqliObject = $mysqli;
			return $this->XM_ERR_OK;
		}
  }	
  function ManualQuery($query)
  {
		if ($this->MysqliObject->query($query) === TRUE)
			return $this->XM_ERR_OK;
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::ManualQuery() Error Occurpued!";
		}
  }
	function Update($TableName, $RequestArray, $Where){
		$RequestStr = "UPDATE $TableName SET ";
		$countx = count($RequestArray);
		$ccount = 1;
		foreach ($RequestArray as $cKey => $cVal)
		{			
			$RequestStr .= $cKey . "='$cVal'";
			if($countx != $ccount)
				$RequestStr .= " ";
			$ccount++;
		}
		if($Where != null)
		{
			$cKey = key($Where);
			$cVal = $Where[$cKey];
			if(!is_string($cVal))
				$RequestStr .= " WHERE $cKey=$cVal";
			else				
				$RequestStr .= " WHERE $cKey='$cVal'";
		}
		if ($this->MysqliObject->query($RequestStr) === TRUE)
			return $this->XM_ERR_OK;
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::Update() Error Occurpued!";
		}
	}
	function Insert($TableName, $RequestArray){
		$RequestStr = "INSERT INTO $TableName (";
		$ReqKeyArr = array_keys($RequestArray);
		$ReqValArr = array_values($RequestArray);
		$countreq = count($ReqKeyArr);
		$countval = count($ReqValArr);
		$ccount = 1;
		foreach ($ReqKeyArr as $cKey)
		{			
			$RequestStr .= $cKey;
			if($countreq != $ccount)
				$RequestStr .= ",";
			$ccount++;
		}
		$RequestStr .= ") VALUES (";
		$ccount = 1;
		foreach ($ReqValArr as $cVal)
		{	
			$RequestStr .= "'$cVal'";
			if($countval != $ccount)
				$RequestStr .= ",";
			$ccount++;
		}
		$RequestStr .= ")";
		if ($this->MysqliObject->query($RequestStr) === TRUE)
			return $this->XM_ERR_OK;
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::Insert() Error Occurpued!";
		}
	}
	function Select($TableName, $Selection = "*", $Where = null, $bIsAssoc = true)
	{
		$RequestStr = "SELECT $Selection FROM $TableName";
		if($Where != null)
		{
			$cKey = key($Where);
			$cVal = $Where[$cKey];
			if(!is_string($cVal))
				$RequestStr .= " WHERE $cKey=$cVal";
			else
				$RequestStr .= " WHERE $cKey='$cVal'";
		}
		$result = $this->MysqliObject->query($RequestStr);
		if ($result->num_rows > 0)
			if($bIsAssoc)
				return $result->fetch_assoc();
			else
				return $result->fetch_row();
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::Select() No Results!";
		}
	}
	function MultiSelectManualQuery($TableName, $Selection, $Where)
	{
		$RequestStr = "SELECT $Selection FROM $TableName WHERE $Where";
		$result = $this->MysqliObject->query($RequestStr);
		if ($result->num_rows > 0)
		{
			$XMArray = array();
			while($row = $result->fetch_assoc()) {
				array_push($XMArray,$row);
			}
			return $XMArray;
		}
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::MultiSelect() No Results!";
		}
	}
	function MultiSelect($TableName, $Selection = "*", $Where = null, $bIsAssoc = true)
	{
		$RequestStr = "SELECT $Selection FROM $TableName";
		if($Where != null)
		{
			$cKey = key($Where);
			$cVal = $Where[$cKey];
            if(!is_string($cVal))
			    $RequestStr .= " WHERE $cKey=$cVal";
			else
				$RequestStr .= " WHERE $cKey='$cVal'";
		}
		$result = $this->MysqliObject->query($RequestStr);
		if ($result->num_rows > 0)
		{
			$XMArray = array();
			if($bIsAssoc)
			{
				while($row = $result->fetch_assoc()) {
					array_push($XMArray,$row);
				}
			}else
			{
				while($row = $result->fetch_row()) {					
					array_push($XMArray,$row);
				}
			}
			return $XMArray;
		}
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::MultiSelect() No Results!";
		}
	}
	function Delete($TableName, $Where)
	{
		$cKey = key($Where);
		$cVal = $Where[$cKey];
		$RequestStr = "";
		if(!is_string($cVal))
            $RequestStr .= "DELETE FROM $TableName WHERE $cKey=$cVal";
		else
			$RequestStr .= "DELETE FROM $TableName WHERE $cKey='$cVal'";
		if ($this->MysqliObject->query($RequestStr) === TRUE)
			return $this->XM_ERR_OK;		
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::Delete() Error Occurpued!";
		}
	}
	function Truncate($TableName)
	{
		$RequestStr = "TRUNCATE TABLE `$TableName`";
		if ($this->MysqliObject->query($RequestStr) === TRUE)
			return $this->XM_ERR_OK;		
		else
		{
			if(!$this->ShowErrors)
				return $this->XM_ERR;
			return "XMMysqli::Truncate() Error Occurpued!";
		}
	}
	function CleanStr($str)
	{
		return $this->MysqliObject->real_escape_string($str);
	}
}
 
?>
