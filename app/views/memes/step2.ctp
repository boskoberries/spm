<style type="text/css">
.step1-img{
	background: url("/img/user_memes/<?=$data['meme']['Meme']['image_url_original']?>") no-repeat scroll 0 0 transparent;
	width: <?=$data['dimensions'][0]?>px;
	width: 100%;
	height: <?=$data['dimensions'][1]?>px;		
}
</style>
<?=$javascript->link('/js/jquery.quickfit.js')?>
<?=$javascript->link('/js/meme-creator.js')?>
<script type="text/javascript">
$(document).ready(function(){
	$("#click-me").click(function(){
		// var ala = $("#containable"); // var img    = ala.toDataURL("image/png"); // alert(img);
	})


});
</script>

<div class="row">

	<img id="meme-image-size" src="/img/user_memes/<?=$data['meme']['Meme']['image_url_original']?>" class="hide" />

	<div id="controlPanel" class="control-panel four columns">
	<form action="/memes/step2/<?=$data['meme']['Meme']['id']?>" method="post" target="_blank">

		<div class="panel-top">	

			<h3>Add your caption</h3>
			<br />
			<div class="panel-ct">
				<label>Style:</label>

				<select name="data[caption][text_style]" id="text-style" style="float:none;">
					<option value="upper">All Caps</option>
					<option value="lower">Regular Text</option>
				</select>
			</div>
				
			<div class="caption-block">
				<? if(isset($data['remake']) && !empty($data['meme']['MemeCaption'])){ ?>
					<? $z=1;?>
					<? foreach($data['meme']['MemeCaption'] as $caption){
						echo $this->element('caption-block',array('caption'=>$caption,'number'=>$z));			
						$z++;
					}  
				} else{
					echo $this->element('caption-block',array('number'=>1));
					echo $this->element('caption-block',array('number'=>2));				
				} ?>

			</div><!-- end caption-block-->
			<div class="clear"></div>
			

			<br />
			<a id="add-another-caption" class="hide">+ Add Another Caption</a>
		</div><!-- end panel top -->
		<br />	
		<div class="panel-bottom">
			<Br />
			<h3>Done?</h3>
		
			<? if(!isset($data['remake'])){ ?>
				<div class="panel-ct">
					<label>Meme Title:<span class="required no-float">*</span></label>
					<input id="meme-title" type="text" name="data[meme][title]" value="" />
				</div>	
				<div class="panel-ct">
					<label>Sport: <span class="required no-float">*</span></label>
					<select name="data[meme][league_id]" class="league-select" >
						<option value="">Select A Sport</option>
						<? foreach($data['leagues'] as $league){ ?>
						<option value="<?=$league['Sport']['id']?>"><?=$league['Sport']['name']?></option>
						<? } ?>
					</select>				

					<!-- <select name="data[meme][team_id]" class="team-select" style="float:left;">
						<option value="">Select A Team</option>
						<? foreach($data['leagues'] as $league_id=>$league):?>
							<optgroup label="<?=$league['name']?>">
							<? if(isset($data['teams'][$league_id])):?>
								<? foreach($data['teams'][$league_id] as $team):?>
									<option value="<?=$team['id']?>"><?=$team['name']?></option>
								<? endforeach;?>
							<? endif;?>
							</optgroup>
						<? endforeach;?>
					</select> -->
				</div>
			<? } else {?>
				<input id="parent-meme" type="hidden" name="data[meme][parent]" value="<?=$data['parent_id']?>" />
			<? } ?>
			<div class="panel-ct">
				<label>Public:</label>
				<input type="checkbox" name="data[meme][public]" value="1" checked="checked" />&nbsp;Allow this meme to be seen by the public?
			</div>

			<div class="panel-ct">
				<label>Created By:</label>
				<input type="radio" name="data[meme][creator]" value="anon" checked="checked" /> Anonymous
				<br />
				<input type="radio" name="data[meme][creator]" value="user" /> Username
			</div>


			<div class="panel-ct">
				<label>Tag(s): </label>
				<input type="text" id="tag-search" name="data[meme][tags]" value="" placeholder="Add tags here" />			
			</div>
			
			<div class="panel-ct">
				<br />
				<input type="submit" class="button" value="GENERATE YOUR MEME!" />
			</div>	
		</div><!-- end panel-bottom -->
	</form>
	</div><!-- end control Panel -->
	<div class="seven columns"> <!-- main content -->
		<? if(isset($data['remake'])){ ?>
		<h2 class="meme-title"><?=ucwords($data['meme']['Meme']['title'])?></h2>
		<? } ?>
		
		<div id="containable" class="step1-img ">
			<? if(isset($data['remake']) && !empty($data['meme']['MemeCaption'])){?>
				<? $z = 1;?>
				<? foreach($data['meme']['MemeCaption'] as $caption){?>
					<div class="caption font-size-auto bubble-font upper" capt-num="<?=$z?>" style="<?=$caption['properties']?>">
						<span style="<?=$caption['font_size_str']?>"><?=$caption['body']?></span>
					</div>

				<? $z++;?>				
				<? } ?>			
			<? } else { ?>
				<div class="caption font-size-auto bubble-font upper" style="text-align:center;" capt-num="1">
					<span>Caption 1 Goes Here</span>
				</div>
				<div class="caption font-size-auto bubble-font upper bottom" style="text-align:center;" capt-num="2">
					<span>Caption 2 Goes Here</span>
				</div>
			<? } ?>	
		</div>
	</div>




</div>