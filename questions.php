<?php

function answers_form(){
if(session_id() == '' || !isset($_SESSION)) {
            session_start();
}

	
	//echo "session"; print_r($_SESSION);
	$sessionKey=$_SESSION['sessionKey'];
	//echo $sessionKey;
	require_once('config.php');
	$view_answer_url=esc_url( get_permalink( get_page_by_title( 'View Answers' ) ) );
	//echo $view_answer_url;
	get_sidebar('sidebar3');
	?>
				<?php 
				if('Y' == ENABLE_SPLAH_SCREEN){
		echo "<h1>You Have Successfully Logged In. <br><br> This is a Temporary page, links will not be active at this time. Contact your admin for further details.</h1>";
	
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.titlebg').hide();
		
	});
	</script>
	<?php }else{ ?>
<div class="contnr">
	
	<div class="searchall-section col-sm-12 pad0">
        <form name="search_form" id="search_form"  class="search_form">
        <p id="queserror"></p>
          <div class="input-group">
         	
            <input type="text" class="form-control" placeholder="Search Articles" name="q" id="q">
            <span id="basic-addon2" class="input-group-addon search">
            <input type="button" value="search" name="" class="searchbutton" name="questionsearch" id="questionsearch">
            </span> </div>
            <span style="display:none;" id="loadimage1"><img src="https://apptivoapp.cachefly.net/site/v1.0.5/images/aloading.gif" style="padding:6px 10px 10px;"></span>
            <br><br>    
        </form>
      </div>
      
      
   	<?php
	$response_ques = get_all_questions($sessionKey);
	
	//po1(count($response_ques->data));
	//echo '<pre>';print_r($response_ques);
		
	//echo "<h3>Questions</h3>";
	echo "<p id='no'></p>";
        echo '<div class="featured_questindex">';
	echo '<ul id="que" class="featuredqus">';
	foreach($response_ques->data as $ques){
			
		?>
<a href="<?php echo $view_answer_url.'?id='.$ques->questionId?>"><li
	type="circle"><?php echo "#".getSolutionNumber($ques) . " - " . utf8_decode(stripcslashes($ques->questionText));?>

</a>
<br>
		<?php
		echo "<font size=2px>" .$ques->creationDate.'</font>';
		//. " by " .$ques->postedByName
		
		?>
</li>

		<?php
	}
	
	?>
</ul>
</div>
</div>
<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script	type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript">
$ = jQuery;
$(document).ready(function () {
	jQuery("#q").keypress(function (e) {
// 		alert("I'm also getting called");
		 var key = e.which;
		 if(key == 13)  // the enter key code
		  {
			  
		    $('#questionsearch').click();
		    return false;  
		  }
	}); 

	
		$('#questionsearch').click(function(){

						
			questVal = jQuery.trim(jQuery("#q").val());
			if (questVal == "") {
            //alert(questVal);
            $("#queserror").show();
		    jQuery("#queserror").html("<p style='color:red;'>Please enter text for search</p>");
		    
		    	 
		     }
		     else
		     {$('#loadimage1').show();
		    	 $.ajax(
		    	            {
		    	                type: 'POST',
		    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
		    	                data: {'action':'search_question',"searchquestion":questVal,"sessionkey":<?php echo "'$sessionKey'";?>},
		    	                success: function(response)	
		    	                { 
			    	                if(response!=''){
				    	        	    	        
			    	            $('#que').html("");                           
			    	           	$('#que').html(response);
			    	           	$("#queserror").hide();
			    	           	$('#loadimage1').hide();
			    	                }
			    	                else
			    	                {
			    	                	$('#que').html("<p style='color:red;'>No Results Found</p>");
			    	                	$("#queserror").hide();
			    	                	$('#loadimage1').hide();
			    	                }   
		    	                }
		    	                
									    	               
		    	            });
		    	                
		     }
			
			});
		



});    
	

</script>

	<?php
	}
}
?>