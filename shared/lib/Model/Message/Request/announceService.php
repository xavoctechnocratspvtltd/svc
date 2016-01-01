<?php


class Model_Message_Request_announceService extends Model_AbstractMessage{
	
	public $type= "sConfigurationRequest";

	function respond($response){
		header('Content-length: 0');
		exit;
		return $response->add('Model_Message_Response_statusResponse');
	}
}