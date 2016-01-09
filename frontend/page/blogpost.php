<?php

class page_blogpost extends Page{

    function init(){
        parent::init();

        $this->template->set('baseurl',$this->api->pm->base_url.$this->api->pm->base_path);
        
        if(!$_GET['blogpost_id']){
        	// $this->add('View_Error',null,'nofound')->set('Blog Post Not Found');
        	$this->template->del('blogpost');
        	return;
        }

        $blog = $this->add('Model_Blog');
        $blog->tryLoad($_GET['blogpost_id']);

        if(!$blog->loaded()){
        	// $this->add('View_Error',null,'nofound')->set('Blog Post Not Found');
        	$this->template->del('blogpost');
        	return;
        }

    	$this->template->del('nofound');
        $this->setModel($blog);


    }

    function setModel($model){
    	parent::setModel($model);
    }

    function defaultTemplate(){
    	return ['page/blogpost'];
    }

}