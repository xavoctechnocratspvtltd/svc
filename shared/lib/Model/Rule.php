<?php

class Model_Rule extends SQL_Model {
	public $table = 'rule';

	function init(){
		parent::init();

		$this->hasOne('Industry');
		$this->hasOne('Company');
		$this->hasOne('Department');
		$this->hasOne('Category');

		$this->addField('type')->enum(['routine','activity rule','task rule']);
		$this->addField('name');

		$this->addField('is_template')->type('boolean')->defaultValue(false);

		$this->addField('applicable_on')->type('text');

		$this->addField('is_done')->type('boolean')->defaultValue(false);

		$this->addField('auto_status')->type('text');

		$this->addField('moderated_by')->enum(['SVC Admin','Company Owner','Manager','Self','None']);
		
		$this->addField('is_mandatory')->type('boolean');
		$this->addField('applicable')->enum(['daily','weekly']);
		$this->addField('is_self_addable')->type('boolean');

		$this->addField('cross_check')->type('Number');
		// $this->containsMany('cross_check_options',function($m){
		// 	$m->addField('name');
		// 	$m->addField('gMarks')->type('text');
		// });

		$this->hasMany('RuleOption');
		$this->hasMany('gMarks');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}