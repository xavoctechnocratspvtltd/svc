<?php


class Model_Message_Notification_override extends Model_Message_Notification{
	
	public $type= "sLightControlNotification";
	public $addresses_changed = [];

	function render(){
		$message = str_replace("Model_Message_Notification_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");
		foreach ($this->addresses_changed as $add => $functions_values) {
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$add));
			foreach ($functions_values as $key => $value) {
				$this->xml->documentElement->appendChild($this->xml->createElement($key,$value));
			}
		}
		$this->api->responseDoc->dispose_to_notification = true;
		return $this->xml;
	}

	function addAddress($addresses){
		$this->addresses_changed = is_array($addresses)?$addresses:[$addresses];
	}

}