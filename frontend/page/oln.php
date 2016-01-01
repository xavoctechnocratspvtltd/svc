<?php

class page_oln extends Page{
	public $title="Devices";
	function init(){
		parent::init();

		$crud = $this->add('CRUD');
        $crud->setModel('OLN');

        if(!$crud->isEditing()){
        	$g = $crud->grid;
        	$btn = $g->addColumn('Button','Devices');
            if($_GET['Devices']){
                $this->js()->univ()->location($this->api->url('network_device',array('oln_id'=>$_GET['Devices'])))->execute();
            }
        }
	}
}
