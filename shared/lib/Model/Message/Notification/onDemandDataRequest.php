<?php


class Model_Message_Notification_onDemandDataRequest extends Model_Message_Notification{
	
	public $type= "sOnDemandDataNotification";
	public $addresses_changed = [];

	function render(){
		$message = str_replace("Model_Message_Notification_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");
		$this->xml->documentElement->appendChild($this->xml->createElement('includeConfig','false'));
		foreach ($this->addresses_changed as $add) {
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$add));
		}
		$this->api->responseDoc->dispose_to_notification = true;
		return $this->xml;
	}

	function addAddress($addresses){
		$this->addresses_changed = is_array($addresses)?$addresses:[$addresses];
	}

	//Sample XML Code for NotifyOnDemandData

	// <response xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:sOnDemandDataNotification" reqOrd="1" seq="23">
	// 	<onDemandDataRequest cmsRefId="122">
	// 		<talq:includeConfig >false</talq:includeConfig>
	// 		<address xsi:type="talq:Address">Dev:11</address>
	// 	</onDemandDataRequest>
	// </response>
}