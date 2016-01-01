<?php

class Admin extends App_Admin {

    function init() {
        parent::init();

        //DB Connect not default
        $this->dbConnect();

        // Might come handy when multi-timezone base networks integrates
        $this->today = date('Y-m-d',strtotime($this->recall('current_date',date('Y-m-d'))));
        $this->now = date('Y-m-d H:i:s',strtotime($this->recall('current_date',date('Y-m-d H:i:s'))));


        $superadmin = $this->add('Model_User')
                        ->addCondition('type','Backend');

        // print_r($superadmin->getRows());

        $auth = $this->add('BasicAuth');
        $auth->setModel($superadmin,'name','password');
        $auth->check();

        $this->api->pathfinder
            ->addLocation(array(
                'addons' => array('addons', 'vendor','shared/addons2'),
            ))
            ->setBasePath($this->pathfinder->base_location->getPath() . '/..')
        ;
    }



    function initTopMenu() {
        $this->api->menu->destroy();
        $m=$this->layout->add('Menu_Horizontal',null,'Top_Menu');
        

        $m->addMenuItem('/', 'Home');

        // Invitation Menu
        $m->addMenuItem('invitations_index','Invitations');

        //Clients Menu
        $m->addMenuItem('companies/index','Companies');
        // $user_menu = $m->addMenu('Clients');
        // $user_menu->addMenuItem('users/permissions','Permissions');
        // $user_menu->addMenuItem('users/accesslist','Access List');

        // Locations
        $m->addMenuItem('locations/index','Locations');

        
        // Network Menu
        // $network_menu = $m->addMenu('Networks');
        // $network_menu->addMenuItem($this->api->url('network/oln',array('client_id'=>$_GET['client_id'])), 'OLN Management');
        // $network_menu->addMenuItem('network/group','Groups Management');
        // $network_menu->addMenuItem($this->api->url('network/mapeditor',array('client_id'=>$_GET['client_id'])),'Map Editor');

        
        //Setting Menu
        $setting_menu = $m->addMenu('Setting');
        $setting_menu->addMenuItem($this->api->url('setting/lamptype',array('client_id'=>$_GET['client_id'])),'Lamp Types');
        $setting_menu->addMenuItem($this->api->url('setting/programControl',array('client_id'=>$_GET['client_id'])),'Program Control');
        $setting_menu->addMenuItem($this->api->url('setting/calendarManagement',array('client_id'=>$_GET['client_id'])),'Calendar Management');
        $setting_menu->addMenuItem($this->api->url('setting/locationManagement',array('client_id'=>$_GET['client_id'])),'Location Management');
        $setting_menu->addMenuItem($this->api->url('setting/logManagement',array('client_id'=>$_GET['client_id'])),'Log Management');

        //Logout
        $m->addMenuItem('logout','Logout');

    }
}



        // For improved compatibility with Older Toolkit. See Documentation.
        // $this->add('Controller_Compat42')
        //     ->useOldTemplateTags()
        //     ->useOldStyle()
        //     ->useSMLite();
