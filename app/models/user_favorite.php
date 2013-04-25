<?php
class UserFavorite extends AppModel {

	var $name = 'UserFavorite';

	function saveFavorite($data,$user){
		$cond = array('UserFavorite.meme_id'=>$data['meme_id']);
		$count_cond = array();
		if(!empty($user)){
			$data['user_id'] = $user['User']['id'];
			$cond[] = array('UserFavorite.user_id'=>$data['user_id']);	
			$count_cond[] = array('UserFavorite.user_id'=>$data['user_id']);

			//check to see if this user already has favorited/unfavorited this meme.
			$exists = $this->find('first',array('conditions'=>$cond));

		} elseif(!empty($data['ip_address'])){
			$cond[] = array('UserFavorite.ip_address'=>$data['ip_address']);	
			$count_cond[] = array('UserFavorite.ip_address'=>$data['ip_address']);

			$exists = $this->find('first',array('conditions'=>$cond));
		} else{ //proxied user? 
		}
		if($data['favorite']!=1){ //sanity check
			$data['favorite'] = 0;
		}

		if(isset($exists) && !empty($exists)){ //if already in there, just updated the row.
			$data['updated'] = date('Y-m-d H:i:s');
			$data['id'] = $exists['UserFavorite']['id'];
			$this->set($data);
			$this->save();
		} else{
			$data['created'] = date('Y-m-d H:i:s');
			$this->create();
			$this->save($data);
		}

		$new_count = 0;
		if(!empty($count_cond)){
			$count_cond[] = array('UserFavorite.favorite'=>1);
			$new_count = $this->find('count',array('conditions'=>$count_cond));				
		}
		return $new_count;

	}	
}
?>	