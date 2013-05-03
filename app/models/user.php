<?php
//App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {

	var $name = 'User';
	public $validate = array(
	       'username' => array(
	           'required' => array(
	               'rule' => array('notEmpty'),
	               'message' => 'A username is required'
	           )
	       ),
	       'password' => array(
	           'required' => array(
	               'rule' => array('notEmpty'),
	               'message' => 'A password is required'
	           )
	       ),
	       'role' => array(
	           'valid' => array(
	               'rule' => array('inList', array('admin', 'author')),
	               'message' => 'Please enter a valid role',
	               'allowEmpty' => false
	           )
	       )
	   );


	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = $this->hashPassword($this->data[$this->alias]['password']);
	        //AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}

	function getUserName($user_id){
		$data=$this->find('first',array('conditions'=>array('User.id'=>$user_id)));
		return $data['User']['username'];
	}	

	function checkIfUserExists($user_name){
		$exists = $this->find('first',array('conditions'=>array('User.username'=>$user_name,'User.active'=>1)));
		if(!empty($exists)){
			return true;
		} else{
			return false;
		}
	}

    function isValidEmail($email){
    	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]+)$", trim($email));
	}

	function validateSignUpForm($form){
		$response = array();
		$form['username'] = trim($form['username']);
		$form['email'] = trim($form['email']);
		if(empty($form['username'])){
			$errors[] = 'Please enter a valid username';
		} elseif(strlen($form['username'])<3){
			$errors[] = 'Username must be at least 3 characters.';
		} elseif($this->checkIfUserExists($form['username'])){
			$errors[] = 'Username already taken.';
		} 
		
		if(empty($form['email'])){
			$errors[] = 'Email address is required.';
		} elseif(!$this->isValidEmail($form['email'])){
			$errors[] = 'Please enter a valid email address';
		}

		if(empty($form['password'])){
			$errors[] = 'Password is required';
		} elseif(strlen($form['password'])<6){
			$errors[] = 'Password must be at least 6 characters.';
		} elseif($form['password']!=$form['password_2']){
			$errors[] = 'Passwords do not match.';
		}

		//if(is_array(Configure::read('ocb.banned_ips')) && in_array($_SERVER['REMOTE_ADDR'],Configure::read('ocb.banned_ips'))){ //DONT LET BANNED IPS THROUGH!
			//$this->redirect('http://aplsthat.com.com?b=1');
			//exit;
		//}

		if(empty($errors)){
			$user = array('username'=>$form['username'],'email'=>$form['email'],'password'=>$this->hashPassword($form['password']));
			if($this->save($user)){
				$user_row = $this->find('first',array('conditions'=>array('User.id'=>$this->id)));
				// log them in as them
				$response['success'] = $user_row;
			} else{
				$errors[] = 'There was an error saving your data.  Please try again.';
			}
		}

		if(!empty($errors)){
			$response['errors'] = $errors;
		}

		return $response;
	}
	function hashPassword($password){
		return md5($password);
	}

}
?>
