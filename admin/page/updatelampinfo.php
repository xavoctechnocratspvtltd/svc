<?php

class page_updatelampinfo extends Page {

	function page_index(){

		$lamp_id = $_GET['lamp_id']
		$network_id = $_GET['network_id'];
		//Device Brightess Level 
		if($_GET['brightness_level']){
			
		}


		//Device Working Status 
		if($_GET['working_status']){
			
		}



		echo "updated";
		exit;
	}

}