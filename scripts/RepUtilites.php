<?php

include_once ("DBcon.php");
include_once("SessionManager.php");
include_once("PreparedQueryHelper.php");

class RepUtilites
{

	private $uid;
	private $queryhelper;
	


	function __construct($uid) 
	{           
        $this->uid = $uid;
		$this->queryhelper = new PreparedQueryHelper();
    }
	
	function getAdvertisementTypes()
	{
		
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
			
		$result = $mysqli->query("SELECT * FROM type");
												 
		$this->queryhelper->commitTransaction($mysqli);
			
		return $result;
		
	}
	
	function getCustomerRecord($custid)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		

		$params = array("s",$custid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE idcustomer = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		
		return $result->fetch_assoc();
	}
	
	function getCustomerList()
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$this->queryhelper->beginTransaction($mysqli);
			
		$result = $mysqli->query("SELECT * FROM customer");
												 
		$this->queryhelper->commitTransaction($mysqli);
			
		return $result;
		
	}
	
	
	function createAdvertisement($name,$company,$imgloc,$description,$unitprice,$unitsleft,$type)
	{
		
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		

		
		date_default_timezone_set('America/New_York');
		
		$date = date('Y-m-d', time());
		
		$params = array("sssssdiii",$date,$name,$company,$imgloc,$description,$unitprice,$unitsleft,$type,$this->uid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		
		$result = $this->queryhelper->executeStatement($mysqli,"INSERT INTO advertisement (date,itemname,company,imgloc,content,unitprice,unitsleft,typefkey,repfkey) VALUES (?,?,?,?,?,?,?,?,?)",$params);
		
		
		$this->queryhelper->commitTransaction($mysqli);
	
	}
	
	function checkUniqueUsername($user)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		

		
		$params = array("s",$user);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE username = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		$rowcount = mysqli_num_rows($result);
		
		return $rowcount;
		
		
		
		
	}
	
	function checkUniqueEmail($email)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		

		
		$params = array("s",$email);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customer WHERE email = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		$rowcount = mysqli_num_rows($result);
		
		return $rowcount;
		
		
	}
	
	function createCustomer($firstname,$lastname,$email,$username,$password,$gender,$birthdate,$address,$city,$state,$zip,$phone)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$params = array("ssssssssssii",$firstname,$lastname,$email,$username,$password,$gender,$birthdate,$address,$city,$state,$zip,$phone);
		
		$result = $this->queryhelper->executeStatement($mysqli,"INSERT INTO customer (firstname,lastname,email,username,password,gender,birthdate,address,city,state,zip,telephone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
		
	}
	
	function editCustomer($firstname,$lastname,$email,$username,$password,$gender,$birthdate,$address,$city,$state,$zip,$phone,$idcustomer)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$params = array("ssssssssssiii",$firstname,$lastname,$email,$username,$password,$gender,$birthdate,$address,$city,$state,$zip,$phone,$idcustomer);
		
		$result = $this->queryhelper->executeStatement($mysqli,"UPDATE customer SET firstname = ? , lastname = ? , email = ? , username = ? , password = ? , gender = ? , birthdate = ? , address = ? , city = ? , state = ? , zip = ? , telephone = ? WHERE idcustomer = ?",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
		
	}
	
	function deleteCustomer($idcustomer)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("i",$idcustomer);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"DELETE FROM customer WHERE idcustomer = ? ",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
	}
	
	function getTransactionOfCustomer($idcustomer)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		$params = array("i",$idcustomer);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM transaction t
																INNER JOIN account ON
																account.idaccount = t.accountfkey
																WHERE account.customer_idcustomer = ? ORDER BY t.timestamp DESC",$params);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		return $result;
		
	}
	
	function getAdvertisementRow($id)
	{
			$con = DBcon::getDBcon();
			$mysqli = $con->getMysqliObject();
			
			$params = array("i",$id);
			
			$this->queryhelper->beginTransaction($mysqli);
			
			$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM advertisement WHERE idadvertisement = ?",$params);
			
			$this->queryhelper->commitTransaction($mysqli);
			
			return $result->fetch_assoc();
	
	}
	
	function echoNav($activetab)
	{
		$con = DBcon::getDBcon();
		$mysqli = $con->getMysqliObject();
		
		
		
		
		$params1 = array("i",$this->uid);
		
		$this->queryhelper->beginTransaction($mysqli);
		
		$result = $this->queryhelper->executeStatement($mysqli,"SELECT * FROM customerrep WHERE idcustomerrep = ?",$params1);
		
		$this->queryhelper->commitTransaction($mysqli);
		
		$row = $result->fetch_assoc();
		
	
		echo '<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
		 <div class = "row-fluid" >
		  <div class="span1 offset2">
          <a class="brand" href="./index.html"><img src="assets/img/SBHlogo.jpg" width="40" height="40" ></a>
		  </div>
		 <ul class="nav" style="position: relative; top: 10px;">
		

              <li '; if($activetab == 0) { echo 'class="active"';}  echo'>
                <a href="./rephome.php">Home</a>
              </li>
              <li '; if($activetab == 1) { echo 'class="active"';}  echo'>
                <a href="./advertisements.php">Advertisements</a>
              </li>
              <li '; if($activetab == 2) { echo 'class="active"';}  echo'>
                <a href="./transactions.php">Transactions</a>
              </li>
            
              <li '; if($activetab == 3) { echo 'class="active"';}  echo'>
                <a href="./mailinglists.php">Mailing Lists</a>
              </li>
              <li '; if($activetab == 4) { echo 'class="active"';}  echo'>
                <a href="./editcustomers.php">Customers</a>
              </li>
			  

            </ul>
			
			 <ul class="nav offset2" style="position: relative; top: 10px;">
			 
			 <li style="position: relative; top: 12px;">'.$row['firstname'].' '.$row['lastname'].'</li>
			 
			 
			 
			  <li class="" style="position: relative; top: -5px;">
			    <a class="btn btn-small" href="scripts/LogoutScript.php">Logout</a>
			  </li>
			 
			 </ul>
			 
			 
          </div>
		 </ul>		
		</div>

      </div>';
	}


}



?>


