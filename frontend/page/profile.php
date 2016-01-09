<?php

class page_profile extends Page {
	
	function init(){
		parent::init();

		$this->setModel($this->api->auth->model);

	}

	function defaultTemplate(){
		return ['page/profile'];
	}

}