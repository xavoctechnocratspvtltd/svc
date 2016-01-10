<?php

class Model_RuleCrossCheckOption extends SQL_Model {
	public $table="rulecrosscheckoption";

	function init(){
		parent::init();

		$this->hasOne('Rule');
		$this->addField('name');
		$this->addField('gMarks')->type('text');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}