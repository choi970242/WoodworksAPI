<?php
include 'db/DBHelper.php';
include 'models/CustomerModel.php';
include 'models/UserModel.php';
include 'models/WoodModel.php';
include 'models/TransactionModel.php';
class Actions {
	public function authenticate($user_key){
		$usermodel = new UserModel();
		return $usermodel -> authenticate($user_key);
	}
//CustomerModel.php
	public function addCustomer($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$customermodel = new CustomerModel();
		$result = $customermodel -> addCustomers($params);
		return $result;
	}
	
	public function getCustomer($params,$user_key) {
		//get all customer
		$customermodel = new CustomerModel();
		$customers = $customermodel -> getCustomers($params);
		return array("row_count" => count($customers),"result" => $customers);	
	}
	
	public function editCustomer($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$customermodel = new CustomerModel();
		$result = $customermodel -> editCustomers($params);
		return $result;
	}
	
	public function deleteCustomer($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$customermodel = new CustomerModel();
		$result = $customermodel -> deleteCustomers($params);
		return $result;
	}
//UserModel.php	
	public function login($params,$user_key){
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
	
	public function addUser($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$usermodel = new UserModel();
		$result = $usermodel -> addUsers($params);
		return $result;
	}
	
	public function getUser($params,$user_key) {
		//get all user
		$usermodel = new UserModel();
		$users = $usermodel -> getUsers($params);
		return array("row_count" => count($users),"result" => $users);	
	}
	
	public function editUser($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$usermodel = new UserModel();
		$result = $usermodel -> editUsers($params);
		return $result;
	}
	
	public function deleteUser($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$usermodel = new UserModel();
		$result = $usermodel -> deleteUsers($params);
		return $result;
	}
//WoodModel.php
	public function addWood($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new WoodModel();
		$result = $woodmodel -> addWoods($params);
		return $result;
	}
	
	public function getWood($params,$user_key) {
		//get all user
		if($this -> authenticate($user_key)){
			$woodmodel = new WoodModel();
			$woods = $woodmodel -> getWoods($params);
			return array("row_count" => count($woods),"result" => $woods);
		}
		else{
			return array("error" => "1", "message" => "No User Key Required");
		}
	}
	
	public function editWood($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new WoodModel();
		$result = $woodmodel -> editWoods($params);
		return $result;
	}
	
	public function deleteWood($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new UserModel();
		$result = $woodmodel -> deleteWoods($params);
		return $result;
	}
//TransactionModel.php	
	public function addTransaction($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$transactionmodel = new TransactionModel();
		$result = $transactionmodel -> addTransactions($params);
		return $result;
	}
	
	public function getTransaction($params,$user_key) {
		//get all user
		$transactionmodel = new TransactionModel();
		$transactions = $transactionmodel -> getTransactions($params);
		return array("row_count" => count($transactions),"result" => $transactions);	
	}
	
	public function editTransaction($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new TransactionModel();
		$result = $woodmodel -> editTransactions($params);
		return $result;
	}
	
	public function deleteTransaction($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new UserModel();
		$result = $woodmodel -> deleteTransactions($params);
		return $result;
	}
}
