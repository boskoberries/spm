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
	<? if(isset($data['leagues']) && count($data['leagues'])>1){
		$i = 0;
		foreach($data['leagues'] as $k=>$league){ ?>
			<a href="/memes/league/<?=$league?>"><?=$league?></a>
	 		<?=($i<(count($data['leagues'])-1))?'|':''?> 
			<? $i++;
		 }
	} ?>
	<div id="all-entries">
		<? foreach($data['memes'] as $m){ ?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? } ?>
		<?=$this->element('paging')?>
	</div>
</div>