<?php


include_once ("CustomerUtilites.php");


class Navbar
{
	private $uid;
	private $activetab;


	function __construct($uid, $activetab)
	{           
        $this->uid = $uid;
		$this->activetab = $activetab;
    }
	

	
	function echoNav()
	{
		
		
		$utilites = new CustomerUtilites($this->uid,-1);
		$utilites->echoNav($this->activetab);
		
		
	
	}

}


?>