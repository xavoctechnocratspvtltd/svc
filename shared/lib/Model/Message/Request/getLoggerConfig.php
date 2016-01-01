<?php

class Model_Message_Request_getLoggerConfig extends Model_AbstractMessage {

	public $type="sDataCollectRequest";

	function init(){
		parent::init();
		
	}

	function respond($response){

		// if(!isset($this->api->currentBridge)){
		// 	return $this->add('Model_Device_TalqBridge')->initBootstrap($response);
		// }

		$address =  $this->domxpath->query('//address');
		$addresses_demanded = [];
		foreach ($address as $ad_dom) {
			$addresses_demanded[]  = $ad_dom->nodeValue;
		}

		$m = $response->add('Model_Message_Response_loggerConfig',['addresses_demanded'=>$addresses_demanded]);
		return $m;
	}
}