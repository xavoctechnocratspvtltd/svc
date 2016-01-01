<?php


class Model_Company extends SQL_Model {
	public $table="company";

	function init(){
		parent::init();

		$this->hasOne('Invitation','invitation_id');

		$this->addField('name')->caption('Company Name')->mandatory(true);
		$this->addField('registration_number')->mandatory(true);
		$this->addField('VAT_number')->mandatory(true);
		$this->addField('country')->mandatory(true);
		$this->addField('address')->mandatory(true);
		$this->addField('position_in_company')->mandatory(true);
		$this->addField('email_address')->mandatory(true)->hint('To Validate as unique');
		$this->addField('Mobile_phone')->mandatory(true);
		$this->addField('phone');

		$this->addField('access_token')->defaultValue(uniqid())->system(true);
		$this->addField('is_trial_account')->defaultValue(true)->system(true);
		$this->addField('is_approved')->type('boolean')->system(true)->defaultValue(false);

		// $this->addField('type')->enum(['Owner','Maintainer']);

		$this->hasMany('User','company_id');
		$this->hasMany('OLN','owner_id',null,'OwnedOLN');
		$this->hasMany('OLN','maintainer_id',null,'MaintainedOLN');
		$this->hasMany('Location','company_id');

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}

	  /**
     * Create a new account model from a current code. Returs a model, which you must
     * present on a form and on save it will create data as necessary.
     */
    function newTrialUser(){
      	if(!$this->loaded())
      		throw new \Exception("Comapny must loaded");
      	
      	$trial_user = $this->add('Model_User_Trial');
      	$trial_user['company_id'] = $this->id;
      	$trial_user['username'] = $this['email_address'];
      	$trial_user['email'] = $this['email_address'];
      	$trial_user['name'] = $this['email_address'];
      	$trial_user['type'] = "Frontend";
      	$trial_user['role'] = "Admin";
      	return $trial_user->save();


    }
}