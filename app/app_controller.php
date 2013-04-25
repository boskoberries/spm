<?php 
	class AppController extends Controller {
		var $components=array('Auth','Cookie','Email');
		var $helpers=array('Html','Javascript');
		
		
		function beforeFilter(){
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
		}


	  	function checkId($id){
  			$arr = explode("-",$id);
  			return array_pop($arr)*1;
  		}

	}
?>