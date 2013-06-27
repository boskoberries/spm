$(document).ready(function(){
	/*jslint sub: true, maxlen: 80, indent: 4 */

	// ==ClosureCompiler==
	// @output_file_name jquery.breakLines.min.js
	// @compilation_level ADVANCED_OPTIMIZATIONS
	// @code_url http://goo.gl/eL6PR
	// ==/ClosureCompiler==

	(function ($) {
	    "use strict";

	    // Written for: http://stackoverflow.com/questions/4671713/#7431801
	    // by Nathan MacInnes, nathan@macinn.es

	    // use square bracket notation for Closure Compiler
	    $.fn['breakLines'] = function (options) {
	        var defaults = {
	            // HTML to insert before each new line
	            'lineBreakHtml' : '<br />',
	            // Set this to true to have the HTML inserted at the start of a
	            // <p> or other block tag
	            'atStartOfBlocks' : false,
	            // false: <LINEBREAK><span>text</span>;
	            // true: <span><LINEBREAK>text</span>
	            'insideStartOfTags' : false,
	            // If set, the element's size will be set to this before being
	            // wrapped, then reset to its original value aftwerwards
	            'widthToWrapTo' : false
	        };
	        options = $.extend(defaults, options);
	        return this.each(function () {
	            var textNodes, // all textNodes (as opposed to elements)
	                copy, // jQuery object for copy of the current element
	                el = $(this), // just so we know what we're working with
	                recurseThroughNodes, // function to do the spitting/moving
	                insertedBreaks, // jQuery collection of inserted line breaks
	                styleAttr; // Backup of the element's style attribute

	            // Backup the style attribute because we'll be changing it
	            styleAttr = $(this).attr('style');

	            // Make sure the height will actually change as content goes in
	            el.css('height', 'auto');

	            // If the user wants to wrap to a different width than the one
	            // set by CSS
	            if (options.widthToWrapTo !== false) {
	                el.css('width', options.widthToWrapTo);
	            }

	            /*
	                This function goes through each node in the copy and splits
	                it up into words, then moves the words one-by-one to the
	                element. If the node it encounters isn't a text node, it
	                copies it to the element, then the function runs itself again,
	                using the copy as the currentNode and the equivilent in the
	                copy as the copyNode.
	            */
	            recurseThroughNodes = function (currentNode, copyNode) {
	                $(copyNode).contents().each(function () {
	                    var nextCopy,
	                        currentHeight;
	                    
	                    // update the height
	                    currentHeight = el.height();

	                    // If this is a text node
	                    if (this.nodeType === 3) {
	                        // move it to the original element
	                        $(this).appendTo(currentNode);
	                    } else {
	                        // Make an empty copy and put it in the original,
	                        // so we can copy text into it
	                        nextCopy = $(this).clone().empty()
	                                .appendTo(currentNode);
	                        recurseThroughNodes(nextCopy, this);
	                    }

	                    // If the height has changed
	                    if (el.height() !== currentHeight) {
	                        // insert a line break and add to the list of
	                        // line breaks
	                        insertedBreaks = $(options.lineBreakHtml)
	                            .insertBefore(this)
	                            .add(insertedBreaks);
	                    }
	                });
	            };

	            // Clone the element and empty the original
	            copy = el.clone().insertAfter(el);
	            el.empty();

	            // Get text nodes: .find gets all non-textNode elements, contents
	            // gets all child nodes (inc textNodes) and the not() part removes
	            // all non-textNodes.
	            textNodes = copy.find('*').add(copy).contents()
	                .not(copy.find('*'));

	            // Split each textNode into individual textNodes, one for each
	            // word
	            textNodes.each(function (index, lastNode) {
	                var startOfWord = /\W\b/,
	                    result;
	                while (startOfWord.exec(lastNode.nodeValue) !== null) {
	                    result = startOfWord.exec(lastNode.nodeValue);
	                    // startOfWord matches the character before the start of a
	                    // word, so need to add 1.
	                    lastNode = lastNode.splitText(result.index + 1);
	                }
	            });

	            // Go through all the nodes, going recursively deeper, until we've
	            // inserted line breaks in all the text nodes
	            recurseThroughNodes(this, copy);

	            // We don't need the copy anymore
	            copy.remove();

	            // Clean up breaks at start of tags as per options
	            insertedBreaks.filter(':first-child').each(function () {
	                if (!options.atStartOfBlocks &&
	                        $(this).parent().css('display') === "block") {
	                    $(this).remove();
	                }
	                if (!options.insideStartOfTags) {
	                    $(this).insertBefore($(this).parent());
	                }
	            });
	            // Restore backed-up style attribute
	            $(this).attr('style', styleAttr);
	        });
	    };
	}(jQuery));

	// jQuery(function ($) {
	//     $('#break-lines').breakLines({
	//         lineBreakHtml : '<br class="automatic-line-break" />'
	//     });
	// });

	$("div.caption").each(function(){
		$(this).makeDraggable();
	});
	$(document).on('click','div.caption',function(){
		var num = $(this).attr("capt-num");
		var $parent = $("#controlPanel").find("div.panel-ct[capt-num="+num+"]");
		if($parent.length>0){
			$parent.find(".caption-txt-input:first").focus();
		}
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

	$(document).on('keyup focusout',".caption-txt-input",function(){
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

	$(document).on('change',"select.caption-size-input", function(){
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

	$(document).on('change',"select.color-select",function(){
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

	$(document).on('click',"a.delete-button",function(){
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

	$(document).on('change',"select.alignment-select",function(){
		var value = $(this).val();
		var caption_number = $(this).parents("div.panel-ct").attr("capt-num");
		console.log("value "+value+" - number "+caption_number);
		$("#containable").find("div.caption[capt-num="+caption_number+"]").css('text-align',value);
	});
	
	/*$("#tag-search").autocomplete({
		//source: "/search",
		source: [
	      "ActionScript",
	      "AppleScript",
	      "Asp",
	      "BASIC",
	      "C",
	      "C++",
	      "Clojure",
	      "COBOL",
	      "ColdFusion",
	      "Erlang",
	      "Fortran",
	      "Groovy",
	      "Haskell",
	      "Java",
	      "JavaScript",
	      "Lisp",
	      "Perl",
	      "PHP",
	      "Python",
	      "Ruby",
	      "Scala",
	      "Scheme"
	    ],
		minLength: 2,
		select: function( event, ui ) {			
			//log( ui.item ?
				//////"Selected: " + ui.item.value + " aka " + ui.item.id :
				//"Nothing selected, input was " + this.value );
		}
	});*/

	function split( val ) {
	  return val.split( /,\s*/ );
	}
	function extractLast( term ) {
	  return split( term ).pop();
	}

	$("#tag-search").tagit({
		autocomplete: {
		  minLength: 2,
		  delay: 0,
		  source: function( request, response ) {
		    $.getJSON( "/search", {
		      term: extractLast( request.term )
		    }, response );
	  		}
	  	},		
	  	allowSpaces:true,
	  	tagLimit: 6,
	  	beforeTagAdded: function(event, ui) {
	  	    // do something special
	  	    console.log('tag about to be added. '+ui.tag);
	  	},
	  	onTagLimitExceeded: function(event,ui){
	  		alert('You have added enough tags!  Move on..');
	  	}
	});

	$('#meme-image-size').load(function(){
		var w =    $(this).width();
		var h =    $(this).height();
		//alert(w); alert(h);
		//if the width of the image is less than the width of the container, shrink the container.
		if(w < $("#containable").width()){
			$("#containable").css('width',w);
		}		

	}).error(function (){
	   //$(this).remove();//remove image if it fails to load// or what ever u want
	});

	$(window).resize(function(){
		if($("#containable").width() > $("#imgContainer").width()){
			$("#containable").width($("#imgContainer").width()-10);
		} 
		//else{
		//	$("#containable").width($("#imgContainer").width()-10);
		//}
	});
	
	$("form").submit(function(){
	    // $('#break-lines').breakLines({
	    //     lineBreakHtml : '<br class="automatic-line-break" />'
	    // });
		$("div.caption").each(function(){
			var $obj = $(this);
			//var text = $obj.find("span").html().split("\n");//text();
			var text = $obj.find("span").text();
			//var current = $(this);
			  // var text = current.text();
		   /*var words = text.split(' ');
			$obj.text(words[0]);
			 var height = $obj.height();
			   for(var i = 1; i < words.length; i++){
			       $obj.text($obj.text() + ' ' + words[i]);

			       if($obj.height() > height){
			           height = $obj.height();
			           // (i-1) is the index of the word before the text wraps
			           console.log(words[i-1]);
			       }
		      } */
		 	
			console.log(word_array);
			console.log(text);
			//console.log(result);
			//return false;
			//console.log(text);
			//var first = $('<pre class="identifier">'+text.charAt(0)+'</pre>');
	     	//console.log("height "+$obj.height());
	     	//console.log("first - "+first.height());			
			//$obj.find("span").html(text.substring(1)).prepend(first);

		    var word_array = text.split(' ');
			var len = word_array.length;
			result = [];
			for(var z=0;z<len;z++){
				if($.trim(word_array[z])!=''){
					if(z==0){//first word.
						var first_letter = word_array[z].charAt(0);
						word_array[z].substr(1);
						result[z] = '<pre class="idf"><pre class="identifier">'+first_letter+'</pre>'+word_array[z].substr(1)+'</pre>';
					} else{
						result[z] = '<pre class="idf">'+word_array[z]+'</pre>';
					}
				}
			}	     
			$obj.find("span").html(result.join(' '));

			var $first_letter = $obj.find("pre.identifier");
			if($first_letter.length){
				// console.log('wtf!')
				// console.log("height "+$obj.height());
				// console.log("first - "+$first_letter.position());			

				var $block = $("#controlPanel").find("div.panel-ct[capt-num="+$obj.attr("capt-num")+"]");
				$block.find("input.caption-pos-left").val($obj.position().left);
				$block.find("input.caption-pos-top").val($obj.position().top);

				$block.find("input.caption-first-letter-left").val($first_letter.position().left);
				$block.find("input.caption-first-letter-top").val($obj.position().top+$first_letter.height());

				//now loop through and see if we can find the line break.
				var first_word_top = $first_letter.parent("pre.idf").position().top;
				//var newLine = false;
				var x = 0;
				var newLines = [];
				$obj.find("pre.idf").each(function(){
					//if(!newLine && $(this).position().top > first_word_top){
					if($(this).position().top > first_word_top){
						//newLine=x;
						console.log("WE FOUND A NEW LINE AT WORD "+x+" the word? "+$(this).text());
						$(this).html('<pre class="identifier">'+$(this).text().charAt(0)+'</pre>'+$(this).text().substr(1));
						var $letter = $(this).find("pre.identifier");
						if($letter.length){
							newLines.push(x);
							first_word_top = $letter.position().top;	
							console.log("made it here "+$letter.text()+" - "+first_word_top);
							var $new_left_input = $block.find("input.caption-first-letter-left").clone();

							var $new_top_input = $block.find("input.caption-first-letter-top").clone();
							$block.append($new_left_input).append($new_top_input);
							$new_left_input.val($letter.position().left);
							//$new_top_input.val($obj.position().top+$letter.height());
							$new_top_input.val($letter.position().top);//());
							
						}
						//return;
					}
					x++;
				});
				if(newLines.length > 0){
				//if(newLine!==false){
					//newLines = the nth word in the sentence. now have to pass an identifier through to the input so we know where to do the word break[s]!
					var words = $block.find(".caption-txt-input").val().split(' ');
					for(var zz in newLines){
						for(var word_number in words){
							//if(word_number==newLine){
							if(word_number==newLines[zz]){
								words[word_number] = '<br>'+words[word_number];
							}
						}
					}	
					$block.find(".caption-txt-input").val(words.join(' '));	
					console.log(' i think i did it.  '+words.join(' '));
				}

			}
			else{ //shouldn't make it here.
				//console.log('niet');
			}

			//consol.log()
		});
		//return false;
		//return false;
		if($("#meme-title").length && $.trim($("#meme-title").val()) == ''){
			alert('You must give this Meme a title in order to continue!');
			$("#meme-title").focus();
			return false;			
		}

		if($("select.sport-select").val()==''){
			alert('You must pick a sport in order to continue!');
			$("select.sport-select").focus();
			return false;			
		}


		return true;	
	});
	$("#addAnotherTeam").click(function(event){
		event.preventDefault();
		var $parent = $("#subSelectTeam");
		var $select = $parent.find("select.team-select");
		if($select.length==1){//only allow 2 teams.
			var $newSelect = $select.clone();
			$newSelect.addClass('indented');
			$parent.append($newSelect);
			$(this).hide();
		}
	});
	$(".sport-select").change(function(){
		current_val = $(this).val();
		console.log('cur '+current_val);
		if(current_val != '' ){
			console.log("mm");
			$(".league-select").find("option").hide().end().find("option[sport-id="+current_val+"]").show();
		}
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
	},200);
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