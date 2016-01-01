<?php

class page_invitations_index extends Page {

	function init(){
		parent::init();

        // TODO: Replace this with a lister with a custom template.
        // You simply need a button, which does onthing but generates a new
        // invite (no form needed). No expiration needed. Once new code is
        // generated, refresh page. Also add ability to block 
        $invitation = $this->add('Model_Invitation');
		if($_GET['invitation_block']){
        	$invitation->load($_GET['invitation_block']);
        	$invitation->revoke();
		}

		$invitation_btn = $this->add('Button');
		$invitation_btn->set('Create Invitation');
		
		$lister = $this->add('View_Lister_Invitation');
		$lister->setModel('Invitation');
		
		$invitation_btn->onClick(function()use($lister){
			$this->add('Model_Invitation')->save();
			return $lister->js()->reload();
		});
		

	}
}
