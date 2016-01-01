<?php


class Model_AbstractMessage extends Model_XMLModel {
	public $table ="messages";

	function init(){
		parent::init();

		$this->hasOne('RequestResponse','req_resp_id');
		$this->hasOne('AbstractDevice','related_to_device_id');

		$this->addField('name');
		$this->addField('Content')->type('text');
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function setUpLive(){
		$this->api->isLive=true;
		$this['Content'] = $this->xml_string;
		
	}
}