<?php
class page_index extends Page{
    function init(){
        parent::init();

        // $this->add('View_Registration');
        $this->api->jui->addStaticStylesheet('bootstrap.min','.css');
        $this->api->jui->addStaticStylesheet('animate.min','.css');
        $this->api->jui->addStaticStylesheet('font-awesome.min','.css');
        $this->api->jui->addStaticStylesheet('lightbox','.css');
        $this->api->jui->addStaticStylesheet('main','.css');
        $this->api->jui->addStaticStylesheet('responsive','.css');
        $this->api->jui->addStaticStylesheet('presets/preset1','.css');

        $this->api->jui->addStaticInclude('http://maps.google.com/maps/api/js?sensor=true','.css','.js');
        $this->api->jui->addStaticInclude('highcharts','.js');
        $this->api->jui->addStaticInclude('map','.js');
        $this->api->jui->addStaticInclude('in-all','.js');

        $this->js(true)->_load('bootstrap.min');
        $this->js(true)->_load('wow.min');
        $this->js(true)->_load('mousescroll');
        $this->js(true)->_load('smoothscroll');
        $this->js(true)->_load('jquery.countTo');
        $this->js(true)->_load('lightbox.min');
        // $this->js(true)->_load('highcharts');
        // $this->js(true)->_load('map');
        $this->js(true)->_load('main');
        $this->js(true)->_load('svc');


        $form = $this->add('Form',null,'registration_form');
        $form->setLayout(['page/home','registration_form']);
        $form->addField('line','contact_name','name')->set("Hello");
        // $hospital_images = $this->add('CompleteLister',null,'hospital_photos',array('page/hospital','hospital_photos'));
        
    }

    function defaultTemplate(){
    	return ['page/home'];
    }

}