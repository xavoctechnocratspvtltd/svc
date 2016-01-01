<?php

class Model_Invitation extends SQL_Model {

	public $table = 'invitations';

	function init(){
		parent::init();

		$this->addField('name')->caption('Code')->defaultValue(uniqid());
		$this->addField('valid_from')->type('date')->defaultValue($this->api->today);
        $this->addField('is_revoked')->type('boolean')->caption('If leaked, revoking acode can stop malicious users from signing up from trial.')->defaultValue(false);
		// $this->addField('valid_days');

        $this->add('Field_Callback','invitation_url')->set(function($f){
            // TODO - must return clickable URL
            return $this->app->getConfig('frontend_url').'registration?code='.$this['name'];

        });

		$this->hasMany('Company','invitation_id');

		// $this->addExpression('valid_till')->set(function($m,$q){
		// 	return $q->expr("DATE_ADD(valid_from,INTERVAL [0] DAY)",[$m->getElement('valid_days')]);
		// })->type('date');

		$this->addExpression('trial_clients')->set(function($m,$q){
			return $m->refSQL('Company')->count();
		});



		$this->add('dynamic_model/Controller_AutoCreator');
	}

    /**
     * Revokes a currently loaded invitation, preventing users from signing up.
     * If any trial users are created, they must be individually blocked.
     */
    function revoke(){
        if(!$this->loaded())throw $this->exception('Must be loaded to revoke');
        $this['is_revoked']=true;
        $this->save();
    }

    /**
     * Create a new account model from a current code. Returs a model, which you must
     * present on a form and on save it will create data as necessary.
     */
    function newTrialUser(){
        $c = $this->ref('Company','model');
        $u = $c->join('user.company_id');
        $u->addField('email');

        $u->addField('trial_user_id','id');
        $u->addField('is_trial_user')->type('boolean')->defaultValue(true);
        
        // we do not set trial user expiration here yet, because it needs
        // to be set during initial set of password.

        // TODO: add other fields here into $u if necessary for form, e.g. name etc
        $c->addMethod('refTrialUser',function($c){
            return $c->add('Model_User_Trial')->load($c['trial_user_id']);
        });
    }
}
