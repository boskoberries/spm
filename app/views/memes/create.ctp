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
	$("#pageLeft,#pageRight").click(function(event){
		event.preventDefault();
		console.log('hi');
		var $this = $(this);
		var $carousel = $("#carousel");
		var $current = $carousel.find(".carousel-page.current");
		var currentPage = $current.attr("page")*1;
		console.log(currentPage);
		if(currentPage){
			if($this.prop("id")=='pageRight'){
				var nextPage = currentPage+1;
			} else{
				var nextPage = currentPage-1;
			}
			var $next = $carousel.find(".carousel-page[page="+nextPage+"]");
			if($next.length && $next.find(".meme-entry").length>0){
				$current.removeClass('current').hide();
				$next.addClass('current').fadeIn();
				//.find(".cas")
			} else{
				if($this.prop("id")=='pageRight'){
					var nextPage = 1;
				} else{
					var nextPage = 5;
				}

				var $next = $carousel.find(".carousel-page[page="+nextPage+"]");
				if($next.length && $next.find(".meme-entry").length>0){
					$current.removeClass('current').hide();
					$next.addClass('current').fadeIn();
					//.find(".cas")
				}	

			}
		}	 
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
#carousel-paging{
	font-size: 60px;
	position: absolute;
	top: -15px;
	right: 20px;
}
#carousel-paging a:hover{
	text-decoration: none;	
	color: #333333;
}
</style>
<div class="row">
<div class="one columns"></div>
<div class="eight columns">
		<h2>Create Your Own</h2>

	<? if(true || isset($data['meme_type'])){ ?>
		<form name="meme_form" action="" method="post" enctype="multipart/form-data">
			<p class="image-msg">Click below to upload your image.  Only .png, .jpeg, .jpg and .gif files accepted</p>
			<input id="upload-img-box" type="file" name="data[image]" style="display:none;" />
			<input id="meme-upload-link" type="button" class="button" value="UPLOAD AN IMAGE" />
			<input type="submit" value="go" class="hide" />
		</form>
		<hr />
		<div class="add-caption relative">
			<h3>Or Add Your Own Caption</h3>
			<div id="carousel">
				<? $i = 1; ?>				
				<? foreach($data['memes'] as $meme){ ?>
					<? if($i==1){ ?>
						<div class="carousel-page current" page="1">
					<? } ?>
					<div class="meme-entry left small">
						<a class="left" href="/memes/add/<?=$meme['Meme']['url']?>" title="<?=$meme['Meme']['title']?>">
							<img class="meme" src="/img/user_memes/<?=$meme['Meme']['image_url_medium']?>" />
						</a>
					</div>
					<? if($i%10==0){ ?>
						<? if($i!=1){ ?>
						</div>
						<div class="carousel-page hide" page="<?=($i/10)+1?>">
						<? } ?>
					<? } ?>
					<? $i++; ?>
				<? } ?>
			</div>
			<div class="clear"></div>
			<div id="carousel-paging" class="right">
				<a href="#" id="pageLeft" class="icon2-arrow-short-left"></a>
				<a href="#" id="pageRight" class="icon2-arrow-short-right"></a>
			</div>
			<br />
			<a href="/memes" class="blue btn">Browse All Memes</a>
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


