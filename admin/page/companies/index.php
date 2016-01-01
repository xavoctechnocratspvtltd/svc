<?php


class page_companies_index extends Page {
	
	public $title="Companies";

	function init(){
		parent::init();
		$this->add('CRUD')->setModel('Company');
	}
}