<?php


class PreparedQueryHelper
{

	function __construct() 
	{           

    }
	
	function executeStatement($mysqli,$qstring,$values)
	{
			$query = mysqli_prepare($mysqli,$qstring);
			call_user_func_array(array($query, "bind_param"),$this->refValues($values)); 
			mysqli_stmt_execute($query);
			$result = $query->get_result();
			
			return $result;
	}
	
	function refValues($arr)
	{ 
	
        $refs = array(); 
        foreach($arr as $key => $value) 
            $refs[$key] = &$arr[$key]; 
        return $refs; 
     
    return $arr; 
	} 
	

	
	function beginTransaction($mysqli)
	{
		mysqli_begin_transaction($mysqli);
	}
	
	function commitTransaction($mysqli)
	{
		mysqli_commit($mysqli);
	}
	
	function abortTransaction($mysqli)
	{
		mysqli_rollback($mysqli);
	}
	
	



}



?>