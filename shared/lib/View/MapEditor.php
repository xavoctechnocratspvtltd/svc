<?php

//Reference: https://developers.google.com/maps/documentation/javascript/3.exp/reference

class View_MapEditor extends \View{
	public $client_id;
	function init(){
		parent::init();

		$this->addClass('mapeditor');
	}


	function render(){
		$networks = $this->add('Model_OLN');
		$data = [];

		//Load Only Current Selected Client OLN Networks
		if($_GET['client_id']){
			$networks->addCondition('client_id',$_GET['client_id']);
		}
			
		// $data['networks'] = [];
		foreach ($networks as $network) {
			$data[$network['id']] = [];
			$data[$network['id']]['name'] = $network['name'];
			$data[$network['id']]['location'] = $this->add('Model_Location')->load($network['id'])->get('name');
			$data[$network['id']]['mode'] = "Normal";
			$data[$network['id']]['lamps'] = [];

			$lamps = $network->lamp();

			foreach ($lamps as $lamp) {
				$data[$network['id']]['lamps'][$lamp->id] = [];
				$data[$network['id']]['lamps'][$lamp->id]['address'] = $lamp['address'];
				$data[$network['id']]['lamps'][$lamp->id]['latitude'] = $lamp['fBasic_latitude'];
				$data[$network['id']]['lamps'][$lamp->id]['longitude'] = $lamp['fBasic_longitude'];
				$data[$network['id']]['lamps'][$lamp->id]['used_time'] = "Dummy (200)";
				$data[$network['id']]['lamps'][$lamp->id]['remaining_time'] = "Dummy (1000)";
				$data[$network['id']]['lamps'][$lamp->id]['status'] = 'true';
				$data[$network['id']]['lamps'][$lamp->id]['setup'] = "Setup Details";
				$data[$network['id']]['lamps'][$lamp->id]['faults'] = "Faults Details";
				$data[$network['id']]['lamps'][$lamp->id]['history'] = "History of Lamp";
				$data[$network['id']]['lamps'][$lamp->id]['userAccess'] = "User Access";
				$data[$network['id']]['lamps'][$lamp->id]['model'] = "SR 0 RK ".rand(000,999);
				$data[$network['id']]['lamps'][$lamp->id]['brightness_level'] = rand(00,100);
				$data[$network['id']]['lamps'][$lamp->id]['surge_protector_condition'] = 'On';
				$data[$network['id']]['lamps'][$lamp->id]['power'] = rand(00,50)." W";
				$data[$network['id']]['lamps'][$lamp->id]['voltage'] = rand(000,250)." V";
				$data[$network['id']]['lamps'][$lamp->id]['current'] = rand(000,999)." m A";
				$data[$network['id']]['lamps'][$lamp->id]['consumption'] = rand(000,999)." kWh";
				$data[$network['id']]['lamps'][$lamp->id]['pf'] = rand(00,99);
				$data[$network['id']]['lamps'][$lamp->id]['t_led'] = rand(00,99)." C";
				$data[$network['id']]['lamps'][$lamp->id]['t_lc'] = rand(00,99)." C";
				$data[$network['id']]['lamps'][$lamp->id]['clo'] = rand(00,99)."%";
				$data[$network['id']]['lamps'][$lamp->id]['actual_working_time'] = rand(00000,99999)." h";
				$data[$network['id']]['lamps'][$lamp->id]['group'] = "GRK ".rand(00,999);
				$data[$network['id']]['lamps'][$lamp->id]['lc_model'] = "GRK ".rand(00,999);
				$data[$network['id']]['lamps'][$lamp->id]['lc_firmware'] = "v1.00";
				$data[$network['id']]['lamps'][$lamp->id]['terminal_address'] = rand(00,99);
			}

			//Lamp Order to draw line between them
			$data[$network['id']]['line'] = json_decode($network['line'])?:[];
		}

		$data = json_encode($data);
		//Loading Inline Chart JqueryPlugins
		$this->js(true)->_load('sparkline');
		$this->js(true)->_load('gmap3.min');
		
		//add MapEditor Css and JS
		$this->api->jquery->addStylesheet('mapEditor');
		$this->js(true)->_load('mapEditor');
		
		$this->js(true)->mapEditor(array(
										'current_selected_client'=>$this->client_id,
										'networks'=>$data,
										'mode'=>'Normal'

									));
		parent::render();
	}

	function defaultTemplate(){
		return array('view/mapeditor');
	}
}

		//Generating Jsone Data 
		//Required Structure 
		/*networks: {'id'=>[
					name => 'Network 121',
					country=> 'India',
					city=> 'Udaipur',
					location => 'SurajPole',
					status => 'active',
					maintenance =>'',
					faluts=> '',
					history=> '',
					displayColor => ''
					lamps => {
							'lamp_id'=>	[
										'Address' = "LAMP:0001111",
										latitude: '30',
										longitude: '76',
										lifetime: '200', in hours
										used_time: '10', in hours
										remaining_time: '190', in hours
										remaining_time: '190', in hours
										status: 'On', Off
										setup:'',
										faults:'',
										history:'',
										userAccess:''
									]
							},
					line:['points':'point_1,point_2, point_3']
				]
			}

		*/
