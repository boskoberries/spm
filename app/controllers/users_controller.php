<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('Meme','MemeType','MemeCaption','User');
	var $helpers = array('Form','Time','Session');
	var $components = array('Session','Auth');
	var $_store_clear_password = false;


	public function beforeFilter() {
		$this->Auth->allow('signup');
		// $this->Auth->allow('reset');
		// $this->Auth->allow('reset_pass');
		$this->Auth->allow('login');
    $this->Auth->allow('*');
		// $this->Auth->autoRedirect = false;
		parent::beforeFilter();
	}

 //  function isAuthorized(){
	// 	  if (isset($this->params[Configure::read('Routing.admin')])){
 //        	if ($this->Auth->user('admin') == 0) {
 //            	return false;
 //            }
 //        }
 //        return true;
	// }
	
	function index() {
	    $users = $this->paginate('User');
	    $this->set(compact('users'));
	}


 /*   function login() {	

    	if ($this->Auth->user()) {
    		//print "I AM INNNNN";exit;
    		$this->User->id = $this->Auth->user('id');
    		$this->User->saveField('last_login', date('Y-m-d H:i:s'));
    		$this->redirect($this->Auth->redirect());

    	}
 
    	if (empty($this->data)) {


    		$cookie = $this->Cookie->read('Auth.User');
	   		if (!is_null($cookie)) {
    			if ($this->Auth->login($cookie)) {
    				//  Clear auth message, just in case we use it.
    				$this->Session->delete('Message.auth');
    				$this->redirect($this->Auth->redirect());
    			} else { // Delete invalid Cookie
    				$this->Cookie->delete('Auth.User');
    			}
    		}

    	}else {
    		// pr($this->data);
    		// print "<br /><br />";
    		//pr($this->Auth->data);exit;
    		// print "<br/>";
    		// pr($_SESSION);
    		// exit;
    		if($this->Auth->login($this->Auth->data['User'])){
				$this->redirect($this->Auth->redirect());
			}
    		//$_POST['email']=$this->data['User']['email'];
    		$error = 'Whoops, we didn\'t recognize that e-mail/password combination.&nbsp;&nbsp;Forgot your password?&nbsp;&nbsp;<a href="/users/reset">Click here to retrieve it.</a>';
    		$this->set('error',$error);
    		//$this->data['flash'] = 'Whoops, we didn\'t recognize that e-mail/password combination.&nbsp;&nbsp;Forgot your password?&nbsp;&nbsp;<a href="/users/reset">Click here to retrieve it.</a>';
    		//if(isset($this->data['Event']['domain'])){
    		//	$this->redirect('/registration?site=true');
    		//}
    	}

    }*/

    function login() {
        if (!empty($this->data) && $this->Auth->user()) {
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_login', date('Y-m-d H:i:s'));
            //$this->redirect($this->Auth->redirect());
            $this->redirect('/memes');          
        }
    }
    
    function logout() {
        $this->Session->setFlash('You are now logged out');
        $this->redirect($this->Auth->logout());
    }


    // function logout() {
    //   	$this->Session->delete('Auth');
    //     $this->redirect($this->Auth->logout());
    // }

    function add() {
      if (!empty($this->data)) {
          $this->User->set($this->data);
          if ($this->User->validates()) {
            $this->data['User']['password'] = $this->data['User']['clear_password'];
            $this->data = $this->Auth->hashPasswords($this->data);
            if (!$this->_store_clear_password) {
               unset($this->data['User']['clear_password']);
            }
            $this->User->save($this->data, false);
            $this->Session->setFlash('User Added');
            $this->redirect('index');
          }
        }
    }


       function edit($id = null) {
           if (!empty($this->data)) {
               $fields = array_keys($this->data['User']);
               if (!empty($this->data['User']['clear_password']) || !empty($this->data['User']['confirm_password'])) {
                   $fields[] = 'password';
               } else {
                   $fields = array_diff($fields, array('clear_password', 'confirm_password'));
               }
               $this->User->set($this->data);
               if ($this->User->validates()) {
                   if (!empty($this->data['User']['clear_password'])) {
                       $this->data['User']['password'] = $this->data['User']['clear_password'];
                   }
                   $this->data = $this->Auth->hashPasswords($this->data);
                   if (!$this->_store_clear_password) {
                       unset($this->data['User']['clear_password']);
                   }
                   $this->User->save($this->data, false, $fields);
                   $this->Session->setFlash('User Updated');
                   $this->redirect('index');
               }
           } else {
               $user = $this->User->findById($id);
               if (empty($user)) {
                   $this->Session->setFlash('Invalid User ID');
                   $this->redirect('add');
               } else {
                   unset($user['User']['clear_password']);
                   $this->data = $user;
               }
           }
       }


    /*function register(){
    	//pr($this->Auth->user());
    	if ($this->data) {
    		// print $this->data['NewUser']['password'];
    		// print "<br>";
    		// print $this->Auth->password($this->data['NewUser']['password']);
    	    //if ($this->data['NewUser']['password'] == $this->Auth->password($this->data['NewUser']['password'])) {
    	      	
	      	 	 $this->User->create();
    	        $this->User->save($this->data['User']);
    	        if($this->Auth->login($this->data['User'])){

	    	        $this->redirect('/memes');
	    	    }
	    	    else{
	    	    	print "no go.";exit;
	    	    }
    	   //	 }
    	}
    }*/

    function favorites(){
    	$data['user_id'] = $this->Auth->user('id');
  		$this->loadModel('UserFavorite');
    	$data['favorites'] = $this->UserFavorite->getFavorites($data['user_id']);
    	$this->set('data',$data);
    }


	function signup(){
		if ($this->Auth->user()) { //if logged in, redirect.
			$this->redirect('/memes');
		} 
	//	pr($this->data);exit;
		
		//$data = $this->User->validateSignUpForm($this->data['NewUser']);
		//if($data['sucecss']){

		//}
		if($this->User->save($this->data['NewUser'])){
			$user = $this->User->read(null,$this->User->id);
			$this->Auth->login($user);
		} else {
			//pr($_SESSION);
			//if(isset($data['errors']) && !empty($data['errors'])){
			$this->set('data',$this->data['NewUser']);
				//$this->set('errors',$data['errors']);
			//}			
		}
		$this->render('login');


		 // else { //success!
			// //print "DONE!";
			// // pr($this->Auth->user());
			// // exit;

//		}
	}

  	function login2(){

		if(!empty($this->data)){	
	
			if(!empty($this->data['User']['email'])){
				$data['email']=trim($this->data['User']['email']);
			}
			
			if(strlen($data['username']) < 5){
				$errors[] = 'Your username must be at least 4 characters.';
			}

            if($this->data['User']['password']=='')
            	$errors[] = 'Password is required.';
			elseif($this->data['User']['password']!='' && strlen($this->data['User']['password'])<6)
                $errors[] = 'Password must be at least six characters.';
            elseif($this->data['User']['password'] != $this->data['User']['confirm_password'])
            	$errors[] = 'Passwords do not match.';

			if(!sizeof($errors)){
				$userData = $this->User->find('first',array('conditions'=>array('username' => $data['username'])));
	                
    	        if(!empty($userData)){
                    $errors[] = 'You\'ve entered a username that is already registered with Sports Memes.&nbsp;&nbsp;If you already are or previously were a member <a href="/users/login?username='.$this->data['User']['username'].'">click here to log in.</a>';
                }
        	}    
				            
				
            if(!sizeof($errors)){ //success.
				$data['password'] = trim($this->data['User']['password']);
	
				/////START/////
			    if($this->User->save($data)){   
					//send email to new user post-registration (and ben and I too)
	                /*
	                //$recipients = $this->data['User']['email'];
					//$recipients .= "brett@oneclipboard.com,jesse.boskoff@gmail.com";
						
					$params=array('first_name'=>$this->data['User']['first_name'],'email'=>$this->data['User']['email']);
					$this->set('params',$params);
						
					$this->_sendEmail($recipients,__('Welcome To One Clipboard', true),'info@oneclipboard.com','registration_complete',array('ben@oneclipboard.com','brett@oneclipboard.com'));
					*/
					
    	            $this->Auth->login($data);
					//$data=$this->User->read(null,$this->User->id);
					$this->redirect('/memes');


                }
	            else{
                    $errors .= 'Currently unable to create user, please contact an administrator.';
                    return;
                }

                    
                

			}	
			else{ 
				//something went wrong.
				$this->Session->setFlash(implode("<br />",$errors));
			}	
		}						
  	}
} ?>