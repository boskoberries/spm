<?php
class MemeTag extends AppModel {

	var $name = 'MemeTag';
	var $belongsTo = array(
		'Meme' => array(
			'className' => 'Meme',
			'foreignKey' => 'meme_id',
			'dependent' => false
		)
	);
	var $hasMany = array(
		// 'MemeCaption' => array(
		// 	'className' => 'MemeCaption',
		// 	'foreignKey' => 'meme_id',
		// 	'dependent' => false
		// )
	);

	function saveTags($meme_id,$tag_list,$user_id){
		$tag_array = explode(",",$tag_list);
		$Tag = ClassRegistry::init('Tag');
		foreach($tag_array as $t){
			if(trim($t)!=''){
				$tag_id = $Tag->findAndReturn($t,$user_id);
				$info = array('meme_id'=>$meme_id,'tag_id'=>$tag_id['id'],'tag_name'=>$tag_id['name'],
				'created'=>date('Y-m-d H:i:s'));
				$this->create();
				$this->save($info);
			}
		}

	}
}
?>