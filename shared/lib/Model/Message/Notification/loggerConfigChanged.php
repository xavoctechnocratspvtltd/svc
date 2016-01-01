<?php


class Model_Message_Notification_loggerConfigChanged extends Model_Message_Notification{
	
	public $type= "sDataCollectNotification";
	public $addresses_changed = [];

	function render(){
		$message = str_replace("Model_Message_Notification_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");
		foreach ($this->addresses_changed as $add) {
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$add));
		}
		$this->api->responseDoc->dispose_to_notification = true;
		return $this->xml;
	}

	function addAddress($addresses){
		$this->addresses_changed = is_array($addresses)?$addresses:[$addresses];
	}


	// <response xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:sDataCollectNotification">
	// 	<loggerConfigChanged>
	// 		<talq:address seq="12">DEV:1234</talq:address>
	// 	</loggerConfigChanged>
	// </response>
}