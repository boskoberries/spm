<div class="meme-entry <?=(isset($small))?$small:''?>">
	<div class="title"><?=$m['Meme']['title']?><span class="child-count hide">(<?=$m['Meme']['view_count']?>)</span></div>
	<a href="/memes/view/<?=$m['Meme']['url']?>">
		<img class="meme" src="/img/user_memes/<?=$m['Meme']['image_url_medium']?>" />
	</a>
	<div class="action-box hide">
<!-- 		<div class="rating">Rating: <?=$m['Meme']['rating']?></div>
		<div class="view-count clear">View Count: <?=$m['Meme']['view_count']?></div> -->
		<?=$html->link('Add your own',"/memes/add/".$m['Meme']['url'],array('class'=>'add-your-own'))?>
		
		<div class="star" <? if(isset($m['Meme']['user_rating'])) echo "data-rating=\"{$m['Meme']['user_rating']}\"";?>></div>
	</div>				

</div>
