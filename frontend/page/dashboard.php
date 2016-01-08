<?php

class page_dashboard extends Page{

	function init(){
		parent::init();

		$this->api->title = "Dashboard";

		// $this->add('View_Info')->set('Hello');
	}

	function defaultTemplate(){
    	return ['page/dashboard'];
    }
}
