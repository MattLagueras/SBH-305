<?php

include_once ("DBcon.php");
include_once("SessionManager.php");
include_once("PreparedQueryHelper.php");


class ManagerUtilites
{
	private $uid;
	private $queryhelper;
	


	function __construct($uid, $pageid) 
	{           
        $this->uid = $uid;
		$this->queryhelper = new PreparedQueryHelper();
    }
	/*
	function exampleFunction()
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$queryhelper = new PreparedQueryHelper();
		
		$queryhelper->beginTransaction($mysqli);
		
		$params = array("ii",$this->uid,$this->uid);
		
		$result = $queryhelper->executeStatement($mysqli,"YOUR QUERY HERE, USE ? FOR ARGUMENTS IN PARAMS EX: SELECT * FROM TABLE WHERE ID = ?",$params);
		
		$queryhelper->commitTransaction($mysqli);
		
		NOW YOU CAN RETURN THE RESULT OR ITERATE OVER THE ROWS LIKE THIS:
		
		while($row = $result->fetch_assoc())
		{
			// DO STUFF
		}
		
		
		
	}*/


?>