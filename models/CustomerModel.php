<?php
class CustomerModel{
	
	private $db;
	
	public function CustomerModel(){
		$helper = new DBHelper();
		$this-> db = $helper -> getInstance();
	}
	public function getCustomers($params){
		if(empty($params)){
			$sqlstmt = "SELECT * FROM CUSTOMER;";
			$stmt = $this->db -> prepare($sqlstmt);
		}
		else{
			$sqlstmt = "SELECT * FROM CUSTOMER WHERE CUSTOMER_ID = ?;";
			$stmt = $this->db -> prepare($sqlstmt);
			$stmt -> bindParam(1,$params->customer_id,PDO::PARAM_INT);
		}
		
		$stmt -> execute();
		$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $customers;
	}
	
	public function addCustomers($params){
		$stmt = $this->db -> prepare("INSERT INTO CUSTOMER (COMPANY_NAME, COMPANY_ADDRESS, CONTACT_PERSON, CONTACT_NUMBER) VALUES (?,?,?,?);");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->company_name,PDO::PARAM_STR,200);
			$stmt -> bindParam(2,$param->company_address,PDO::PARAM_STR,500);
			$stmt -> bindParam(3,$param->contact_person,PDO::PARAM_STR,500);
			$stmt -> bindParam(4,$param->contact_number,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->company_name,PDO::PARAM_STR,200);
			$stmt -> bindParam(2,$params->company_address,PDO::PARAM_STR,500);
			$stmt -> bindParam(3,$params->contact_person,PDO::PARAM_STR,500);
			$stmt -> bindParam(4,$params->contact_number,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Customer added successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("result" => "1", "message" => $e->getMessage());
		}
	}
	
	public function editCustomers($params){
		$stmt = $this->db -> prepare("UPDATE CUSTOMER SET COMPANY_NAME = ?, COMPANY_ADDRESS = ?, 
									  CONTACT_PERSON = ?, CONTACT_NUMBER = ? WHERE CUSTOMER_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->company_name,PDO::PARAM_STR,200);
			$stmt -> bindParam(2,$param->company_address,PDO::PARAM_STR,500);
			$stmt -> bindParam(3,$param->contact_person,PDO::PARAM_STR,500);
			$stmt -> bindParam(4,$param->contact_number,PDO::PARAM_INT,11);
			$stmt -> bindParam(5,$param->customer_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->company_name,PDO::PARAM_STR,200);
			$stmt -> bindParam(2,$params->company_address,PDO::PARAM_STR,500);
			$stmt -> bindParam(3,$params->contact_person,PDO::PARAM_STR,500);
			$stmt -> bindParam(4,$params->contact_number,PDO::PARAM_INT,11);
			$stmt -> bindParam(5,$params->customer_id,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Customer edited successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("result" => "1", "message" => $e->getMessage());
		}
	}
	
	public function deleteCustomers($params){
		$stmt = $this->db -> prepare("DELETE FROM CUSTOMER WHERE CUSTOMER_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->customer_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->customer_id,PDO::PARAM_INT,11);
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
	
	public function addSpecialPrice($params){
		$stmt = $this->db -> prepare("INSERT INTO CUSTOMER_SPECIAL_PRICES (CUSTOMER_ID, WOOD_ID, WOOD_PRICE) VALUES (?,?,?);");
		try{
			$this->db->beginTransaction();
			$specialprices = $params -> customer_specialprices;
			if(is_array($specialprices)){
				foreach($specialprices as $specialprice){
					$stmt -> bindParam(1,$params->customer_id);
					$stmt -> bindParam(2,$specialprice-> wood_id);
					$stmt -> bindParam(3,$specialprice->wood_price);
					$stmt -> execute();
				}
			}
			else{
				$stmt -> bindParam(1,$params->customer_id);
				$stmt -> bindParam(2,$specialprices->wood_id);
				$stmt -> bindParam(3,$specialprices->wood_price);
				$stmt -> execute();
			}
			$this->db->commit();
			$result = array("error" => null, "message" => "Prices added successfully!");
			return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
}
?>