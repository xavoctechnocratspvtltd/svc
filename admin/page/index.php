<?php

class page_index extends Page {

    public $title='Dashboard';

    function init() {
        parent::init();    

        $tabs = $this->add('Tabs');

        $tab_rulebook = $tabs->addTab('RuleBook');
        $tabs->addTab('Industries')->add('CRUD')->setModel('Industry');
        $tabs->addTab('Departments')->add('CRUD')->setModel('Department');
        $tabs->addTab('Categories')->add('CRUD')->setModel('Category');
        $tabs->addTab('Users')->add('CRUD')->setModel('User');
        $tabs->addTab('gMarks')->add('CRUD')->setModel('gMarks');
        $tabs->addTab('Rule')->add('CRUD')->setModel('Rule');

        $c= $tab_rulebook->add('CRUD');
        $c->setModel('RuleBook');
        // $c->addRef('RuleOption');
        // $c->addRef('RuleCrossCheckOption');


    }

}
