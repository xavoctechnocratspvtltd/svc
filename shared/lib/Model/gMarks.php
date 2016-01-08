<?php

class Model_gMarks extends SQL_Model {
	public $table="gmarks";

	function init(){
		parent::init();

		$this->hasOne('Company');
		$this->hasOne('User');
		$this->hasOne('Rule');
		$this->addField('gmarks');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}