<?php


class Model_Message_Notification extends Model_AbstractMessage {

	public $seq=null;
	
	function init(){
		parent::init();
		$this->seq = $this->api->currentBridge->ref('RespondedDocument')->addCondition('type','notification_response')->setOrder('id','desc')->tryLoadAny()->get('id')?:1;
		$this->owner->setSequence($this->seq);
		$this->owner->owner->dispose_to_notification = true;
	}
}