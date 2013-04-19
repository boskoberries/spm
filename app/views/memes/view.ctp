<?=$javascript->link('/js/jquery.raty.js')?>
<?=$javascript->link('/js/meme-rater.js')?>
<script type="text/javascript">
	var constants = { meme_id: <?=$data['Meme']['id']?> };
</script>

<div class="row row-top">
	<div class="eight columns">
		<h2>
			<?=$html->link($data['Meme']['title'],'/memes/all/'.$data['Meme']['url'])?>
		</h2>
	</div>
	<div class="three columns">
	
	</div>
</div>
<div class="row">
	<div class="eight columns meme-view">
		<img src="/img/user_memes/<?=$data['Meme']['image_url']?>" />
	</div>
	<div class="three columns">
		<div class="stats-sidebar">
			<a href="/memes/add/<?=$data['Meme']['id']?>" class="button">Add Your Own Caption</a>
		</div>
		<div class="stats-sidebar">
			<? if(isset($data['admin']) || $data['owner']){ ?>
				<a href="#" id="delete-meme" class="right delete">Delete</a>
			<? }?>
			<? if(isset($data['creator'])){ ?>
				<div class="stat">
					By: <?=$html->link($data['creator'],'/memes/users/'.$data['creator_slug'])?>
				</div>
			<? } ?>
			<div class="stat">
				<span>Rating: <span id="meme-rating"><?=$data['meme_rating'];?></span></span>
				<span class="push-right"><div id="star" <?php if(is_numeric($data['user_rating'])) echo "data-rating=\"{$data['user_rating']}\"";?>></div> </span>
			</div>
			<br />
			<div class="stat">
				<span>Views: <?=$data['Meme']['view_count']?></span>
				<span class="push-right">created <?=date('n/j/y',strtotime($data['Meme']['created']))?></span>
			</div>	
		</div>
	
		<div class="stats-sidebar">
			<?=$html->link('Show all results for '.$data['Meme']['title'],'/memes/all/'.$data['Meme']['url'])?>			
		</div>
	

		<? if(!empty($data['MemeTag'])){ ?>
		<div class="stats-sidebar">
			<b>Tags:</b>
			<ul class="tag-list">
				<? foreach($data['MemeTag'] as $tag){ ?>
				<li><a href="/tags/<?=$tag['tag_name']?>"><?=$tag['tag_name']?></a></li>
				<? } ?>
			</ul>
		</div>
		
		<? } ?>
		<div class="stats-sidebar">
			<h5>Share The Love</h5>
			<script type="text/javascript" src="http://www.reddit.com/static/button/button1.js?newwindow=1"></script>

			<a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out this SportsMeme" data-size="large" data-related="bboskoff" data-hashtags="sportsmemes">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<br />
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
			<g:plusone></g:plusone>
			<br /><br />
			<h5>Share Tiny URL</h5>
			<a href="#">http://spts.me/el192l</a>

		
		</div>

	</div>
</div>
