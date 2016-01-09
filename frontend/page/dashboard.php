<?php

class page_dashboard extends Page{

	function init(){
		parent::init();

		$this->api->title = "Dashboard";
		$this->setModel($this->api->auth->model);
	
	}

	function defaultTemplate(){
    	return ['page/dashboard'];
    }
}
