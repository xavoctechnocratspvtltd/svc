<?php


class page_blogs extends Page {
	function init(){
		parent::init();

		$c = $this->add('CRUD');
		$c->setModel('Blog',['subject','content','image_id'],null);
	
	}
}