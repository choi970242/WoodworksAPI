<?php
class UOMModel{
	
	private $db;
	
	public function UOMModel(){
		$helper = new DBHelper();
		$this-> db = $helper -> getInstance();
	}
	public function getUOMs($params){
		if(empty($params)){
			$sqlstmt = "SELECT * FROM UNIT_OF_MEASURE;";
			$stmt = $this->db -> prepare($sqlstmt);
		}
		else{
			$sqlstmt = "SELECT * FROM WOOD WHERE UNIT_OF_MEASURE = ?;";
			$stmt = $this->db -> prepare($sqlstmt);
			$stmt -> bindParam(1,$params->uom_id,PDO::PARAM_INT);
		}
		
		$stmt -> execute();
		$uoms = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $uoms;
	} 
	
	public function addUOMs($params){
		$stmt = $this->db -> prepare("INSERT INTO UNIT_OF_MEASURE (UOM_CD, UOM_DESC) VALUES (?,?);");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->uom_cd);
			$stmt -> bindParam(2,$param->uom_desc);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->uom_cd);
			$stmt -> bindParam(2,$params->uom_desc);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "UOM added successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
	
	public function editUOMs($params){
		$stmt = $this->db -> prepare("UPDATE UNIT_OF_MEASURE SET UOM_CD = ?, UOM_DESC = ? WHERE UOM_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->uom_cd);
			$stmt -> bindParam(2,$param->uom_desc);
			$stmt -> bindParam(3,$param->uom_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->uom_cd);
			$stmt -> bindParam(2,$params->uom_desc);
			$stmt -> bindParam(3,$params->uom_id,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "UOM edited successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
	
	public function deleteUOMs($params){
		$stmt = $this->db -> prepare("DELETE FROM UNIT_OF_MEASURE WHERE UOM_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->uom_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->uom_id,PDO::PARAM_INT,11);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "UOM deleted successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("error" => "1", "message" => $e->getMessage());
		}
	}
}
?>