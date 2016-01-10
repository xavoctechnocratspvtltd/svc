<?php

class Model_RuleBookCrossCheckOption extends SQL_Model {
	public $table="rulebookcrosscheckoption";

	function init(){
		parent::init();

		$this->hasOne('RuleBook');
		$this->addField('name');
		$this->addField('gMarks')->type('text');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}