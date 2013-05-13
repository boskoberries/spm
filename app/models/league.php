<?php
class League extends AppModel{
	var $name = 'League';
	var $belongsTo = array(
		'Sport' => array(
			'className' => 'Sport',
			'foreignKey' => 'sport_id',
			'dependent' => false
		)
	);

	function getLeagueId($league_name){
		$data = $this->find('first',array('fields'=>'id','conditions'=>array('League.name'=>$league_name)));
		return $data['League']['id'];
	}	

	function getSportLeagues($sport_id){
		$data = $this->find('list',array('conditions'=>array('sport_id'=>$sport_id)));
		return $data;
	}
	function getAll(){
		$rows = $this->find('all',array('order'=>'League.sort ASC'));
		return $rows;
	}

	function getLeagueParent($league_name){
		$row = $this->find('first',array("conditions"=>array('League.name'=>$league_name)));
		return $row;
	}

	function getLeaguesForHeader(){
		//this function is used to grab the most relevant leagues for the top level naviation on the site.
		$rows = $this->find('all',array('conditions'=>array(),'order'=>'sort ASC','recursive'=>-1));
		return $rows;
	}



}
?>