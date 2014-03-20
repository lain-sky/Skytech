<?php


class Cache{

	private function __construct(){
	
	}
	
	
	
	public static function get( $id ){
	
		if( empty( $id ) ) die( 'error => Cache:get()' );
		
		$conf = self::getData( $id );
		$tempParams =  func_get_args();
		
		if( $conf['type'] == 'file' ){
			
			$file = DB_CACHE_DIR . '/' . $conf['name'] ;
			if( !is_readable( $file ) ){
				call_user_func_array( array( 'Cache', 'set'), $tempParams );
			}
			elseif( isset( $conf['time'] ) ){
				$modTime= filemtime( $file ) + $conf['time'] ;
				if( time() > $modTime ){
					call_user_func_array( array( 'Cache', 'set'), $tempParams );
				}				
			}
			
			$content = file_get_contents( $file );
		}
		else{
			if( empty( $_SESSION['CACHE'][ $conf['name'] ] ) ){
				call_user_func_array( array( 'Cache', 'set'), $tempParams );
			}
			$content = $_SESSION['CACHE'][ $conf['name'] ] ;
			//var_dump( $content );
		}		
		
		if( $conf['serialize'] == true ){
			$data = unserialize( $content );
		}
		else{
			$data = $content;
		}
		
		return $data;
	}

	
	public static function set(){
		
		$params = func_get_args();
		//var_dump( $params );
		$id = array_shift( $params );
		
		if( empty( $id ) ) 	die( 'error => Cache:set()' );
		
		$conf = self::getData( $id );
		$data = call_user_func_array( $conf['create'], $params );
		
		//var_dump( $data );
						
		if( $conf['serialize'] == true ){
			$content = serialize( $data );
		}
		else{
			$content = $data;
		}
		
		if( $conf['type'] == 'file' ){
			$file = DB_CACHE_DIR . '/' . $conf['name'] ;
			if( !file_put_contents( $file, $content ) ) die( 'error => Cache:write()' );
		}
		else{
			$_SESSION['CACHE'][ $conf['name'] ] = $content;
		}
		
		if( is_array( $conf['depends'] ) ){
			foreach( $conf['depends'] as $item ){
				die('TODO: cache:params');
				call_user_func_array( array( 'Cache', 'set'), $params );
			}
		}
		 return true;
		
	}
	
	

	public static function clearAll(){
		
		foreach( scandir( DB_CACHE_DIR ) as $item ){
			
			if( $item == '.' || $item =='..' ){
				continue;
			}
			unlink( DB_CACHE_DIR . $item );
		}
	}
	
	private static function getData( $id = null ){
	
		$data=$GLOBALS['CACHE_CONFIG'];
		if( is_null( $id ) ){
			return $data;
		}
		else{
			return $data[$id];
		}	
	}
	


}





?>