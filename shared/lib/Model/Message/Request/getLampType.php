<?php

class Model_Message_Request_getLampType extends Model_AbstractMessage {

	
	public $type="sNotificationRequest";

	function init(){
		parent::init();
		
	}

	function respond($response){
		$address =  $this->domxpath->query('//address');
		$addresses_demanded = [];
		foreach ($address as $ad_dom) {
			$addresses_demanded[]  = $ad_dom->nodeValue;
		}

		$m = $response->add('Model_Message_Response_lampType',['addresses_demanded'=>$addresses_demanded]);
		return $m;
	}
}