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
		<?=$html->css('/css/grid.css')?>
		<?=$html->css('/css/app.css')?>
		<?=$html->css('/css/ui-elements.css')?>
		<?=$html->css('/js/jquery-ui-1.8.14.custom.css')?>
    	<?=$javascript->link('/js/jquery-1.9.1.min.js')?>
    	<?//=$javascript->link('/js/jquery-1.6.1.min.js')?>
    	<?//=$javascript->link('/js/jquery-ui-1.8.14.custom.min.js')?>
    	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    	<?=$javascript->link('site-ui.js')?>
		<!--[if lt IE 9]>
			<?php echo $html->css('/js/ie.css',"stylesheet",array('media'=>'all'));?>
		<![endif]-->
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=378957218792212";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
   		<div class="global-header">
        	    <div id="mainNavRow" class="row">
                	<div class="three columns">
                	   <a href="/" class="logo" >SPORTS MEMES</a>
                	</div>
                	<div class="nine columns">
							<nav class="global nine columns">
								<ul class="nav-links">
									<? $i = 1;?>
									<li><a href="/" class="nav-link <?=(!isset($this->params['option'])||$this->params['option']=='')?'active':''?>">All Sports</a></li>
									<li><a href="/football" class="nav-link <?=(isset($this->params['option'])&&$this->params['option']=='football')?'active':''?>">Football</a></li>
	     							<li><a href="/basketball" class="nav-link <?=(isset($this->params['option'])&&$this->params['option']=='basketball')?'active':''?>">Basketball</a></li>
	     							<li><a href="/baseball" class="nav-link <?=(isset($this->params['option'])&&$this->params['option']=='baseball')?'active':''?>">Baseball</a></li>
	     							<li><a href="/hockey" class="nav-link <?=(isset($this->params['option'])&&$this->params['option']=='hockey')?'active':''?>">Hockey</a></li>
	     							<?/* <li class="has-children">
	 									<a href="#" class="nav-link ">Other Sports <span class="icon-down"></span></a>
	 									<ul class="">
	 										<li><a href="/soccer">Soccer</a></li>
	 										<li><a href="/tennis">Tennis</a></li>
	 										<li><a href="/nascar">NASCAR</a></li>
	 									</ul>
	 								</li> */?>
	     						</ul>	    
						</nav>
						<a id="createYourOwn" href="/memes/create" class="nav-link button right three columns">Create Your Own!</a>
					</div>	

	            </div>
	    </div>  
	    <div id="subnav">
	    	<div class="left">
<!--<div class="fb-like" data-href="http://sportsmemes.com" data-send="false" data-width="20" data-show-faces="false" data-font="lucida grande"></div> -->
	    	</div>
	    	<div class="right">
	    		<? if(isset($info['user']['User']['id'])){ ?>
	    		<a href="/memes/users/<?=$info['user']['User']['id']?>">Your memes (<?=(isset($info['meme_count']))?$info['meme_count']:0?>)</a>
	    		<? } else { //logged out ?>
<!-- 	    		<a href="/memes/users/">Your memes (<?=(isset($info['meme_count']))?$info['meme_count']:0?>)</a>
	    		&nbsp;|&nbsp;
		    	<a href="/users/favorites">Your favorites (<?=(isset($info['fav_count']))?$info['fav_count']:0?>)</a>&nbsp;|&nbsp; -->
		    	<? } ?>
		    	<? if(isset($info['user']) && !empty($info['user'])){ ?>
		    	<span class="logged-in bold">Logged in as: <?=$info['user']['User']['username']?></span>
		    	<a href="/users/logout">(sign out)</a>

		    	<? } else { ?>
		    	<a id="loginBtn" href="#" reveal-href="/users/login">Log-in</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="signUpBtn" href="#" reveal-href="/users/signup">Sign Up</a>

		    	<? } ?>
		    	<input id="searchBar" type="text" placeholder="Search..." />
		    </div>
	    </div>   
	    <? if(isset($error) && !empty($error)){ ?>
		<div id="errorMessage">							
	    	<?=$error?>
	    </div>
	    <? } ?>
	    <div id="authMessage"></div>

    	<?/*
		<div id="authMessage"></div>
		<?php if(isset($_SESSION['Message']['flash']['message']) && !empty($_SESSION['Message']['flash']['message'])){ ?>
			<?php $flash_class=(isset($_SESSION['Message']['flash']['params']['class']))?$_SESSION['Message']['flash']['params']['class']:'error_area';?>
			<div id="flashMessage" class="<?php echo $flash_class;?>"><?php echo $_SESSION['Message']['flash']['message'];?></div>
			<?php unset($_SESSION['Message']['flash']['message']);?>
		<?php } ?>
	*/?>
	<?php if(isset($_SESSION['Message']['flash']['message']) && !empty($_SESSION['Message']['flash']['message'])){ ?>
		<?php $flash_class=(isset($_SESSION['Message']['flash']['params']['class']))?$_SESSION['Message']['flash']['params']['class']:'error_area';?>
		<div id="flashMessage" class="<?php echo $flash_class;?>"><?php echo $_SESSION['Message']['flash']['message'];?> <i class="close-flash-message icon-close-2"></i></div>
		<?php unset($_SESSION['Message']['flash']['message']);?>
	<?php }?>

		<!-- body container -->
		<div id="container" class="container page-content">
			<?php echo $content_for_layout;?>
			<?php echo $this->element('sql_dump');?>
			<div id="simple-modal-wrap" class="simple-modal-wrap hide">
				<div class="simple-modal-flow-control ">
					<div id="sign-me-up" class="simple-modal hide">
						<?=$this->element('signup-form')?>
					</div>
				</div>
			</div>

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
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-42204217-1', 'sportsmemes.com');
		  ga('send', 'pageview');

		</script>

</body>
</html>
