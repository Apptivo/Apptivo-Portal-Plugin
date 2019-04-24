<?php function create_question_form(){
	
	if(session_id() == '' || !isset($_SESSION)) {
            session_start();
}
	//echo "session"; print_r($_SESSION);
	$sessionKey=$_SESSION['sessionKey'];
	//echo $sessionKey;
?>
	<div class="contnr">
	
	
	<div class="searchall-section col-sm-12 pad0">
        <form class="search_form" action="" method="GET" id="search_form" name="search_form">
          <div class="form-group">
            <h4 class="">Question Text</h4>
            
		<div id="errmess" ></div>
            <textarea placeholder="Type a question here" class="form-control" name="questionText"
			id="questionText" placeholder="Type a question here" rows="5" ></textarea>
         
           
            

            <div class="col-sm-offset-6 col-sm-6 text-right createcase-btn pad0"> <a class="mgnrgt5" href="#">Cancel</a>
              <button class="btn btn-primary" type="button" name="createQ" id="createQ">Create</button><span style="display:none;" id="loadimage1"><img src="https://apptivoapp.cachefly.net/site/v1.0.5/images/aloading.gif" style="padding:6px 10px 10px;"></span>
          
            </div>
          </div>
        </form>
      </div>
	
		
	<?php get_sidebar('sidebar3');?>

<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script	type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>

<script type="text/javascript" language="javascript">
$ = jQuery;
$(document).ready(function () {

		$('#createQ').click(function(){
	     qVal = jQuery.trim(jQuery("#questionText").val());
	     //alert(qVal);
	   	     if (qVal == "") {
	    	 jQuery("#errmess").html("<p style='color:red;'>Question text was not entered</p>");
	     }
	     else
	     {
	    	 $('#loadimage1').show();
	    	 $.ajax(
	    	            {
	    	                type: 'POST',
	    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
	    	                data: {'action':'create_question',"question":qVal,"sessionkey":<?php echo "'$sessionKey'";?>},
	    	               	success:function(data){
		    	               	if(data == 100){
		    	               	jQuery("#errmess").html("<p style='color:green;'>Question Created Successfully</p>");
		    	               	$('#loadimage1').hide();
			    	              //alert(response);
	    	               	 //jQuery("#que").append(data);
		    	               	}
		    	               	else
		    	               	{	$('#loadimage1').hide();
		    	               		jQuery("#errmess").html("<p style='color:red;'>Try again later</p>");
		    	               		
		    	               	}
		    	               	
	    	               	}
	    	            });
	    	                
	     }
	     
		});
});
</script>
<?php 
}?>