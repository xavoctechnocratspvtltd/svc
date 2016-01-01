<?php

/**
* <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
* <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
*<responseDoc xmlns="http://talq.org/schemas/core/2013/6">
*<responseDoc xmlns="http://talq.org/schemas/core/2013/6">
*    <response xsi:type="sNotificationNotification" seq="0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
*    <response xsi:type="sNotificationNotification" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
*        <synchronizeBridge>
*            <bridgeAddress>DEV:TB176786124656</bridgeAddress>
*            <lastNotificationSeq>10</lastNotificationSeq>
*        </synchronizeBridge>
*    </response>
*</responseDoc>
*        <synchronizeBridge>
*            <bridgeAddress>DEV:TB176786124656</bridgeAddress>
*            <lastNotificationSeq>0</lastNotificationSeq>
*        </synchronizeBridge>
*    </response>
*</responseDoc>
 */

class Model_Message_Notification_synchronizeBridge extends Model_Message_Notification {

	public $type= "sNotificationNotification";
	public $bridgeAddress=null;
	public $lastNotificationSeq = null;

	function setBridgeAddress($address){
		$this->bridgeAddress = $address;
	}

	function setLastNotificationSeq($number){
		$this->lastNotificationSeq = $number;
	}

	function render(){
		$message = str_replace("Model_Message_Notification_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message."></".$message.">");
		$this->xml->documentElement->appendChild($this->xml->createElement('bridgeAddress',$this->api->currentBridge['address']));
		$this->xml->documentElement->appendChild($this->xml->createElement('lastNotificationSeq',$this->seq));
		$this->api->responseDoc->dispose_to_notification = true;
		return $this->xml;
	}

}