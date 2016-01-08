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

        $this->js(true)->_load('main');
        $this->js(true)->_load('svc');

        $form = $this->add('Form',null,'login');
        $form->setLayout(['page/home','login']);
        $form->addField('email');
        $form->addField('password');
        $form->addSubmit('Login');

        $form->onSubmit(function($f){
            if(!$this->app->auth->verifyCredentials($f['email'],$f['password']))
                $f->displayError('email','Nope');
            $this->api->auth->login($f['email']);
            return $f->js()->univ()->location('dashboard');
        });


        $form = $this->add('Form',null,'registration_form',['form/stacked']);
        $form->setLayout(['page/home','registration_form']);

        $form->setModel('User',['name','surname','email','password']);
        $form->addField('Password','re_password');
        $form->addField('Checkbox','terms','I Agree terms and condition');

        $form->addSubmit('Join Now!')->addClass('atk-swatch-blue');

        $form->onSubmit(function($f){
            if(!$f['name']) $f->displayError('name','You must have some name');
            if(!$f['surname']) $f->displayError('surname','Its good if you make your name comlete');
            if(!$f['email']) $f->displayError('email','Buddy its required!');
            if(!$f['password']) $f->displayError('password','Please give some password mate');
            if(!$f['re_password'] || $f['password'] != $f['re_password']) $f->displayError('re_password','Wow! just type same password here');
            if(!$f['terms']) $f->displayError('terms','Sorry, you have to agree ;)');

            return $f->js()->univ()->dialogOK("Hi",'Just check your email to confirm email account');

        });


        $blog_lister = $this->add('CompleteLister',null,'svc_blog',array('page/home','svc_blog'));
        
        $blog_model = $this->add('Model_Blog');

        $blog_lister->setModel($blog_model);
        $blog_lister->addHook('formatRow',function($l){
            if(!$l->current_row['image'])
                $l->current_row['image'] = "images/blog/1.jpg";
        });
    }

    function defaultTemplate(){
    	return ['page/home'];
    }

}