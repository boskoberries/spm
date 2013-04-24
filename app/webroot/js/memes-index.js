$(document).ready(function(){

	$('.star').raty({
	  //scoreName: 'entity.score',
	 number:    4,
	 start: function() {
    	return $(this).attr('data-rating');
  	},
  	 click: function(score, evt) {
  	 	$.post("/memes/addRating", { id: 0, value: score }, function(response){
			if(response){
				var jq = $.parseJSON(response);
				if(jq.value){
					$("#meme-rating").html(jq.value).fadeIn();
				}
			}  	 	
  	 	});

	  },
	   starOff:   'star-off-big.png',
	  starOn:    'star-on-big.png'
	});
	
	$("#addYourOwn").click(function(){
	
	});
	$("a.delete-meme").click(function(event){
		event.preventDefault();
		var answer = confirm('Are you sure you want to delete this meme?');
		var meme_id = $(this).attr("meme-id");
		$(this).parents(".meme-entry").fadeOut('fast',function(){
			$(this).remove();
		});
		
		if(answer){
			$.post("/memes/delete",{ data: { meme_id: meme_id } }, function(response){

			});
		}
	});
});