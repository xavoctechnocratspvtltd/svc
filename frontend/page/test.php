<?php

class page_test extends Page{

	function init(){
		parent::init();

		$form = $this->add('Form');
		$form->addField('Number1')->validateNotNull(true);
		$form->addField('Number2')->validateNotNull(true);

		$form->addSubmit('Compare');

		if($form->isSubmitted()){

			if($form['Number1'] != $form['Number2']){
				$form->js()->univ()->errorMessage('Not Equal')->execute();
			}

		}

	}
}
