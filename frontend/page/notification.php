<?php

	/**
	 * Do put htaccess on so Bridge can access this page with <cmsURI>/notification
	 * 
	 * Get getNotifications message from $_POST
	 * fetch address
	 * if device is not Bridge and request is not with address we need BootStrapping 
	 * (
	 * 		Or Better get Device from message, create its object(no need to load) 
	 * 		and simple handover the received message to that object to handle
	 * 		This keeps this page simple and all handling to respected device in its Model/Class/Controller
	 * 		... it should always be Bridge, but let it be this way for expansion to have multiple types of Bridge
	 * 		and keep code categorised
	 * )
	 * 
	 * check if do have that address now live in devices
	 * 
	 * if not Bridge and no address found, send Bridge to get/set update devices information Message and exit
	 * 
	 * 
	 * while (true){
	 * 	loop througth messages model if we have something for this address
	 * 	if yes send it to device and put 200/403/... to message that we have delivered it
	 * 	sleep(well)
	 * }
	 * */

class page_notification extends BridgeAPI {
	
	function init(){
		parent::init();

		set_time_limit(30);

		$requestDoc = $this->add('Model_requestDoc',['xml_string' => @file_get_contents('php://input')]);
		$requestDoc->setUpLive();
		$responseDoc = $requestDoc->respond();

		$responseDoc->dispose(true,false);

		$resp_doc = $this->api->currentBridge->ref('RespondedDocument')
						->addCondition('type','notification_response')
						->addCondition('action','<>','flushed');

		$resp_doc->tryLoadAny();
		
		while(($resp = $resp_doc['Content']) == ""){
			usleep(500);
			$resp_doc->tryLoadAny();
		}

		$resp_doc['action']='flushed';
		$resp_doc->saveAndUnload();

		header('Content-type: text/xml');
		header('Content-length: '.strlen($resp));
		echo $resp;

		exit;
	}
}