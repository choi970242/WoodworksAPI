<?php
class WoodModel{
	
	private $db;
	
	public function WoodModel(){
		$helper = new DBHelper();
		$this-> db = $helper -> getInstance();
	}
	public function getWoods($params){
		if(empty($params)){
			$sqlstmt = "SELECT * FROM WOOD;";
			$stmt = $this->db -> prepare($sqlstmt);
		}
		else{
			$sqlstmt = "SELECT * FROM WOOD WHERE WOOD_ID = ?;";
			$stmt = $this->db -> prepare($sqlstmt);
			$stmt -> bindParam(1,$params->wood_id,PDO::PARAM_INT);
		}
		
		$stmt -> execute();
		$woods = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $woods;
	}
	
	public function addWoods($params){
		$stmt = $this->db -> prepare("INSERT INTO WOOD (WOOD_TYPE, WOOD_WIDTH, WOOD_LENGTH, WOOD_HEIGHT, WOOD_PRICE) VALUES (?,?,?,?,?);");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$param->wood_width);
			$stmt -> bindParam(3,$param->wood_length);
			$stmt -> bindParam(4,$param->wood_height);
			$stmt -> bindParam(5,$param->wood_price);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$params->wood_width);
			$stmt -> bindParam(3,$params->wood_length);
			$stmt -> bindParam(4,$params->wood_height);
			$stmt -> bindParam(5,$params->wood_price);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Wood added successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
	
	public function editWoods($params){
		$stmt = $this->db -> prepare("UPDATE WOOD SET WOOD_TYPE = ?, WOOD_WIDTH = ?, 
									  WOOD_LENGTH = ?, WOOD_HEIGHT = ?, WOOD_PRICE = ? WHERE WOOD_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$param->wood_width);
			$stmt -> bindParam(3,$param->wood_length);
			$stmt -> bindParam(4,$param->wood_height);
			$stmt -> bindParam(5,$param->wood_price);
			$stmt -> bindParam(6,$param->wood_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$params->wood_width);
			$stmt -> bindParam(3,$params->wood_length);
			$stmt -> bindParam(4,$params->wood_height);
			$stmt -> bindParam(5,$params->wood_price);
			$stmt -> bindParam(6,$params->wood_id,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Wood edited successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
	
	public function deleteWoods($params){
		$stmt = $this->db -> prepare("DELETE FROM WOOD WHERE WOOD_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->wood_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->wood_id,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "Wood deleted successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
}
?>