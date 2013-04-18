<script type="text/javascript">

$(document).ready(function(){

	// $('.star').raty({
	//   //scoreName: 'entity.score',
	//  number:    4,
	//  start: function() {
 //    	return $(this).attr('data-rating');
 //  	},
 //  	 click: function(score, evt) {
 //  	 	$.post("/memes/addRating", { id: 0, value: score }, function(response){
	// 		if(response){
	// 			var jq = $.parseJSON(response);
	// 			if(jq.value){
	// 				$("#meme-rating").html(jq.value).fadeIn();
	// 			}
	// 		}  	 	
 //  	 	});

	//   },
	//    starOff:   'star-off-big.png',
	//   starOn:    'star-on-big.png'
	// });

});
</script>

<div class="row">
	<? if(isset($data['meme_data'])):?>
		<h2 class="meme-title left"><?=$data['meme_data']['Meme']['title']?></h2>
		<div class="clear"></div>
		<p class="quick-stats"># of memes: <?=count($data['memes'])?></p>	
		<div class="action right">
			<a href="/memes/add/<?=$data['meme_data']['Meme']['url']?>">
			<input id="addYourOwn" type="button" class="button" value="Add Your Own"/>
			</a>
		</div>
	<? else:?>
		<h2>Browse Memes</h2>
	<? endif;?>
	<div class="clear"></div>	
	<div class="sorting-links">
		<a href="/rating">Highest Rated</a>
		<a href="/new" class="active">Newest</a>					
		<a href="/kids">Most Child Memes</a>
	</div>
	<? foreach($data['memes'] as $m):?>		
		<?=$this->element('meme-entry',array('m'=>$m))?>
	<? endforeach;?>

</div>