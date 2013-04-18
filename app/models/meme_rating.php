<?php
class MemeRating extends AppModel {

	var $name = 'MemeRating';
	
	function getRating($meme_id){
		$q = $this->query("SELECT SUM(rating) FROM meme_ratings WHERE meme_id = $meme_id");

		return @(isset($q[0][0]))?$q[0][0]['SUM(rating)']:0;
	}
	function translateScore($score){
		switch($score) {
            case 5:
				$value = 3;
				break;
			case 4: 
				$value = 2;
				break;
			case 3:
				$value = 1;
				break;
			case 2: 
				$value = -1;
				break;
			case 1: 
				$value = -2;	
				break;
			default:
				$value = 0;				
				break;
		}
		return $value;
	
	}
	
	function getUserRatingForMeme($meme_id,$user_id){
		if(!is_numeric($user_id)){
			$user_id = 0;
		}
		$rating = $this->find('first',
			array('fields'=>array('rating'),
			'conditions'=>array('meme_id'=>$meme_id,'user_id'=>$user_id)
			)
		);
		if(!empty($rating)){
			if($rating['MemeRating']['rating'] > 0){
				$value = $rating['MemeRating']['rating']+2; //1 = 3 stars, 2 = 4 stars, 3 = 5 stars  
			}
			elseif($rating['MemeRating']['rating'] < 0){
				$value = $rating['MemeRating']['rating']+3; //-2 = 1 star, -1 = 2 stars. 
			}
			else{
				$value = null;
			}
		}
		else{
			$value = null;
		}
		return $value;

	}
	

}
?>
