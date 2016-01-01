<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_location extends Page {

    public $title='Location';

    function init() {
        parent::init();
        
        $crud = $this->add('CRUD')->setModel('Location');

    }

}