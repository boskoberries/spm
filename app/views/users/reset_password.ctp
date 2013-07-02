<?=$html->css('signup.css')?>
<div id="signup-container">
	<div class="reg-form left">
		<div class="header first">
			<h3>Reset Password</h3>
		</div>
		<? if(isset($data['password_sent'])){ ?>
			<div class="text-top">
				<div>A reset link has been sent to <b><?=$data['email']?></b></div>
				<div>Please follow the instructions in the email.</div>
			</div>
		<? } else { ?>
		<?php
			echo $form->create('User',array('action'=>'reset_password'));
			echo $form->input('email',array('label'=>'Email Address:'));
			echo "<br />";
			echo $form->submit('Send Me Password',array('class'=>'big blue btn'));//, array('after' => ' ' . $html->link('Cancel', array('action' => 'index'))));
			echo $form->end();
		} ?>
	</div>
</div>