<?php


class Model_CalendarRule extends Model_XMLModel {
	public $table ="calendar_rules";

	function init(){
		parent::init();

		$this->hasOne('CalendarProgram','calendarprogram_id');
		$this->hasOne('ControlProgram','controlprogram_id')->mandatory(true);

		$this->addField('startDate')->type('date')->hint('Start date when the rule becomes active');
		$this->addField('endDate')->type('date')->hint('Date when the rule becomes inactive. If not specified, the rule shall apply always after thestartDate.');
		$this->addField('condition')->hint('The condition can be date or day based, If there is no condition, the rule applies unconditionally.');
		$this->addField('order');
		$this->addField('ccDate')->mandatory(true)->hint('Each item defines a day within each month (---DD) or day within a specific month (--MMDD). An item can also define a range by specifying an end in the same format as the start of the item.');
		$this->addField('ccDay')->mandatory(true)->hint('List of days of the week. Each item defines a weekday using numbers 1 to 7 where 1 is Monday. An item can also define a range by specifying an end weekday as well.');
		$this->addField('occurances')->mandatory(true)->hint('indicates the weeks within a month the condition applies to. Weeks are represented by a number from 1 to 5 and are relative to the first day of the month. The special character “L” specifies the last week of the month relative to the last day. This parameter can be used to indicate whether the rule applies every week or only the 1 st , 2 nd , 3 rd , 4 th ,5 th or last week of the month. Enumeration 1, 2, 3 , 4 , 5 or L');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function render(){
		$this->xml = new DOMDocument();
		$this->xml->loadXML('<rule></rule>');

		if($this['startDate'])
			$this->xml->documentElement->appendChild($this->xml->createElement('startDate',$this['startDate']));
		
		if($this['endDate'])
			$this->xml->documentElement->appendChild($this->xml->createElement('endDate',$this['endDate']));

		if($this['condition'])
			$this->xml->documentElement->appendChild($this->xml->createElement('condition',''));
			$condition = $this->xml->getElementsByTagName('condition')->item(0);

		if($this['ccDay']){
			$condition_type = "ccDay";
			$child_element = "days";
		}

		if($this['ccDate']){
			$condition_type = "ccDate";
			$child_element = "dates";
		}

		if( isset($condition) and isset($condition_type) ){
			@$condition->setAttributeNode(new DOMAttr('xsi:type',$condition_type));
			$child_element_obj = $this->xml->documentElement->appendChild($this->xml->createElement($child_element,''));
			$item = $child_element_obj->appendChild($this->xml->createElement('item',''));
			
			$start_end_array = explode(',', $this[$condition_type]);

			$item->setAttribute('start',$start_end_array[0]);
			if($start_end_array[1])
				$item->setAttribute('end',$start_end_array[1]);
		}

		if($this['occurances']){
			$this->xml->documentElement->appendChild($this->xml->createElement('occurances',''));
			$occurances = $this->xml->getElementsByTagName('occurances')->item(0);

			foreach ( explode(',', $this['occurances']) as $ocrs => $value) {
				$occurances->appendChild($this->xml->createElement('occurance',$value));
			};
		}

		$this->xml->documentElement->appendChild($this->xml->createElement('program','prg:'.$this['controlprogram_id']));
		return $this->xml;
	}

}
