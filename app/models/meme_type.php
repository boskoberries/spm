<?php
class MemeType extends AppModel {

	var $name = 'MemeType';
	/*var $hasMany = array(
		'EventClient' => array(
			'className' => 'EventClient',
			'foreignKey' => 'event_id',
			'dependent' => false
		)
	);*/

	function grabTypes(){
		$d=$this->find('all',array('order'=>array('id ASC')));
		return $d;
	}
}
?>
