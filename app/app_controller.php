<?php 
	App::import('Sanitize');
	class AppController extends Controller {
		//var $helpers=array('Html','Javascript','Session');
		// AppController's components are NOT merged with defaults,
		// so session component is lost if it's not included here!
//		var $components = array('Auth', 'Session', 'Cookie'	);
		var $components = array(
		    'Auth' => array(
		        'autoRedirect' => false,
		    ),
		    'Session',
		    'Cookie'
		);
		var $helpers = array('Html', 'Javascript', 'Form', 'Session');

		function isAuthorized() {

		}

	    
// 	    public function beforeFilter() {
// //	        $this->Auth->allow('*');//index', 'view');
// 	    	$this->loadModel('League');$this->loadModel('UserFavorite');
// 			$leagues = $this->League->getLeaguesForHeader();
// 			// Handle the user auth filter
// 			//  This, along with no salt in the config file allows for straight
// 			// md5 passwords to be used in the user model
// 			Security::setHash("md5");
// 			//$this->Auth->fields = array('username' => 'email', 'password' => 'password');

			
// 			$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
// 			$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
// 			$this->Auth->loginError = 'Whoops, our system didn\'t recognize that e-mail / password combination.  Please try again.';
// 			$this->Auth->authorize = 'controller';

// 			$cookie = $this->Cookie->read('User');
// 			$user = $this->Auth->user();


// 			if (is_array($cookie) && !$this->Auth->user()){
// 				if ($this->User->checkLogin($cookie['email'], $cookie['token'])){
// 					if (!$this->Auth->login($this->User)){
// 						$this->Cookie->del('User');
// 					}
// 				}			
// 			}

// 			$fav_count = $this->UserFavorite->getFavorites($this->Auth->user('id'),true);
// 			$this->set('fav_count',$fav_count);
// 			$this->set('user',$user);
// 			$this->set('leagues',$leagues);
// 		}

		
	  	function checkId($id){
  			$arr = explode("-",$id);
  			return array_pop($arr)*1;
  		}

	}
?>