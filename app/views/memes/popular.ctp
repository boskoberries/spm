<?=$javascript->link('memes-index.js')?>
<?=$html->css('memes-index.css')?>

<div class="row">
	<h2>Popular Memes</h2>
	<div class="clear"></div>	
	<div id="sorting-links" class="sorting-links">
		<b>Most Popular:</b>
		<a href="?sort=2" type="2" class="<?=(!isset($data['sort']) || $data['sort']=='' || $data['sort']=='2')?'active':''?>" title="most popular last 2 days">Right Now</a>&nbsp;|&nbsp;
		<a href="?sort=7" type="7" class="<?=($data['sort']=='7')?'active':''?>" title="most popular last 7 days">Past Week</a>&nbsp;|&nbsp;
		<a href="?sort=30" type="30" class="<?=($data['sort']=='30')?'active':''?>" title="most popular last 30 days">This Month</a>&nbsp;|&nbsp;
		<a href="?sort=all" type="all" class="<?=($data['sort']=='all')?'active':''?>" title="most popular all time">All-Time</a>&nbsp;|&nbsp;
		<a href="?sort=new" type="new" class="<?=($data['sort']=='new')?'active':''?>">Newest</a>
	</div>
	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
	</div>
	<?=$this->element('paging')?>
	
</div>