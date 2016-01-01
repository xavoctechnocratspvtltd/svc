<?php

class Model_Message_Request_getGroup extends Model_AbstractMessage {

	public $type="sNotificationRequest";

	function init(){
		parent::init();
		
	}

	function respond($response){

		if(!isset($this->api->currentBridge)){
			return $this->add('Model_Device_TalqBridge')->initBootstrap($response);
		}
	}
}