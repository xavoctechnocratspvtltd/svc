<?php

class page_graph extends Page{
	public $title = "Graphs";
	function init(){
		parent::init();

		$this->add('View_Info')->set('Graphs to be Implement');

		$this->api->title = "Graphs";

		$column = $this->add('Columns');
		$col1 = $column->addColumn(3);
		$col2 = $column->addColumn(3);
		$col3 = $column->addColumn(3);
		$col4 = $column->addColumn(3);

		// $col1->add('View_Info');
		$col1->setElement('img')->setAttr('src','images/g1.png');
		$col2->setElement('img')->setAttr('src','images/g2.jpg');
		$col3->setElement('img')->setAttr('src','images/g3.jpg');
		$col4->setElement('img')->setAttr('src','images/g4.jpg');
	}
}
