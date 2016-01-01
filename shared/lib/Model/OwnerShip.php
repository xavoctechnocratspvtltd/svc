<?php


class Model_OwnerShip extends SQL_Model {
	public $table="ownerships";

	function init(){
		parent::init();

		$this->hasOne('AbstractDevice','device_id');
		$this->addField('function');
		$this->addField('ownership_to_cms')->type('boolean');


		$this->add('dynamic_model/Controller_AutoCreator');
	}
}