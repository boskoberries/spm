<?php
class Team extends AppModel {

	var $name = 'Team';
	var $belongsTo = array(
		'Sport' => array(
			'className' => 'Sport',
			'foreignKey' => 'sport_id'
		)
	);
	function afterFind($results){
		for($i=0; $i<count($results); $i++ ) {
			if(isset($results[$i]['Team']['name'])){
				$title=$results[$i]['Team']['name'];
				
				$results[$i]['Team']['url']=$this->getUrlPart($title.'-'.$results[$i]['Team']['id']);
			}
		}
		return $results;
	}		
	function getTeamsBySport(){
		$sql=  $this->find('all',array('order'=>'Team.name ASC'));

		$data = array();		
		foreach($sql as $d){
			if(!isset($data['leagues'][$d['Sport']['id']])){
				$data['leagues'][$d['Sport']['id']] = $d['Sport'];
			}
			$data['teams'][$d['Sport']['id']][]=$d['Team'];
		}
		return $data;
	}

	function getAllForSport($sport_id){
		$rows = $this->find('all',array('conditions'=>array('Team.sport_id'=>$sport_id)));
		return $rows;
	}
	function getAllForLeague($league_id){
		$rows = $this->find('all',array('conditions'=>array('Team.league_id'=>$league_id)));
		return $rows;
	}
	
	

}
?>
