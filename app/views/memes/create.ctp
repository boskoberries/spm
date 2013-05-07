<?=$javascript->link('/js/jquery.tipTip.minified.js')?>
<?=$html->css('/css/tipTip.css')?>

<script type="text/javascript">
$(document).ready(function(){
	$("#meme-upload-link").click(function(){
		$("#upload-img-box").click();
	});
	$("#upload-img-box").change(function(){
		document.meme_form.submit();
	});
	// $("div.meme-entry").each(function(){ //add tiptip functionality
	// 	var $obj=$(this);
	// 	$obj.tipTip({
	// 		delay: 50,
	// 		content: $obj.find("a").attr("title")
	// 	});	
	// })
});
</script>
<style type="text/css">
.file-msg{
	color:#333;
	font-size:11px;
		
}
</style>
<div class="row">
<div class="one columns"></div>
<div class="eight columns">
		<h2>Create Your Own</h2>

	<? if(true || isset($data['meme_type'])){ ?>
<!--		<h2>Create A <?=$data['meme_type']['MemeType']['name']?> Meme</h2>-->
		<form name="meme_form" action="" method="post" enctype="multipart/form-data">
			<p class="image-msg">Click below to upload your image.  Only .png, .jpeg, .jpg and .gif files accepted</p>
			<input id="upload-img-box" type="file" name="data[image]" style="display:none;" />
			<input id="meme-upload-link" type="button" class="button" value="UPLOAD AN IMAGE" />
			<input type="submit" value="go" class="hide" />
			
			<?/*<div id="team-div" >
				<ul class="league-list">
				<? //if(isset($data['leagues'])){?>
					<? //foreach($data['leagues'] as $league_id=>$league){ ?>
					<li>
						<span>b<?=$league?></span>

						<ul class="team-list">						
						
							<? foreach($data['teams'][$league_id] as $team){ ?>
							<li>
								<span><?=$team['name']?></span>
								<img src="<?=$team['image_url']?>" />				
							</li>
							<? endforeach;?>
						</ul>
						
					</li>	
			
					<? }?>
				<? } ?>
				</ul>
			</div>*/ ?>
		</form>

		<div class="add-caption">
			<h3>Add Your Own Caption</h3>
			
			<? foreach($data['memes'] as $meme){ ?>
				<div class="meme-entry small">
					<a class="left" href="/memes/add/<?=$meme['Meme']['url']?>" title="<?=$meme['Meme']['title']?>">
						<img class="meme" src="/img/user_memes/<?=$meme['Meme']['image_url_medium']?>" />
					</a>
				</div>
			<? } ?>
			<div class="clear"></div>
			<br />
			<?=$html->link('Browse All Our Memes','/memes/browse',array('class'=>'action-link'))?>
			<br />
		</div>
	<? } else{ ?>
		<p class="file-msg">.png, .jpeg, .jpg and .gif files only</p>
		<div class="add-caption">
			<h3>Add Your Own Caption</h3>
			
			<? foreach($data['memes'] as $meme){ ?>
				<div class="meme-entry small">
					<a class="left" href="/memes/add/<?=$meme['Meme']['url']?>" title="<?=$meme['Meme']['title']?>">
						<img class="meme" src="/img/user_memes/<?=$meme['Meme']['image_url_medium']?>" />
					</a>
				</div>
			<? } ?>
			<div class="clear"></div>
			<br />
			<?=$html->link('Browse All Our Memes','/memes/browse',array('class'=>'action-link'))?>
			<br />
		</div>
		<div class="clear"></div>
		<div class="upload-new">
			<h3>Or Create Your Own</h3>
			<div class="meme-type-select">
				<? foreach($data['meme_types'] as $meme_type):?>
					<div class="meme-type">
						<?=$html->link($meme_type['MemeType']['name'],'/memes/create?type_id='.$meme_type['MemeType']['id'])?>
					</div>	
				<? endforeach;?>
			</div>

		</div>
	<? } ?>	
</div>

</div>


