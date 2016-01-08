<?php


class Model_User extends SQL_Model {
	public $table="user";

	function init(){
		parent::init();
		$this->add('Controller_Validator');
		
		$this->hasOne('Company');
		$this->hasOne('Department');

		$this->addField('name')->mandatory(true)->caption('First Name');
		$this->addField('surname')->mandatory(true)->caption('Last Name');
		$this->addField('email')->mandatory(true);
		$this->addField('password')->mandatory(true)->type('password');
		$this->addField('type')->mandatory(true)->enum(['Frontend','Backend'])->defaultValue('Frontend');
		$this->addField('role')->mandatory(true)->enum(['SuperAdmin','Admin','Staff'])->defaultValue('Staff');

		$this->addField('is_trial_user')->type('boolean')->defaultValue(false);

		$this->addExpression('is_admin')->set('IF(type="Frontend" AND role="Admin",1,0)')->type('boolean');
		
		$this->addField('created_at')->type('datetime')->defaultValue($this->api->now);	
		$this->addField('updated_at')->type('datetime')->defaultValue($this->api->now);	
		
		$this->hasMany('Company','owner_id');


		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}