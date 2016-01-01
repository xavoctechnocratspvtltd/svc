<?php

class page_registration extends Page {

	function init(){
		parent::init();

        //if GET invitation_code Validate Code and Fill Registration Form
        //Send Verification email
        //Enter Your Password
        //Go To Dashboard
        
        $box = $this->add('View')->addClass('atk-box');

        $invitation_code  = $this->app->stickyGET('code');
        $verification  = $this->app->stickyGET('verification');

        //Fill Registration Form
        if($invitation_code){
            $i = $this->add('Model_Invitation')->loadBy('name',$invitation_code);
            if(!$i->loaded())
                throw new Exception("Invitation Code Not Found", 1);
            
            if($i['is_revoked']){
                $box->add('View_Error')->set("Invitation Code Blocked");
                return;
            }

            $company_model = $this->add('Model_Company')->addCondition('invitation_id', $i->id);
            $registration_form = $box->add('Form');
            $registration_form->setModel($company_model);
            $registration_form->addSubmit('Register');

            if($registration_form->isSubmitted()){
                $registration_form->save();
                $new_company = $registration_form->model;
                $u = $new_company->newTrialUser();

                //sticky Forget the Code for next step
                $this->app->stickyForget('code');

                $u->sendEmailVerification();
                $registration_form->js()->univ()->successMessage('Activation code send to your registered email id')->execute();
            }

            
        }


        if($verification){
            // Veification code supplied, ask for password
            $u = $box->add('Model_User_Trial')->loadBy('trial_verification_code',$verification);
            $f = $box->add('Form');
            $f->setModel($u,['password']);

            $f->addField('password','re_password')->validate('required');

            $f->addSubmit('Finish Registration');
            $f->onSubmit(function($f){
                if($f['password'] != $f['re_password'])
                    $f->error('password','password must match');

                $f->save();
                $u = $f->model;
                $this->app->auth->login($u);
                return $f->js()->univ()->location('./dashboard');
            });
        }


		// $form = $box->add('Form');
		// $form->setModel($i->newTrialUser());

		// $form->addField('CheckBox','accept_terms_and_condition')->validate('required');

		// $form->addSubmit('Confirm');

		// // if($form->isSubmitted()){
		// // 	$form->displayError('accept_terms_and_condition','Hello');
		// // }

		// $form->onSubmit(function($form){
		// 	$c = $form->save();
  //           $u = $c->refTrialUser();

  //           $u->sendEmailVerification();

		// 	return $form->js()->reload();
		// });
	}
}
