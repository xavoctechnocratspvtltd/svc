<?php

class View_Lister_Invitation extends \CompleteLister{

	function init(){
		parent::init();

		$this->js('click')->_selector('.block-invitation')->univ()->location([$this->app->url(),'invitation_block'=>$this->js()->_selectorThis()->closest('tr')->data('id')]);
	}

	function setModel($model){
		parent::setModel($model);
	}

	function formatRow(){
		if($this->model['is_revoked']){
			$this->current_row['blocked'] = "atk-effect-danger";
		}

	}

	function defaultTemplate(){
		return array('view/invitation');
	}
}