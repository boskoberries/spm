<?//=$this->element('signup-form')?>

<?php
	echo '<h2>Login';
	echo $form->create('User', array('action' => 'login'));
	echo $form->input('username');
	echo $form->input('password');
	echo $form->end('Login');
?>