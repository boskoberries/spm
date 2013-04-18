<?=$javascript->link('/app/js/jquery.raty.js')?>
<script type="text/javascript">
$(document).ready(function(){

	$('.star').raty({
	  //scoreName: 'entity.score',
	 number:    4,
	 start: function() {
    	return $(this).attr('data-rating');
  	},
  	 click: function(score, evt) {
  	 	$.post("/app/memes/addRating", { id: 0, value: score }, function(response){
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
	
	$("div.meme-entry").hover(function(){
		$(this).find("div.action-box").show();
	},function(){
		$(this).find("div.action-box").hide();	
	});
	$("#addYourOwn").click(function(){
	
	});
});
</script>

<div class="row">
	
	<? if(isset($data['team_info'])){ ?>
	<h2><img src="" width="35" /><?=$data['team_info']['Team']['name']?></h2>
	<? } else { ?>	
	<h2>Search By Team</h2>
	<? } ?>

	<div class="clear"></div>	
	<div class="sorting-links">
		<? if(isset($data['team_info'])):?>
			<b>Sort By:</b>
			<a href="?sort=rating" class="active" title="rating">Rating</a>&nbsp;|&nbsp;
			<a href="?sort=viewcount" title="most views">View Count</a>&nbsp;|&nbsp;
			<a href="?sort=newest"  title="newest">Newest</a>&nbsp;|&nbsp;
			<a href="?sort=oldest"  title="oldest">Oldest</a>&nbsp;|&nbsp;
			<a href="?sort=random"  title="Random">Random</a>				
		<? endif;?>
	</div>
	<? if(isset($data['teams'])){ ?>
		<? //pr($data['teams']);?>
		<?foreach($data['leagues'] as $leagueid=>$league){ ?>
		<div class="league-block">
			<h3><img src="" width="35" /><?=$league['name']?></h3>
			<ul>
				<? if(isset($data['teams'][$leagueid])){
					foreach($data['teams'][$leagueid] as $team){ ?>
				<li><a href="/app/teams/<?=$team['url']?>"><?=$team['name']?></a></li>
				<? }
				} ?>
			</ul>
		</div>
		<? } ?>
		<?//print_r($data['teams']);?>
	
	<? } else { ?>
		<? foreach($data['memes'] as $m):?>		
			<?=$this->element('meme-entry',array('m'=>$m))?>
		<? endforeach;?>
	<? } ?>
	
</div>