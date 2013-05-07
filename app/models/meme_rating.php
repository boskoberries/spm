<?php
class MemeRating extends AppModel {

	var $name = 'MemeRating';
	
	function getRating($meme_id){
		$q = $this->query("SELECT SUM(rating) FROM meme_ratings WHERE meme_id = $meme_id");
		return @(isset($q[0][0]))?$q[0][0]['SUM(rating)']:0;
	}
	function translateRating($score){
		if(!is_numeric($score)){
			$value = 0;
		} elseif($score < 1){
			$value = -1;
		} else{
			$value = 1;
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
	

	function checkIfUserHasRated($meme_id,$user_id=null){
		$conditions = array('meme_id'=>$meme_id);
		if(!is_numeric($user_id)){
			$user_id = 0;
			$user_ip = $_SERVER['REMOTE_ADDR'];
			$conditions[] = array('ip_address'=>$user_id);
		} else{
			$conditions[] = array('user_id'=>$user_id);
		}

		$exists = $this->find('first',array('conditions'=>$conditions));
		if(!empty($exists)){
			return $exists['MemeRating']['id'];
		} else{
			return false;
		}
		
	}

	function saveScore($meme_rating_id,$user_id,$postData){
		if(isset($postData['value'])){
			$data = array('rating'=>$this->translateRating($postData['value']));
			if($meme_rating_id!==false){
				//existing row.
				$data['id'] = $meme_rating_id;
				$data['modified'] = date('Y-m-d H:i:s');
			} else{
				//new row.
				if($user_id>0){
					$data['user_id'] = $user_id;
				} else{
					$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
				}
			}

			$this->set($data);
			$this->save();
			return $this->id;
		}
	}

}
?>
