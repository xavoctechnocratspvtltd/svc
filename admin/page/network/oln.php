<?php

class page_network_oln extends Page {

    public $title='OLN Management';

    function init() {
        parent::init();
        
        $crud = $this->add('CRUD');
        $oln_model = $this->add('Model_OLN');
        if($_GET['client_id'])
            $oln_model->addCondition('client_id',$_GET['client_id']);

        $crud->setModel($oln_model);
        $crud->grid->addQuickSearch(array('name'));

        if(!$crud->isEditing()){
        	$g = $crud->grid;
            $client_id = $this->api->stickyGet('client_id');
            $btn = $g->addColumn('Button','Devices');
            if($_GET['Devices']){
                $this->js()->univ()->location($this->api->url('network_device',array('oln_id'=>$_GET['Devices'],'client_id'=>$client_id)))->execute();
            }
        }

    }

}
