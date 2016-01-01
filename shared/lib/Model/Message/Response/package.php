<?php


class Model_Message_Response_package extends Model_AbstractMessage{
	
	public $type= "StatusResponse";
	public $status=200;

	function render(){
		
		$message = str_replace("Model_Message_Response_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message.">".$this->status."</".$message.">");
		return $this->xml;
	}

}