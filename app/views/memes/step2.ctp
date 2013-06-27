<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<style type="text/css">
.step1-img{
	background: url("/img/user_memes/<?=$data['meme']['Meme']['image_url_original']?>") no-repeat scroll 0 0 transparent;
	width: <?=$data['dimensions'][0]?>px;
	width: 100%;
	height: <?=$data['dimensions'][1]?>px;		
}
.ui-autocomplete-loading {
	opacity: 0.6;
}
</style>
<?=$javascript->link('/js/tag-it.min.js')?>
<?=$javascript->link('/js/jquery.quickfit.js')?>
<?=$javascript->link('/js/meme-creator.js')?>
<?=$javascript->link('/js/spectrum.js')?>
<?=$html->css('spectrum.css')?>
<?=$html->css('create.css')?>
<?=$html->css('jquery.tagit.css')?>
<div class="row">

	<img id="meme-image-size" src="/img/user_memes/<?=$data['meme']['Meme']['image_url_original']?>" class="hide" />

	<div id="controlPanel" class="control-panel four columns left">
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
				<input type="text" id="font-color" name="data[caption][color]" value="<?=(!empty($data['meme']['Meme']['color']))?$data['meme']['Meme']['color']:'#ffffff'?>" />
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
					<!-- <select name="data[meme][sport_id]" class="sport-select" >
						<optgroup label="Football">
							<option value="1">NFL</option>
							<option value="1">NCAAF</option>
							<option value="1">General</option>
						</optgroup>
						<optgroup label="Basketball">
							<option value="1">NBA</option>
							<option value="1">NCAAB</option>
							<option value="1">General</option>
						</optgroup>
						<optgroup label="Baseball">
							<option value="1">MLB</option>
							<option value="1">General</option>
						</optgroup>
						<option value="">Tennis</option>
						<option value="">Hockey</option>
						<option value="">Golf</option>
						<option value="">Tennis</option>
					</select> -->	

					<select name="data[meme][league_id]" class="sport-select">			
						<!-- <option value="">Select A League</option> -->
					<? foreach($data['sports'] as $sport){ ?>
						<optgroup label="<?=$sport['Sport']['name']?>">
						<? foreach($sport['League'] as $league){ ?>
							<option sport-id="<?=$sport['Sport']['id']?>" value="<?=$league['id']?>">
								<?=$league['name']?>
							</option>
						<? } ?>
						</optgroup>
					<? } ?>
					</select>
				</div>
				<!-- <div id="subSelectTeam" class="panel-ct">
					<label>Team: </label>
					<select name="data[meme][team_id][]" class="team-select">
						<option value="">Select A Team</option>
						<? foreach($data['sports'] as $sport) { 
							foreach($sport['Team'] as $team) { ?>
								<option league-id="<?=$team['league_id']?>" value="<?=$team['id']?>">
									<?=$team['name']?>
								</option>
							<? }
						} ?>
					</select>
					<br>
					<a id="addAnotherTeam" class=" tight blue btn" href="#">Add another team</a>
				</div> -->
			<? } else {?>
				<input id="parent-meme" type="hidden" name="data[meme][parent]" value="<?=$data['parent_id']?>" />
			<? } ?>
			<div class="panel-ct">
				<label>Public:</label>
				<input type="checkbox" name="data[meme][public]" value="1" checked="checked" />&nbsp;Allow this meme to be seen by the public?
			</div>

			<div class="panel-ct">
				<label>Created By:</label>
				<div class="sp left">
					<label class="natural">
						<input type="radio" name="data[meme][creator]" value="anon" checked="checked" /> Anonymous
					</label>
					<label class="natural">
					<input type="radio" name="data[meme][creator]" value="user" /> 
						<?=(!empty($data['user']))?$data['user']['User']['username']:'Username'?>
					</label>
				</div>	
			</div>


			<div class="panel-ct">
				<label>Tag(s): </label>
				<div class="mini-wrap left">
					<input type="text" id="tag-search" name="data[meme][tags]" value="" placeholder="Add tags here" />
					<small class="">Ie New York Knicks, Carmelo Anthony, etc.</small>		
				</div>
			</div>
			
			<div class="panel-ct center">
				<br />
				<input type="submit" class="button" value="GENERATE YOUR MEME!" />
			</div>	
		</div><!-- end panel-bottom -->
	</form>
	</div><!-- end control Panel -->
	<div id="imgContainer" class="seven columns"> <!-- main content -->
		<? if(isset($data['remake'])){ ?>
		<h2 class="meme-title"><?=ucwords($data['meme']['Meme']['title'])?></h2>
		<? } ?>
		
		<div id="containable" class="step1-img clear">
			
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