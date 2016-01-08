<?php

class Model_Industry extends SQL_Model{
	public $table = "industry";

	function init(){
		parent::init();

		$this->addField('name');
		$this->hasMany('Company');
		$this->hasMany('Rule');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}

}