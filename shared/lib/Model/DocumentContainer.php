<?php


class Model_DocumentContainer extends Model_XMLModel {

	public $table = "communications";

	function init(){
		parent::init();

		$this->hasOne('AbstractDevice','from_device_id');
		$this->hasOne('AbstractDevice','to_device_id');

		$this->addField('Content')->type('text');

		$this->addField('type')->enum(['request','response','notification_response']);

		$this->addField('created_at')->type('datetime')->defaultValue(date("Y-m-d H:i:s"));

		$this->addField('action')->enum(['pending','200','403','flushed'])->defaultValue('pending');

		$this->hasMany('RequestResponse','req_resp_id');

		$this->addHook('afterInsert',$this);

		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function afterInsert($obj,$id){
		
		if(isset($this->responses)){
			foreach ($this->responses as $r) {
				$r['document_container_id'] = $id;
				$r->save();
			}
		}

		if(isset($this->requests)){
			foreach ($this->requests as $r) {
				$r['document_container_id'] = $id;
				$r->save();
			}
		}
	}

	function ref($param){
		return parent::ref($param);
		// Need to redefine to return accurate class object loaded based on from and device type.
		// If its Bridge id should return Bridge object not AbdtractDevice.
	}
}