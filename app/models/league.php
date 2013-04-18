<?php
class League extends AppModel{
	var $name = 'League';

	function getLeagueId($League_name){
		$data = $this->find('first',array('fields'=>'id','conditions'=>array('name'=>'NFL')));
		return $data['League']['id'];
	}	

	function getAll(){
		$rows = $this->find('all',array('order'=>'sort ASC'));
		return $rows;
	}

}
?>