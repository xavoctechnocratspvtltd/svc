<?php

class Model_RuleOption extends SQL_Model {
	public $table = 'ruleoption';

	function init(){
		parent::init();

		$this->hasOne('Rule');
	
		$this->addField('name');

		$this->addField('gMarks')->type('text');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}