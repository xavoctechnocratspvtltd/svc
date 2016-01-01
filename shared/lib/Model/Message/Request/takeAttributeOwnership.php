<?php


class Model_Message_Request_takeAttributeOwnership extends Model_AbstractMessage{
	
	public $type= "sConfigurationRequest";

	function respond($response){
		$address =  $this->domxpath->query('//address');
		$addresses_demanded = [];
		foreach ($address as $ad_dom) {
			$d = $this->add('Model_AbstractDevice')
				->tryLoadBy('address',$ad_dom->nodeValue);
			if($d->loaded())
				$d->ref('OwnerShip')->deleteAll();
		}
		exit;
	}
}