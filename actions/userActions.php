<?php
include 'models/UserModel.php';

//UserModel.php	
	function login($params,$user_key){
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$usermodel = new UserModel();
		$result = $usermodel -> loginUser($params);
		if(empty($result)){
			return array("error" => "1", "message" => "Invalid Username or Password");
		}
		else{
			return array("row_count" => count($result),"result" => $result[0]);
		}
	}
	
	function addUser($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$usermodel = new UserModel();
			$result = $usermodel -> addUsers($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function getUser($params,$user_key) {
		if(authenticate($user_key)){
			//get all user
			$usermodel = new UserModel();
			$users = $usermodel -> getUsers($params);
			return array("row_count" => count($users),"result" => $users);	
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function editUser($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$usermodel = new UserModel();
			$result = $usermodel -> editUsers($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function deleteUser($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$usermodel = new UserModel();
			$result = $usermodel -> deleteUsers($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}

?>