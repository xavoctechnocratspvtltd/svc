<?php

class page_reset extends Page {
	function init(){
		parent::init();

		$models= ['Company','AbstractDevice','CalendarRule','ControlProgram','Location','AbstractMessage','CalendarDeviceAssociation','DocumentContainer','LampType','DeviceLog','AuditLog','LoggerconfigBridgeAsso','OLN','OwnerShip','ParentLocation','RecordingMode','ReportingMode','RequestResponse','SourceAddress','User'];
		
		
		$this->add('Button')->set("Reset All")->onClick(function($btn)use($models){
			$this->api->db->dsql($this->api->db->dsql()->expr('SET FOREIGN_KEY_CHECKS=0;'))->execute();
		 	foreach ($models as $junk) {
				$m=$this->add('Model_'.$junk);
				$m->api->db->dsql($this->api->db->dsql()->expr('TRUNCATE TABLE '.$m->table))->execute();
			}
			$client=$this->add('Model_Company');
			$client['name']='Vizinet';
			$client['email_address']='info@client.com';
			$client->save();

			
			$f_user=$this->add('Model_User');
			$f_user['company_id']=$client->id;
			$f_user['name']=$client['email_address'];
			$f_user['password']='123456';
			$f_user['type']='Frontend';
			$f_user['role']='Admin';
			$f_user->save();

			$b_user=$this->add('Model_User');
			$b_user['name']='admin';
			$b_user['password']='admin';
			$b_user['type']='Backend';
			$b_user['role']='SuperAdmin';
			$b_user->save();
			$m->api->db->dsql($this->api->db->dsql()->expr('SET FOREIGN_KEY_CHECKS=1;'))->execute();
		});


	}
}