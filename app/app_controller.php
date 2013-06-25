<?php 
	App::import('Sanitize');
	class AppController extends Controller {
		//var $helpers=array('Html','Javascript','Session');
		// AppController's components are NOT merged with defaults,
		// so session component is lost if it's not included here!
		var $components = array(
		    'Auth' => array(
		        'autoRedirect' => false,
		    ),
		    'Session',
		    'Email',
		    'Cookie'
		);
		var $helpers = array('Html', 'Javascript', 'Form', 'Session');

		function isAuthorized() {

		}
		function beforeFilter(){
			$this->loadModel('UserFavorite');
			$this->loadModel('Meme');
			
			$info['user'] = $this->Auth->user();
			$info['meme_count'] = $this->Meme->getUserMemeCount($this->Auth->user('id'),true);
			$info['fav_count'] = $this->UserFavorite->getFavorites($this->Auth->user('id'),true);
			$this->set('info',$info);
		}

	  	function checkId($id){
  			$arr = explode("-",$id);
  			return array_pop($arr)*1;
  		}

  		function __sendEmail($options=array()){
  			$this->Email->from    = $options['from'];
  			$this->Email->to      = $options['to'];
  			$this->Email->subject = $options['subject'];
  			$this->Email->template = $options['template'];
			$this->Email->send();
  		}

	}
?>