<?=$javascript->link('memes-index.js')?>
<?=$html->css('memes-index.css')?>

<div class="row">

	<h2>
		<span class="left">Popular Memes</span>
		<select id="sportSelect" class="left">
			<option value="">All Sports</option>
			<? foreach($data['sports'] as $sport){ ?>
			<option value="<?=strtolower($sport['Sport']['name'])?>"><?=$sport['Sport']['name']?></option>
			<? } ?>
		</select>
	</h2>

	
	<div class="clear"></div>	
	<div class="sorting-links">
		<a style="margin-left:-2px;" href="?sort=2" class="<?=(!isset($data['sort']) || $data['sort']=='' || $data['sort']=='2')?'active':''?>" title="most popular last 2 days">Popular Now</a>
		<a href="?sort=new" class="<?=($data['sort']=='new')?'active':''?>">Newest</a>
		<a href="?sort=7" class="<?=($data['sort']=='7')?'active':''?>" title="most popular last 7 days">Past Week</a>
		<a href="?sort=30" class="<?=($data['sort']=='30')?'active':''?>" title="most popular last 30 days">This Month</a>
		<a href="?sort=all" class="<?=($data['sort']=='all')?'active':''?>" title="most popular all time">All-Time</a>
	</div>
	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
	</div>
	<?=$this->element('paging')?>
	
</div>