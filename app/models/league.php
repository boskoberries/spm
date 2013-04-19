<?php
class League extends AppModel{
	var $name = 'League';

	function getLeagueId($League_name){
		$data = $this->find('first',array('fields'=>'id','conditions'=>array('name'=>'NFL')));
		return $data['League']['id'];
	}	

	function getSportLeagues($sport_id){
		$data = $this->find('list',array('conditions'=>array('sport_id'=>$sport_id)));
		return $data;
	}
	function getAll(){
		$rows = $this->find('all',array('order'=>'sort ASC'));
		return $rows;
	}



}
?>