<?php

/*
ACTION CODES
0 = Like/Unlike post [0,pid,uid]
1 = Like/Unlike comment
2 = Make Post [2,pid,content,uid]

*/

include_once ("CustomerUtilites.php");

	$con = DBcon::getDBcon();
	$mysqli = $con->getMysqliObject();
	
	


	$data = $_POST['data'];
	
	
	
	if($data[0] == 0)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$data[1] = str_replace("post",'',$data[1]);
		
		$res = $utilites->likeOrUnlikePost($data[1]);
		
		echo json_encode(array('result' => 'success', 'rdata' => $res));
		
	}
	
	if($data[0] == 2)
	{
		$utilites = new CustomerUtilites($data[3],-1);
	
		$res = $utilites->createPost($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
		
	}
	


?>