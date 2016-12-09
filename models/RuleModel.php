<?php
class WoodModel{
	
	private $db;
	
	public function WoodModel(){
		$helper = new DBHelper();
		$this-> db = $helper -> getInstance();
	}
	public function getRules($params){
		if(empty($params)){
			$sqlstmt = "SELECT * FROM WOOD;";
			$stmt = $this->db -> prepare($sqlstmt);
		}
		else{
			$sqlstmt = "select 
						wood.wood_id
						,wood.wood_type
						,wood.wood_thickness
						,wood.wood_width
						,wood.wood_length
						,coalesce(special.wood_price, wood.wood_price,0) as wood_price
						,wood.wood_qty
						from wood wood
						left outer join customer_special_prices special
						on wood.wood_id = special.wood_id and special.customer_id = ?";
			/*select 
wood.wood_id
,wood.wood_type
,wood.wood_thickness
,wood.wood_width
,wood.wood_length
,coalesce(special.wood_price, discounted.discount_prcnt, wood.wood_price,0) as wood_price
,wood.wood_qty
from wood wood
left outer join customer_special_prices special
on wood.wood_id = special.wood_id and special.customer_id = 133
left outer join (select a.wood_id, a.discount_prcnt from rules_discount a
left outer join rules_discount d
on a.wood_id=d.wood_id and d.discount_prcnt > a.discount_prcnt
inner join discount_rules b
on a.rule_id = b.rule_id
inner join customer_discount c
on c.customer_id = 133 and b.rule_id = c.rule_id
where d.rule_id is null) as discounted
on wood.wood_id = discounted.wood_id;*/

			$stmt = $this->db -> prepare($sqlstmt);
			$stmt -> bindParam(1,$params->customer_id,PDO::PARAM_INT);
		}
		
		$stmt -> execute();
		$woods = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $woods;
	} 
	
	public function getSpecialPrices($params){
		$sqlstmt = "select 
					wood.wood_id
					,wood.wood_type
					,wood.wood_thickness
					,wood.wood_width
					,wood.wood_length
					,coalesce(special.wood_price, wood.wood_price,0) as wood_price
					,wood.wood_qty
					from wood wood
					inner join customer_special_prices special
					on wood.wood_id = special.wood_id and special.customer_id = ?";
		$stmt = $this-> db -> prepare($sqlstmt);
		$stmt -> bindParam(1,$params->customer_id,PDO::PARAM_INT);
		$stmt -> execute();
		$woods = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $woods;
	}
	
	public function addWoods($params){
		$stmt = $this->db -> prepare("INSERT INTO WOOD (WOOD_TYPE, WOOD_THICKNESS, WOOD_WIDTH, WOOD_LENGTH, WOOD_PRICE) VALUES (?,?,?,?,?);");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$param->wood_thickness);
			$stmt -> bindParam(3,$param->wood_width);
			$stmt -> bindParam(4,$param->wood_length);
			$stmt -> bindParam(5,$param->wood_price);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$params->wood_thickness);
			$stmt -> bindParam(3,$params->wood_width);
			$stmt -> bindParam(4,$params->wood_length);
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
		$stmt = $this->db -> prepare("UPDATE WOOD SET WOOD_TYPE = ?, WOOD_THICKNESS = ?, WOOD_WIDTH = ?, 
									  WOOD_LENGTH = ?, WOOD_PRICE = ? WHERE WOOD_ID = ?;");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$param->wood_thickness);
			$stmt -> bindParam(3,$param->wood_width);
			$stmt -> bindParam(4,$param->wood_length);
			$stmt -> bindParam(5,$param->wood_price);
			$stmt -> bindParam(6,$param->wood_id,PDO::PARAM_INT,11);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->wood_type,PDO::PARAM_STR,45);
			$stmt -> bindParam(2,$params->wood_thickness);
			$stmt -> bindParam(3,$params->wood_width);
			$stmt -> bindParam(4,$params->wood_length);
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
	
	public function addStock($id, $qty){
		$stmt = $this->db ->prepare("UPDATE WOOD SET WOOD_QTY = WOOD_QTY + ? WHERE WOOD_ID = ?");
		try{
			$this->db->beginTransaction();
			$stmt -> bindParam(1,$qty);
			$stmt -> bindParam(2,$id);
			$stmt -> execute();
			$this->db->commit();
			return true;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return false;
		}
	}
	
	public function remStock($id, $qty){
		$stmt = $this->db ->prepare("UPDATE WOOD SET WOOD_QTY = WOOD_QTY - ? WHERE WOOD_ID = ?");
		try{
			$this->db->beginTransaction();
			$stmt -> bindParam(1,$qty);
			$stmt -> bindParam(2,$id);
			$stmt -> execute();
			$this->db->commit();
			return true;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return false;
		}
	}
}
?>