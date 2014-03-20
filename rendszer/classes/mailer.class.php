<?php
if(!defined('SZINT1') || SZINT1!==666 ) die('Hozzáférés megtagadva'); //osztály biztonság

require_once( MAILER_DIR . 'class.phpmailer.php');
class Mailer{


	private $charSet="iso-8859-2";
	private $wordWrap = 50;
	private $isHTML=true;
	
	protected $from;
	protected $fromName;
	protected $replyTo;
	
	public $address= false;
	public $subject= false;
	public $body=false;
 	
	
	
	
	
	function __construct(){
		$this->from=OLDAL_VAKMAIL;
		$this->fromName=OLDAL_NEVE;
		$this->replyTo='info@sky-tech.hu';
	}
	
	
	
	function send(){
		$mail=new PHPMailer();
		$mail->CharSet="iso-8859-2";	
		$mail->WordWrap = 50; 
		$mail->IsHTML(true);
		
		$mail->From=OLDAL_VAKMAIL;
		$mail->FromName=OLDAL_NEVE;
		$mail->AddReplyTo('info@sky-tech.hu');
		$mail->Subject = $this->subject; 
		$mail->AddAddress( $this->address );  
		$mail->Body = $this->antiSpam( $this->body ) ;
		return $mail->Send();
	}
	
	
	
	function antiSpam( $str ){
		
		$mit=array('http://');
		$mire=array('');
		return str_replace($mit,$mire,$str);
	}
	
	
	
	function sendTo(){	
		
		/*
		$class_vars = get_object_vars( $this  );

		foreach ($class_vars as $name => $value) {
			$postData[$name]=$value;
		}
		*/
		$postData['address']=$this->address;
		$postData['subject']=$this->subject;
		$postData['body']=$this->body;
		
		
		$url = "http://private.sky-tech.hu/Y29ubmVjdA/cmVnaXN6dHLhY2nz.php";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	

}// end class
?>