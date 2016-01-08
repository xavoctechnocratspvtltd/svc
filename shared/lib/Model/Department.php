<?php

class Model_Department extends SQL_Model {
	public $table = "department";
	
	function init(){
		parent::init();

		$this->addField('name');
		$this->hasMany('User',null,null,'Staff');
		$this->hasMany('Rule');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}