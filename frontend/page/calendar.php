<?php

class page_calendar extends Page{
	
	public $title='Calendar Management';

	function init(){
		parent::init();

        $col = $this->add('Columns');
        $col1 = $col->addColumn(7);
        $col2 = $col->addColumn(5);

        $client_id = $this->api->stickyGET('client_id');
        $model = $this->add('Model_CalendarProgram');
        if($client_id)
            $model->addCondition('client_id',$client_id);

        $crud = $col1->add('CRUD');
        $crud->setModel($model,array('client_id','name','address'),['client','name','address']);

        if(!$crud->isEditing()){
            $g = $crud->grid;
            $btn = $g->addColumn('Button','Rules');
            if($_GET['Rules']){
                $this->js()->univ()->location($this->api->url('setting_calendarRule',array('calendar_id'=>$_GET['Rules'])))->execute();
            }
        
            $assign=$crud->grid->addColumn('Button','Assign');
            if($_GET['Assign']){
                $this->js()->univ()->frameURL('Assign ',$this->api->url('setting_calendarAssign',array('calendar_id'=>$_GET['Assign'])))->execute();
            }

        }

        $p = $crud->addFrame('XML');
        if($p){
            $cp = $this->add('Model_CalendarProgram')->load($crud->id);
            $cp->render();
             echo  htmlspecialchars($cp->xml->saveXML());
        }


        //Notify the selected Calender
        $form = $crud->add('Form');
        $allowed_app = $form->addField('hidden','allow_calendar');//->set();
        $form->addSubmit('Notify');

        $crud->grid->addSelectable($allowed_app);

        if($form->isSubmitted()){
            $selected_calendar = json_decode($form['allow_calendar'],true);
            // $this->add('Model_CalendarProgram')->notify($selected_calendar);
            foreach ($selected_calendar as $calendar_id) {
                $this->add('Model_CalendarProgram')->load($calendar_id)->notify();
            }

            $form->js(null)->univ()->successMessage('Notify Successfully')->execute();
        }


        $col2->add('View_Info')->set('Required Graph to be implemented...');
        $col2->add('View')->setElement('img')->setAttr(array('src'=>'images/g2.jpg'));
	}
}
