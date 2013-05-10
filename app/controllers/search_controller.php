<?php
class SearchController extends AppController {

	var $name = 'Search';
	var $uses = array('Meme');

	function beforeFilter(){
		$this->Auth->allow('*');
	}
	
	function index($term=null){
		Configure::read('debug',0);
		$this->layout = 'ajax';
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
			$rows = $this->Meme->findSearchResults($term);
			if(!empty($rows)){
				foreach($rows as $row){
					$row_arr['label'] = $row['Meme']['title'];
					$row_arr['value'] = $row['Meme']['title'];//id
					$row_arr['url'] = $row['Meme']['url'];
					array_push($return_array,$row_arr);
					//$data['results'][] = array('id'=>$row['Meme']['id'],'label'=>$row['Meme']['title'],'value'=>$row['Meme']['title']);
				}
			}
		}
		//print json_encode($data);
		echo json_encode($return_array);
		exit;
	}	
}
?>	