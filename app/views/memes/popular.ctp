<?=$javascript->link('memes-index.js')?>
<?=$html->css('memes-index.css')?>

<div class="row">
	<? if(isset($data['meme_data'])){ ?>
		<h2 class="meme-title left"><?=$data['meme_data']['Meme']['title']?></h2>
		<div class="clear"></div>
		<p class="quick-stats"># of memes: <?=count($data['memes'])?></p>	
		<div class="action right">
			<a href="/memes/add/<?=$data['meme_data']['Meme']['url']?>">
			<input id="addYourOwn" type="button" class="button" value="Add Your Own"/>
			</a>
		</div>
	<? } elseif(isset($data['sport'])){ ?>
	
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
		<? if(isset($data['leagues']) && count($data['leagues'])>1){
			$i = 0;
			foreach($data['leagues'] as $k=>$league){ ?>
				<a href="/memes/league/<?=$league?>"><?=$league?></a>
		 		<?=($i<(count($data['leagues'])-1))?'|':''?> 
				<? $i++;
			 }
	 	} ?>
	<? } else { ?>
		<h2>Popular Memes</h2>
	<? } ?>
	<div class="clear"></div>	
	<div class="sorting-links">
		<? if(isset($data['meme_data'])):?>
			<b>Sort By:</b>
			<a href="?sort=rating" class="<?=(!isset($data['sort']) || $data['sort']=='rating')?'active':''?>" title="rating">Most Popular</a>&nbsp;|&nbsp;
			<a href="?sort=viewcount" class="<?=($data['sort']=='viewcount')?'active':''?>" title="most views">View Count</a>&nbsp;|&nbsp;
			<a href="?sort=newest" class="<?=($data['sort']=='newest')?'active':''?>" title="newest">Newest</a>&nbsp;|&nbsp;
			<a href="?sort=oldest" class="<?=($data['sort']=='oldest')?'active':''?>" title="oldest">Oldest</a>&nbsp;|&nbsp;
			<a href="-index?sort=random" class="<?=($data['sort']=='random')?'active':''?>" title="Random">Random</a>
		<? elseif(isset($data['browse'])):?>
			<a href="/rating">Most Popular</a>
			<a href="/new" class="active">Newest</a>					
			<a href="/kids">Most Child Memes</a>

		
		<? else:?>
			<b>Most Popular:</b>
			<a href="?sort=2" class="<?=(!isset($data['sort']) || $data['sort']=='' || $data['sort']=='2')?'active':''?>" title="most popular last 2 days">Right Now</a>&nbsp;|&nbsp;
			<a href="?sort=7" class="<?=($data['sort']=='7')?'active':''?>" title="most popular last 7 days">Past Week</a>&nbsp;|&nbsp;
			<a href="?sort=30" class="<?=($data['sort']=='30')?'active':''?>" title="most popular last 30 days">This Month</a>&nbsp;|&nbsp;
			<a href="?sort=all" class="<?=($data['sort']=='all')?'active':''?>" title="most popular all time">All-Time</a>

					
		<? endif;?>
	</div>
	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
		<div id="loadMoreContain" class="clear center"><a href="#" id="loadMore">More</a></div>
	</div>
</div>