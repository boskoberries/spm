<?php
class Sport extends AppModel{
	var $name = 'Sport';

	function findIdByName($sport_name){
		$row = $this->find('first',array("conditions"=>array("name"=>strtolower($sport_name))));
		if(!empty($row)){
			return $row['Sport']['id'];
		} else{
			return false;
		}
	}

	function checkForSport($sport_name=null,&$params){
 		//print $sport_name;exit;
 		if($sport_name==null){
 			if(isset($params['option']) && !empty($params['option'])){
	 			$sport_name = $params['option'];	
 			}
 		} else{

 		}

 		return $sport_name;
	}

	function grabAll(){
		$sports = $this->find('all',array('conditions'=>array('active'=>1,'parent_sport_id'=>0),'order'=>array('sort'=>'ASC')));
		return $sports;
		//CASE WHEN sort = 0 thensort ASC'));
	}

}
?>