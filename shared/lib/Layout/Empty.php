<?php


class Layout_Empty extends Layout_Basic {

	function setAlign($align='center',$width="100%"){
		$this->template->set('align',$align);
		$this->template->set('width',$width);

	}

    function defaultTemplate() {
        return array('layout/empty');
    }
}