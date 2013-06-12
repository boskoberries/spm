<?=$html->css('signup.css')?>
<div id="signup-container">
	<div class="reg-form left">
		<div class="header first">
			<h3>Sign Up</h3>
		</div>

		<?/*<form id="signupForm" action="/users/signup" method="POST">
			<label>Username:</label>
			<input type="text" name="data[NewUser][username]" value="<?=(isset($data['username']))?$data['username']:''?>" title="What do you want to go by?" />
			<div class="clear"></div>
			<label>Email (optional):</label>
			<input type="text" name="data[NewUser][email]" value="<?=(isset($data['email']))?$data['email']:''?>" title="Your email address will be used for logging in" />
			<div class="clear"></div>
			<label>Password:</label>
			<input type="password" name="data[NewUser][password]" value="" title="Enter your password" />
			<div class="clear"></div>
			<label>Confirm Password:</label>
			<input type="password" name="data[NewUser][password_2]" value="" title="Enter your password" />
			<div class="clear"></div>
			<br>
			<input type="submit" class="big blue btn" value="Register" />
		</form>
*/?>
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
			echo $form->submit('Login',array('class'=>'big blue btn'));//, array('after' => ' ' . $html->link(
			echo $form->end();
		?>
		<a href="#">Forgot username/password?</a>

		<!-- <form id="userLogin" action="/users/login" method="POST">
			<label>Email Address:</label>
			<input id="em2" type="text" name="data[User][email]" value="" />
			<div class="clear"></div>
			<label>Password:</label>
			<input id="pw2" type="password" name="data[User][password]" value="" />
			<br/><br>
			<input type="submit" class="blue big btn" value="Login" />
		</form> -->
	</div>
</div>