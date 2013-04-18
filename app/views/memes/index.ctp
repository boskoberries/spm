<div class="content">
<h2>Today's Sports Memes</h2>

<? foreach($data['memes'] as $meme):?>
	<div class="meme-entry">
		<div class="title"><?=$meme['Meme']['title']?></div>
		<div class="meme-mini">
			<img src="/img/<?=$meme['Meme']['image_url_original']?>" />
		</div>
	</div>
<? endforeach;?>

<?=$html->link('Create Your Own','/memes/create')?>

</div>