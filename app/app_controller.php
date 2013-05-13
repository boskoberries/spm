<?php 
	class AppController extends Controller {
		var $helpers=array('Html','Javascript','Session');
		// AppController's components are NOT merged with defaults,
		// so session component is lost if it's not included here!
		var $components = array('Auth', 'Session');


	    public function beforeFilter() {
	        $this->Auth->allow('*');//index', 'view');
			$leagues = $this->League->getLeaguesForHeader();
			$this->set('leagues',$leagues);
		}


		/*function beforeFilter(){
			$this->Auth->allow('*');
//			$this->render();
			//$this->Auth->loginAction = array('controller' => 'registration', 'action' => 'index');
			$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');

			//$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');
			$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
			$this->Auth->loginError = 'Whoops, our system didn\'t recognize that e-mail / password combination.  Please try again.';
			if($this->Auth->user()){
				$this->set('user',$this->Auth->user());
			} else{

			}
		}*/


	  	function checkId($id){
  			$arr = explode("-",$id);
  			return array_pop($arr)*1;
  		}

	}
?>