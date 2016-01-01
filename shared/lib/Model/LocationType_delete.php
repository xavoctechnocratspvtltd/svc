<?php


class Model_LocationType extends SQL_Model {
	public $table = "location_types";

	function init(){
		parent::init();

		$this->addField('name')->mandatory(true);
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}