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
	$("a.delete-meme").click(function(event){
		event.preventDefault();
		var answer = confirm('Are you sure you want to delete this meme?');
		var meme_id = $(this).attr("meme-id");
		$(this).parents(".meme-entry").fadeOut('fast',function(){
			$(this).remove();
		});
		
		if(answer){
			$.post("/memes/delete",{ data: { meme_id: meme_id } }, function(response){

			});
		}
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
		<? if(isset($data['parent']) && !empty($data['parent']['Sport'])){ ?>
		<h2><a href="/memes/sport/<?=$data['parent']['Sport']['name']?>"><?=ucwords($data['parent']['Sport']['name'])?></a> </h2> &raquo;
		<? } ?>
		<h2><?=ucwords($data['sport'])?> Memes</h2>
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
			<a href="?sort=rating" class="active" title="rating">Most Popular</a>&nbsp;|&nbsp;
			<a href="?sort=viewcount" title="most views">View Count</a>&nbsp;|&nbsp;
			<a href="?sort=newest"  title="newest">Newest</a>&nbsp;|&nbsp;
			<a href="?sort=oldest"  title="oldest">Oldest</a>&nbsp;|&nbsp;
			<a href="?sort=random"  title="Random">Random</a>
		<? elseif(isset($data['browse'])):?>
			<a href="/rating">Most Popular</a>
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