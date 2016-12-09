<?php
include 'models/WoodModel.php';

//WoodModel.php
	function addWood($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$woodmodel = new WoodModel();
			$result = $woodmodel -> addWoods($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function getWood($params,$user_key) {
		//get all user
		if(authenticate($user_key)){
			$woodmodel = new WoodModel();
			$woods = $woodmodel -> getWoods($params);
			return array("row_count" => count($woods),"result" => $woods);
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function editWood($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$woodmodel = new WoodModel();
			$result = $woodmodel -> editWoods($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function deleteWood($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$woodmodel = new WoodModel();
			$result = $woodmodel -> deleteWoods($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function getSpecialPrice($params,$user_key) {
		//get all user
		if(authenticate($user_key)){
			$woodmodel = new WoodModel();
			$woods = $woodmodel -> getSpecialPrices($params);
			return array("row_count" => count($woods),"result" => $woods);
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
?>
