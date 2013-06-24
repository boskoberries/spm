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

	function searchTeamsByTerm($term){
  		$rows = $this->find('all',array('conditions'=>array('Team.name LIKE'=>'%'.$term.'%'),'order'=>'Team.name ASC','limit'=>10));
  		$return_array = array();
		foreach($rows as $row){
			$row_arr['label'] = $row['Team']['name'];
			$row_arr['value'] = $row['Team']['name'];//id
			$row_arr['url'] = $row['Team']['id'];
			array_push($return_array,$row_arr);
			//$data['results'][] = array('id'=>$row['Meme']['id'],'label'=>$row['Meme']['title'],'value'=>$row['Meme']['title']);
		}


  		return $return_array;
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
