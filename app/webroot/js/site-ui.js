$(document).ready(function(){

    $("html").click(function(e){
      if(openModal){
        if(!$("#simple-modal-wrap").hasClass('persistent')){
          var $target = $(e.target);
          if(!$target.hasClass('simple-modal') && $target.parents(".simple-modal").length < 1){
            closeSimpleModal();
            openModal = false;
          }
        }
      }
    }).keyup(function(e){
      if(e.which==27){
        if(openModal){
          if(!$("#simple-modal-wrap").hasClass('persistent')){
            closeSimpleModal();
            openModal = false;
          }
        }
      }
    });

    //search bar functionality. 
   	$("#searchBar").autocomplete({
   		source:'/search',
   		minLength: 2,
   		select: function(event,ui){
   			window.location = '/memes/view/'+ui.item.url;
   		},
      // select: function( event, ui ) {
      //   console.log(ui.item);
      //   console.log( ui.item ?
      //     "Selected: " + ui.item.value + " aka " + ui.item.id :
      //     "Nothing selected, input was " + this.value );
      // },
      complete: function(results){
        //console.log("results "+results.length);
        
      }
   	});
 
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
      openModal = true;
      return $obj;
    }

    function closeSimpleModal(){
      $("#simple-modal-wrap").hide().removeClass('persistent').find(".simple-modal").hide();
      $("#simple-modal-ajax").removeClass('email-send').empty();
      if(!$("#planning-tools").hasClass('expanded')){
        $("body").removeClass('lockItUp showSimple');
      } else {
        $("body").removeClass('showSimple');
      }
      $("#finetune-block").removeClass('persistent first-view');
    }

});

var openModal = false;