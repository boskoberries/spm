<?php
class Sport extends AppModel{
	var $name = 'Sport';

	function findIdByName($sport_name){
		$row = $this->find('first',array("conditions"=>array("name"=>$sport_name)));
		if(!empty($row)){
			return $row['Sport']['id'];
		} else{
			return false;
		}
	}

}
?>