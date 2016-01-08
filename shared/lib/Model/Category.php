<?php

class Model_Category extends SQL_Model {
	public $table ="category";

	function init(){
		parent::init();

		$this->addField('name');
		$this->hasMany('Rule');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}