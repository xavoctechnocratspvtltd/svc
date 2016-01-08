<?php

class Model_Company extends SQL_Model {
	public $table= 'company';

	function init(){
		parent::init();

		$this->hasOne('Industry');
		$this->hasOne('User','owner_id');
		
		$this->addField('name');

		$this->addField('is_closed')->type('boolean')->defaultValue(false);

		$this->hasMany('User',null,null,'Staff');
		$this->hasMany('gMarks');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);

	}
}