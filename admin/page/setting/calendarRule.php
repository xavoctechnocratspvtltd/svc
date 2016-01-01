<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_calendarRule extends Page {

    public $title='Calendar Rules';

    function init() {
        parent::init();

        $calendar_id = $this->api->stickyGET('calendar_id');
        $calendar = $this->add('Model_CalendarProgram')->addCondition('id',$calendar_id);
        $calendar->tryLoadAny();
        if(!$calendar->loaded()){
        	$this->add('View_Error')->set('Wrong Calendar Selected');
        	return;
        }

        $this->add('View_Info')->set('Selected Calendar : '.$calendar['name']);

        $calendar_rule_model = $this->add('Model_CalendarRule')->addCondition('calendarprogram_id', $calendar_id);
        $crud = $this->add('CRUD');
        $crud->setModel($calendar_rule_model);

    }

}