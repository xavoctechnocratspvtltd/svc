<?php
class Model_DeviceLog extends Model_TalqEntity {
	public $table = "devicelog";
	
	function init(){
		parent::init();

		$this->hasOne('LoggerConfig','loggerconfig_id')->mandatory(true);
		$this->hasOne('AbstractDevice','device_id')->mandatory(true);

		$this->addField('address')->mandatory(true);
		$this->addField('timestamp')->mandatory(true);
		$this->addField('type')->enum(['EventLogData','LightStateChangeLogData','PeriodicLogData','sDataCollectEventLogData']);

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}

	function loggerConfig(){
		if(!$this->loaded())
			throw new Exception("Log Model Must be Loaded");
			
		return $this->ref('loggerconfig_id');
	}

	function render(){
		$this->xml = new DOMDocument();
		$logger_config = $this->loggerConfig();
		$reporting_mode_model = $logger_config->reportingMode();

		foreach ($reporting_mode_model as $reporting_mode) {
			
			$this->xml->loadXML('<logReport></logReport>');
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$this['address']));
			
			$log_entry = $this->xml->documentElement->appendChild($this->xml->createElement('logEntry',''));
			$log_entry->appendChild($this->xml->createElement('timestamp',$this['timestamp']));

			$data = $log_entry->appendChild($this->xml->createElement('data',''));
			$data->setAttributeNode(new DOMAttr('xsi:type',$this['type']));


			//Check for the Reporting Mode
			switch ($reporting_mode_model->get('type')) {
				case 'talq:ScheduledReportingMode':
					
					break;
				case 'talq:ImmediateReportingMode':
						
					break;
			}

			return $this->xml;
		}
		


	}

	// <logReport>
	// 	<address xsi:type="talq:Address" >dev:111</address>
	// 	<logEntry>
	// 		<timestamp>2001-12-17T09:30:47Z</timestamp> 
	// 		<!--Data xsi:type has only one value amoung it's options-->
	// 		<data xsi:type="talq:EventLogData"> 
	// 			<eventType xsi:type="talq:EventType">talq:cabinetDoorOpen</eventType>
	// 			<srcAddress xsi:type="talq:Address">dev:111</srcAddress>
	// 			<!--
	// 				Missing:
	// 				<attributes>
	// 					<attribute srcAddress="dev:123" tag="someFieldname_of_device">Value to log</attribute>
	// 				</attributes>

	// 				Look at xsd line 546
	// 			-->
	// 		</data>
	// 	</logEntry>
	// </logReport>
}