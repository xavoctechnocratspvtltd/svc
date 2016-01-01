<?php


class Model_Device_Lamp extends Model_AbstractDevice {
	function init(){
		parent::init();

		$this->addCondition('deviceType','Lamp');

	}

	function notifyLampMantainance($operation,$initialhours){
		if(!$this->loaded())
			throw new Exception("Model Must be loaded before notifi Lamp Maintanance");

		$devices = $this->getAssociatedDevices(true);
		$devices->_dsql()->del('fields')->field('bridge_id');

		foreach ($devices->getRows(['bridge_id']) as $obj) {

			$device = $this->add('Model_AbstractDevice')->load($obj['bridge_id']);
			$this->api->currentBridge = $device;

	        $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
	        $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	        $message = $response->messages[] = $response->add('Model_Message_Notification_lampMaintenance');
	        $message->addAddress($this['address']);
	        if($operation)
	       		$message->addOperation($operation);
	       	if($initialhours)
	       		$message->addInitialHours($initialhours);

	        $response_doc_model->dispose(true,false);
		}
	}

	function getAssociatedDevices($group_by_bridge=false){
		
		$devices = $this->add('Model_Device_Lamp');
		// $devices->addCondition('fLampActuator_lampTypeId_id',$this->id);
		if($group_by_bridge)
			$devices->_dsql()->group($devices->dsql()->expr('[0]',[$devices->getElement('bridge_id')]));
		
		return $devices;		
					// ->del('fields')->field('id')->getAll();

		// return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($abs_device)),false);
	}
	
}