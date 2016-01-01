<?php


class Layout_ViziLogin extends Layout_Basic {

	function setAlign($align='center',$width="80%"){
		$this->template->set('align',$align);
		$this->template->set('width',$width);

	}

    function defaultTemplate() {
        return array('layout/login');
    }
}