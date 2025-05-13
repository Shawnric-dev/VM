<?php
class DBQuerries{
	private $con;

	function __construct(){
		require dirname(__FILE__).'/Connector.php';
		$db = new Connector();
		$this->con = $db->connect();

		// $db = new K_Connector();
		// $this->kcon = $db->kconnect();
	}
	// ____GENERIC BEGIN _____
	function read_ifAlreadyExists($val,$col,$table){
		$query='select '.$col.' from '.$table.' where '.$col.'=?';
		$stmt=$this->con->prepare($query);
		$stmt->bind_param('s',$val);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows>0;
	}

	function deleteRow($val,$col,$dataType,$table){
		$stmt = $this->con->prepare('delete from '.$table.' where '.$col.'=?;');
		$stmt->bind_param($dataType, $val);
		return $stmt->execute();
	}

	function readFrom($table, $col){
		$q='select '.$col.' from '.$table.' order by id asc;';
		$stmt=$this->con->prepare($q);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		
		
		// $stmt=$this->con->prepare($q);
		// $stmt->execute();
		// return $stmt->get_result()->fetch_assoc();
		// return $q;
	}

	function insertInto($val,$col,$table){
		$stmt = $this->con->prepare('insert into '.$table.'('.$col.') values(?);');
		$stmt->bind_param('s', $val);
		$id=-1;
		if($stmt->execute())
			$id=$this->con->insert_id;

		return $id;
	}
	// ____GENERIC END _____

}
?>