<?php

class Level{
	
// 	Attributes

	private $id;
	private $name;
	
	
// 	Setters

	public function setId($id){
		$this->id = $id;
	}
	
	public function setName($serial){
		$this->name = $serial;
	}
	
// 	Getters

	public function getId(){
		return $this->id;
	}
	
	public function getName(){
		return $this->name;
	}
}

?>