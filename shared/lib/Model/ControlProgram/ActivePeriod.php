<?php


class Model_ControlProgram_ActivePeriod extends Model_XMLModel {
	public $table ="active_periods";

	function init(){
		parent::init();

		$this->hasOne('ControlProgram','controlprogram_id');
		
		$this->addField('type')->mandatory(true)->defaultValue('AstroClockActivePeriod'); //Attr

		$this->addField('sunriseOffset')->mandatory(true);
		$this->addField('sunsetOffset')->mandatory(true);


		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<activePeriod></activePeriod>');
		
		$ap = $this->xml->getElementsByTagName('activePeriod')->item(0);
		@$ap->setAttributeNode(new DOMAttr('xsi:type',$this['type']));

		$this->xml->documentElement->appendChild($this->xml->createElement('sunriseOffset',$this['sunriseOffset']));
		$this->xml->documentElement->appendChild($this->xml->createElement('sunsetOffset',$this['sunsetOffset']));
		return $this->xml;
	}

}