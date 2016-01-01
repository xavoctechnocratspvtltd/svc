<?php

class Model_Request extends Model_RequestResponse {
	public $type=null;

	function setUpLive(){
		$this->api->isLive=true;
		
		$this['xsi_type'] = $this->xml->getElementsByTagName('request')->item(0)->getAttribute('xsi:type');
		
		// $this['seq'] = 

		foreach ($this->xml->getElementsByTagName('request')->item(0)->childNodes as $message_xml) {
			$message = $this->messages[] = $this->add('Model_Message_Request_'.$message_xml->tagName ,['xml_string'=>$this->xml->saveXML($message_xml)]);
			$message->setUpLive();
		}
	}

	function respond($responseDoc){
		if(file_exists($this['xsi_type'])){
			return $this->add('Controller_'.$this['xsi_type'])->respond($this->messages);
		}

		$response = $responseDoc->add('Model_Response');

		foreach ($this->messages as $msg) {
			$response_mesg = $msg->respond($response);
			if($response_mesg) $response->messages[] = $response_mesg;
		}
		if($response_mesg)
			$response->type = $response_mesg->type;
		return $response;
	}
	
}