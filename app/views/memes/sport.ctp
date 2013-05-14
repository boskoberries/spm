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
	<div id="sorting-links" class="sorting-links">
		<input type="hidden" id="current-sport-id" value="<?=$data['sport_id']?>" />
		<input type="hidden" id="current-sport-name" value="<?=$data['sport']?>" />
		<? if(isset($data['leagues']) && count($data['leagues'])>1){ ?>
			<select id="sportSelect">
				<option value="">All <?=ucwords($data['sport'])?></option>
				<? foreach($data['leagues'] as $k=>$league){ ?>
				<option value="<?=$league?>"><?=$league?></option>
				<? } ?>
			</select>
		<? } ?>
		<b>Sort By:</b>
		<a href="?s=rating" type="rating" class="<?=($data['sort']=='' || $data['sort']=='rating')?'active':''?>" title="rating">Rating</a>&nbsp;|&nbsp;
		<a href="?s=viewcount" type="viewcount" class="<?=($data['sort']=='viewcount')?'active':''?>" title="most views">View Count</a>&nbsp;|&nbsp;
		<a href="?s=newest" type="newest" class="<?=($data['sort']=='newest')?'active':''?>"  title="newest">Newest</a>&nbsp;|&nbsp;
		<a href="?s=random" type="random" class="<?=($data['sort']=='random')?'active':''?>"  title="Random">Random</a>				
	</div>

	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
		<?=$this->element('paging')?>
	</div>
</div>