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

	$("#all-entries").on({
		click:function(){
			var $this = $(this);
			var params = { meme_id: $this.parents(".meme-entry").attr("meme-id") };
			if($this.hasClass('favorite')){
				$this.removeClass('favorite').prop("src",'/img/star-off-big.png');
				params.favorite = 0;
			} else{
				$this.addClass('favorite').prop("src",'/img/star-on-big.png');
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

		},
		dblclick:function(event){
			event.preventDefault();
			return false;
		}
	},'img.star');

});