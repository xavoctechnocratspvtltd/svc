<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_users_useradmin extends Page {

    public $title='User Admin';

    function init() {
        parent::init();
        

        $client = $this->add('Model_Client');
    	$crud = $this->add('CRUD');
    	$crud->setModel($client);

    	$u = $crud->addFrame('Users');
        if($u){
            $user = $this->add('Model_User')->addCondition('client_id',$crud->id);
            $user_crud = $u->add('CRUD');
            $user_crud->setModel($user);
        }

    }

}
