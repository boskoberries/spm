<style type="text/css">
#signup-container{
/*	padding: 30px 40px;*/
	background: #ffffff;
	border:1px solid #333333;
	float: left;
	margin-left: 120px;
	box-shadow: 1px 1px 5px #000000;
}
#signup-container h3{
	text-transform: uppercase;
	font-size: 22px;
}
#signup-container label{
	color: #333333;
	font-weight: bold;
	margin:10px 0 0 0;
}
#signup-container input[type='text'],#signup-container input[type='password']{
	width: 250px;
}
#signup-container .header{
	background: #eeeeee;
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	padding-top: 7px;
	text-align: center;
	box-shadow: 1px 1px 5px #000000;
}
#signup-container .header.first{
	border-right: 1px solid #cccccc;
}
#signup-container .header h3{
	color: #333;
	font-family: 'gibsonSemiBold';
}
#signup-container input[type="submit"]{
	width:100%;
}
#signup-container form{
	margin-top:40px;
}
.reg-form{
	border-right: 1px solid #cccccc;
}
.reg-form,.login-form{
	padding: 30px 40px;
	position: relative;
}
</style>
<div id="signup-container">
	<div class="reg-form left">
		<div class="header first">
			<h3>Sign Up</h3>
		</div>
		<? if(isset($errors)){?>
		<?=implode("<br />",$errors)?>
		<? } ?>

		<form action="/users/register" method="POST">
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
		</form>
		<?/* 
			echo $this->Form->create('User');
		    echo $this->Form->input('username');
		    echo $this->Form->input('password');
		    echo $this->Form->end('Signup');
	    */?>

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
		<?php/*
		    echo $this->Session->flash('auth');
		    echo $this->Form->create('Register');
		    echo $this->Form->input('email');
		    echo $this->Form->input('password');
		    echo $this->Form->end('Login');
		    */
		?>

		<form action="/users/login" method="POST">
			<label>Username or Email:</label>
			<input type="text" name="data[User][email]" value="" />
			<div class="clear"></div>
			<label>Password:</label>
			<input type="password" name="data[User][password]" value="" title="Enter Passwrd"/>
			<br/><br>
			<input type="submit" class="blue big btn" value="Login" />
		</form>
	</div>
</div>