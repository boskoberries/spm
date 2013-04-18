$(document).ready(function(){
	$("div.caption").each(function(){
		$(this).makeDraggable();
	});
/*	$("div.caption").draggable({
		stop: function(){
			var capt_num = $(this).attr("capt-num");
			var $panel = $("#controlPanel").find("div.panel-ct[capt-num="+capt_num+"]");
			var	top = $(this).position().top*1;
			var caption_height = $(this).find("span").height()*1;
			console.log("top "+top+" - height"+caption_height);
			console.log("")
			$panel.find("input.caption-pos-left").val($(this).position().left);
		//	$panel.find("input.caption-pos-top").val($(this).position().top);
			$panel.find("input.caption-pos-top").val(top+caption_height);//$(this).position().top);
		
		// var inputs = '';
		// $("div.caption").find("span").each(function(){
		// 	inputs += '<input type="hidden" name="data[caption_coords][left][]" value="'+$(this).position().left+'" />';
		// 	inputs += '<input type="hidden" name="data[caption_coords][top][]" value="'+$(this).position().top+'" />';
		// });
		// $(this).append(inputs);

//			console.log("bottom? "+$(this).position().top-$(this).find("span").height()*1);
			//var $caption = $(this);
			//var position = $caption.position();	
			//var right = window.width() - position.left - $caption.width()
		}
	
	});*/
	
$.fn.toUnit = function (unit, settings) {
    settings = jQuery.extend({
        scope: 'body'
    }, settings);
    var that = parseInt(this[0], 10);
    var scopeTest = jQuery('<div style="display: none; width: 10000' + unit + '; padding:0; border:0;"></div>').appendTo(settings.scope);
    var scopeVal = scopeTest.width() / 10000;
    scopeTest.remove();
    return (that / scopeVal).toFixed(8);
};	

	$(".caption-txt-input").live('keyup focusout',function(){
		var $obj=$(this);
		var caption_number=$obj.parents("div.panel-ct").attr("capt-num");
		var $div = $("div.caption[capt-num="+caption_number+"]");
		if($.trim($obj.val()) != ''){
			$div.find("span").html($.trim($obj.val()));		
		}
		else{
			$div.find("span").html($obj.attr("placeholder"));
		}
		if($obj.parents(".panel-ct").find("select.caption-size-input").val()=='auto'){
			resizeText($div,$obj);
			//$("#containable").find(".caption").find("span").quickfit({ max: 80, min: 22 });
		}

		// $("#caption-"+caption_number+"-size-input").val(font);
		// console.log($("#caption-"+caption_number+"-size-input").val());

	});

	$("select.caption-size-input").live('change',function(){
		console.log("here ?");
		var $obj=$(this);
		var caption_number=$obj.parents("div.panel-ct").attr("capt-num");
		if(!isNaN($obj.val())){
			$("div.caption[capt-num="+caption_number+"]").find("span").css('font-size',$obj.val()+'pt');
		}
		else{
			resizeText($("div.caption[capt-num="+caption_number+"]"),$obj);
			//$("div.caption[capt-num="+caption_number+"]").find("span").quickfit({ max: 80, min: 22 });	
		}
	});

	$("select.color-select").live('change',function(){
		var $obj=$(this);
		var caption_number=$obj.parents("div.panel-ct").attr("capt-num");
		if($.trim($obj.val())==''){
			$("div.caption[capt-num="+caption_number+"]").css( {'color':'#fff', 'text-shadow':'2px 2px 2px #000'} );
		}
		else{
			$("div.caption[capt-num="+caption_number+"]").css( { 'color':$obj.val(), 'text-shadow':'1px 1px 1px #FFFFFF' });
		}
	
	
	});


	$("#text-style").change(function(){
		if($(this).val()!='upper'){
			$("div.caption").removeClass('upper').addClass($(this).val());
		}
		else{
			$("div.caption").addClass('upper');
		}
//		$(this).addClass('');	
	});


	$("#add-another-caption").click(function(){
		var capt_num = $("#containable").find("div.caption:visible").length + 1;
		var new_txt = 'Caption '+capt_num+' Goes Here';
		var other_class = $("#text-style").val();//apply font style to this new caption.

		var previous_caption = capt_num-1;
		var $previous_block = $("#controlPanel").find("div.panel-ct[capt-num="+previous_caption+"]");

		if(capt_num == '1'){
			var $new_caption_block = $("#controlPanel").find("div.caption-block").find("div.panel-ct:first");//.show();//clone();
		}
		else{
			var $new_caption_block = $("#controlPanel").find("div.caption-block").find("div.panel-ct:last").clone();
		}
		
		$new_caption_block.hide().attr("capt-num",capt_num)
			.find("label").html('Caption '+capt_num+':').end()
			.find(".caption-txt-input").val('').attr("placeholder",new_txt).end()
			.find(".delete").removeClass('hide');



		var styles = '';
		var top_css = 15*capt_num*1;
		var resizeSpan = true;
		if($previous_block.length && $previous_block.is(":visible")){
			var prev_align = $previous_block.find("select.alignment-select").val();
			styles+= 'text-align:'+$previous_block.find("select.alignment-select").val()+';';
			$new_caption_block.find("select.alignment-select").val(prev_align);
			var h = $("#containable").find("div.caption:last").height();
			if(!isNaN(h)){
				top_css = h + 5;
			}
			var prev_font = $previous_block.find("select.caption-size-input").val();
			var span_style='';
			if(!isNaN(prev_font)){
				resizeSpan = false;
				span_style+='font-size:'+prev_font+'pt;';
				//styles.push('font-size:'+prev_font)
			
			}
		}
		var new_caption = 	$('<div class="caption font-size-auto bubble-font '+other_class+'" style="'+styles+'" capt-num="'+capt_num+'"><span style="'+span_style+'">'+new_txt+'</span></div>');
		if(resizeSpan){
			$("#containable").append(new_caption).find("div.caption:last").find("span").quickfit({ max: 80, min: 22 });		
		} else{
			$("#containable").append(new_caption);
		}
//		$("div.caption:not('.ui-draggable')").draggable().css('top',top_css+'px');
		
		$("div.caption:not('.ui-draggable')").each(function(){
			$(this).makeDraggable()
			$(this).css('top',top_css+'px');
		});

		$("#add-another-caption").hide();

		if(capt_num != '1'){
			$("#controlPanel").find("div.caption-block").find("div.panel-ct:last").after($new_caption_block);
		}
		$new_caption_block.fadeIn();
	});

	$("a.delete-button").live('click',function(){
		var capt_num=$(this).parents("div.panel-ct").attr("capt-num");
		if($(this).parents("div.panel-ct").attr("capt-num")=='1' && $(this).parents("div.caption-block").find("div.panel-ct").length == 1){
			//only hide caption #1 if it's the ONLY caption.  otherwise just remove it and update the caption numbers.
			$(this).parents("div.panel-ct").fadeOut('fast',function(){
				reorderCaptionNumbers();
			});		
		}
		else{
			$(this).parents("div.panel-ct").fadeOut('fast',function(){
				$(this).remove();
				reorderCaptionNumbers();

			});
		}
		
		$("#containable").find("div.caption[capt-num="+capt_num+"]").remove();
		$("#add-another-caption").show();
	});

	$("select.alignment-select").live('change',function(){
		var value = $(this).val();
		var caption_number = $(this).parents("div.panel-ct").attr("capt-num");
		console.log("value "+value+" - number "+caption_number);
		$("#containable").find("div.caption[capt-num="+caption_number+"]").css('text-align',value);
	});
	
	$("#tag-search").autocomplete({
		source: "/search",
		minLength: 2,
		select: function( event, ui ) {
			log( ui.item ?
				"Selected: " + ui.item.value + " aka " + ui.item.id :
				"Nothing selected, input was " + this.value );
		}
	});

	$('#meme-image-size').load(function(){
		var w =    $(this).width();
		var h =    $(this).height();
			//alert(w); alert(h);
		if(w < $("#containable").width()){
			$("#containable").css('width',w);
		}		

	}).error(function (){
	   //$(this).remove();//remove image if it fails to load// or what ever u want
	});
	
	$("form").submit(function(){

		$("div.caption").each(function(){
			var $obj = $(this);
			//var text = $obj.find("span").html().split("\n");//text();
			var text = $obj.find("span").text();
			
			//console.log(text);
			var first = $('<pre class="identifier">'+text.charAt(0)+'</pre>');
			$obj.find("span").html(text.substring(1)).prepend(first);
			var $first_letter = $obj.find("pre.identifier");
			if($first_letter.length){
				console.log('wtf!')
				var $block = $("#controlPanel").find("div.panel-ct[capt-num="+$obj.attr("capt-num")+"]");
				$block.find("input.caption-pos-left").val($obj.position().left);
				$block.find("input.caption-pos-top").val($obj.position().top);

				$block.find("input.caption-first-letter-left").val($first_letter.position().left);
				$block.find("input.caption-first-letter-top").val($obj.position().top+$first_letter.height());


			}
			else{
				console.log('niet');
			}

		});

		//return false;
		if($("#meme-title").length && $.trim($("#meme-title").val()) == ''){
			alert('You must give this Meme a title in order to continue!');
			$("#meme-title").focus();
			return false;			
		}

		if($("select.league-select").val()==''){
			alert('You must pick a sport in order to continue!');
			$("select.league-select").focus();
			return false;			
		}


		return true;	
	});
});

	function reorderCaptionNumbers(){
		var i=1;
		$("div.caption-block").find("div.panel-ct:visible").each(function(){
			var capt_num = $(this).attr("capt-num");
			$(this).attr("capt-num",i)
				   .find("label").html("Caption "+i+":").end()
				   .find(".caption-txt-input-").attr("placeholder","Caption Goes Here");//.focus().focusout();
			$("div.caption[capt-num="+capt_num+"]").attr('capt-num',i);
			i++;
		});
	}

	function resizeText($div,$obj){
		console.log("DO IT");
		$div.find("span").quickfit({ max: 80, min: 22 });
		var font_size = $div.find("span").css('font-size');
		if(font_size!=='undefined'){

		}
		var font = Math.ceil($div.find("span").css('font-size').replace('px','')*1);
		var font_pt = $($div.find("span").css('font-size').replace('px','')*1).toUnit('pt');
		if(!isNaN(font_pt)){
			$obj.parents("div.panel-ct").find("input.caption-autosize-input").val(font_pt);
		}
			

	}
	setTimeout(function(){
		if($("#parent-meme").length<1){
			$("#controlPanel").find("div.caption-block").find("div.panel-ct").each(function(){
				var num = $(this).attr("capt-num")*1;
				if(!isNaN(num)){
					var $div = $("div.caption[capt-num="+num+"]");
					console.log($div);
					resizeText($div,$(this));

				}
			});

			//$("#containable").find("div.caption").find("span").quickfit({ max: 80, min: 22 });
		}
	},100);
	$.fn.makeDraggable = function (){
		var $obj = $(this);		
		$obj.draggable({
			axis: 'y',
			start:function(){
				$(this).css('bottom','auto');
			},
			stop: function(){
				var capt_num = $(this).attr("capt-num");
				var $panel = $("#controlPanel").find("div.panel-ct[capt-num="+capt_num+"]");
				var	top = $(this).position().top*1;
				console.log('lefty'+$(this).position().left);
				console.log('leftletter'+$(this).find(""))
				var caption_height = $(this).find("span").height()*1;
				console.log("top "+top+" - height"+caption_height);
				$panel.find("input.caption-pos-left").val($(this).position().left);
				$panel.find("input.caption-pos-top").val(top+caption_height);//$(this).position().top);
			}	
		});
	}