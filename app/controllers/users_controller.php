<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('Meme','MemeType','MemeCaption','User');
	var $helpers = array('Form','Time');
	var $components = array('Session','Auth');

    function beforeFilter(){
		//$this->Session->write('Auth.redirect', null);
		$this->Auth->allow('login','signup');
		$this->Auth->autoRedirect = false;
		
		parent::beforeFilter();
	}



    function isAuthorized(){
		if (isset($this->params[Configure::read('Routing.admin')])){
 	   		if ($this->Auth->user('admin') == 0) {
        		return false;
    	    }
        }
        return true;
	}


	function index(){

	}

	function logout(){
		$this->Session->delete('Auth');
		$this->Auth->logout();
//		$this->redirect($this->Auth->logout());
//		exit;
//		print "wt";exit;
		$this->redirect('/users/login');
		exit;
	}

	function signup(){
		if ($this->Auth->user()) { //if logged in, redirect.
			$this->redirect('/memes');
		} 
		pr($this->data);exit;
		
		$data = $this->User->validateSignUpForm($this->data['NewUser']);
		if(isset($data['errors']) && !empty($data['errors'])){
			pr($data['errors']);
			$this->set('data',$this->data['NewUser']);
			$this->Session->setFlash(implode('<br>',$data['errors']));
			$this->render('login');
		} else { //success!
			$this->Auth->login($data['success']);
			print "DONE!";
			pr($this->Auth->user());
			exit;

		}
	}

	function login(){
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


			//$_POST['email']=$this->data['User']['email'];
			$this->Session->setFlash('Whoops, we didn\'t recognize that e-mail/password combination.&nbsp;&nbsp;Forgot your password?&nbsp;&nbsp;<a href="/users/reset">Click here to retrieve it.</a>', 'default');
			//$this->data['flash'] = 'Whoops, we didn\'t recognize that e-mail/password combination.&nbsp;&nbsp;Forgot your password?&nbsp;&nbsp;<a href="/users/reset">Click here to retrieve it.</a>';
			//if(isset($this->data['Event']['domain'])){
			//	$this->redirect('/registration?site=true');
			//}
		}
	}
  	function login2(){

		if(!empty($this->data)){	
			//print_r($this->data);
			//exit;
			//$data['username']=trim($this->data['User']['email']);
			// if(empty($this->data['User']['password'])){
			// 	print "yep";
			// }
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
				            
				
				/*$extra_params='';
				if(isset($this->data['event_redirect'])){
					$extra_params='?ref_to='.$this->data['event_redirect'];
					$profile_after_register=$this->data['event_redirect'];
				}*/


				
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
}
?>