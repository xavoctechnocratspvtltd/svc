<?php


class Model_Message_Response_lampType extends Model_AbstractMessage{
	
	public $type= "sLightControlResponse";
	public $addresses_demanded=null;

	function render(){

		$message = str_replace("Model_Message_Response_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");

		
		foreach ($this->addresses_demanded as $address) {
			$lt_m = $this->add('Model_LampType')->tryLoadBy('address',$address);
			
			if(!$lt_m->loaded())
				throw new Exception("Wrong address event or ask of this entity from bridge", 1);
				
			$this->xml->documentElement->appendChild(
				$this->xml->importNode($lt_m->render()->documentElement,true)
			);
		}
		return $this->xml;
	}

}