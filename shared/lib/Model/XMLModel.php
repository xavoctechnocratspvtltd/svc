<?php


class Model_XMLModel extends SQL_Model {
	public $xml_string= null ;
	public $xml = null;
	public $domxpath=null;
	public $isLive=false;

	function init(){
		parent::init();
		$this->populateXML();
	}

	function populateXML(){
		if($this->xml_string != null && $this->xml == null){
			$this->xml = new DOMDocument();
			$this->xml->preserveWhiteSpace=false;
			@$this->xml->loadXML($this->xml_string);
			$this->domxpath = new DOMXPath($this->xml);
		}elseif($this->xml != null && $this->xml_string ==null){
			$this->xml_string = $this->xml->saveXML();
		}
	}

	function __call($method, $arguments){
		if($this->xml instanceof DOMDocument && method_exists($this->xml, $method)){
			return call_user_func_array([$this->xml,$method], $arguments);
		}
		parent::__call($method, $arguments);
	}

}