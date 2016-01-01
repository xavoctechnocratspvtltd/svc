<?php

class page_lightControl extends BridgeAPI {
	function init(){
		parent::init();
		
		$requestDoc = $this->add('Model_requestDoc',['xml_string' => @file_get_contents('php://input')]);
		$requestDoc->setUpLive();
		$responseDoc = $requestDoc->respond();

		$requestDoc->save();

		$responseDoc->dispose();

	}
}