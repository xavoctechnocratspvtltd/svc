<?php


class Model_Message_Response_deviceConfiguration extends Model_AbstractMessage{
	
	public $type= "sConfigurationResponse";
	public $addresses_demanded=[];

	function render(){
		
		$message = str_replace("Model_Message_Response_","",get_class($this));
		$this->xml = new DOMDocument();
		$this->xml->loadXML("<".$message." modifier='complete'></".$message.">");

		// $this->xml->setAttribute('modifier',"complete");

		foreach ($this->add('Model_AbstractDevice')->addCondition('address',$this->addresses_demanded) as $d) {
			$specific_device = $this->add('Model_Device_'.$d['deviceType']);
			$this->xml->documentElement->appendChild($this->xml->createElement('address',$d['address']));
			$this->xml->documentElement->appendChild($this->xml->createElement('class',$d['class']));
			$functions = $this->xml->documentElement->appendChild($this->xml->createElement('functions'));

			foreach ($specific_device->functions as $functionID => $function_names) {
				
				if(!count($function_names)) continue;
				
				$f_x = $this->xml->createElement('function');
				$f_x->setAttribute('xsi:type',$functionID);
				$f_x->setAttribute('functionId',$functionID);
				$function = $functions->appendChild($f_x);


				$ext = $function->appendChild($this->xml->createElement('ext'));

				foreach ($function_names as $fname) {
					if($d[$functionID."_".$fname]){
						$attr = $ext->appendChild($this->xml->createElement('attribute',$d[$functionID."_".$fname]));
						$attr->setAttribute('name',$fname);
					}
				}
				$function->appendChild($this->xml->createElement('name',$functionID));
			}
		}
		return $this->xml;
	}
}