<?php
class Model_SourceAddress extends  Model_XMLModel{
	public $table = "source_addresses";
	public $loggerconfig_id;
	function init(){
		parent::init();

		$this->hasOne('LoggerConfig','loggerconfig_id');
		// $this->hasOne('AbstractDevice','abstractdevice_id');
		$this->addField('type')->enum(array('whiteList','blackList'))->mandatory(true);
		$this->addField('address')->mandatory(true)->hint('Multiselect Dropdown, currently comma separated values');//MultiSelect Value.

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		
		if(!$this->loggerconfig_id)
			throw new \Exception("Logger Config Required");
			
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<sourceAddresses></sourceAddresses>');

		//Note SourceAddress has one entry for each type and save multiple address as comma separated
		
		$whitelist_model = $this->add('Model_SourceAddress')->addCondition('loggerconfig_id',$this->loggerconfig_id)->addCondition('type','whiteList')->tryLoadAny();
		if($whitelist_model->loaded()){
			$white_list = $this->xml->documentElement->appendChild($this->xml->createElement('whiteList',''));
			$whiteList_array = explode(',',$whitelist_model['address']);
			foreach ($whiteList_array as $key => $address) {
				$white_list->appendChild($this->xml->createElement('address',$address));
			}

		}


		$blacklist_model = $this->add('Model_SourceAddress')->addCondition('loggerconfig_id',$this->loggerconfig_id)->addCondition('type','blackList')->tryLoadAny();	
		if($blacklist_model->loaded()){	
			$black_list = $this->xml->documentElement->appendChild($this->xml->createElement('blackList',''));
			$blackList_array = explode(',',$blacklist_model['address']);			
			foreach ($blackList_array as $key => $address) {
				$black_list->appendChild($this->xml->createElement('address',$address));
			}

		}	

		return $this->xml;
			
	}


	// <talq:sourceAddresses>
	// 	<talq:whiteList>
	// 		<talq:address>dev:1234</talq:address>
	// 	</talq:whiteList>
	// 	<talq:blackList>
	// 		<talq:address>dev:1234</talq:address>
	// 	</talq:blackList>
	// </talq:sourceAddresses>
}