<?php 
	class AppController extends Controller {
		//var $helpers=array('Html','Javascript','Session');
		// AppController's components are NOT merged with defaults,
		// so session component is lost if it's not included here!
		//var $components = array('Session','Auth');
		var $components = array(
		    'Auth' => array(
		        'autoRedirect' => false,
		    ),
		    'Session',
		);
		var $helpers = array(
		    'Html',
		    'Javascript',
		    'Form',
		    'Session',
		);
		
	    public function beforeFilter() {
//	        $this->Auth->allow('*');//index', 'view');
	    	$this->loadModel('League');
			$leagues = $this->League->getLeaguesForHeader();
			$this->set('leagues',$leagues);
		}

		function afterFilter() {
		    # Update User last_access datetime
		   if ($this->Auth->user()) {
		        $this->loadModel('User');
		        $this->User->id = $this->Auth->user('id');
		        $this->User->saveField('last_access', date('Y-m-d H:i:s'));
		    }
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