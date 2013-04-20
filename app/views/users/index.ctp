<div class="reg-form">
<h2>Register</h2>
<? if(isset($errors)):?>
<?=implode("<br />",$errors)?>
<? endif;?>

<form action="/registration" method="POST">
<label>Username <span class="required">*</span>:</label>
<input type="text" name="data[User][username]" value="" title="What do you want to go by?" />
<div class="clear"></div>
<label>Email:</label>
<input type="text" name="data[User][email]" value="" title="Your email address will be used for logging in" />
<div class="clear"></div>
<label>Password:</label>
<input type="text" name="data[User][password] value="" title="Enter your password" />
<div class="clear"></div>
<label>Confirm Password:</label>
<input type="text" name="data[User][password] value="" title="Enter your password" />
<div class="clear"></div>
<input type="submit" value="Register" />
</form>
</div>
<div class="login-form">
<form action="/users/login" method="POST">
<label>Username or Email:</label>
<input type="text" name="data[User][email]" value="" />
<div class="clear"></div>
<label>Password:</label>
<input type="text" name="data[User][password]" value="" />
<input type="checkbox" name="data[User][remember_me]" value="" />&nbsp;Remember me for 2 weeks?
<input type="submit" value="Login" />

</form>

</div>