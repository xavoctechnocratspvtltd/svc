<?php

class page_blogs extends Page{
    function init(){
        parent::init();

	
		$this->template->set('baseurl',$this->api->pm->base_url.$this->api->pm->base_path);
		

        $blog_lister = $this->add('View_Lister_Blog',null,'svc_blog');
        $blog_model = $this->add('Model_Blog');
        $blog_lister->setModel($blog_model);
    }

    function defaultTemplate(){
    	return ['page/blog'];
    }

}