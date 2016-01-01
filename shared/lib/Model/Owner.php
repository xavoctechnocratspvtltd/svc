<?php


class Model_Owner extends Model_Company{

	public $table_alias='owner';
	
	function init(){
		parent::init();

		// $this->addCondition('type','Owner');

	}
}