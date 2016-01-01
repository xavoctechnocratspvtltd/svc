<?php


class Model_Maintainer extends Model_Company{
	
	public $table_alias='maintainer';

	function init(){
		parent::init();

		// $this->addCondition('type','Maintainer');

	}
}