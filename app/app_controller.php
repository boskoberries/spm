<?php 
	class AppController extends Controller {
		var $components=array('Auth','Cookie','Email');
		var $helpers=array('Html','Javascript');
		
		
		function beforeFilter(){
			$this->Auth->allow('*');
//			$this->render();
		}


	  	function checkId($id){
  			$arr = explode("-",$id);
  			return array_pop($arr)*1;
  		}

	}
?>