$(document).ready(function(){
	console.log('hey');
   	var cache = [];
   	$("#searchBar").autocomplete({
   		source:'/search',
   		minLength: 2,
   		select: function(event,ui){
//   			alert('label '+ui.item.label+',value'+ui.item.value);
   			window.location = '/memes/view/'+ui.item.url;
   		}
   	});
    $("#searchBar3").autocomplete({
      source: function( request, response ) {
        var term = request.term;	
        if ( term in cache ) {
          response( cache[ term ] );
          return;
        }
        $.ajax({
          url: "/search",
          type: "POST",
          dataType: "jsonp",
          data: { term: term },
          //   featureClass: "P",
          //   style: "full",
          //   maxRows: 12,
          //   name_startsWith: request.term
          // },
         success: function( data ) {
           console.log("grrrr!");
           
           response( $.map( data.results, function( item ) {
             console.log("WTF!");
             return {
               label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
               value: item.name
             }
           }));
         }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.label :
          "Nothing selected, input was " + this.value);
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
});