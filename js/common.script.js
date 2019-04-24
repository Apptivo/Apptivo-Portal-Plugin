
$(function(){
	
	
	
	  $(".editval").hide();
	$(".vwfrmcnt").click(function(){
    $(".viewval").hide();
	$(".spstybtn").show();
	 $(".editval").show();
	 
		
});


$('.qtagsec').click(function(){
	$('.twittericind').css('display','block');

	
	});
	$('.sharecloseind').click(function(){
	$('.twittericind').css('display','none');

	
	});
	
	
	$('.filterclose').click(function(){

		$(this).closest('ul').hide();
	});
	$('.filterdrop').click(function(){

		$(this).next().show();
	});


		var outside_clck;
        $('.filterdropdown ').unbind();
		
        $('.filterdropdown').hover(function ()
        {
            outside_clck = true; 
        }, function ()
        {
            outside_clck = false; 
        });
		//$(".filterotr").die();
        $(".filterotr").on('mouseup', function ()
        { 
            if (!outside_clck)
            {
              
			   $(".filterdropdown").hide();
		
			 
            }

        });
        
    
	
	$('#moveLeft').on("click", function() {
			document.getElementById('bodytable').scrollLeft -= 100;
			document.getElementById('headertable').style.left = "-" + document.getElementById('bodytable').scrollLeft + "px";
});
$('#moveRight').on("click", function() {
			document.getElementById('bodytable').scrollLeft += 100;
			document.getElementById('headertable').style.left = "-" +document.getElementById('bodytable').scrollLeft + "px";
});
$('#bodytable').bind("scroll", function() {
			var bodys = 	$('#bodytable').scrollLeft();
			$('#headertable').attr('style','left:-' + bodys + 'px'  );
});

		

$('.cancelact').click(function(){
	$('.spstybtn').css('display','none');
	$(".editval").hide();
	 $(".viewval").show();
	
	});
	
	
	
 $('.siconckz').on('click',function(){
   $(".aside").show();
   $(".aside").css("top","195px");
 });
 
 
 $('table#mycaseslist tr td.viewpage').on('click',function(){
   $(".aside").hide();
 });
 $('table#mycaseslist tr td.viewpage').on('click',function(){
	   $(".aside1").hide();
	 });
 
 $('.close, .cancelact').on('click',function(){
  
 
 $(".aside").hide();
 });
 
 $('.close, .cancelact').on('click',function(){
	  $(".aside1").hide();
	 });
 
 $('.bdr-rad').click(function(){
	  $('.spstybtn').css('display','none');
	 });


	
$('.maintgle').on('click',function(){
if($('#sidebar').hasClass('in')){
$('body').removeClass('toggles');

}else{
 $('body').addClass('toggles');
}
})

});

  
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator")
        .toggleClass('glyphicon-chevron-down glyphicon-chevron-right');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);
