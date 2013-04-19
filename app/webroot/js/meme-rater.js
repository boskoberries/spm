$(document).ready(function(){
	$('#star').raty({
	 start: function() {
    	return $(this).attr('data-rating');
  	},
  	 click: function(score, evt) {
  	 	$.post("/memes/addRating", { id: constants.meme_id, value: score }, function(response){
			if(response){
				var jq = $.parseJSON(response);
				if(jq.value){
					$("#meme-rating").html(jq.value).fadeIn();
				}
			}  	 	
  	 	});

	  },
	  size:24,
	   starOff:   'star-off-big.png',
	  starOn:    'star-on-big.png'
	});
});