<?php
class TeamsController extends AppController {

	var $name = 'Teams';
	var $uses = array('Meme','MemeType','MemeCaption','MemeRating','User','Team');
	var $helpers = array('Form','Time');
	var $components = array('Image','Session');

	function beforeFilter(){
		$this->Auth->allow('*');
	}
	function index($team_slug=null){
			
		if($team_slug==null){

			$data =$this->Team->getTeamsBySport();

		}
		else{
			$team_id = $this->checkId($team_slug,'Team');
			$data['team_info']=$this->Team->find('first',array('conditions'=>array('Team.id'=>$team_id)));
			$data['memes'] = $this->Meme->findAllByTeamId($team_id);
		}

		$this->set('data',$data);
		return;exit;
	}

	function display($team_id=null){
//		if($team_id==null){ $this->redirect('/teams/index'); }

		$team_id = $this->checkId($team_id);
		$data['memes'] = $this->Meme->findAllByTeamId($team_id);
		pr($data);
		$this->set('data',$data);

	}
}
?>