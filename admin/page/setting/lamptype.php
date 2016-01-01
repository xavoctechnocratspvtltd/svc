<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_lamptype extends Page {

    public $title='Lamp Type';

    function init() {
        parent::init();

        $client_id = $this->api->stickyGET('client_id');

        $crud = $this->add('CRUD');
        $model = $this->add('Model_LampType');
        if($client_id)
            $model->addCondition('client_id',$client_id);

        $crud->setModel($model,['client_id','name','address'],['client','name','address']);

        $form = $crud->add('Form');
        $selected_lamptype = $form->addField('hidden','selected_lamptype');//->set();
        $form->addSubmit('Notify');

        $crud->grid->addSelectable($selected_lamptype);

        if($form->isSubmitted()){
            $selected_lamptype_array = json_decode($form['selected_lamptype'],true);

            foreach ($selected_lamptype_array as $lamptype_id) {
                $this->add('Model_LampType')->load($lamptype_id)->notify();
            }

            $form->js(null)->univ()->successMessage('Notification added in Queue')->execute();
        }

        $crud->grid->addColumn('button','Refresh');
            if($_GET['Refresh']){                
            	$this->api->stickyGET('Refresh');
            	$lamptype = $this->add('Model_LampType')->load($_GET['Refresh']);
				$lamptype->refresh();
				$this->js()->univ()->successMessage('LampType Refresh Notification added in Queue')->execute();
            }
    }

}