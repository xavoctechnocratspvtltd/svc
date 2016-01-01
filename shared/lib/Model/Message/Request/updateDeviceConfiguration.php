<?php


class Model_Message_Request_updateDeviceConfiguration extends Model_AbstractMessage{
	
	public $type= "sConfigurationRequest";

	public $address_changed = [];

	function respond(&$response){

		$address =  $this->domxpath->query('//address')->item(0)->nodeValue;
		$class =  $this->domxpath->query('//class')->item(0)->nodeValue;

		$device = $this->add('Model_AbstractDevice');
		$device->addCondition('address',$address);
		$device->addCondition('class',$class);
		$device->addCondition('deviceType',explode(":",$class)[1]);
		$device->tryLoadAny();

		$device['bridge_id'] = @$this->api->currentBridge->id;

		foreach ($this->domxpath->query('//functions/*') as $funct) {
			foreach ($funct->childNodes as $f) {
				if($f->tagName == 'name') 
					$f_id = $f->nodeValue!='Communication'?$f->nodeValue:'fCommunication';
				else
					$device[$f_id."_".$f->tagName] = $f->nodeValue;
			}
		}

		$device->save();

		$m = $response->add('Model_Message_Notification_deviceConfigurationChanged');
		$m->addAddress($address);
		return $m;


	}
}