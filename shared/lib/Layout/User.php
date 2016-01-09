<?php


class Layout_User extends Layout_Basic {

	function setModel($model){
		$model->reload();
		parent::setModel($model);
		$this->template->set('member_since',date('M, Y',strtotime($model['created_at'])));
	}

    function defaultTemplate() {
        return array('layout/user');
    }
}