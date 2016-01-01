<?php
class Model_ReportingMode extends  Model_XMLModel{
	public $table = "reporting_modes";
	
	function init(){
		parent::init();

		$this->hasOne('LoggerConfig','loggerconfig_id');
		$this->addField('type')->enum(['talq:ScheduledReportingMode','talq:ImmediateReportingMode'])->mandatory('true');
		$this->addField('numberOfRetries')->type('Number')->mandatory(true);
		$this->addField('times')->hint('multiple value by Comma(,) separate. ie. 00:00:00, 02:05:10');
		$this->addField('randomTime');

		//If ReportingMode type is talq:ImmediateReportingMode
		$this->addField('delay');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<reportingMode></reportingMode>');
		$this->xml->documentElement->setAttributeNode(new DOMAttr('xsi:type',$this['type']));
		$this->xml->documentElement->appendChild($this->xml->createElement('numberOfRetries',$this['numberOfRetries']));
				
		switch ($this['type']) {
			case 'talq:ScheduledReportingMode':
				$times = $this->xml->documentElement->appendChild($this->xml->createElement('times',''));
				$times_array = explode(',', $this['times']);
				foreach ($times_array as $key => $time) {
					$times->appendChild($this->xml->createElement('time',$time));
				}
				$this->xml->documentElement->appendChild($this->xml->createElement('randomTime',$this['randomTime']));
			break;
			
			case 'talq:ImmediateReportingMode':
				$sampling_profile = $this->xml->documentElement->appendChild($this->xml->createElement('delay',$this['delay']));

			break;
		}

		return $this->xml;
	}

		// 	<talq:reportingMode xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:ScheduledReportingMode">
		// 	<talq:numberOfRetries>3</talq:numberOfRetries>
		// 	<talq:times>
		// 		<talq:time>00:00:00</talq:time>
		// 	</talq:times>
		// 	<talq:randomTime>123455667</talq:randomTime>
		// </talq:reportingMode>


		// <talq:reportingMode xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:ImmediateReportingMode">
		// 	<talq:numberOfRetries>3</talq:numberOfRetries>
		// 	<talq:delay>60</talq:delay>
		// </talq:reportingMode>


}