<?php
include 'models/CustomerModel.php';

	function addCustomer($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$customermodel = new CustomerModel();
			$result = $customermodel -> addCustomers($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function getCustomer($params,$user_key) {
		if(authenticate($user_key)){
			//get all customer
			$customermodel = new CustomerModel();
			$customers = $customermodel -> getCustomers($params);
			return array("row_count" => count($customers),"result" => $customers);
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function editCustomer($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$customermodel = new CustomerModel();
			$result = $customermodel -> editCustomers($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function deleteCustomer($params,$user_key) {
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$customermodel = new CustomerModel();
			$result = $customermodel -> deleteCustomers($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	function addSpecialPrice($params,$user_key){
		if(authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$customermodel = new CustomerModel();
			$result = $customermodel -> addSpecialPrice($params);
			return $result;
		}
	}
?>