<?php
class Model_LoggerConfig extends Model_AbstractDevice {
	// public $table = "logger_configs";
	
	function init(){
		parent::init();

		// $this->addField('address')->mandatory(true);
		$this->addCondition('deviceType','LoggerConfig');

		$this->hasMany('SourceAddress','loggerconfig_id');
		$this->hasMany('RecordingMode','loggerconfig_id');
		$this->hasMany('ReportingMode','loggerconfig_id');
		$this->hasMany('LoggerconfigBridgeAsso','loggerconfig_id');
		$this->hasMany('Log','loggerconfig_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function reportingMode(){
		if(!$this->loaded())
			throw new \Exception("Log Model Must be loaded before load ReportingMode");
		
		return $this->ref('ReportingMode');
	}

	function getBridge(){
		$associated_bridge = $this->add('Model_LoggerconfigBridgeAsso')
			->addCondition('loggerconfig_id',$this->id)
			->_dsql()->del('fields')->field('bridge_id')->getAll();

		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_bridge)),false);
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<loggerConfig></loggerConfig>');
		$this->xml->documentElement->setAttributeNode(new DOMAttr('modifier',$this['modifier']));

		$this->xml->documentElement->appendChild($this->xml->createElement('address',$this['address']));

		// $sourceAddresses = $this->xml->documentElement->appendChild($this->xml->createElement('sourceAddresses',''));
		$sourced_address_model = $this->add('Model_SourceAddress',['loggerconfig_id'=>$this['id']]);
		// foreach ($this->ref('SourceAddress') as $sa) {
			$this->xml->documentElement->appendChild(
									$this->xml->importNode($sourced_address_model->render($this['id'])->documentElement,true)
								);
		// }
		
		// $recordingMode = $this->xml->documentElement->appendChild($this->xml->createElement('recordingMode',''));
		foreach ($this->ref('RecordingMode') as $rcm) {
			$this->xml->documentElement->appendChild(
									$this->xml->importNode($rcm->render()->documentElement,true)
								);
		}

		// $reportingMode = $this->xml->documentElement->appendChild($this->xml->createElement('reportingMode',''));
		foreach ($this->ref('ReportingMode') as $rpa) {
			$this->xml->documentElement->appendChild(
									$this->xml->importNode($rpa->render()->documentElement,true)
								);
		}

		return $this->xml;

	}

	// 	<loggerConfig modifier="complete" seq="12">
	// 		<talq:address>dev:1234</talq:address>
	// 		<talq:sourceAddresses>
	// 			<talq:whiteList>
	// 				<talq:address>dev:1234</talq:address>
	// 			</talq:whiteList>
	// 			<talq:blackList>
	// 				<talq:address>dev:1234</talq:address>
	// 			</talq:blackList>
	// 		</talq:sourceAddresses>

	// 		<talq:recordingMode xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:EventRecordingMode">
	// 			<talq:sourceEvents>
	// 				<talq:whiteList>
	// 					<talq:eventType>talq:cabinetDoorOpen</talq:eventType>
	// 					<talq:eventType>talq:controlGearComFailure</talq:eventType>
	// 				</talq:whiteList>
	// 			</talq:sourceEvents>
	// 		</talq:recordingMode>


	// 		<talq:reportingMode xmlns:talq="http://talq.org/schemas/core/2013/6" xsi:type="talq:ScheduledReportingMode">
	// 			<talq:numberOfRetries>3</talq:numberOfRetries>
	// 			<talq:times>
	// 				<talq:time>00:00:00</talq:time>
	// 			</talq:times>
	// 			<talq:randomTime>123455667</talq:randomTime>
	// 		</talq:reportingMode>
	// 	</loggerConfig>
	// </response>
}