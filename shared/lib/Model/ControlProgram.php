<?php


class Model_ControlProgram extends Model_AbstractDevice {

	function init(){
		parent::init();

		$this->hasMany('ControlProgram_ActivePeriod','controlprogram_id');
		$this->hasMany('ControlProgram_FixedTimeControlItem','controlprogram_id');
		$this->hasMany('CalendarRule','controlprogram_id');

		$this->addCondition('deviceType','ControlProgram');
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<controlProgram></controlProgram>');

		$this->xml->documentElement->setAttributeNode(new DOMAttr('xsi:type','ControlProgramOne'));

		$this->xml->documentElement->appendChild($this->xml->createElement('address',$this['address']));

		$activePeriods = $this->xml->documentElement->appendChild($this->xml->createElement('activePeriods',''));
		
		foreach ($this->ref('ControlProgram_ActivePeriod') as $ap) {
			$activePeriods->appendChild(
									$this->xml->importNode($ap->render()->documentElement,true)
								);
		}
		
		$fixedTime = $this->xml->documentElement->appendChild($this->xml->createElement('fixedTimeControl',''));
		foreach ($this->ref('ControlProgram_FixedTimeControlItem') as $ftc) {
			$fixedTime->appendChild(
									$this->xml->importNode($ftc->render()->documentElement,true)
								);
		}


		return $this->xml;
	}

	function getAssociatedDevices($group_by_bridge=false){
		
		$abs_device = $this->add('Model_AbstractDevice');
		$calendar_pro_j = $abs_device->join('devices','fLampActuator_calendarID_id',null,'cal_j');
		$calendar_rule_j = $calendar_pro_j->join('calendar_rules.calendarprogram_id',null,null,'rule_j');
		$calendar_rule_j->addField('controlprogram_id');
		$abs_device->addCondition('controlprogram_id',$this->id);
		if($group_by_bridge)
			$abs_device->_dsql()->group($abs_device->dsql()->expr('[0]',[$abs_device->getElement('bridge_id')]));
		
		return $abs_device;		
					// ->del('fields')->field('id')->getAll();

		// return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($abs_device)),false);
	}

	function notify(){
		if(!$this->loaded())
			throw new \Exception("model must be loaded before notify about controlProgram Changed");

		$devices = $this->getAssociatedDevices(true);
		// $devices->_dsql()->del('fields')->field('bridge_id');

		foreach ($devices->getRows(['bridge_id']) as $obj) {

			$device = $this->add('Model_AbstractDevice')->load($obj['bridge_id']);
			$this->api->currentBridge = $device;

	        $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
	        $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	        $message = $response->messages[] = $response->add('Model_Message_Notification_controlProgramChanged');
	        $message->addAddress($this['address']);
	        $response_doc_model->dispose(true,false);
		}
	}


}