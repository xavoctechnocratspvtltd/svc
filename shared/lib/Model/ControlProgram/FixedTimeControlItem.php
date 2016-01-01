<?php


class Model_ControlProgram_FixedTimeControlItem extends Model_XMLModel {
	public $table ="fixed_time_control_items";

	function init(){
		parent::init();

		$this->hasOne('ControlProgram','controlprogram_id');
		
		$this->addField('startTime')->mandatory(true);
		$this->addField('stateLevel')->mandatory(true);


		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<item></item>');

		$this->xml->documentElement->appendChild($this->xml->createElement('startTime',$this['startTime']));
		
		$lightCommand = $this->xml->documentElement->appendChild($this->xml->createElement('lightCommand',''));
		$state = $lightCommand->appendChild($this->xml->createElement('state',''));
		$level = $state->appendChild($this->xml->createElement('level',$this['stateLevel']));

		return $this->xml;		
	}

}