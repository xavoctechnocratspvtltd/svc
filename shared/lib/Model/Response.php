<?php


class Model_Response extends Model_RequestResponse{

	public $type=null;
	public $sequence=null;

	function setSequence($number){
		$this->sequence = $number;
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></response>');
		$r = $this->xml->getElementsByTagName('response')->item(0);
		$r->setAttributeNode(new DOMAttr('xsi:type', $this->type));
		
		if($this->sequence){
			$this->xml->documentElement->setAttribute('seq',$this->sequence);
		}

		foreach ($this->messages as $m) {
			$this->xml->documentElement->appendChild(
					$this->xml->importNode($m->render()->documentElement,true)
				);
		}

		return $this->xml;
	}

}