<?php
class TagsController extends AppController {

	var $name = 'Tags';

	function beforeFilter(){
		$this->Auth->allow('*');
		parent::beforeFilter();
	}
	// function index($tag_name){
	// 	$data['matches'] = $this->MemeTag->find('all');
	// 	pr($data['matches']);
	// 	exit;

	// }
	function view($tag_name=null){

		if(trim($tag_name)=='' || $tag_name==null){
			$this->redirect('/memes/browse');
		}

		$this->loadModel('Tag');
		$this->loadModel('Meme');
		$this->loadModel('MemeTag');
		$data['tag'] = $this->Tag->getTagBySlug($tag_name);		
		if(empty($data['tag'])){
			$this->redirect('/memes/browse');
		}

		$data['memes'] = $this->MemeTag->findAllByTagId($data['tag']['Tag']['id']);
		$data['sort'] = $this->Meme->getSortParam($_GET,$this->params);
		$this->set('data',$data);
	}



}
?>