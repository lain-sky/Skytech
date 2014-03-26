<?php
if(!defined('SZINT1') || SZINT1 !== 666)
	die('Hozzáférés megtagadva');

class baseModel {
	protected $table = '';
	protected $idName = '';
		
	public function __construct($id = null) {}
	
	public function add($data) {
		$keys = array_keys($data);
		$values = array_values($data);
		$sql = "INSERT INTO " . $this->table . "(" . implode(',', $keys) . ") VALUES ('" . implode("','", $this->convertArray($values)) . "')";
		array_unshift($values,$sql);
		return call_user_func_array(array('db', 'futat'), $values);
	}

	public function update($where, $data) {
		$values = array_values($data);
		$sql = "UPDATE " . $this->table ." SET ";
		$updates = array();
		foreach($data as $key => $val) {
			$updates[] = $key . "='" . $this->convertData($val) . "' ";
		}
		if(count($updates) >= 1) {
			$sql .= implode(', ', $updates);
			$sql .= " WHERE ";

			if(is_array($where)) {
				$wheres = array();
				foreach($where as $key => $val) {
					$wheres[] = $key . "='" . $this->convertData($val) . "'";
				}
				$sql .= implode(" AND ", $wheres);
			} else {
				$sql .= $where;
			}

			array_unshift($values, $sql);
			if(is_array($where))
				$values = array_merge($values, array_values($where));

			return call_user_func_array(array('db', 'futat'), $values);
		}
		return false;
	}

	public function del($where) {
		$sql = "DELETE FROM " . $this->table . " WHERE ";
		if(is_array($where)) {
			$wheres = array();
			foreach($where as $key => $val) {
				$wheres[] = $key . "='" . $this->convertData($val) . "'";
			}
			$sql .= implode(" AND ", $wheres);

			$values = array_values($where);
			array_unshift($values, $sql);
			return call_user_func_array(array('db', 'futat'), $values);
		} else {
			db::futat($sql . $where);
		}
	}

	public function getById($id) {
		$sql = "SELECT * FROM " . $this->table . " WHERE ". $this->idName . " = '%d'";
		return db::getRow($sql, $id);
	}

	public function getAll($where = null, $order = null, $limit = null) {
		$sql = "SELECT * FROM " . $this->table . " ";
		if(!empty($where))
			$sql .= " WHERE " . $where;

		if(!empty($order))
			$sql .= " ORDER BY " . $order;

		if(!empty($limit))
			$sql .= " LIMIT " . $limit;

		return db::getAll($sql);
	}

	protected function convertArray($tomb) {
		$kesz = array();
		foreach($tomb as $val) {
			$kesz[] = $this->convertData($val);
		}
		return $kesz;
	}

	protected function convertData($var) {
		switch(gettype($var)) {
			case "integer":
				$kesz = '%d';
			break;

			case "double":
			case "float":
				$kesz = '%f';
			break;

			default:
				$kesz = '%s';
			break;
		}
		return $kesz;
	}
}

?>
