	<div class="panel-ct row" capt-num="<?=$number?>"> 					
		<label class="three columns">Caption <?=$number?>:</label>
		<div class="nine columns">
			<input class="ten columns caption-txt-input"  name="data[caption][body][]" placeholder="Caption <?=$number?> goes here" value="<?=(isset($caption))?$caption['body']:''?>"/>
			<span class="delete <?=($number<=1)?'hide':''?>">
				<a class="delete-button">X</a>
			</span>
			
			<div class="select-inputs" >
				<input class="caption-autosize-input" type="hidden" name="data[caption][auto_size][]" value="<?=(isset($caption))?$caption['font_size']:''?>" />
				<input type="hidden" class="caption-pos-left" name="data[caption_coords][left][]" value="<?=(isset($caption))?$caption['latitude']:'0'?>" />
				<input type="hidden" class="caption-pos-top" name="data[caption_coords][top][]" value="<?=(isset($caption))?$caption['longitude']:'0'?>" />
				<input type="hidden" class="caption-first-letter-left" name="data[caption_coords][letter_left][]" value="<?=(isset($caption))?$caption['letter_left']:'0'?>" />
				<input type="hidden" class="caption-first-letter-top" name="data[caption_coords][letter_top][]" value="<?=(isset($caption))?$caption['letter_top']:'0'?>" />

				<select class="caption-size-input" name="data[caption][size][]">
					<? foreach($data['caption_sizes'] as $size):?>
						<option value="<?=$size['id']?>" <? if(isset($caption) && $size['id']==$caption['font_size']) echo "selected";?>><?=$size['value']?></option>				
					<? endforeach;?>
				</select>
				<select class="alignment-select" name="data[caption][align][]">
					<? foreach($data['alignment_options'] as $key=>$ao):?>
						<option value="<?=$key?>" <? if(isset($caption) && $key==$caption['text_align']) echo "selected";?>>Align: <?=ucwords($ao)?></option>
					<? endforeach;?>
				</select>

			</div>		
		</div>

	</div>	