<?php

class Model_RuleBookOption extends SQL_Model {
	public $table = 'rulebookoption';

	function init(){
		parent::init();

		$this->hasOne('RuleBook');
	
		$this->addField('name');

		$this->addField('gMarks')->type('text');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}