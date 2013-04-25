<?php
class PagesController extends AppController {

	var $name = 'Pages';
	// var $uses = array('Meme','MemeType','MemeCaption','MemeRating','User','Team');
	
	function beforeFilter(){
		$this->Auth->allow('*');
	}
	
	function display(){
		$this->loadModel('Meme');
		$sort=(isset($_GET['sort']))?$_GET['sort']:'';
		$data['sort']=$sort;
		
		$data['memes']=  $this->Meme->getMemesByPopularity($sort);
 		$this->set('data',$data);		
 		$this->render('/memes/popular');
 	}

	function home(){
		print"hi";exit;
	}	
}
?>	