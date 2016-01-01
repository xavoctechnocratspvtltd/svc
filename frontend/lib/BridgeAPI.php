<?php



class BridgeAPI extends Page {
	function init(){
		parent::init();

		session_write_close();
		header('Content-type: text/xml');

	}

	function recursiveRender(){
		exit;
	}
}