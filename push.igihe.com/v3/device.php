<?php

class Device{
	
// 	Attributes

	private $id;
	private $serial;
	private $gcm_token;
	private $update_date;
	private $registration_date;
	
	
// 	Setters

	public function setId($id){
		$this->id = $id;
	}
	
	public function setSerial($serial){
		$this->serial = $serial;
	}
	
	public function setGcmToken($gcm_token){
		$this->gcm_token = $gcm_token;
	}

	public function setUpdateDate($date){
		$this->update_date = $date;
	}
	
	public function setRegistrationDate($registration_date){
		$this->registration_date = $registration_date;
	}
	
// 	Getters

	public function getId(){
		return $this->id;
	}
	
	public function getSerial(){
		return $this->serial;
	}
	
	public function getGcmToken(){
		return $this->gcm_token;
	}

	public function getUpdateDate(){
		return $this->update_date;
	}
	
	public function getRegistrationDate(){
		return $this->registration_date;
	}
}

?>