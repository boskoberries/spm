<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('Meme','MemeType','MemeCaption','User');
	var $helpers = array('Form','Time','Session');
	var $components = array('Session','Auth');
	var $_store_clear_password = false;


	public function beforeFilter() {
		$this->Auth->allow('signup');
		//$this->Auth->allow('reset');
		$this->Auth->allow('reset_password');
		$this->Auth->allow('login');
    //$this->Auth->allow('*');
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

    function login() {
        if (!empty($this->data) && $this->Auth->user()) {
            $this->User->id = $this->Auth->user('id');
            $this->User->saveField('last_login', date('Y-m-d H:i:s'));
            //$this->redirect($this->Auth->redirect());
            $this->redirect('/memes');          
        } elseif(!empty($this->data)){
            $this->Session->setFlash('Whoops, we didn\'t recognize that e-mail/password combination.', 'default');
        }
    }
    
    function logout() {
        $this->Session->setFlash('You are now logged out');
        $this->redirect($this->Auth->logout());
    }

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

    function favorites(){
    	$data['user_id'] = $this->Auth->user('id');
  		$this->loadModel('UserFavorite');
    	$data['favorites'] = $this->UserFavorite->getFavorites($data['user_id']);
    	$this->set('data',$data);
    }

    function signup(){
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
        $this->render('login');
    }

    function reset_password(){
        if(!empty($this->data)){
          if($this->User->isValidEmail($this->data['User']['email'])){
              $data['password_sent'] = true;
              $data['email'] = $this->data['User']['email'];
              $this->set('data', $data);
              $options = $this->User->resetPasswordParams($data['email']);
              $this->__sendEmail($options);

          } else{
             $this->User->validates();
          }
        }

    }
	
		
} ?>