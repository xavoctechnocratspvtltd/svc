<?php

class Model_RuleBook extends SQL_Model {
	public $table = 'rulebook';

	function init(){
		parent::init();

		$this->hasOne('Industry');
		$this->hasOne('Company');
		$this->hasOne('Department');
		$this->hasOne('Category');

		$this->addField('type')->enum(['routine','activity rule','task rule']);
		$this->addField('name');

		$this->addField('applicable_on')->type('text');

		$this->addField('is_done')->type('boolean')->defaultValue(false);

		$this->addField('auto_status')->type('text');

		$this->addField('moderated_by')->enum(['SVC Admin','Company Owner','Manager','Self','None']);
		
		$this->addField('is_mandatory');
		$this->addField('applicable')->enum(['daily','weekly']);
		$this->addField('is_self_addable')->type('boolean');

		$this->addField('cross_check')->type('Number');
		// $this->containsOne('cross_check_data',function($m){
		// 	$m->containsMany('options',function($m){
		// 		$m->addField('name');
		// 		$m->addField('gMarks')->type('text');
		// 	});
		// });

		$this->hasMany('RuleBookOption');
		$this->hasMany('RuleBookCrossCheckOption');
		$this->hasMany('Rule');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}