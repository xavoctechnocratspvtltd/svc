<?php


class Model_Device_TalqBridge extends Model_AbstractDevice {

	public $table_alias='tb';

	public $functions = ['fBasic'=>['assetId','latitude','longitude','serial','hwType','swVersion'],'fCommunication'=>['physicalAddress','parentAddress'],'fTalqBridge'=>['cmsUri','bootstrapComplete','pollTimeout','lastNotificationSeq','retryPeriod','crlUrn','vendor'],'fElectricalMeter'=>[]];
	
	function init(){
		parent::init();

		$this->getElement('bridge_id')->destroy();
		$this->addCondition('deviceType','TalqBridge');

	}

	function generateDeviceAddress(){
		return "DEV:TB176786124".rand(100,999);
	}

	function initBootstrap($request){
		$new_address = $this->generateDeviceAddress();
		$d = $this->add('Model_AbstractDevice')
			->addCondition('address',$new_address)
			->addCondition('class','cls:TalqBridge')
			->addCondition('deviceType','TalqBridge')
			->tryLoadAny()
			->set('process_running','bootstrapping')
			->set('oln_id',$this->add('Model_OLN')->addCondition('name',$new_address)->tryLoadAny()->save()->get('id'))
			->save();

		$this->api->switchCurrentBridge($d);

		$m = $request->add('Model_Message_Notification_synchronizeBridge');
		$m->setBridgeAddress($this->generateDeviceAddress());
		

		$m->setLastNotificationSeq($d['fTalqBridge_lastNotificationSeq']+1);
		return $m;
	}
}