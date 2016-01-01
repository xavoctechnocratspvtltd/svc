<?php


class Model_AuditLog extends SQL_Model {
	public $table ="auditlog";

	function init(){
		parent::init();

		$this->hasOne('User');
		$this->addField('name');
		
		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);

	}


}