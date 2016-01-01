<?php


class Model_Location extends SQL_Model {
	public $table="location";

	function init(){
		parent::init();

		// In case of no client_id Location will be considered as Global
		$this->hasOne('Company','company_id');

		$this->hasOne('ParentLocation','parent_id')->defaultValue('Null');

		$this->addField('locationType')->enum(['Country','State','District','City','Area','Sub-Area']);
		$this->addField('name')->mandatory(true);

		$this->hasMany('OLN','location_id');
		$this->hasMany('Location','parent_id',null,'ParentLocation');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}