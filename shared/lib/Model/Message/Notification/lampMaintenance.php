<?php


class Model_Message_Notification_lampMaintenance extends Model_Message_Notification{
	
	public $type= "sLightControlNotification";
	public $addresses_changed = [];
	public $operation;
	public $initialHours;
	function render(){
		$message = str_replace("Model_Message_Notification_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");
		foreach ($this->addresses_changed as $add) {
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$add));
		}

		if($this->operation)
			$this->xml->documentElement->appendChild($this->xml->createElement('operation',$this->operation));
			// <talq:operation initialHours="3" >replaced</talq:operation>
		
		if($this->initialHours){
			$operation = $this->xml->getElementsByTagName('operation')->item(0);
			$operation->setAttributeNode(new DOMAttr('initialHours',$this->initialHours));
		}

		$this->api->responseDoc->dispose_to_notification = true;
		return $this->xml;
	}

	function addAddress($addresses){
		$this->addresses_changed = is_array($addresses)?$addresses:[$addresses];
	}


	function addOperation($operation){
		$this->operation = $operation;
	}

	function addInitialHours($initialHours)
	{
		$this->initialHours = $initialHours;
	}

}