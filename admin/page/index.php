<?php

class page_index extends Page {

    public $title='Dashboard';

    function init() {
        parent::init();    

        $tabs = $this->add('Tabs');

        $ct = $tabs->addTab('Rules');
        $tabs->addTab('Industries')->add('CRUD')->setModel('Industry');
        $tabs->addTab('Departments')->add('CRUD')->setModel('Department');
        $tabs->addTab('Categories')->add('CRUD')->setModel('Category');
        $c= $ct->add('CRUD');
        $m=$c->setModel('Rule');

        $p=$c->addFrame('set_options');
        if($p){
            
            $p->add('View');

            $f=$p->add('CRUD');
            $f->setModel($this->add('Model_Rule')->load($c->id)->ref('gMarksOptions'));
        }

        $tabs->addTab('Users')->add('CRUD')->setModel('User');
        $tabs->addTab('gMarks')->add('CRUD')->setModel('gMarks');



    }

}
