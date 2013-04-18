<?php
class TagController extends AppController {

	var $name = 'Tag';
	var $uses = array();

	function index($tag_name=null){
		if(trim($tag_name)=='' || $tag_name==null){
			$this->redirect('/memes/browse');
		}

		$this->loadModel('Tag');
		$this->loadModel('Meme');
		$this->loadModel('MemeTag');
		$tag_id = $this->Tag->getTagId($tag_name);		
		if(empty($tag_id)){
			$this->redirect('/memes/browse');
		}

		$data['memes'] = $this->MemeTag->findAllByTagId($tag_id);
		print "here".$tag_name;exit;

	}

}
?>