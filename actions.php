<?php
include 'db/DBHelper.php';
include 'models/UOMModel.php';
include 'actions/woodActions.php';
include 'actions/customerActions.php';
include 'actions/userActions.php';
include 'actions/transactionActions.php';

function authenticate($user_key){
		$usermodel = new UserModel();
		return $usermodel -> authenticate($user_key);
	}
	
class Actions {
	public function authenticate($user_key){
		$usermodel = new UserModel();
		return $usermodel -> authenticate($user_key);
	}
//CustomerModel.php
	public function addCustomer($params,$user_key) {
		if($this -> authenticate($user_key)){
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
	
	public function getCustomer($params,$user_key) {
		if($this -> authenticate($user_key)){
			//get all customer
			$customermodel = new CustomerModel();
			$customers = $customermodel -> getCustomers($params);
			return array("row_count" => count($customers),"result" => $customers);
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	public function editCustomer($params,$user_key) {
		if($this -> authenticate($user_key)){
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
	
	public function deleteCustomer($params,$user_key) {
		if($this -> authenticate($user_key)){
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
		if($this -> authenticate($user_key)){
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
	
	public function getUser($params,$user_key) {
		if($this -> authenticate($user_key)){
			//get all user
			$usermodel = new UserModel();
			$users = $usermodel -> getUsers($params);
			return array("row_count" => count($users),"result" => $users);	
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	public function editUser($params,$user_key) {
		if($this -> authenticate($user_key)){
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
	
	public function deleteUser($params,$user_key) {
		if($this -> authenticate($user_key)){
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
//WoodModel.php
	public function addWood($params,$user_key) {
		if($this -> authenticate($user_key)){
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
	
	public function getWood($params,$user_key) {
		//get all user
		if($this -> authenticate($user_key)){
			$woodmodel = new WoodModel();
			$woods = $woodmodel -> getWoods($params);
			return array("row_count" => count($woods),"result" => $woods);
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	public function editWood($params,$user_key) {
		if($this -> authenticate($user_key)){
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
	
	public function deleteWood($params,$user_key) {
		if($this -> authenticate($user_key)){
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
//UOMModel.php		
	public function addUOM($params,$user_key) {
		if($this -> authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$woodmodel = new UOMModel();
			$result = $woodmodel -> addUOMs($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	public function getUOM($params,$user_key) {
		//get all user
		if($this -> authenticate($user_key)){
			$woodmodel = new UOMModel();
			$woods = $woodmodel -> getUOMs($params);
			return array("row_count" => count($woods),"result" => $woods);
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	public function editUOM($params,$user_key) {
		if($this -> authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$woodmodel = new UOMModel();
			$result = $woodmodel -> editUOMs($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
	
	public function deleteUOM($params,$user_key) {
		if($this -> authenticate($user_key)){
			if(empty($params))
				return array("error" => "1", "message" => "No Input Received!");
			$woodmodel = new UOMModel();
			$result = $woodmodel -> deleteUOMs($params);
			return $result;
		}
		else{
			return array("error" => "1", "message" => "No User Key Entered!");
		}
	}
}
