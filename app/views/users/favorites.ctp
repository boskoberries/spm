<div class="row">

	<h3>Your Favorites</h3>
	<div id="all-entries">
		<? if(!empty($data['favorites'])){ ?>
			<? foreach($data['favorites'] as $favorite){ ?>
				<?=$this->element('meme-entry',array('m'=>$favorite))?>
			<? } ?>
		<? } else { ?>
			<i>No favorites to show yet.</i>  <a href="/memes">Browse and add some!</a>	
		<? } ?>
	</div>
</div>