<?php

class Model_Message_Request_updateLampType extends Model_AbstractMessage {

	public $type="sNotificationRequest";

	function init(){
		parent::init();
		
	}

	function respond($response){

		$address =  $this->domxpath->query('//address')->item(0)->nodeValue;

		$device = $this->add('Model_LampType');
		$device->addCondition('address',$address);
		$device->tryLoadAny();

		$device['bridge_id'] = @$this->api->currentBridge->id;

		foreach ($this->domxpath->query('//*') as $attr) {
			// if($f->tagName == 'name') $f_id = $f->nodeValue;
			if($attr->tagName == 'lumenDepreciationCurve'){
				// TODO ?? HOW TO .. TO SEE
			}else{
				$device[$attr->tagName] = $attr->nodeValue;
			}
		}

		$device->save();

		// TODO: May be if something changed then only send this notification
		$m = $response->add('Model_Message_Notification_deviceConfigurationChanged');
		$m->addAddress($address);
		return $m;

	}
}