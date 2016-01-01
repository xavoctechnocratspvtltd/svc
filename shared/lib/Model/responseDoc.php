<?php


class Model_responseDoc extends Model_DocumentContainer {
	public $responses=[];
	public $dispose_to_notification=false;

	function init(){
		parent::init();		
		$this->addCondition('type',['response','notification_response']);
		
	}

	function setUpLive(){
		$this->api->isLIve = true;
		$this->api->responseDoc= $this;
		// $this->addCondition('to_device_id',@$this->api->currentBridge->id);
		return $this;
	}

	function setType($type){
		$this->type = $type;
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<responseDoc xmlns="http://talq.org/schemas/core/2013/6"></responseDoc>');
		if((isset($this->api->requestDoc) and $this->api->requestDoc->containsBridgeAddress) OR $this->api->currentBridge)
			$this->xml->documentElement->setAttributeNode(new DOMAttr('bridgeAddress', $this->api->currentBridge['address']));

		foreach ($this->responses as $r) {
			$this->xml->documentElement->appendChild(
					$this->xml->importNode($r->render()->documentElement,true)
				);
		}

	}

	function dispose($save=true, $flush=true, $addBridgeAddress=false){
		$this->render();
		if($addBridgeAddress)
			$this->xml->documentElement->setAttributeNode(new DOMAttr('bridgeAddress', $addBridgeAddress));
		$xml_output = $this->xml->saveXML();
		$this['Content'] = $xml_output;
		if($save){
			if(@$this->api->currentBridge->id && !$this['to_device_id']){
				$this['to_device_id'] = $this->api->currentBridge->id;
			}
			$this['type']='response';
			if($this->dispose_to_notification){
				$this['type']='notification_response';
				$flush=false;
			}
			$this->save();
		}
		
		file_put_contents('../assets/flow.txt', "\n".$this['type']." " . $_SERVER['REDIRECT_URL']." - \n" . $xml_output ,FILE_APPEND);

		if($flush){
			header('Content-type: text/xml');
			header('Content-length: '.strlen($xml_output));
			echo $xml_output;
			exit;
		}else{
			// file_put_contents('../assets/flow.txt', "\n".$this['type']." " . $_SERVER['REDIRECT_URL']." - \n" . $xml_output ,FILE_APPEND);
			return $xml_output;
		}
	}
}