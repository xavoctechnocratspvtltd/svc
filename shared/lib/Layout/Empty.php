<?php


class Layout_Empty extends Layout_Basic {

	function init(){
		parent::init();

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

        $this->js(true)->_load('main');
        $this->js(true)->_load('svc');
	}

	function setAlign($align='center',$width="100%"){
		$this->template->set('align',$align);
		$this->template->set('width',$width);

	}

    function defaultTemplate() {
        return array('layout/empty');
    }
}