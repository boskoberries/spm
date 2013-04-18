<?php
class SearchController extends AppController {

	var $name = 'Search';
	// var $uses = array('Meme','MemeType','MemeCaption','MemeRating','User','Team');
	// var $helpers = array('Form','Time');
	// var $components = array('Image','Session');

	function beforeFilter(){
		$this->Auth->allow('*');
	}
	
	function index($term=null){

	}	
}
?>	