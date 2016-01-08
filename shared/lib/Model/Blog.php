<?php

class Model_Blog extends SQL_Model {
	public $table="blog";

	function init(){
		parent::init();

		$this->hasOne('User')->defaultValue($this->api->auth->model->id);

		$this->addField('subject');
		$this->addField('content')->type('text')->display(['form'=>'RichText']);

		$this->add('filestore/Field_Image','image_id')->caption('Default Image');

		$this->addField('created_at')->type('datetime')->defaultValue($this->api->now);


		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}
}