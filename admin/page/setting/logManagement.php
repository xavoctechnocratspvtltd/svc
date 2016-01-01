<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_logManagement extends Page {

    public $title='Log Management';

    function init() {
        parent::init();

        $client_id = $this->api->stickyGET('client_id');
        $model = $this->add('Model_LoggerConfig');
        if($client_id)
            $model->addCondition('client_id',$client_id);

        $tab = $this->add('Tabs');
        $log_config = $tab->addTab('Log Configuration');
        $log = $tab->addTab('Log');

        //Logger Configuration
        $log_config_crud = $log_config->add('CRUD');
        $log_config_crud->setModel($model,['client_id','address'],['client','address']);

        // $log_config_crud->addRef('SourceAddress');
        // $log_config_crud->addRef('RecordingMode');
        // $log_config_crud->addRef('ReportingMode');
        
        $log_config_crud->grid->add('VirtualPage')
                ->addColumn('source', 'Source Address', 'SourceAddress')
                ->set(function($page){
                    $id = $_GET[$page->short_name.'_id'];
                    $model = $page->add('Model_SourceAddress')->addCondition('loggerconfig_id',$id);
                    $crud = $page->add('CRUD');
                    $crud->setModel($model);
                });

        $log_config_crud->grid->add('VirtualPage')
                ->addColumn('recording', 'Recording Mode', 'RecordingMode')
                ->set(function($page){
                    $id = $_GET[$page->short_name.'_id'];
                    $model = $page->add('Model_RecordingMode')->addCondition('loggerconfig_id',$id);
                    $crud = $page->add('CRUD');
                    $crud->setModel($model);

                });

        $log_config_crud->grid->add('VirtualPage')
                ->addColumn('reporting', 'Reporting Mode', 'ReportingMode')
                ->set(function($page){
                    $id = $_GET[$page->short_name.'_id'];

                    $model = $page->add('Model_ReportingMode')->addCondition('loggerconfig_id',$id);
                    $crud = $page->add('CRUD');
                    $crud->setModel($model);
                });

        $log_config_crud->grid->add('VirtualPage')
                ->addColumn('function_attrib', 'What To Log', 'WhatToLog')
                ->set(function($page){
                    echo "Talq specification 1.0.3 page 157 &lt;content&gt; tag data";
                });

        //LoggerConfig Bridge Associations 
        $log_config_crud->grid->add('VirtualPage')
                ->addColumn('bridgeAsso','Bridge Association','bridgeAsso')
                ->set(function($page){
                    $loggerconfig_id = $_GET[$page->short_name.'_id'];
                    $model = $page->add('Model_LoggerconfigBridgeAsso');
                    $model->addCondition('loggerconfig_id',$loggerconfig_id);
                    $crud = $page->add('CRUD');
                    $crud->setModel($model);
                    // $asso_model = $page->add('Model_LoggerconfigBridgeAsso'); 
                    // $previous_asso = $asso_model->getAssociatedBridge($_GET[$page->short_name.'_id']);

                    // $model = $page->add('Model_Device_TalqBridge');
                    // $crud = $page->add('CRUD',['allow_add'=>false,'allow_edit'=>false,'allow_del'=>false]);
                    // $crud->setModel($model,array('name'));

                    // $form = $crud->add('Form');
                    // $associate_bridge_field = $form->addField('hidden','associate_bridge')->set(json_encode($previous_asso));
                    // $form->addSubmit('Save');
                    // $crud->grid->addSelectable($associate_bridge_field);

                    // if($form->isSubmitted()){
                    //     $bridge_array = json_decode($form['associate_bridge'],true);
                    //     $config_array[] = $_GET[$page->short_name.'_id'];
                    //     $asso_model = $this->add('Model_LoggerconfigBridgeAsso');                        
                    //     $asso_model->newAssociation($config_array,$bridge_array);

                    //     $form->js()->univ()->successMessage('LoggerConfig Bridge Association updated')->execute();
                    // }

                });

        //Add Form for Multiple selectabel 
        $form = $log_config_crud->add('Form');
        $modified_loggerconfig = $form->addField('hidden','modified_loggerconfig');//->set();
        $form->addSubmit('Notify');
        $log_config_crud->grid->addSelectable($modified_loggerconfig);

        if($form->isSubmitted()){
            //for each LoggerConfig notify the associated Bridge about loggerConfigChanged

            $selected_list = json_decode($form['modified_loggerconfig'],true);

            foreach ($selected_list as $key => $loggerconfig_id) {

                
                $config_logger_model = $this->add('Model_LoggerConfig')->load($loggerconfig_id);
                $configlogger_address = $config_logger_model->get('address');
                foreach ($config_logger_model->ref('LoggerconfigBridgeAsso') as $asso_model) {
                    //throw new Exception("Error Processing Request", 1);
                    $this->api->currentBridge = $bridge_model = $this->add('Model_Device_TalqBridge')->load($asso_model['bridge_id']);

                    //Notify
                    $this->api->responseDoc  = $response_doc_model = $this->add('Model_responseDoc');
                    $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
                    $message = $response->messages[] = $response->add('Model_Message_Notification_loggerConfigChanged');
                    
                    $message->addAddress($configlogger_address);
                    $response_doc_model->dispose(true,false,$bridge_model['address']);
                }
            }
            
            
            // $loggerconfig_array  = [];
            // foreach ($selected_list as $loggerconfig_id) {
            //     $loggerconfig_array[] = $this->add('Model_LoggerConfig')->load($loggerconfig_id)->get('address');
            // }

            $form->js(null,$log_config_crud->js()->reload())->univ()->successMessage('Notify Successfully')->execute();
        }

        $xml = $log_config_crud->addFrame('XML');
        if($xml){
            $cp = $this->add('Model_LoggerConfig')->load($log_config_crud->id);
            $cp->render();
             echo  htmlspecialchars($cp->xml->saveXML());
        }


//-------------------------------Log Managemnet----------------------------------------------

        $log_crud = $log->add('CRUD');
        $log_m = $this->add('Model_Log');
        if($client_id)
            $log_m->addCondition('client_id',$client_id);
        
        $log_crud->setModel($log_m);

        //Notify Form
        $log_form = $log_crud->add('Form');
        $selected_log_field = $log_form->addField('hidden','selected_log');
        $log_form->addSubmit('Notify');

        $log_crud->grid->addSelectable($selected_log_field);

        if($log_form->isSubmitted()){
            $selected_list = json_decode($log_form['selected_log'],true);

            foreach ($selected_list as $key => $log_id) {
                $log_model = $this->add('Model_Log')->load($log_id);
                $log_address = $log_model->get('address');

                //Get Associated Bridge Array
                $logger_config_model = $log_model->loggerConfig();
                $asso_bridges_array = $logger_config_model->getBridge();

                foreach ($asso_bridges_array as $key => $bridge_id) {
                    $this->api->currentBridge = $bridge_model = $this->add('Model_Device_TalqBridge')->load($bridge_id);

                    //Notify
                    $this->api->responseDoc  = $response_doc_model = $this->add('Model_responseDoc');
                    $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
                    $message = $response->messages[] = $response->add('Model_Message_Notification_adHocLogRequest');
                    
                    $message->addAddress($log_model['address']);
                    $response_doc_model->dispose(true,false,$bridge_model['address']);
                }   
            }
            $log_form->js(null,$log_config_crud->js()->reload())->univ()->successMessage('Notify Successfully')->execute();
        }

        //XML Sample Generation
        $xml = $log_crud->addFrame('XML');
        if($xml){
            $cp = $this->add('Model_Log')->load($log_crud->id);
            $cp->render();
             echo  htmlspecialchars($cp->xml->saveXML());
        }
    }
}