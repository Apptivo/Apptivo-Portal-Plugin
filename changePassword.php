<?php
if (session_id () == '' || ! isset ( $_SESSION )) {
	session_start ();
}
/*
 * Change password
 */
require_once ('config.php');
// include_once dirname(__FILE__) . '/config.php';
function change_password_form() {
		?>
		
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
	var validator = $("#changepswForm").validate({
		
		onkeyup: false,
	    errorClass: 'error',
	    validClass: 'valid',
	    rules: {
	    	oldPsswd: {
	            required: true
	       	},
	    	newPsswd: {
	            required: true,
	            minlength: 7
	        },
	        confirmPsswd: {
	            required: true,
	            minlength: 7,
	            equalTo: "#newPsswd"
	        }
	    },
	    messages: {
	    	oldPsswd: {
	            required:"Please provide current password"
	    	},
	    	newPsswd: {
	            required: "Please provide a password",
	            minlength: "Your password must be at least 7 characters long"
	        },
	        confirmPsswd: {
	            required: "Please provide a password",
	            minlength: "Your password must be at least 7 characters long",
	            equalTo: "Your password didn't match"
	        }
	    },
	    submitHandler: function(form) { 
	    	var oldpwd =  jQuery("#oldPsswd").val();
			var newpwd = jQuery("#newPsswd").val();
			var confpwd = jQuery("#confirmPsswd").val();
			 $.ajax(
		 	            {
		 	 	            
		 	                type: 'POST',
		 	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
		 	                data:{'action':'change_password',"oldPsswd":oldpwd,"newPsswd":newpwd,"confirmPsswd":confpwd},
		 	                success: function(data){
		 	               if(data == 100){
		 	 	               alert("Password Changed Successfully");
		 	 	             jQuery("#oldPsswd").val("");
		 	 	   			jQuery("#newPsswd").val("");
		 	 	   			jQuery("#confirmPsswd").val("");
		 	 	               
		 	               }
		 	               else{
		 	            	   alert("Your current password didn't match.");
		 	              	 }
		 	                
			    	  		}	
		 	            });

		    }
		});
});

</script>

	
<div class="col-sm-8 change_pwd">
		<form name="changepswForm" id="changepswForm" method="post" class="" >
		<div class="clearfix col-sm-12 pd0">
			<label class="control-label col-sm-3 pdlft0">
				<font class="pull-right">Current</font>
			</label>
            <div class="col-sm-5 pd0">
                <input class="form-control input-sm "  name="oldPsswd" id="oldPsswd" placeholder="" type="password" maxlength="25" required="">
            </div>
		</div>
        <div class="clearfix  col-sm-12 pd0">
			<label class="control-label col-sm-3 pdlft0">
				<font class="pull-right">New</font>
			</label>
			<div class="col-sm-5 pd0">
				<input class="form-control input-sm "  name="newPsswd" id="newPsswd" placeholder="Use at least 7 characters." type="password" minlength="7" required="">
			</div>
		</div>
		<div class="  col-sm-12 pd0 clearfix">
			<label class="control-label col-sm-3 pdlft0">
				<font class="pull-right">Re-type new</font>
			</label>
			<div class="col-sm-5 pd0">
				<input class="form-control input-sm pull-left" name="confirmPsswd" id="confirmPsswd" placeholder="" type="password"  required="">
			</div>
		</div>
		<div class=" col-sm-11 pd0 clearfix">
			<label class="control-label col-sm-1 pdlft0">
				<font class="pull-right">&nbsp;</font>
			</label>
			<div class="col-sm-8 pdrgt25">
				<button type="submit" class="btn btn-primary pull-right" value="Save"  name="change_pwd" id="change_pwd">Save</button>
			</div>
		</div>
	</form>
	</div>
	<?php 
}?>