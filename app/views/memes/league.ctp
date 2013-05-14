<?=$javascript->link('memes-index.js')?>
<?=$html->css('memes-index.css')?>

<div class="row">

	<h2>
		<? if(isset($data['parent']) && !empty($data['parent']['Sport'])){ ?>
		<span>
			<a href="/<?=$data['parent']['Sport']['name']?>">
				<?=ucwords($data['parent']['Sport']['name'])?>
			</a> 
		</span> 
			&raquo;
		<? } ?>
		<span>
			<?=ucwords($data['sport'])?> Memes
		</span>
	</h2>	
	<div class="sorting-links">
			<b>Sort By:</b>
			<a href="?s=rating" class="<?=($data['sort']=='' || $data['sort']=='rating')?'active':''?>" title="rating">Rating</a>&nbsp;|&nbsp;
			<a href="?s=viewcount" class="<?=($data['sort']=='viewcount')?'active':''?>" title="most views">View Count</a>&nbsp;|&nbsp;
			<a href="?s=newest" class="<?=($data['sort']=='newest')?'active':''?>"  title="newest">Newest</a>&nbsp;|&nbsp;
			<a href="?s=random" class="<?=($data['sort']=='random')?'active':''?>"  title="Random">Random</a>				
	</div>
	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
		<?=$this->element('paging')?>
	</div>
</div>