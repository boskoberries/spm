<div class="content">
<h2>Caption Time</h2>
<form action="" method="post">
<div class="control-panel">
	<div class="panel-top">
		<h3>Add your caption</h3>
		<label>Style</label>
		<div class="panel-ct">
			<select name="data[caption][text]">
				<option value="">Heavy Capital Text</option>
			</select>
		</div>
		<div class="clear"></div>
		
		<label>Wrap</label>
		<div class="panel-ct">
			<input type="checkbox" name="data[caption][wrap]" checked="checked" />
		</div>
		<div class="clear"></div>
		
		<label>Caption 1:</label>
		<div class="panel-ct">
			<textarea name="data[caption][body]">Caption 1 goes here</textarea>
			<br />
			<select name="data[caption][size]">
				<option value="">Size: Auto</option>
			</select>
			<select name="data[caption][align]">
				<option value="">Align: center center</option>
			</select>
		</div>
	
		<div class="clear"></div>
	
		<a class="add-another-caption">Add Another Caption</a>
	</div>
	<div class="panel-bottom">
		<h3>Done?</h3>
		
		<label>Meme Title:</label>
		<div class="panel-ct">
			<input type="text" name="data[meme][title]" value="" />
			
		</div>		
	
	</div>
</div>

<div class="step1-img">
<img src="/app/img/user_memes/<?=$data['meme']['Meme']['original_image_url']?>" />
</div>


<input type="submit" value="Add Those Captions" />

</form>



</div>