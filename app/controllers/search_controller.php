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
		if(!empty($this->params['form']) && isset($this->params['form']['term'])){
			$term = trim($this->params['form']['term']);
		} elseif($term!=null){
			$term = trim($term);
		}
		if(strlen($term)>2){
			$rows = $this->Meme->findSearchResults($term);
			if(!empty($rows)){
				foreach($rows as $row){
					$data['results'][] = array('id'=>$row['Meme']['id'],'label'=>$row['Meme']['title'],'value'=>$row['Meme']['title']);
				}
			}
		}
		print json_encode($data);
		exit;
	}	
}
?>	