<?php


class Model_CalendarProgram extends Model_AbstractDevice {

	function init(){
		parent::init();

		$this->addCondition('deviceType','Calendar');

		$this->hasMany('CalendarRule','calendarprogram_id');
		$this->hasMany('CalendarDeviceAssociation','calendarprogram_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<calendar></calendar>');

		$this->xml->documentElement->appendChild($this->xml->createElement('address',$this['address']));

		$rules = $this->xml->documentElement->appendChild($this->xml->createElement('rules',''));
		
		foreach ($this->ref('CalendarRule') as $cr) {
			$rules->appendChild(
									$this->xml->importNode($cr->render()->documentElement,true)
								);
		}
		
		return $this->xml;
	}

	function associateDevices($selected_devices, $bridge, $notify=true){
		// remove from old selcted but this time unselected devices
            $unselected_devices = $this->add('Model_Device_Lamp')
                                    ->addCondition('fLampActuator_calendarID_id',$this->id)
                                    ->addCondition('id','<>',array_merge([0],$selected_devices))
                                    ->addCondition('bridge_id',$bridge->id);
            $addresses_effected = [];
            foreach ($unselected_devices as $d) {
                $addresses_effected[] = $d['address'];
                $d['fLampActuator_calendarID_id'] = null;
                $d->saveAndUnload();
                // TODO: send Message with calendar null - 11.2.3.6
            }

            
            if(count($addresses_effected) && $notify){
	            $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
	            $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	            $message = $response->messages[] = $response->add('Model_Message_Notification_assignCalendar',['addresses_changed'=>$addresses_effected,'calendar_address'=>$this['address'],'set_nill'=>true]);
	            $response_doc_model->dispose(true,false,$bridge['address']);
            }


            $addresses_effected = [];
            foreach ($selected_devices as $device_id) {
                $old_model=$this->add('Model_Device_Lamp');
                $old_model->load($device_id);
                
                $addresses_effected[] = $old_model['address'];

                $old_model['fLampActuator_calendarID_id']=$this->id;
                $old_model->save();
            }  

            if(count($addresses_effected) && $notify){
	            $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
	            $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	            $message = $response->messages[] = $response->add('Model_Message_Notification_assignCalendar',['addresses_changed'=>$addresses_effected,'calendar_address'=>$this['address']]);
	            $response_doc_model->dispose(true,false,$bridge['address']);
            } 

	}

	function getAssociatedDevices($bridge_id=null){
		$associated_device = $this->add('Model_Device_Lamp')
					->addCondition('fLampActuator_calendarID_id',$this->id)
					->addCondition('bridge_id',$bridge_id)
					->_dsql()->del('fields')->field('id')->getAll();

		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_device)),false);
	}

	function getAssociatedBridge(){
		if(!$this->loaded())
			throw new \Exception("For Calendar Notify Model must be Loaded");

		$abs_device = $this->add('Model_AbstractDevice')->addCondition('fLampActuator_calendarID_id',$this->id)
					->_dsql()->group('bridge_id')->del('fields')->field('id')->getAll();

		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($abs_device)),false);

	}

	function notify(){
		if(!$this->loaded())
			throw new \Exception("For Calendar Notify Model must be Loaded");
		
		$bridge_array = $this->getAssociatedBridge();

        $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
        
		foreach ($bridge_array as $key => $bridge_id) {			
			$device = $this->add('Model_AbstractDevice')->load($bridge_id);
			$this->api->currentBridge = $device->ref('bridge_id');

	        $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
	        $message = $response->messages[] = $response->add('Model_Message_Notification_calendarChanged');
	        $message->addAddress($this['address']);
	        $response_doc_model->dispose(true,false);
		}




	}

}