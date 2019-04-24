$(function(){
	
	
	
	  $(".editval").hide();
	$(".vwfrmcnt").click(function(){
    $(".viewval").hide();
	$(".spstybtn").show();
	 $(".editval").show();
	 
		
});

$('.bdr-rad').click(function(){
 $(".viewval1").show();
 $('.vwfrmcnt').show();
     $(".editval").hide();
       $(".viewval").show();
       $(".spstybtn").hide();
            
       
    
});


$('.qtagsec').click(function(){
	$('.twittericind').css('display','block');

	
	});
	$('.sharecloseind').click(function(){
	$('.twittericind').css('display','none');

	
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

		var win = $(window).outerHeight() - 295;
		document.getElementById('bodytable').style.height = win + 'px';
	$(window).bind("resize", function() {
		var win = $(window).outerHeight() - 295;
		document.getElementById('bodytable').style.height = win + 'px';
	});	
	
	$('.filterdrop').on('click',function(){
var left = $(this).offset().left -209;
var top = $(this).offset().top + 20;
$(this).find('ul.filter').css({"left": left + 'px', "top": top + 'px'});
		});


$('.cancelact').click(function(){
	$('.spstybtn').css('display','none');
	$(".editval").hide();
	 $(".viewval").show();
	
	});
	$('table#example tr td').on('click',function(){
   $(".aside").show();
 });
 $('table#example tr td.viewpage').on('click',function(){
   $(".aside").hide();
 });
 
 $('.close, .cancelact').on('click',function(){
  
 
 $(".aside").hide();
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
