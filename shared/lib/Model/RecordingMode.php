<?php
class Model_RecordingMode extends  Model_XMLModel{
	public $table = "recording_modes";
	
	function init(){
		parent::init();

		$this->hasOne('LoggerConfig','loggerconfig_id');
		$this->addField('type')->enum(['talq:EventRecordingMode','talq:PeriodicRecordingMode']);
		$this->addField('list')->enum(['talq:whiteList','talq:blackList']);
		$this->addField('event_type')->enum(['talq:cabinetDoorOpen','talq:controlGearComFailure'])->hint('Multiselect Field'); //Multiselect Field;

		//If Reporting Mode type is PeriodicRecordingMode
		$this->addField('samplingStartTime');
		$this->addField('samplingPeriod');

		$this->addHook('beforSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforSave(){

	}


	function render(){
			
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<recordingMode></recordingMode>');
		$this->xml->documentElement->setAttributeNode(new DOMAttr('xsi:type',$this['type']));

		switch ($this['type']) {
			case 'talq:EventRecordingMode':
				$source_event = $this->xml->documentElement->appendChild($this->xml->createElement('sourceEvents',''));
				$white_list = $source_event->appendChild($this->xml->createElement('whiteList',''));

				$selected_event_type_array = explode(',', $this['event_type']);
				foreach ($selected_event_type_array as $key => $event_type) {
					$white_list->appendChild($this->xml->createElement('eventType',$event_type));
				}
				
			break;
			
			case 'talq:PeriodicRecordingMode':
				$sampling_profile = $this->xml->documentElement->appendChild($this->xml->createElement('samplingProfile',''));
				$sampling_profile->appendChild($this->xml->createElement('samplingStartTime',$this['samplingStartTime']));
				$sampling_profile->appendChild($this->xml->createElement('samplingPeriod',$this['samplingPeriod']));

			break;
		}

		return $this->xml;
	}

	// 	<talq:recordingMode xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:EventRecordingMode">
	// 	<talq:sourceEvents>
	// 		<talq:whiteList>
	// 			<talq:eventType>talq:cabinetDoorOpen</talq:eventType>
	// 			<talq:eventType>talq:controlGearComFailure</talq:eventType>
	// 		</talq:whiteList>
	// 	</talq:sourceEvents>
	// </talq:recordingMode>


	// <talq:recordingMode xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:PeriodicRecordingMode">
	// 	<talq:samplingProfile>
	// 		<talq:samplingStartTime>2001-12-17T09:30:47Z</talq:samplingStartTime>
	// 		<talq:samplingPeriod>P0Y1347M0D</talq:samplingPeriod>
	// 	</talq:samplingProfile>
	// </talq:recordingMode>
}