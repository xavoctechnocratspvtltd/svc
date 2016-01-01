
<?php

/**
 * Created by Rk Sinha
 * Date: 7 Oct 2015
 * Time: 11:26
 */
class page_network_mapeditor extends Page {

    public $title='Map Editor';

    function init() {
        parent::init();
        
        $map = $this->add('View_MapEditor',array('client_id'=>$this->api->stickyGet('client_id')));

    }

}
