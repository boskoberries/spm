<?=$html->css('signup.css')?>
<div id="signup-container">
	<div class="reg-form left">
		<div class="header first">
			<h3>Sign Up</h3>
		</div>
		<? if(isset($errors)){?>
		<?=implode("<br />",$errors)?>
		<? } ?>

		<?/*<form id="signupForm" action="/users/signup" method="POST">
			<label>Username:</label>
			<input type="text" name="data[NewUser][username]" value="<?=(isset($data['username']))?$data['username']:''?>" title="What do you want to go by?" />
			<div class="clear"></div>
			<label>Email:</label>
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
		</form>*/?>
		<?/* echo $this->Form->create('User');
		    echo $this->Form->input('username');
		    echo $this->Form->input('password');
		    echo $this->Form->end('Signup'); */?>
	</div>
	<div class="login-form left">
		<div class="header">
			<h3>Log In</h3>
		</div>
		<?/*
		<?php echo $this->Form->create('User',array('action'=>'login')); ?>
			<label>Username or email:</label>
	        <?php echo $this->Form->input('email');
		        echo $this->Form->input('password');
		    ?>
			<?php echo $this->Form->end(__('Submit')); ?>
		*/?>
		<?/* echo $this->Session->flash('auth');
		    echo $this->Form->create('Register');
		    echo $this->Form->input('email');
		    echo $this->Form->input('password');
		    echo $this->Form->end('Login'); */?>

		<form id="userLogin" action="/users/login" method="POST">
			<label>Email Address:</label>
			<input id="em2" type="text" name="data[User][email]" value="" />
			<div class="clear"></div>
			<label>Password:</label>
			<input id="pw2" type="password" name="data[User][password]" value="" />
			<br/><br>
			<input type="submit" class="blue big btn" value="Login" />
		</form>
	</div>
</div>