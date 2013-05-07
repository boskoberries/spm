$(document).ready(function(){

	// $('.star').raty({
	//   //scoreName: 'entity.score',
	//  number:    1,
	//  start: function() {
 //    	return $(this).attr('data-rating');
 //  	},
 //  	 click: function(score, evt) {
 //  	 	$.post("/memes/addRating", { id: 0, value: score }, function(response){
	// 		if(response){
	// 			var jq = $.parseJSON(response);
	// 			if(jq.value){
	// 				$("#meme-rating").html(jq.value).fadeIn();
	// 			}
	// 		}  	 	
 //  	 	});

	//   },
	//    starOff:   'star-off-big.png',
	//   starOn:    'star-on-big.png'
	// });
	
	//$(document).on('click',"a",function(event){
	$("a").click(function(event){
		if($(this).attr("href")=='#'){
			event.preventDefault();
		}
	});
	$("#addYourOwn").click(function(){
	
	});
	$("a.delete-meme").click(function(event){
		event.preventDefault();
		var answer = confirm('Are you sure you want to delete this meme?');
		if(answer){
			var meme_id = $(this).attr("meme-id");
			$(this).parents(".meme-entry").fadeOut('fast',function(){
				$(this).remove();
			});
			
			if(answer){
				$.post("/memes/delete",{ data: { meme_id: meme_id } }, function(response){

				});
			}
		}	
	});


	$("#all-entries a.star").click(function(){
			var $this = $(this);
			var params = { meme_id: $this.parents(".meme-entry").attr("meme-id") };
			if($this.hasClass('favorite')){
				$this.removeClass('favorite icon2-star-2').addClass('icon2-star');
				params.favorite = 0;
			} else{
				$this.addClass('favorite icon2-star-2').removeClass('icon2-star');
				params.favorite = 1;
			}
			$.ajax({
				url:"/memes/saveFavorite",
				type:'POST',
				data: params,
				success:function(r){

				},
				error:function(){
					alert('Whoops.  There was an error processing that.  Please try again');
				}
			});

		}).dblclick(function(event){
			event.preventDefault();
			return false;
		});	
	//},'img.star');

	$("a.rating-btn").click(function(event){
		event.preventDefault();

		var $this = $(this);
		if($this.hasClass('active')){ 
			return false; //no need to fire if it's already set. 
		}
		var $parent = $this.parents("div.rating");
		$this.addClass('active').siblings().removeClass('active');
		var params = { meme_id: $this.parents(".meme-entry").attr("meme-id") };

		if($this.hasClass('root')){
			params.value = 'root';
		} else{
			params.value = 'boo';
		}
		$.ajax({
			url:"/memes/saveRating",
			type:'POST',
			data:params,
			success:function(r){
			},
			error:function(){

			}		
		});

	});


});