<?php

/**
 * Created by Rk Sinha
 * Date: 5 Oct 2015
 * Time: 11:26
 */
class page_setting_fixedTimeControlItem extends Page {

    public $title='Fixed Time Control Item';

    function init() {
        parent::init();
		
        $cp_model = $this->add('Model_ControlProgram')->addCondition('id',$_GET['control_program_id']);
        $cp_model->tryLoadAny();
        if(!$cp_model->loaded()){
            $this->add('View_Error')->set('Wrong Controll Program Selected');
            return;
        }

        $model = $this->add('Model_ControlProgram_FixedTimeControlItem')->addCondition('controlprogram_id',$_GET['control_program_id']);
    	$this->add('CRUD')->setModel($model);
    }

}