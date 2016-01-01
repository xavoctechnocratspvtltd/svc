<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_calendarAssign extends Page {

    public $title='Calendar Assign';

    function init() {
        parent::init();

        $calendar_id = $this->api->stickyGET('calendar_id');
        $bridge_id =$this->api->stickyGET('bridge');
        
        $bridge = $this->add('Model_Device_TalqBridge');//->addCondition('id',$calendar_id);
        
        $form=$this->add('Form');
        $bridge_field=$form->addField('DropDown','bridge')->setEmptyText('Please Select');
        $bridge_field->setModel($bridge);

        $calendar_model=$this->add('Model_CalendarProgram');
        $calendar_model->load($calendar_id);
        
        $grid=$this->add('Grid');
        $device_form=$grid->add('Form','null','grid_buttons');
        $device_field=$device_form->addField('hidden','device');
        $device_field->set(json_encode($calendar_model->getAssociatedDevices()));
        
        if($_GET['bridge']){
            $this->api->currentBridge = $bridge->load($_GET['bridge']);
            // $this->api->currentBridge = $bridge->ref('bridge_id');
            $device_field->set(json_encode($calendar_model->getAssociatedDevices($_GET['bridge'])));
        }

        $device_form->addSubmit('Assign');

        $device_model=$this->add('Model_Device_Lamp');
        $device_model->addCondition('bridge_id',$_GET['bridge']);
        
        $bridge_field->js('change',$grid->js()->reload(['bridge'=>$bridge_field->js()->val()]));

        $grid->setModel($device_model);
        $grid->addSelectable($device_field);

        if($device_form->isSubmitted()){
            // $device_model->ref('CalendarDeviceAssociation')
            
            $lamp_model = $this->add('Model_Device_Lamp');
            $selected_device = array();
            $selected_device = json_decode($device_form['device'],true);
                        
            $calendar_model->associateDevices($selected_device, $bridge);
    
            
            $device_form->js(null,$this->js()->univ()->successMessage('Updated'))->reload()->execute();
        }    
    }

}