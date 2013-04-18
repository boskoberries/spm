<?php
class User extends AppModel {

	var $name = 'User';

	function getUserName($user_id){
		$data=$this->find('first',array('conditions'=>array('User.id'=>$user_id)));
		return $data['User']['username'];
	}	

}
?>
