$(document).ready(function(){

    // //search bar functionality. 
   	// $("#searchBar").autocomplete({
   	// 	source:'/search',
   	// 	minLength: 2,
   	// 	select: function(event,ui){
   	// 		window.location = '/memes/view/'+ui.item.url;
   	// 	},
    //   select: function( event, ui ) {
    //     console.log(ui.item);
    //     console.log( ui.item ?
    //       "Selected: " + ui.item.value + " aka " + ui.item.id :
    //       "Nothing selected, input was " + this.value );
    //   },
    //   complete: function(results){
    //     console.log("results "+results.length);
        
    //   }
   	// });
    //alert('hi');
    $.fn.fireSimpleModal = function(args){
      var $obj = $(this);
      $("body").addClass('lockItUp showSimple');
      var $wrap = $("#simple-modal-wrap");
      if(args!=null){
        if(args.persistent!=='undefined' && args.persistent){
          $wrap.addClass('persistent');
        }
      } else{
        $wrap.removeClass('persistent');
      }
      $wrap.show().find(".simple-modal").hide();
      $obj.show().css('display','inline-block');
      return $obj;
    }

});