<?php
class Tag extends AppModel {

	var $name = 'Tag';
	var $hasMany = array(
		// 'MemeCaption' => array(
		// 	'className' => 'MemeCaption',
		// 	'foreignKey' => 'meme_id',
		// 	'dependent' => false
		// )
	);

	function findAndReturn($tag_name){
		$row = $this->find('first',array('conditions'=>array("name"=>$tag_name)));
		if(empty($row)){
			$info = array('name'=>ucwords(strtolower($tag_name)),'created'=>date('Y-m-d H:i:s'));
			$this->create();
			$this->save($info);
			$tag_id = $this->id;
		} else{
			$info['name'] = $row['Tag']['name'];
			$tag_id = $row['Tag']['id'];
		}

		return array('id'=>$tag_id,'name'=>$info['name']);
	}

	function getTagId($tag_name){
		$row = $this->find('first',array('conditions'=>array("name"=>$tag_name)));
		if(empty($row)){
			return array();
		} else{
			return $row['Tag']['id'];
		}
	}
}
?>