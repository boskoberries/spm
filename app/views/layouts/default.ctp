<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
	<head>
 		<title>Sports Memes</title>
		<meta charset="utf-8" />	
		<!-- Set the viewport width to device width for mobile -->
		<meta name="viewport" content="width=device-width" />
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two' rel='stylesheet' type='text/css'>

			<!--    	<link rel="stylesheet" type="text/css" href="/sports_memes/css/ocbstyle928.css" media="all" />-->

		<?=$html->css('/css/grid.css')?>
		<?=$html->css('/css/app.css')?>

		<?=$html->css('/js/jquery-ui-1.8.14.custom.css')?>
    	<?=$javascript->link('/js/jquery-1.6.1.min.js')?>
    	<?=$javascript->link('/js/jquery-ui-1.8.14.custom.min.js')?>
		<?=$javascript->link('/js/jquery.raty.js')?>
		<!--[if lt IE 9]>
			<?php echo $html->css('/js/ie.css',"stylesheet",array('media'=>'all'));?>
		<![endif]-->
		
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
   		<div class="global-header">
        	    <div class="row">
                	<div class="three columns">
                	   <a href="/" class="logo" >SPORTS MEMES</a>
                	</div>
                	<div class="nine columns">
	                    <nav class="global">
							
								<ul class="nav-links">
									<li><a href="/football" class="nav-link ">Football</a></li>
         							<li><a href="/basketball" class="nav-link ">Basketball</a></li>
         							<li><a href="/baseball" class="nav-link ">Baseball</a></li>
         							<li><a href="/hockey" class="nav-link ">Hockey</a></li>
         							<li class="has-children">
     									<a href="#" class="nav-link ">Other Sports</a>
     									<ul class="hide">
     										<li><a href="/soccer">Soccer</a></li>
     										<li><a href="/tennis">Tennis</a></li>
     										<li><a href="/nascar">Nascar</a></li>
     										<li><a href="/wrestling">Wrestling</a></li>
     									</ul>
     								</li>
         							<li><a href="/memes/popular" class="nav-link ">Most Popular</a></li>
         							<li><a id="createYourOwn" href="/memes/create" class="nav-link button">Create Your Own!</a></li>
         						</ul>	
         					
						</nav>
					</div>	
	            </div>
	    </div>  
	    <div id="subnav">
	    	<div class="right">
		    	<a href="#">Your favorites (3)</a>&nbsp;|&nbsp;
		    	<? if(isset($user)){ ?>
		    	<span class="logged-in bold">Logged in as: butangphp</span>
		    	<a href="/users/logout">(sign out)</a>

		    	<? } else { ?>
		    	<a href="/users/login">Log-in</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/users/signup">Sign Up</a>

		    	<? } ?>
		    	<input id="searchBar" type="text" placeholder="Search..." />
		    </div>
			<?php if(isset($info)){ ?>
         		<div class="three columns">
        		<a id="accountName" class="logout" >
				<img src="/img/<?php echo $info['User']['image_url'];?>" class="user-avatar" />
				<?php echo $info['User']['account_name'];?>&nbsp;&#9660;</a>
		
				<div id="accountDropDown" class="hide_me">
					<div class="dropDownPointer">
						<div class="dropDownArrow"></div>
						<div class="dropDownArrowBorder"></div>
					</div>
					<div class="dropDownContent">
					<ul>
						<li><a href="/account">Account Settings</a></li>
						<li><a href="/users/profile">View My Profile</a></li>
		                <li><a href="/help">Help</a></li>
						<li><a href="/about">About Us</a></li>
						<li><a href="http://www.oneclipboard.com/blog" target="_blank">Blog</a></li>
    	        		<?php if($info['User']['admin']=='1'){ ?>
				    		<li><?php echo  $html->link('Admin Stuff','/admin');?></li>	
						<?php } ?>			       
		                <li class="last" style="border-bottom:0;"><a href="/users/logout">Logout</a></li>
					</ul>
					</div>
				</div>
			</div>
			<?php } ?> 
	    </div>   
							

		<div id="authMessage"></div>
		<?php if(isset($_SESSION['Message']['flash']['message']) && !empty($_SESSION['Message']['flash']['message'])){ ?>
			<?php $flash_class=(isset($_SESSION['Message']['flash']['params']['class']))?$_SESSION['Message']['flash']['params']['class']:'error_area';?>
			<div id="flashMessage" class="<?php echo $flash_class;?>"><?php echo $_SESSION['Message']['flash']['message'];?></div>
			<?php unset($_SESSION['Message']['flash']['message']);?>
		<?php } ?>

		<!-- body container -->
		<div id="container" class="container page-content">
			<?php echo  $content_for_layout;?>
			<?php //echo $cakeDebug; ;?>
		</div>
		<!-- end body container -->    
    	<br clear="all" />
    	<footer>
   			<div class="footerLinks">
    		  	<ul>
    		 		<li><a href="about">About Us</a></li>
    		 		<li><a href="http://oneclipboard.com/blog">Sitemap</a></li>
					<li><a href="/help">Help</a></li>
    			  	<li><a href="/about/privacy">Privacy Policy</a></li>
    			  	<li class="last"><a href="/about/terms">Terms of Service</a></li>
    	  			<li><div class="copyright">&copy; <?=date('Y')?> Sports Memes</div></li>
    			</ul>
    		</div><!-- end of footerLinks -->
		
		</footer>

</body>
</html>
