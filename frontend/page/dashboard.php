<?php

class page_dashboard extends Page{

	function init(){
		parent::init();

		$this->api->title = "Dashboard";
		$this->setModel($this->api->auth->model);

		$rule_model = $this->add('Model_Rule');
		$todo_list = $this->add('View_Lister_Todo',null,"todo");
		$todo_list->setModel($rule_model);

	}

	function defaultTemplate(){
    	return ['page/dashboard'];
    }
}
