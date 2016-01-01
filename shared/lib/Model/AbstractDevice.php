<?php


class Model_AbstractDevice extends Model_TalqEntity {
	public $table= "device";
	public $strict_fields = true;

	function init(){
		parent::init();

		$this->hasOne('OLN','oln_id');
		$this->hasOne('Model_Device_TalqBridge','bridge_id');

		$this->addField('deviceType')->enum(array('CMS','TalqBridge','Lamp','LampType','ControlProgram','Calendar','LoggerConfig'))->mandatory(true); // Device Type
		
		$this->addField('address')->mandatory(true);
		// $this->addField('name')->mandatory(true);
		$this->addExpression('name')->set('address');
		$this->addField('class')->mandatory(true);

		// fBasic Function Implementation
		$this->addField('fBasic_assetId')->mandatory(true)->hint('Customer identifier of the asset');//If multiple devices have the same assetId it means they belong to the same asset
		$this->addField('fBasic_latitude')->mandatory(true)->hint('WGS84 latitude of GPS coordinate');
		$this->addField('fBasic_longitude')->mandatory(true)->hint('WGS84 longitude of GPS coordinate');
		$this->addField('fBasic_altitude')->hint('Meter above sea level');
		$this->addField('fBasic_hwType')->mandatory(true)->hint('Hardware type of the device');
		$this->addField('fBasic_serial')->mandatory(true)->hint('Serial number of the device');
		$this->addField('fBasic_hwVersion')->hint('Hardware revision of the device');
		$this->addField('fBasic_swType')->hint('Software type of device');
		$this->addField('fBasic_swVersion')->mandatory(true)->hint('Software version installed on the device');
		$this->addField('fBasic_installationDateTime')->hint('Date and time of the device was installed');
		// fBasic Events not handeld for now


		// TalqBridge Function Implementation
		$this->addField('fTalqBridge_cmsUri')->mandatory(true)->hint('Base URI for TALQ communication that allows the TALQ Bridge to access the CMS. Must be an absolute URI. Other URI\'s for accessing CMS can be relative to this base.');
		$this->addField('fTalqBridge_bootstrapComplete')->type('boolean')->mandatory(true)->defaultValue(false)->hint('CMS sets this value to true to indicate the bootstrapping process is completed for the TALQ Bridge.');
		$this->addField('fTalqBridge_pollTimeout')->mandatory(true)->hint('Time after sending a getNotifications message (long poll) after which the request is no longer valid and shall be restarted by the TALQ Bridge (see Section 5.2.2).');
		$this->addField('fTalqBridge_crlUrn')->mandatory(true)->hint('URI where the TALQ Bridge can obtain the CRL (see Section 6.5.3).');
		$this->addField('fTalqBridge_vendor')->mandatory(true)->hint('Vendor identification.');
		$this->addField('fTalqBridge_retryPeriod')->mandatory(true)->hint('Vendor identification.');
		
		// Should we have multiple notifications with seq number, and here as expression 
		$this->addField('fTalqBridge_lastNotificationSeq')->mandatory(true)->hint('Sequential number in the last notification message received by the TALQ Bridge.')->defaultValue(0);
		// TalqBridge Events not handeld for now
		

		// Communication Function Implementation
		$this->addField('fCommunication_physicalAddress')->mandatory(true)->hint('Physical address of the device. For example, IEEE MAC address. This attribute can be used to map between logical and physical devices. The format is specific to the OLN implementation.');
		$this->addField('fCommunication_parentAddress')->mandatory(true)->hint('TALQ Address of the parent logical device, e.g. gateway. It shall point to a specific communication function.');
		// Communication Events not handeld for now

		// LampType Attributes/functions
		$this->addField('wattage')->type('money')->hint('range 0.0 to 100000.0');
		$this->addField('controlType')->enum(['DALI','1-10V','PWM','Bilevel','Switch','Other']);
		$this->addField('controlVoltMax')->type('money')->hint('range 0.0 to 10.0');
		$this->addField('controlVoltMin')->type('money')->hint('range 0.0 to 10.0');
		$this->addField('minLightOutput')->type('number')->hint('range 0.0 to 10.0');
		$this->addField('virtualLightOutput')->type('number')->hint('range 0.0 to 10.0');
		$this->addField('daliLedLinear')->type('boolean')->defaultValue(false);
		$this->addField('warmUpTime')->type('number');
		$this->addField('coolDownTime')->type('number');
		$this->addField('lowCurrentThreshold')->type('money');
		$this->addField('highCurrentThreshold')->type('money');
		$this->addField('lowLampVoltageThreshold')->type('money');
		$this->addField('highLampVoltageThreshold')->type('money');
		$this->addField('maxOperatingHours')->type('number');
		$this->addField('powerLightGradient')->type('money');
		$this->addField('lampPowerTolerance')->type('money');
		$this->addField('lampPowerHighThreshold')->type('money');
		$this->addField('lampPowerLowThreshold')->type('money');
		$this->addField('powerFactorThreshold')->type('money');
		// $this->containsMany('lumenDepreciationCurve',function($m){
		// 	$m->addField('operatingHours');
		// 	$m->addField('percentage');
		// });
		// return;
		$this->addField('cloType')->enum(['controller','driver']);

		// LampType Functions end


		//Lamp Actuator Function Implementation
		$this->hasOne('LampType','fLampActuator_lampTypeId_id')->mandatory(true)->hint('TALQ Address of an existing lampType');
		$this->addField('fLampActuator_defaultLightState')->mandatory(true)->hint('Sets the default light output for the lamp actuator. This shall be applicable if no other command is active. This attribute shall be set to 100% as default value.');
		$this->hasOne('CalendarProgram','fLampActuator_calendarID_id')->mandatory(false)->hint('TALQ Address of the calendar controlling this lamp actuator (cal:CalendarID). If this attribute is empty, the behavior shall be determined by the OLN. If the attribute is invalid, the OLN shall trigger a generic invalid address event and the behavior shall be determined by the OLN');
		$this->addField('fLampActuator_targetLightCommand')->mandatory(true)->hint('Latest command for the lamp actuator.');
		$this->addField('fLampActuator_feedbackLightCommand')->mandatory(true)->hint('Actual command of the lamp actuator.');
		$this->addField('fLampActuator_actualLightState')->mandatory(true)->hint('Light State');
		// Lamp Actuator Events not handeld for now

		//Lamp Monitor Function Implementation
		
		// Repeated field, lookscommon for both
		// $this->addField('fLampMonitor_lampTypeId')->mandatory(true)->hint('TALQ Address of an existing lampType');

		$this->addField('fLampMonitor_numberOfLamps')->type('Number')->mandatory(true)->hint('Number of lamps being monitored by the lamp monitor function.')->defaultValue(1);
		$this->addField('fLampMonitor_operatingHours')->mandatory(true)->hint('Number of hours the lamp is on. This is the value used in CLO and may be set by the CMS.');
		$this->addField('fLampMonitor_temperature')->mandatory(true)->hint('Temperature of the device implementing this function.');
		$this->addField('fLampMonitor_supplyVolts')->mandatory(true)->hint('RMS supply volts.');
		$this->addField('fLampMonitor_supplyCurrent')->mandatory(true)->hint('RMS supply current.');
		$this->addField('fLampMonitor_activePower')->mandatory(true)->hint('Active power.');
		$this->addField('fLampMonitor_powerFactor')->mandatory(true)->hint('Active power/Apparent power.');
		$this->addField('fLampMonitor_powerFactorSense')->mandatory(true)->hint('Phase sense of power factor.');
		$this->addField('fLampMonitor_activeEnergy')->mandatory(true)->hint('Cumulative active energy (since installation or counter reset).');
		// Lamp Monitor Events not handeld for now

		//Electrical Meter Function Implementation
		$this->addField('fElectricalMeter_totalPower')->mandatory(true)->hint('Sum of the active power consumed on phase 1, 2 and 3, or just the power for a single phase meter');
		$this->addField('fElectricalMeter_totalActiveEnergy')->mandatory(true)->hint('Total cumulative kWh measured by the meter since installation date (or counter reset).');
		$this->addField('fElectricalMeter_totalPowerFactor')->mandatory(true)->hint('Total active power divided by total apparent power.');
		$this->addField('fElectricalMeter_supplyVoltage')->mandatory(true)->hint('Average between Phase1 RMS Voltage, Phase2 RMS Voltage and Phase3 RMS Voltage, or in the case of a single phase meter just the RMS supply voltage.');
		$this->addField('fElectricalMeter_totalCurrent')->mandatory(true)->hint('Sum of the RMS currents on phase 1, 2 and 3.');
		$this->addField('fElectricalMeter_averageCurrent')->mandatory(true)->hint('Average RMS current on phase 1, 2 and 3.');
		//Electrical Meter Events not handeld for now
		
		//Photocell Function Implementation
		$this->addField('fPhotocell_onLevel')->mandatory(true)->hint('Illuminance level at which the photocell switches to on state.');
		$this->addField('fPhotocell_offLevel')->mandatory(true)->hint('Illuminance level at which the photocell switches to off state.');
		$this->addField('fPhotocell_photocellOutput')->mandatory(true)->hint('Output state of the photocell. Possible values: 1) ON (means the illuminance level has fallen below the onLevel). 2) OFF (means the illuminance level has risen above the offLevel).');
		//Photocell Events not handeld for now
		
		//Light Sensor Function Implementation
		$this->addField('fLightSensor_levelHighThreshold')->mandatory(true)->hint('Light level above which a levelTooHigh event is triggered.');
		$this->addField('fLightSensor_levelLowThreshold')->mandatory(true)->hint('Light level below which a levelTooLow event is triggered.');
		$this->addField('fLightSensor_lightLevel')->mandatory(true)->hint('Illuminance level.');
		//Light Sensor Event not handeld for now

		//Binary Sensor Function Implementation
		$this->addField('fBinarySensor_level')->mandatory(true)->hint('Sensor Output level. Possible values: ON OFF');
		//Binary Sensor not handeld for now
		
		//Generic Sensor Function Implementation
		$this->addField('fGenericSensor_levelHighThreshold')->mandatory(true)->hint('Threshold above which a levelTooHigh event is triggered.');
		$this->addField('fGenericSensor_levelLowThreshold')->mandatory(true)->hint('Threshold below which a levelTooLow event is triggered.');
		$this->addField('fGenericSensor_level')->mandatory(true)->hint('Sensor Output level.');
		//Generic Sensor Event not handeld for now

		//Time Function Implementation
		$this->addField('fTime_timeZone')->mandatory(true)->hint('Time zone of the logical device. Time zone may be expressed in two formats: where <timezone> is a time zone as defined in the zone.tab of the IANA timezone database [IANA] 2)stdoffset[dst[offset][ , start[ / time] , end[ / time]]] as defined by the Open Group for posix systems [POSIX].');
		$this->addField('fTime_currentTime')->mandatory(true)->hint('Current time of the logical device defined as local time with time zone designator [ISO8601].');
		//Time  not Event handeld for now

		// CMS Specific fields
		$this->addField('process_running');
		$this->addField('notification_response')->type('text');

		//LoggerConfig Fields
		$this->addField('modifier')->enum(['complete','delete','update'])->mandatory(true);

		$this->hasMany('AbstractDevice','bridge_id',null,'Devices');
		$this->hasMany('DocumentContainer','from_device_id',null,'ReceivedDocument');
		$this->hasMany('DocumentContainer','to_device_id',null,'RespondedDocument');
		$this->hasMany('Model_CalendarDeviceAssociation','to_device_id',null,'RespondedDocument');
		$this->hasMany('OwnerShip','device_id');
		$this->hasMany('DeviceComment','device_id');

		// $this->addField('location')->set($this->refSQL('oln_id')->fieldQuery('location'));

		$this->add('dynamic_model/Controller_AutoCreator',['engine'=>'INNODB']);
	}


	function notifyOnDemandDataRequest(){
		if(!$this->loaded())
			throw new Exception("Model Must be loaded before notify onDemandDataRequest");
			
		$this->api->currentBridge = $this;
        $this->api->responseDoc = $response_doc_model = $this->add('Model_responseDoc');
        $response = $response_doc_model->responses[] =  $response_doc_model->add('Model_Response');
        $message = $response->messages[] = $response->add('Model_Message_Notification_onDemandDataRequest');
        $message->addAddress($this['address']);
        $response_doc_model->dispose(true,false);

	}

}