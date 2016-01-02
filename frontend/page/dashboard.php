<?php

class page_dashboard extends Page{
	public $title="Map Editor";
	function init(){
		parent::init();

		$this->api->title = "Dashboard";

	}
}
