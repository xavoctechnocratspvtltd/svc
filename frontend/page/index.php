<?php
class page_index extends Page{
    function init(){
        parent::init();

        // $this->add('View_Registration');
        
        $form = $this->add('Form',null,'login');
        $form->setLayout(['page/home','login']);
        $form->addField('email');
        $form->addField('password');
        $form->addSubmit('Login');

        $form->onSubmit(function($f){
            if(!$this->app->auth->verifyCredentials($f['email'],$f['password']))
                return $f->displayError('email','Wrong');
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


        $blog_lister = $this->add('View_Lister_Blog',null,'svc_blog');
        $blog_lister->loadmore = true;
        $blog_model = $this->add('Model_Blog');
        $blog_lister->setModel($blog_model);
        // $blog_lister = $this->add('CompleteLister',null,'svc_blog',array('page/home','svc_blog'));
        // $blog_lister->addHook('formatRow',function($l){
        //     if(!$l->current_row['image'])
        //         $l->current_row['image'] = "images/blog/1.jpg";
        // });
    }

    function defaultTemplate(){
    	return ['page/home'];
    }

}