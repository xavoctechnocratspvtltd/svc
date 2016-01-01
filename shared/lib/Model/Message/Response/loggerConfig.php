<?php


class Model_Message_Response_loggerConfig extends Model_AbstractMessage{
	
	public $type= "sDataCollectResponse";
	public $status=200;
	public $addresses_demanded=null;

	function render(){
		
		$message = str_replace("Model_Message_Response_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message.">".$this->status."</".$message.">");

		foreach ($this->addresses_demanded as $address) {
			$lc_m = $this->add('Model_LoggerConfig')->tryLoadBy('address',$address);
			
			if(!$lc_m->loaded())
				throw new Exception("Wrong address event or ask of this entity from bridge", 1);
				
			$this->xml->documentElement->appendChild(
				$this->xml->importNode($lc_m->render()->documentElement,true)
			);
		}
		return $this->xml;
	}

}