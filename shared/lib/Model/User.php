<?php


class Model_User extends SQL_Model {
	public $table="user";

	function init(){
		parent::init();

		$this->hasOne('Company','company_id');
		$this->addField('name')->mandatory(true)->caption('User Name');
		$this->addField('surname')->mandatory(true);
		$this->addField('username')->mandatory(true);
		$this->addField('password')->mandatory(true)->type('password');
		$this->addField('email')->mandatory(true);
		$this->addField('type')->mandatory(true)->enum(['Frontend','Backend']);
		$this->addField('role')->mandatory(true)->enum(['SuperAdmin','Admin','Staff']);

		$this->addField('trial_verification_code');
		$this->addField('is_trial_user');

		$this->addExpression('is_admin')->set('IF(type="Frontend" AND role="Admin",1,0)')->type('boolean');
		
		$this->hasMany('AuditLog');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}