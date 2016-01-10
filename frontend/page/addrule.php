<?php

class page_addrule extends Page {
	
	function init(){
		parent::init();

		$c = $this->add('Columns');
		$c1 = $c->addColumn(6);
		$c2 = $c->addColumn(6);

		$rulebook = $this->add('Model_RuleBook');
		$g = $c1->add('Grid');
		$g->setModel($rulebook,['name']);

		$v = $c2->add('View_CustomiseRule');

		if($this->api->stickyGet('rulebook_id')){
			$rulebook->load($_GET['rulebook_id']);
		}

		$v->setModel($rulebook);


		$url = $this->app->url(null, array('cut_object' => $v->name));

		$g->on('click','tr',function($js,$data)use($v,$url){
			if($data['id'])
				return [$v->js()->reload(['rulebook_id'=>$data['id']],null,$url)];
		});
	}
}