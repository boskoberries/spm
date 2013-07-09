<?=$html->css('signup.css')?>
<div id="signup-container">
	<div class="reg-form left">
		<div class="header first">
			<h3>Sign Up</h3>
		</div>
		<?php
			echo $form->create('User',array('action'=>'signup'));
			echo $form->input('username',array('label'=>'Username:'));
			echo $form->input('email',array('label'=>'Email (optional):'));
			echo $form->input('clear_password', array('type' => 'password', 'label' => 'Password:'));
			echo $form->input('confirm_password', array('type' => 'password'));
			//echo $form->input('status', array('options' => array('Active' => 'Active', 'Inactive' => 'Inactive')));
			echo "<br />";
			
			echo $form->submit('Register',array('class'=>'big blue btn'));//, array('after' => ' ' . $html->link('Cancel', array('action' => 'index'))));
			echo $form->end();
		?>

	</div>
	<div class="login-form left">
		<div class="header">
			<h3>Log In</h3>
		</div>
		<?php
			echo $form->create('User', array('action' => 'login'));
			echo $form->input('username',array('label'=>'Username:'));
			echo $form->input('password',array('label'=>'Password:'));
			echo "<br />";
			echo $form->submit('Login',array('class'=>'big blue btn'));
			echo $form->end();
		?>
		<a href="/users/reset_password">Forgot username/password?</a>

	</div>
</div>