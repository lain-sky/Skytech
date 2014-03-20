<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság 



class baseModel {
	
	
	protected $table='';
	protected $idName='';
		
	public function __construct( $id=null){
		
	}
	
	public function add( $data ){
		$keys=array_keys($data);
		$values=array_values($data);
		$sql="insert into " .$this->table . "(". implode(',', $keys ) .") values('". implode("','", $this->convertArray( $values ) ) ."')";
		array_unshift($values,$sql);
		return call_user_func_array(array('db','futat'), $values );
	
	}
	
	public function update( $where , $data ){
		$values=array_values($data);
		$sql="update " . $this->table ." set ";
		$updates=array();
		foreach( $data as $key=>$val ){
			$updates[]= $key . "='" .$this->convertData( $val ) ."' ";
		}
		if( count($updates) >= 1){
			$sql.=implode(', ',$updates);
			
			$sql.=" where ";
			
			if( is_array( $where ) ){
				$wheres=array();
				foreach( $where as $key=>$val ){
					$wheres[]= $key."='".$this->convertData( $val )."'";
				}
				$sql.= implode(" and ", $wheres );
			}
			else{
				$sql.= $where;
			}
			
			array_unshift( $values ,$sql);
			if( is_array( $where ) ){
				$values=array_merge( $values, array_values($where) );
			}
			return call_user_func_array(array('db','futat'), $values );			
		}
		return false;
	
	}
	
	public function del( $where ){
		$sql="delete from " . $this->table . " where ";
		if( is_array( $where ) ){
			
			$wheres=array();
			foreach( $where as $key=>$val ){
				$wheres[]= $key."='".$this->convertData( $val )."'";
			}
			$sql.= implode(" and ", $wheres );
			
			$values=array_values($where);
			array_unshift($values,$sql);
			return call_user_func_array(array('db','futat'), $values );
		}
		else{
			db::futat($sql . $where );
		}
		
	
	}
	
	public function getById( $id ){
		$sql="select * from ". $this->table . " where ". $this->idName ."='%d'";
		return db::getRow($sql,$id);
	}
	
	public function getAll( $where=null, $order=null, $limit=null ){
		$sql="select * from ". $this->table . " ";
		
		if(!empty($where)){
			$sql.=" where  ".$where;
		}
		
		if(!empty($order)){
			$sql.=" order by ".$order;
		}
		if(!empty($limit) ){
			$sql.=" limit ".$limit;
		}
		
		return db::getAll($sql);
	}
	
	
	protected function convertArray( $tomb ){
		
		$kesz=array();
		foreach( $tomb as $val ){
			$kesz[]=$this->convertData( $val );
		}
		return $kesz;	
	}
	
	protected function convertData( $var ){
		switch( gettype($var) ){
			
			case  "integer" :
				$kesz='%d';
			break;
			
			case "double" :
			case "float":
				$kesz='%f';
			break;
			
			default:
				$kesz='%s';
			break;
		}
		return $kesz;	
	}


}
?>