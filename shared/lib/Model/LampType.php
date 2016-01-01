<?php


class Model_LampType extends Model_AbstractDevice {

	function init(){
		parent::init();

		$this->addCondition('deviceType','LampType');

	}

	function render(){

		$this->xml = new DOMDocument();
		$this->xml->loadXML('<lampType></lampType>');

		$this->xml->documentElement->appendChild($this->xml->createElement('address',$this['address']));
		$this->xml->documentElement->appendChild($this->xml->createElement('wattage',$this['wattage']));
		$this->xml->documentElement->appendChild($this->xml->createElement('controlType',$this['controlType']));
		$this->xml->documentElement->appendChild($this->xml->createElement('controlVoltMax',$this['controlVoltMax']));
		$this->xml->documentElement->appendChild($this->xml->createElement('controlVoltMin',$this['controlVoltMin']));
		$this->xml->documentElement->appendChild($this->xml->createElement('minLightOutput',$this['minLightOutput']));
		$this->xml->documentElement->appendChild($this->xml->createElement('virtualLightOutput',$this['virtualLightOutput']));
		$this->xml->documentElement->appendChild($this->xml->createElement('daliLedLinear',$this['daliLedLinear']));
		$this->xml->documentElement->appendChild($this->xml->createElement('warmUpTime',$this['warmUpTime']));
		$this->xml->documentElement->appendChild($this->xml->createElement('coolDownTime',$this['coolDownTime']));
		$this->xml->documentElement->appendChild($this->xml->createElement('lowCurrentThreshold',$this['lowCurrentThreshold']));
		$this->xml->documentElement->appendChild($this->xml->createElement('highCurrentThreshold',$this['highCurrentThreshold']));
		$this->xml->documentElement->appendChild($this->xml->createElement('lowLampVoltageThreshold',$this['lowLampVoltageThreshold']));
		$this->xml->documentElement->appendChild($this->xml->createElement('highLampVoltageThreshold',$this['highLampVoltageThreshold']));
		$this->xml->documentElement->appendChild($this->xml->createElement('maxOperatingHours',$this['maxOperatingHours']));
		$this->xml->documentElement->appendChild($this->xml->createElement('powerLightGradient',$this['powerLightGradient']));
		$this->xml->documentElement->appendChild($this->xml->createElement('lampPowerTolerance',$this['lampPowerTolerance']));
		$this->xml->documentElement->appendChild($this->xml->createElement('lampPowerHighThreshold',$this['lampPowerHighThreshold']));
		$this->xml->documentElement->appendChild($this->xml->createElement('powerFactorThreshold',$this['powerFactorThreshold']));
		$lumenDepreciationCurve = $this->xml->documentElement->appendChild($this->xml->createElement('lumenDepreciationCurve',$this['lumenDepreciationCurve']));

		foreach ($this->ref('lumenDepreciationCurve') as $l) {
			$e=$lumenDepreciationCurve->appendChild('entry');
			$e->appendChild('operatingHours',$l['operatingHours']);
			$e->appendChild('percentage',$l['percentage']);
		}

		$this->xml->documentElement->appendChild($this->xml->createElement('cloType',$this['cloType']));
		
		return $this->xml;
	}

	function getAssociatedDevices($group_by_bridge=false){
		
		$devices = $this->add('Model_Device_Lamp');
		$devices->addCondition('fLampActuator_lampTypeId_id',$this->id);

		if($group_by_bridge)
			$devices->_dsql()->group($devices->dsql()->expr('[0]',[$devices->getElement('bridge_id')]));
		
		return $devices;		
					// ->del('fields')->field('id')->getAll();

		// return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($abs_device)),false);
	}

	function notify(){
		if(!$this->loaded())
			throw new \Exception("model must be loaded before notify about LampType Changed");

		$devices = $this->getAssociatedDevices(true);
		$devices->_dsql()->del('fields')->field('bridge_id');

		foreach ($devices->getRows(['bridge_id']) as $obj) {

			$device = $this->add('Model_AbstractDevice')->load($obj['bridge_id']);
			$this->api->currentBridge = $device;

	        $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
	        $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	        $message = $response->messages[] = $response->add('Model_Message_Notification_lampTypeChanged');
	        $message->addAddress($this['address']);
	        $response_doc_model->dispose(true,false);
		}
	}

	function refresh(){

		if(!$this->loaded())
			throw new \Exception("model must be loaded before notify about LampType Changed");

		$devices = $this->getAssociatedDevices(true);
		$devices->_dsql()->del('fields')->field('bridge_id');

		foreach ($devices->getRows(['bridge_id']) as $obj) {

			$device = $this->add('Model_AbstractDevice')->load($obj['bridge_id']);
			$this->api->currentBridge = $device;

	        $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
	        $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	        $message = $response->messages[] = $response->add('Model_Message_Notification_refreshLampType');
	        $message->addAddress($this['address']);
	        $response_doc_model->dispose(true,false);
		}

	}

}