<?php

class Model_Test extends SQL_Model {
	public $table="test";

	function  init(){
		parent::init();

		$this->addField('name');

		// if($this->hasMethod('containsOne')){
			$this->containsMany(['activePeriods','json'=>true],function($m){
				$m->addField('sunriseOffset');
				$m->addField('sunsetOffset');
			});

			$this->containsMany(['fixedTimeControlItems','json'=>true],function($m){
				$m->addField('startTime');
				$m->addField('state_level');
			});
		// }else{
		// 	$this->addField('activePeriods')->type('text');
		// 	$this->addField('fixedTimeControlItems')->type('text');
		// }


		$this->add('dynamic_model/Controller_AutoCreator');

	}



}