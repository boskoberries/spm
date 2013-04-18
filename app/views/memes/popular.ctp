<?=$javascript->link('/js/jquery.raty.js')?>
<script type="text/javascript">
$(document).ready(function(){

	$('.star').raty({
	  //scoreName: 'entity.score',
	 number:    4,
	 start: function() {
    	return $(this).attr('data-rating');
  	},
  	 click: function(score, evt) {
  	 	$.post("/memes/addRating", { id: 0, value: score }, function(response){
			if(response){
				var jq = $.parseJSON(response);
				if(jq.value){
					$("#meme-rating").html(jq.value).fadeIn();
				}
			}  	 	
  	 	});

	  },
	   starOff:   'star-off-big.png',
	  starOn:    'star-on-big.png'
	});
	
	$("#addYourOwn").click(function(){
	
	});
});
</script>

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
		<h2><?=$data['sport']?> Memes</h2>
	<? } else { ?>
		<h2>Popular Memes</h2>
	<? } ?>
	<div class="clear"></div>	
	<div class="sorting-links">
		<? if(isset($data['meme_data'])):?>
			<b>Sort By:</b>
			<a href="?sort=rating" class="active" title="rating">Rating</a>&nbsp;|&nbsp;
			<a href="?sort=viewcount" title="most views">View Count</a>&nbsp;|&nbsp;
			<a href="?sort=newest"  title="newest">Newest</a>&nbsp;|&nbsp;
			<a href="?sort=oldest"  title="oldest">Oldest</a>&nbsp;|&nbsp;
			<a href="?sort=random"  title="Random">Random</a>
		<? elseif(isset($data['browse'])):?>
			<a href="/rating">Highest Rated</a>
			<a href="/new" class="active">Newest</a>					
			<a href="/kids">Most Child Memes</a>

		
		<? else:?>
			<b>Most Popular:</b>
			<a href="?sort=2" class="active" title="most popular last 2 days">Last 2 Days</a>&nbsp;|&nbsp;
			<a href="?sort=7" title="most popular last 7 days">Last 7 Days</a>&nbsp;|&nbsp;
			<a href="?sort=30"  title="most popular last 30 days">Last 30 Days</a>&nbsp;|&nbsp;
			<a href="?sort=all" title="most popular all time">All-Time</a>

					
		<? endif;?>
	</div>
	<? foreach($data['memes'] as $m):?>		
		<?=$this->element('meme-entry',array('m'=>$m))?>
	<? endforeach;?>

</div>