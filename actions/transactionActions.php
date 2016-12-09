<?php
include 'models/TransactionModel.php';

//TransactionModel.php	
	function addTransaction($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$transactionmodel = new TransactionModel();
		$result = $transactionmodel -> addTransactions($params);
		return $result;
	}
	
	function getTransaction($params,$user_key) {
		//get all user
		$transactionmodel = new TransactionModel();
		$transactions = $transactionmodel -> getTransactions($params);
		return array("row_count" => count($transactions),"result" => $transactions);	
	}
	
	function editTransaction($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new TransactionModel();
		$result = $woodmodel -> editTransactions($params);
		return $result;
	}
	
	function deleteTransaction($params,$user_key) {
		if(empty($params))
			return array("error" => "1", "message" => "No Input Received!");
		$woodmodel = new UserModel();
		$result = $woodmodel -> deleteTransactions($params);
		return $result;
	}

?>