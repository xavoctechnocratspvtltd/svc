<?php

class Model_Rule extends SQL_Model {
	public $table = 'rule';

	function init(){
		parent::init();

		$this->hasOne('Industry');
		$this->hasOne('Company');
		$this->hasOne('Department');
		$this->hasOne('Category');

		$this->addField('name');

		$this->addField('gMarksOptions')->type('text');

		$this->containsOne('gMarksOptions1',function($m){
			$m->addField('name')->caption('status');
			$m->addField('gMarks');
			$m->addField('is_final')->type('boolean')->defaultValue(false);
			
		});

		$this->add('Field_Callback','options')->set(function($m){
			return $m['gMarksOptions'];

			$x=json_decode($m['gMarksOptions'],true);
			return $x['name'];
		});

		$this->addField('applicable_on')->type('text');

		$this->addField('is_done')->type('boolean')->defaultValue(false);

		$this->addField('auto_status')->type('text');

		$this->addField('moderated_by')->enum(['SVC Admin','Company Owner','Manager','Self','None']);

		$this->hasMany('gMarks');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}