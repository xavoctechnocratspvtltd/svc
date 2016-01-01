<?php


class Model_OLN extends SQL_Model {
	
	public $table ="oln";

	/**
	 * Either provide true or user_id 
	 * To put conditions such that only OLN that a user can access are loaded
	 */
	public $filter_for_user=false;

	function init(){
		parent::init();

		$this->hasOne('Owner','owner_id');
		$this->hasOne('Maintainer','maintainer_id');
		$this->hasOne('Location','location_id');

		$this->addField('name')->mandatory(true);

		//Used for the draw connection line of lamp in order
		$this->addField('line')->type('text')->system(true);

		$this->hasMany('AbstractDevice','oln_id');

		if($this->filter_for_user){
			if($this->filter_for_user===true) $filter_for_user = $this->api->auth->model->id;
			$user_id = $this->filter_for_user;

			$this->addExpression('is_allowed_to_user')->set(function($m,$q) use ($user_id){
				// TODO ALL CONDITIONS HERE
				/** IF
				* (this OLN is OwnedBy or Maintained By Company of this User)
				* And User (
				* 	is_admin
				* 	OR 
				* 	(
				* 		And Location of this OLN is permitted to User
				* 		And (
				* 			No restriction of OLNs for this user
				* 			OR
				* 			This OLN is permitted to user
				* 		)
				* 	) 
				*/
				return '1';
			})->type('boolean');
		}

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}

	//Return All Lamp of Loaded OLN or You Want (Pass )
	function lamp($oln_id=null){
		$lamp = $this->add('Model_Device_Lamp');
		$selected_oln_id = $this->id;		
		if($oln_id)
			$selected_oln_id = $oln_id;
		
		return $lamp->addCondition('oln_id',$selected_oln_id);
	}

}