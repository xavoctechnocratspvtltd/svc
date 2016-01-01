<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_locationManagement extends Page {

    public $title='Location Management';

    function init() {
        parent::init();
        
        $client_id = $this->api->stickyGET('client_id');
        $model = $this->add('Model_Location');
        if($client_id)
            $model->addCondition('client_id',$client_id);

        $this->add('CRUD')->setModel($model);
    }

}