<?php


class Model_CalendarDeviceAssociation extends SQL_Model {
	public $table ="calendar_device_associations";

	function init(){
		parent::init();

		$this->hasOne('AbstractDevice','device_id');

		$this->hasOne('CalendarProgram','calendar_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}