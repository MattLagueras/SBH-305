<?php

/*
ACTION CODES
0 = Like/Unlike post [0,pid,uid]
1 = Like/Unlike comment [1,cid,uid]
2 = Make Post [2,pid,content,uid]
3 = Edit Post [3,pid,newcontent,uid]
4 = Make Comment [4,pid,content,uid]
5 = Edit Comment [5,cid,newcontent,uid]
6 = Delete Post [6,pid,uid]
7 = Delete Comment [7,cid,uid]
8 = Search Users [8,search,circleid,uid]
9 = Invite to Circle [9,circleid,cid,uid]


*/

include_once ("CustomerUtilites.php");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


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
	
	if($data[0] == 1)
	{

	
		$utilites = new CustomerUtilites($data[2],-1);
		
		$data[1] = str_replace("comment",'',$data[1]);
		
		
		$res = $utilites->likeOrUnlikeComment($data[1]);
		
		echo json_encode(array('result' => 'success', 'rdata' => $res));
		
		
	}
	
	if($data[0] == 2)
	{
		$utilites = new CustomerUtilites($data[3],-1);
	
		$res = $utilites->createPost($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
		
	}
	
	if($data[0] == 3)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$utilites->editPost($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 4)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$utilites->createComment($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	
	}
	
	if($data[0] == 5)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$utilites->editComment($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 6)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$utilites->deletePost($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 7)
	{
		$utilites = new CustomerUtilites($data[2],-1);
		
		$utilites->deleteComment($data[1]);
		
		echo json_encode(array('result' => 'success'));
	}
	
	if($data[0] == 8)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->getCardsFromSearch($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success', 'html' => $htmlres));
	}
	
	if($data[0] == 9)
	{
		$utilites = new CustomerUtilites($data[3],-1);
		
		$htmlres = $utilites->inviteToCircle($data[1],$data[2]);
		
		echo json_encode(array('result' => 'success'));
	}
	


?>