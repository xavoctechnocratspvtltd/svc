<?php

class page_locations_index extends Page {
	
	public $title="Global Locations";
	
	function init(){
		parent::init();
		
		$locations=$this->add('Model_Location')->addCondition('company_id',null);
		$this->add('CRUD')->setModel($locations);

	}

}