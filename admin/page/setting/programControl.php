<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_programControl extends Page {

    public $title='Program Control';

    function page_index() {
        // parent::init();
        $client_id = $this->api->stickyGET('client_id');

        $model = $this->add('Model_ControlProgram');
        if($_GET['client_id'])
            $model->addCondition('client_id',$client_id);

        $crud = $this->add('CRUD');

        $crud->setModel($model,array('client_id','name','address'),['client','name','address']);
        
    	// $crud->addRef('ControlProgram_ActivePeriod',array('label'=>'Active Period'));
    	// $crud->addRef('ControlProgram_FixedTimeControlItem',array('label'=>'Fixed Time Control Item'));

        $p = $crud->addFrame('XML');
        if($p){
            $cp = $this->add('Model_ControlProgram')->load($crud->id);
            $cp->render();
             echo  htmlspecialchars($cp->xml->saveXML());
        }


         if(!$crud->isEditing()){
            $g = $crud->grid;
            $g->addColumn('Button','active_period');
            $g->addColumn('Button','fixed_time_control_item');
            if($_GET['active_period']){
                $this->js()->univ()->location($this->api->url('setting_activePeriod',array('control_program_id'=>$_GET['active_period'])))->execute();
            }

            if($_GET['fixed_time_control_item']){
                $this->js()->univ()->location($this->api->url('setting_fixedTimeControlItem',array('control_program_id'=>$_GET['fixed_time_control_item'])))->execute();
            }
        }

        $form = $crud->add('Form');
        $selected_program = $form->addField('hidden','selected_program');//->set();
        $form->addSubmit('Notify');

        $crud->grid->addSelectable($selected_program);

        if($form->isSubmitted()){
            $ctrl_program_array = json_decode($form['selected_program'],true);

            foreach ($ctrl_program_array as $ctrl_id) {
                $this->add('Model_ControlProgram')->load($ctrl_id)->notify();
            }

            $form->js(null)->univ()->successMessage('Notify added in Queue')->execute();
        }

    }

    function page_fixed_time_control_item(){

    }

}