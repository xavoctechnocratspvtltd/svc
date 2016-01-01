<?php


class Model_Message_Notification_assignCalendar extends Model_Message_Notification{
	
	public $type= "sLightControlNotification";
	public $addresses_changed = [];
	public $calendar_address=null;
	public $set_nill = false;

	function render(){
		$message = str_replace("Model_Message_Notification_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");
		foreach ($this->addresses_changed as $add) {
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$add));
		}
	
		$cal = $this->xml->documentElement->appendChild($this->xml->createElement('calendar',$this->calendar_address));
		if($this->set_nill){
			$cal->setAttribute('nil','true');
		}

		$this->api->responseDoc->dispose_to_notification = true;
		return $this->xml;
	}

	function addAddress($addresses){
		$this->addresses_changed = is_array($addresses)?$addresses:[$addresses];
	}

}