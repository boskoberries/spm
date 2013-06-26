<?=$javascript->link('memes-index.js')?>
<?=$html->css('memes-index.css')?>

<div class="row">
	<h2>Memes by  <?=$data['tag']['Tag']['name']?></h2>
	<div class="clear"></div>	
	<div id="sorting-links" class="sorting-links">
		<a href="?sort=new" type="new" class="<?=(!isset($data['sort']) || $data['sort']=='' || $data['sort']=='new')?'active':''?>">Newest</a>
		&nbsp;|&nbsp;
		<a href="?sort=views" type="2" class="<?=($data['sort']=='views')?'active':''?>" title="Most views">Most Views</a>&nbsp;|&nbsp;
		<a href="?sort=favs" type="7" class="<?=($data['sort']=='favs')?'active':''?>" title="Most favorites">Favorited</a>
	</div>
	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
	</div>
	<?=$this->element('paging')?>
	
</div>