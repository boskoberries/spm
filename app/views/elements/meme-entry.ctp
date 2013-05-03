<div class="meme-entry <?=(isset($small))?$small:''?>" meme-id="<?=$m['Meme']['id']?>">
	<? if(isset($data['isAdmin'])){?>
		<a href="#" class="delete-meme hide icon-delete" meme-id="<?=$m['Meme']['id']?>"></a>
	<? } ?>
	<div class="title"><?=$m['Meme']['title']?><span class="child-count hide">(<?=$m['Meme']['view_count']?>)</span></div>
	<a href="/memes/view/<?=$m['Meme']['url']?>">
		<img class="meme" src="/img/user_memes/<?=$m['Meme']['image_url_medium']?>" />
	</a>
	<div class="action-box hide">
		<?=$html->link('Add your own',"/memes/add/".$m['Meme']['url'],array('class'=>'add-your-own'))?>
		<div class="favorite">
			<? if(isset($data['favorites']) && in_array($m['Meme']['id'],$data['favorites'])){ ?>
			<img class="star favorite" src="/img/star-on-big.png" />
			<? } else { ?>
			<img class="star" src="/img/star-off-big.png" />
			<? } ?>
		</div>
		<div class="rating">
			<? $selected = '';?>
			<? if(isset($data['user_ratings']) && in_array($m['Meme']['id'],$data['user_ratings'])){ ?>
				<? $selected = $data['user_ratings'][$m['Meme']['id']];?>
			<? } ?>
			<a href="#" class="rating-btn <?=($selected=='root')?'active':''?> root">:D</a>
			<a href="#" class="rating-btn <?=($selected=='boo')?'active':''?> boo">:(</a>

		</div>
<?/*		<div class="star" <? if(isset($m['Meme']['user_rating'])) echo "data-rating=\"{$m['Meme']['user_rating']}\"";?>></div>*/?>
	</div>				

</div>
