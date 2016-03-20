<?php
class TransactionModel{

	private $db;

	public function TransactionModel(){
		$helper = new DBHelper();
		$this-> db = $helper -> getInstance();
	}

	public function getTransactions($params){
		if(empty($params)){
			$sqlstmt = "SELECT * FROM V_TRANSACTION WHERE TRANSACTION_STATUS <> 'DELETED';";
			$stmt = $this->db -> prepare($sqlstmt);
		}
		else{
			$sqlstmt = "SELECT * FROM V_TRANSACTION WHERE TRANSACTION_ID = ? AND TRANSACTION_STATUS <> 'DELETED';";
			$stmt = $this->db -> prepare($sqlstmt);
			$stmt -> bindParam(1,$params->transaction_id,PDO::PARAM_INT);
		}

		$stmt -> execute();
		$transactions = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		foreach ($transactions as &$transaction) {
			$transaction['TRANSACTION_ITEMS'] = $this->getTransactionDetails($transaction['TRANSACTION_ID']);
		}
		return $transactions;
	}

	public function getTransactionDetails($transaction_id){
		$sqlstmt = "SELECT WOOD_TYPE, WOOD_LENGTH, WOOD_WIDTH, WOOD_HEIGHT, WOOD_QTY, TOTAL_PRICE FROM V_TRANSACTION_DETAIL WHERE TRANSACTION_ID = ?";
		$stmt = $this->db->prepare($sqlstmt);
		$stmt -> bindParam(1,$transaction_id,PDO::PARAM_INT);
		$stmt -> execute();
		$details = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $details;
	}

	public function addTransactions($params){
		$stmt = $this->db -> prepare("INSERT INTO TRANSACTION (CUSTOMER_ID, TRANSACTION_TYPE) VALUES (?,?);");
		if(!array_key_exists('transaction_items',$params)){
			return array("error" => "1", "message" => "No items received");
		}
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
			return array("error" => "1", "message" => "Only one transaction only");
		}
		else{
			$stmt -> bindParam(1,$params->customer_id,PDO::PARAM_INT,100);
			$stmt -> bindParam(2,$params->transaction_type,PDO::PARAM_INT,100);
			$stmt -> execute();
		}
		$details = $this->addTransactionDetails($this-> db -> lastInsertId(),$params->transaction_items);
		if(empty($details['error'])){
			$this->db->commit();
			$result = array("error" => null, "message" => "Transaction Added Successfully!");
		}
		else{
		$this->db->rollBack();
		$result = $details;
		}
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("result" => "1", "message" => $e->getMessage());
		}
	}

	public function addTransactionDetails($id,$params){
		$stmt = $this->db -> prepare("INSERT INTO TRANSACTION_DETAIL (TRANSACTION_ID, WOOD_ID, WOOD_QTY) VALUES (?,?,?);");
		try{
		//$this->db->beginTransaction();
		if($id != 0){
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$id,PDO::PARAM_INT,100);
			$stmt -> bindParam(2,$param->wood_id,PDO::PARAM_INT,100);
			$stmt -> bindParam(3,$param->wood_qty,PDO::PARAM_INT,50);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$id,PDO::PARAM_INT,100);
			$stmt -> bindParam(2,$params->wood_id,PDO::PARAM_INT,100);
			$stmt -> bindParam(3,$params->wood_qty,PDO::PARAM_INT,50);
			$stmt -> execute();
		}
		}
		$result = array("error" => null, "message" => "Details Inserted Successfully");
		return $result;
		}
		catch(Exception $e){
			//$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}

	public function editTransactions($params){
		$stmt = $this->db -> prepare("UPDATE USER SET PASSWORD = ?, ACCESS_RIGHTS = ?,
									  FIRST_NAME = ?, LAST_NAME = ? WHERE USER_ID = ? AND USERNAME = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->password,PDO::PARAM_STR,100);
			$stmt -> bindParam(2,$param->access_rights,PDO::PARAM_STR,50);
			$stmt -> bindParam(3,$param->first_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(4,$param->last_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(5,$param->user_id,PDO::PARAM_INT,11);
			$stmt -> bindParam(6,$param->username,PDO::PARAM_STR,100);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$param->password,PDO::PARAM_STR,100);
			$stmt -> bindParam(2,$param->access_rights,PDO::PARAM_STR,50);
			$stmt -> bindParam(3,$param->first_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(4,$param->last_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(5,$param->user_id,PDO::PARAM_INT,11);
			$stmt -> bindParam(6,$param->username,PDO::PARAM_STR,100);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Transaction edited successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("result" => "1", "message" => $e->getMessage());
		}
	}

	public function deleteTransactions($params){
		$stmt = $this->db -> prepare("DELETE FROM TRANSACTION_DETAILS WHERE TRANSACTION_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->user_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->user_id,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Customer deleted successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
}
?>
