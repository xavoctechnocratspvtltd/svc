<?php


class Model_Message_Response_controlProgram extends Model_AbstractMessage{

	public $type= "sLightControlResponse";
	public $addresses_demanded=null;

	function render(){

		$message = str_replace("Model_Message_Response_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");

		
		foreach ($this->addresses_demanded as $address) {
			$cp_m = $this->add('Model_ControlProgram')->tryLoadBy('address',$address);
			
			if(!$cp_m->loaded())
				throw new Exception("Wrong address event or ask of this entity from bridge", 1);
				
			$this->xml->documentElement->appendChild(
				$this->xml->importNode($cp_m->render()->documentElement,true)
			);
		}
		return $this->xml;
	}

}