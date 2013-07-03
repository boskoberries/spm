<?php
class SearchController extends AppController {

	var $name = 'Search';
	var $uses = array('Meme','Team');

	function beforeFilter(){
		$this->Auth->allow('*');
	}
	
	function index($term=null){
		$this->layout = 'ajax';
		$this->loadModel('Tag');
		$data=array('results'=>array());
		//if(!empty($this->params['form']) && isset($this->params['form']['term'])){
		if(isset($_GET['term'])){
			$term = $_GET['term'];//trim($this->params['form']['term']);
		} elseif($term!=null){
			$term = trim($term);
		}
		//print $term;
		//pr($this->data);
		$return_array = array();

		if(strlen($term)>2){
			$return_array = $this->Tag->search($term);
			//$return_array = $this->Team->searchTeamsByTerm($term);
		}
		//print json_encode($data);
		echo json_encode($return_array);
		exit;
	}	
}
?>	