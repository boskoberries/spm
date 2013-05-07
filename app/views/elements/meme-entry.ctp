<div class="meme-entry <?=(isset($small))?$small:''?>" meme-id="<?=$m['Meme']['id']?>">
	<? if(isset($data['isAdmin'])){?>
		<a href="#" class="delete-meme hide icon-delete" meme-id="<?=$m['Meme']['id']?>"></a>
	<? } ?>
	<div class="title"><?=$m['Meme']['title']?><span class="child-count hide">(<?=$m['Meme']['view_count']?>)</span></div>
	<a href="/memes/view/<?=$m['Meme']['url']?>">
		<img class="meme" src="/img/user_memes/<?=$m['Meme']['image_url_medium']?>" />
	</a>
	<div class="action-box hide">
		<div class="favorite left">
			<? if(isset($data['favorites']) && in_array($m['Meme']['id'],$data['favorites'])){ ?>
			<a href="#" class="star icon2-star-2 favorite"></a>
<!-- 			<img class="star favorite" src="/img/star-on-big.png" /> -->
			<? } else { ?>
			<a href="#" class="star icon2-star"></a>
	<!-- 		<img class="star icon2-star-2" src="/img/star-off-big.png" />
 -->			<? } ?>

			<? $selected = '';?>
			<? if(isset($data['user_ratings']) && in_array($m['Meme']['id'],$data['user_ratings'])){ ?>
				<? $selected = $data['user_ratings'][$m['Meme']['id']];?>
			<? } ?>
			<a href="#" class="icon2-arrow-up rating-btn <?=($selected=='root')?'active':''?> root"></a>
			<a href="#" class="icon2-arrow-down rating-btn <?=($selected=='boo')?'active':''?> boo"></a>

		</div>
		<a href="/memes/add/<?=$m['Meme']['url']?>" class="blue btn right">Add Your Own</a>

<?/*		<div class="star" <? if(isset($m['Meme']['user_rating'])) echo "data-rating=\"{$m['Meme']['user_rating']}\"";?>></div>*/?>
	</div>				

</div>
