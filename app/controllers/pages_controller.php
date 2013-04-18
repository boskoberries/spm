<?php
class PagesConroller extends AppController {

	var $name = 'Pages';
	// var $uses = array('Meme','MemeType','MemeCaption','MemeRating','User','Team');
	
	function beforeFilter(){
		$this->Auth->allow('*');
	}
	
	function home(){
	//	print"hi";exit;
	}	
}
?>	