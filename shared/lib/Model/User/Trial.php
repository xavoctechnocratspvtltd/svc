<?php
class Model_User_Trial extends Model_User {

    function init(){
        parent::init();

        $this->addCondition('is_trial_user', true);
    }

    function sendEmailVerification(){
        // email verification for trial user
        if(!$this->loaded())
            throw new Exception("Model User Trial Must Loaded");
        
        $this['trial_verification_code'] = uniqid();
        $this->save();

        $tm = $this->add('TMail');
        $tm->loadTemplate('userverification');

        $tm->set('link',$this->app->url('registration', ['verification'=>$this['trial_verification_code']])->useAbsoluteURL());

        $tm->send($this['email']);

        // mandril->send('trial-user-email-verification',$this->get());
        // ask Zak for mandril code.
    }

    function sendConfirmation(){
               
    }


}
