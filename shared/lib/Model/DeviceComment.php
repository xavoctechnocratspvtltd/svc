<?php


class Model_DeviceComment extends SQL_Model {
	public $table = "device_comment";

	function init(){
		parent::init();
		$this->hasOne('AbstractDevice','device_id');
		$this->addField('name');
		

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}