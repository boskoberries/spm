<?php
class TagController extends AppController {

	var $name = 'Tag';
	var $uses = array('MemeTag');

	function index($tag_name){
		$data['matches'] = $this->MemeTag->find('all');
		pr($data['matches']);
		exit;

	}

	function view($tag_name){
		print "asdsa";exit;
	}

}
?>