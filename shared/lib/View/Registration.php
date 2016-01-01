<?php

class View_Registration extends View{

	function init(){
		parent::init();

		$form = $this->add('Form',null,null,['form/minimal']);
		$form->setLayout('form/layout/registration');
		$form->setModel('Client');
		$form->addSubmit('Confirm')->addClass('atk-swatch-red');

	}
}