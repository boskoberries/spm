<? foreach($data['memes'] as $m){ ?>		
	<?=$this->element('meme-entry',array('m'=>$m))?>
<? } ?>
<? if(empty($data['memes'])){ ?>
<input id="reachedBottom" type="hidden" value="1" />
<? } ?>