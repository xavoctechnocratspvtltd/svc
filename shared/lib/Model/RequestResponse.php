<?php

class Model_RequestResponse extends Model_XMLModel {
	public $table = "request_response_docs";

	public $messages=[];

	function init(){
		parent::init();

		$this->hasOne('DocumentContainer','document_container_id');

		$this->addField('xsi_type');
		$this->addField('seq');

		$this->hasMany('AbstractMessage','document_id');

		$this->addHook('afterInsert',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterInsert($obj, $id){
		foreach ($this->messages as $m) {
			$m['req_resp_id'] = $id;
			$m->save();
		}
	}
}