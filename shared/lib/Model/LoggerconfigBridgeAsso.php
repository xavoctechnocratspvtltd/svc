<?php


class Model_LoggerconfigBridgeAsso extends SQL_Model {
	public $table ="loggerconfig_bridg_associations";

	function init(){
		parent::init();

		$this->hasOne('LoggerConfig','loggerconfig_id')->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('Device_TalqBridge','bridge_id');

		$this->add('dynamic_model/Controller_AutoCreator');

		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		//TODO Check for the duplicate entry
		
	}

	function newAssociation($loggerconfig_array, $bridge_array){
		if(!is_array($loggerconfig_array) and is_array($bridge_array))
			throw new \Exception("Must Pass Param as Array");
		
		foreach ($loggerconfig_array as $l_key => $loggerconfig_id) {
				foreach ($bridge_array as $b_key => $bridge_id) {
					$asso_model = $this->add('Model_LoggerconfigBridgeAsso');
					$asso_model->addCondition('loggerconfig_id',$loggerconfig_id);
					$asso_model->addCondition('bridge_id',$bridge_id);
					$asso_model->tryLoadAny();
					$asso_model->save();

					//TODO remove Associted entry
				}
			}	

	}


	function getAssociatedBridge($loggerconfig_id){
		if(!$loggerconfig_id)
			throw new Exception("ConfigLogger Id Param Required");
		
		$model = $this->addCondition('loggerconfig_id',$loggerconfig_id)->tryLoadAny();
		$bridge_array = [];
		foreach ($model as $record) {
			$bridge_array[] = $record['bridge_id'];
		}

		return $bridge_array;
		
	}


}