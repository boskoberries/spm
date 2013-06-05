<?php
//App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
	var $name = 'User';
	// var $validate = array(
	// 	'email' => '/.+/',
	// 	'password' => '/.+/'
	// );

	var $validate = array(
	    'username' => array(
	        'empty' => array(
	            'rule' => 'notEmpty',
	            'required' => true,
	            'allowEmpty' => false,
	            'message' => 'Username is required',
	        ),
	        'minlength' => array(
	            'rule' => array('minLength', 4),
	            'required' => true,
	            'allowEmpty' => true,
	            'message' => 'Usernames must be at least 4 characters long',
	        ),
	        'maxlength' => array(
	            'rule' => array('maxLength', 20),
	            'required' => true,
	            'allowEmpty' => true,
	            'message' => 'Usernames may not be more than 20 characters long',
	        ),
	        'alphanum' => array(
	            'rule' => 'alphaNumeric',
	            'required' => true,
	            'allowEmpty' => true,
	            'message' => 'Usernames may only contain letters and numbers',
	        ),
	        'unique' => array(
	            'rule' => 'isUnique',
	            'required' => true,
	            'allowEmpty' => true,
	            'message' => 'That username is already in use',
	        ),
	    ),
	    'clear_password' => array(
	        'empty' => array(
	            'rule' => 'notEmpty',
	            'required' => true,
	            'allowEmpty' => false,
	            'on' => 'create',
	            'message' => 'Password is required',
	        ),
	        'length' => array(
	            'rule' => array('minLength', 6),
	            'required' => true,
	            'allowEmpty' => true,
	            'message' => 'Passwords must be at least 6 characters long',
	        ),
	    ),
	    'confirm_password' => array(
	        'empty_create' => array(
	            'rule' => 'notEmpty',
	            'required' => true,
	            'allowEmpty' => false,
	            'on' => 'create',
	            'message' => 'Please confirm the password 1',
	        ),
	        'empty_update' => array(
	            'rule' => 'validateConfirmPasswordEmptyUpdate',
	            'required' => true,
	            'allowEmpty' => true,
	            'on' => 'update',
	            'message' => 'Please confirm the password 2',
	        ),
	        'match' => array(
	            'rule' => 'validateConfirmPasswordMatch',
	            'required' => true,
	            'allowEmpty' => true,
	            'message' => 'The passwords do not match',
	        ),
	    ),
	    // 'email' => array(
	    //     'empty' => array(
	    //         'rule' => 'notEmpty',
	    //         'required' => true,
	    //         'allowEmpty' => false,
	    //         'message' => 'Email is required',
	    //     ),
	    //     'valid' => array(
	    //         'rule' => 'email',
	    //         'required' => true,
	    //         'allowEmpty' => true,
	    //         'message' => 'Please enter a valid email address',
	    //     ),
	    // ),
	);

	// function beforeSave() {
	//      if(isset($this->data['User']['password'])) {
	//      //     $this->data['User']['password'] = md5($this->data['User']['password']);
	//      }
	//      return true;
	// }

	// public function beforeSave($options = array()) {
	//     if (isset($this->data[$this->alias]['password'])) {
	//         $this->data[$this->alias]['password'] = $this->hashPassword($this->data[$this->alias]['password']);
	//         //AuthComponent::password($this->data[$this->alias]['password']);
	//     }
	//     pr($this->data);
	//     return true;
	// }

function validateConfirmPasswordEmptyUpdate() {
       return !empty($this->data['User']['clear_password']) && !empty($this->data['User']['confirm_password']);
   }
   
   /**
    * Callback function for confirm_password
    * Used to check if clear_password and confirm_password match
    * @return bool
    */
   function validateConfirmPasswordMatch() {
       return $this->data['User']['clear_password'] == $this->data['User']['confirm_password'];
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
		// if(empty($form['username'])){
		// 	$errors[] = 'Please enter a valid username';
		// } elseif(strlen($form['username'])<3){
		// 	$errors[] = 'Username must be at least 3 characters.';
		// } elseif($this->checkIfUserExists($form['username'])){
		// 	$errors[] = 'Username already taken.';
		// } 
		
		// if(empty($form['email'])){
		// 	$errors[] = 'Email address is required.';
		// } elseif(!$this->isValidEmail($form['email'])){
		// 	$errors[] = 'Please enter a valid email address';
		// }

		// if(empty($form['password'])){
		// 	$errors[] = 'Password is required';
		// } elseif(strlen($form['password'])<6){
		// 	$errors[] = 'Password must be at least 6 characters.';
		// } elseif($form['password']!=$form['password_2']){
		// 	$errors[] = 'Passwords do not match.';
		// }

		//if(is_array(Configure::read('ocb.banned_ips')) && in_array($_SERVER['REMOTE_ADDR'],Configure::read('ocb.banned_ips'))){ //DONT LET BANNED IPS THROUGH!
			//$this->redirect('http://aplsthat.com.com?b=1');
			//exit;
		//}

		if(empty($errors)){
			// $user = array('username'=>$form['username'],'email'=>$form['email'],'password'=>$form['password']);
			// if($this->save($user)){
			// 	$user_row = $this->find('first',array('conditions'=>array('User.id'=>$this->id)));
			// 	// log them in as them
			// 	$response['success'] = $user_row;
			// } else{
			// 	$errors[] = 'There was an error saving your data.  Please try again.';
			// }
			return true;
		} else{

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
