<?php
class UserModel{
	
	private $db;
	
	public function UserModel(){
		$helper = new DBHelper();
		$this-> db = $helper -> getInstance();
	}
	
	public function authenticate($user_key){
		$sqlstmt = "SELECT * FROM USER WHERE BINARY USER_KEY = ?;";
		$stmt = $this->db -> prepare($sqlstmt);
		$stmt -> bindParam(1,$user_key,PDO::PARAM_STR,100);
		$stmt -> execute();
		$user = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		if(count($user) != 0)
			return true;
		else
			return false;
	}
	
	public function loginUser($params){
		$sqlstmt = "SELECT * FROM USER WHERE BINARY USERNAME = ? AND BINARY PASSWORD =MD5(?);";
		$stmt = $this->db -> prepare($sqlstmt);
		$stmt -> bindParam(1,$params->username,PDO::PARAM_STR,100);
		$stmt -> bindParam(2,$params->password,PDO::PARAM_STR,100);
		$stmt -> execute();
		$user = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $user;
	}
	public function getUsers($params){
		if(empty($params)){
			$sqlstmt = "SELECT * FROM USER;";
			$stmt = $this->db -> prepare($sqlstmt);
		}
		else{
			$sqlstmt = "SELECT * FROM USER WHERE USER_ID = ?;";
			$stmt = $this->db -> prepare($sqlstmt);
			$stmt -> bindParam(1,$params->user_id,PDO::PARAM_INT);
		}
		
		$stmt -> execute();
		$customers = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		return $customers;
	}
	
	public function addUsers($params){
		$stmt = $this->db -> prepare("INSERT INTO USER (FIRST_NAME, LAST_NAME, USERNAME, PASSWORD, ROLE, USER_KEY) VALUES (?,?,?,md5(?),?,md5(?));");
		try{
		$this->db->beginTransaction();
		if(is_array($params)){
		foreach($params as $param){
			$stmt -> bindParam(1,$param->first_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(2,$param->last_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(3,$param->username,PDO::PARAM_STR,100);
			$stmt -> bindParam(4,$param->password,PDO::PARAM_STR,100);
			$stmt -> bindParam(5,$param->role,PDO::PARAM_STR,50);
			$stmt -> bindParam(6,$param->username,PDO::PARAM_STR,100);
			$stmt -> execute();
			}
		}
		else{
			$stmt -> bindParam(1,$params->first_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(2,$params->last_name,PDO::PARAM_STR,500);
			$stmt -> bindParam(3,$params->username,PDO::PARAM_STR,100);
			$stmt -> bindParam(4,$params->password,PDO::PARAM_STR,100);
			$stmt -> bindParam(5,$params->role,PDO::PARAM_STR,50);
			$stmt -> bindParam(6,$params->username,PDO::PARAM_STR,100);
			$stmt -> execute();
		}
		$this->db->commit();
		$result = array("error" => null, "message" => "User added successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("result" => "1", "message" => $e->getMessage());
		}/*[{"company_name":"derp3"
			,"company_address":"derp st.2"
			,"contact_person":"Mr. Derp2"
			,"contact_number":"3309558"},
			{"company_name":"derp4"
			,"company_address":"derp st.2"
			,"contact_person":"Mr. Derp2"
			,"contact_number":"3309558"},
			{"company_name":"derp5"
			,"company_address":"derp st.2"
			,"contact_person":"Mr. Derp2"
			,"contact_number":"3309558"}]*/
	}
	
	public function editUsers($params){
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
		$result = array("error" => null, "message" => "User edited successfully!");
		return $result;
		}
		catch(Exception $e){
			$this->db->rollBack();
			return array("result" => "1", "message" => $e->getMessage());
		}
	}
	
	public function deleteUsers($params){
		$stmt = $this->db -> prepare("DELETE FROM USER WHERE USER_ID = ?;");
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