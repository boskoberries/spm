<?=$javascript->link('memes-index.js')?>
<?=$html->css('memes-index.css')?>

<div class="row">
	<h2 class="meme-title left"><?=$data['meme_data']['Meme']['title']?></h2>
	<div class="action right">
		<a href="/memes/add/<?=$data['meme_data']['Meme']['url']?>">
		<input id="addYourOwn" type="button" class="button" value="Add Your Own Caption"/>
		</a>
	</div>
	<div class="clear"></div>
	<p class="quick-stats"># of memes: <?=count($data['memes'])?></p>	


	<div class="clear"></div>	

	<div class="sorting-links">
		<b>Sort By:</b>
		<a href="?sort=rating" class="<?=($data['sort']=='rating' || $data['sort']=='')?'active':''?>" title="rating">Most Popular</a>
		<a href="?sort=viewcount" class="<?=($data['sort']=='viewcount')?'active':''?>" title="most views">View Count</a>
		<a href="?sort=newest" class="<?=($data['sort']=='newest')?'active':''?>" title="newest">Newest</a>
		<a href="?sort=oldest" class="<?=($data['sort']=='oldest')?'active':''?>" title="oldest">Oldest</a>
		<a href="?sort=random" class="<?=($data['sort']=='random')?'active':''?>" title="Random">Random</a>
	</div>

	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
	</div>
	<?=$this->element('paging')?>
</div>