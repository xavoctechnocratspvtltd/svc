<?php


class Model_requestDoc extends Model_DocumentContainer {
	
	public $requests=[];
	public $containsBridgeAddress=false;

	function init(){
		parent::init();

		$this->addCondition('type','request');

	}

	function setUpLive(){
		$this->api->isLive=true;
		$this->api->requestDoc = $this;
		if($this->xml && $bridgeAddress = $this->xml->getElementsByTagName('requestDoc')->item(0)->getAttribute('bridgeAddress')){
			$this->containsBridgeAddress=true;
			$this->api->currentBridge = $this->add('Model_Device_TalqBridge',['table_alias'=>'tb'])->loadBy('address',$bridgeAddress);
			
		}

		$this['Content'] = $this->xml_string;

		foreach ($this->xml->getElementsByTagName('requestDoc')->item(0)->childNodes as $request_xml) {
			$request = $this->requests[] = $this->add('Model_Request',['xml_string'=>$this->xml->saveXML($request_xml)]);
			$request->setUpLive();
		}
	}

	function respond(){
		$responseDoc = $this->add('Model_responseDoc');
		if($this->api->isLive) {
			$responseDoc->setUpLive();
		}

		foreach ($this->requests as $r) {
			$responseDoc->responses[] = $r->respond($responseDoc);
		}
		
		return $responseDoc;
	}
}