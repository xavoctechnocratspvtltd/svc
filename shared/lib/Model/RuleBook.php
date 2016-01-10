<?php

class Model_RuleBook extends Model_Rule {


	function init(){
		parent::init();

		$this->addCondition('is_template',true);
	}

	function afterSave($m){
		if($m['is_mandatory']){

			$rule = $m->ref('Rule');
			foreach ($m->getActualFields() as $field) {
				if($field=="id") continue;

				$rule[$field] = $m[$field];
			}

			$rule->save();
		}
	}


	
}