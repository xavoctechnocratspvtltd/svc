<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_network_device extends Page {

    public $title='Device';

    function init() {
        parent::init();

        $client_id = $this->api->stickyGET('client_id');

        $oln_id = $this->api->stickyGET('oln_id');
        $oln = $this->add('Model_OLN')->addCondition('id',$oln_id);
        $oln->tryLoadAny();
        if(!$oln->loaded()){
        	$this->add('View_Error')->set('Wrong OLN Selected');
        	return;
        }

        $this->add('View_Info')->set('Selected OLN : '.$oln['name']);
        $tab = $this->add('Tabs');
        $bridge_tab = $tab->addTab('Bridge');
        $lamp_tab = $tab->addTab('Lamp');

        $bridge_model = $this->add('Model_Device_TalqBridge')->addCondition('oln_id',$oln_id);
        $lamp_model = $this->add('Model_Device_Lamp')->addCondition('oln_id',$oln_id);

        if($client_id){
            $bridge_model->addCondition('client_id',$client_id);
            $lamp_model->addCondition('client_id',$client_id);
        }

        $bridge_tab->add('CRUD')->setModel($bridge_model,['client','address','fBasic_assetId','fBasic_latitude','fBasic_longitude','fBasic_hwType','fBasic_serial','fBasic_hwVersion','fBasic_swType','fBasic_swVersion','fTalqBridge_cmsUri','fTalqBridge_bootstrapComplete','fTalqBridge_pollTimeout','fTalqBridge_crlUrn','fTalqBridge_vendor','fTalqBridge_lastNotificationSeq']);
        $lamp_crud = $lamp_tab->add('CRUD');
        $lamp_crud->setModel($lamp_model,['client','address','bridge_id','fLampActuator_lampTypeId_id','fLampActuator_defaultLightState','fLampActuator_calendarID_id','fLampActuator_calendarID','fLampActuator_targetLightCommand','fLampActuator_feedbackLightCommand','fLampActuator_actualLightState']);

        if(!$lamp_crud->isEditing()){
            $g = $lamp_crud->grid;
            
            $this->add('VirtualPage')->addColumn('adHocLogRequest',null,null,$g)->set(function($p){
                echo "create form to ask ad hoc log report from this device ... on submit create notification";
            });

            $this->add('VirtualPage')->addColumn('AssignCalendar',null,null,$g)->set(function($p){
                echo "create form to assign calendar ... on submit create notification assignCalendar";
            });

            $this->add('VirtualPage')->addColumn('LampMaintenance',null,null,$g)->set(function($p){
                $form = $p->add('Form');
                $form->addField('initial_hours')->validateNotNull(true);
                $operation_field = $form->addField('DropDown','operation')->validateNotNull(true)->setEmptyText('Please Select One');
                $operation_field->setValueList(['replaced'=>'replaced','canceled'=>'canceled']);
                $form->addSubmit('Go');
                if($form->isSubmitted()){
                    $this->add('Model_Device_Lamp')->load($p->id)->notifyLampMantainance($operation=$form['operation'],$form['initial_hours']);
                    $form->js()->univ()->successMessage('LampMaintenance Notify added in Queue')->execute();
                }
                // echo "select maintenace type and send notification ... sample_xml line 147";
            });

            $this->add('VirtualPage')->addColumn('onDemandDataRequest',null,null,$g)->set(function($p){
                $device = $this->add('Model_Device_Lamp')->load($p->id);
                $device->notifyOnDemandDataRequest();
                // echo "set notification to send Data for this device sample_xml 180 line";
            });

            $this->add('VirtualPage')->addColumn('refreshDeviceConfiguration',null,null,$g)->set(function($p){
                
                $device = $this->add('Model_AbstractDevice')->load($p->id);
                $this->api->currentBridge = $device->ref('bridge_id');

                $response_doc_model = $this->add('Model_responseDoc');
                $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
                $message = $response->messages[] = $rdn = $response->add('Model_Message_Notification_refreshDeviceConfiguration',['addresses_changed'=>[$device['address']]]);                

                $response_doc_model->dispose(true,false);
            });

            $this->add('VirtualPage')->addColumn('onEDit',null,null,$g)->set(function($p){
                echo "remove this virtualpage, just a note. on Edit set deviceConfigurationchange notification for this device";
            });
        }
    }

}