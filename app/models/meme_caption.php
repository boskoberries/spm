<?php
class MemeCaption extends AppModel {

	var $name = 'MemeCaption';
	var $belongsTo = array(
		'Meme' => array(
			'className' => 'Meme',
			'foreignKey' => 'meme_id'
		)
	);
	
	function getAttributes($data){
		//if(isset($data['font_size']) && $data['font_size'] > 0){
		//	$arr[] = 'font-size:'.$data['font_size'].'px';		
		//}
		if(isset($data['latitude'])){
			$arr[] = 'left:'.$data['latitude'].'px';	
		}	
		if(isset($data['longitude'])){
			$arr[] = 'top:'.$data['longitude'].'px';	
		}	
		if(isset($data['text_align']) && !empty($data['text_align'])){
			$arr[] = 'text-align:'.$data['text_align'];
		}
		// else{
		// 	$arr[] = 'text-align:center';
		// }
		if(isset($arr)){
			return implode(";",$arr);
		}
		else{
			return '';
		}
		
	
	}

	function setFontSize($data){
		$size = '';
		if(isset($data['font_size']) && $data['font_size'] > 0){
			$size = 'font-size:'.$data['font_size'].'pt';		
		}
		return $size;
	}

}
?>
