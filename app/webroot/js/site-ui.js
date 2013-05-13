$(document).ready(function(){

    //search bar functionality. 
   	$("#searchBar").autocomplete({
   		source:'/search',
   		minLength: 2,
   		select: function(event,ui){
   			window.location = '/memes/view/'+ui.item.url;
   		}
   	});
    
});