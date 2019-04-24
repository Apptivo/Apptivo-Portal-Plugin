<?php
/*
 * Create Case
 */
ob_start ();
if (session_id () == '' || ! isset ( $_SESSION )) {
	session_start ();
}
function createCase_form() {
	$caseConfigDatas = getCaseConfigData ();
	$support_config_weblayout = $caseConfigDatas->webLayout;
	$support_weblayout = json_decode ( $support_config_weblayout, true );
	$support_weblayout_sections = $support_weblayout ['sections'];
	$case_form_data = array ();
	foreach ( $support_weblayout_sections as $layout_sections ) {	
		$section_attributes = $layout_sections ['attributes'];
		foreach ( $section_attributes as $sec_attributes ) {
			$labe_name = $sec_attributes ['label'] ['modifiedLabel'];
			$labe_name1 = $sec_attributes ['label'] ['originalLabel'];
			switch ($labe_name) {
				case 'Type' :
					$case_form_data [$labe_name] = $sec_attributes;
					break;
				case 'Status' :
					$case_form_data [$labe_name] = $sec_attributes;
					break;
				case 'Priority' :
					$case_form_data [$labe_name] = $sec_attributes;
					break;
				default :
					break;
			}
		}
	}
	$statuses = $caseConfigDatas->statuses;
	foreach ( $statuses as $status ) {
		if ($status->statusName == DEFAULT_STATUS_NAME) {
			$default_status_id = $status->statusId;
			$default_status_name = $status->statusName;
		}
	}
	$sources = $caseConfigDatas->caseSources;
	foreach ( $sources as $source ) {
		if ($source->caseSourceName == DEFAULT_SOURCE_NAME) {
			$default_source_id = $source->caseSourceId;
			$default_source_name = $source->caseSourceName;
		}
	}
	$view_case_url = esc_url ( get_permalink ( get_page_by_title ( OBJECT_NAME.' Overview' ) ) );
	$create_case_url = esc_url ( get_permalink ( get_page_by_title ( 'Create '.OBJECT_NAME ) ) );
	if (isset ( $_POST ['submit'] )) {
		$firstName = $_POST ['first_name'];
		$lastName = $_POST ['last_name'];
		$caseStatusId = $default_status_id;
		$caseStatus = $default_status_name;	
		$caseSourceId = $default_source_id;
		$caseSource = $default_source_name;
		$caseType = $_POST ['case_type_value'];
		$caseTypeId = $_POST ['case_type_key'];
		$casePriority = $_POST ['case_priority_value'];
		$casePriorityId = $_POST ['case_priority_key'];
		$case_attribute_json_str = '';
		if (! empty ( $custom_req_data )) {
			$case_attribute_json_str = json_encode ( $custom_req_data );
		}
		$emailId = getUserEmail();
		$subject = $_POST ['subject'];
		$caseNumber = $_POST ['case#'];
		if ($_POST ['subject'] != '' && isset ( $_POST ['subject'] )) {
			$caseSummary = stripslashes($_POST ['subject']);
		} else {
			$caseSummary = stripslashes($_POST ['summary']);
		}
		
		$caseDescription = stripslashes($_POST ['description']);
		$form_name = $_POST ['ajp_form_name'];
		$assigneeObjId = DEFAULT_ASSIGNEE_TYPE_ID;
		$assigneeObjRefId = DEFAULT_ASSIGNEE_OBJECT_ID;
		$assigneeName = DEFAULT_ASSIGNEE_NAME;
		
		if ($lastName == "" && $emailId == "") {
			
			$response_msg = '<span style="color:red">Please enter valid details</span>';
		} else {
			$case_response = saveTicketForm( $employeeId, $firstName, $lastName, $caseNumber, $caseStatus, $caseStatusId, $caseSource, $caseSourceId, $caseType, $caseTypeId, $casePriority, $casePriorityId, $assigneeName, $assigneeObjId, $assigneeObjRefId, $caseSummary, $caseDescription, $emailId, $case_assignee, $caseAssociates, $createAssociates, $case_custom_fields, $caseSeverity, $caseSeverityId, $casePayVersion, $casePayVersionId, $casePayCritical, $casePayCriticalId, $case_attribute_json_str );
			if ($case_response != '') {
				$caseId = $case_response->csCase->caseId;
				$createdcaseNumber = $case_response->csCase->caseNumber;
				$summary = $case_response->csCase->caseSummary;
				
				$desc = $case_response->csCase->description;
				$contactId = $_SESSION ['contactId'];
				$contactName = $_SESSION ['contactName'];
				$customerId = $_SESSION ['customerId'];
				$customerName = $_SESSION ['customerName'];
				
				$file_name = $_FILES ['image'] ['name'];
				if ($file_name != '') {
					$file_ext = strtolower ( end ( explode ( '.', $file_name ) ) );
					$file_size = $_FILES ['image'] ['size'];
					$file_tmp = $_FILES ['image'] ['tmp_name'];
					$data = file_get_contents ( $file_tmp );
					$base64 = base64_encode ( $data );
					$add_document = uploadDocument1 ( $caseId, $file_name, $file_ext, $file_size, $base64 );
				}
				// $response_msg = '<span style="color:green;font-weight:bold">Your case created successfully. <a href="'.$view_case_url.'?id='.$case_response->csCase->caseId.'">View</a></span>';
				wp_redirect ( $view_case_url . '?id=' . $case_response->csCase->caseId . '&created=true' );
				exit ();
			} else {
				
				$response_msg = '<span style="color:red">Your request was not sent. Please try again after 10 mins</span>';
			}
		}
	}
	?>
<style>
label.error {
	font-size: 12px;
	font-weight: normal;
	color: red;
}

.formsection {
	margin-top: 20px !important;
}

.formlft {
	width: 20%;
	float: left
}

.formrgt textarea {
	width: auto !important
}

.formrgt textarea, .formrgt select {
	width: 25% !important;
}

.formrgt input, .formrgt textarea {
	width: 55% !important;
	border: 1px solid #ccc
}

input[type=file] {
	border: 1px solid #fff;
}

.svsubmit input {
	width: auto !important
}

.formrgt textarea {
	height: 100px
}

.err {
	margin-top: 50px;
	color: red;
}

@media screen and ( max-width: 782px ) {
	.formlft {
		width: 100% !important;
		float: left
	}
	.formrgt {
		width: 100% !important;
	}
	.formrgt input, .formrgt textarea, .formrgt select {
		width: 100% !important;
	}
}
</style>
<?php
	// if (! isAccreditedUser ()) {
	if (1 == 2) {
		
		echo '<div class="contnr"><p class="text-center err">You are not authorized to create or update '.strtolower(OBJECT_NAME_PLURAL).'.</p></div>';
	} else {
		?>

<div class="contnr createpage">
	<div class="bg-color col-sm-12">
        <?php
        $createPageFieldNames=CREATE_PAGE_FIELD_NAMES;
		$createPageFields=array();
		/* Getting Apptivo's Weblayout From API calls */
		$casesConfigData = getCaseConfigData ();
		if (isset ( $casesConfigData )) {
			$apptivoFields = json_decode ( $casesConfigData->webLayout );
			$apptivoFieldsDisplay = display_cases_fields1 ( $apptivoFields );
			$apptivoCasesData = ajp_cases_data1 ( $casesConfigData, $casesConfigData->statuses, $casesConfigData->priorities, $casesConfigData->types );
			$apptivoCasesData = json_decode ( $apptivoCasesData, true );
		}
		if (is_array ( $apptivoFieldsDisplay )) {
			
			
			
			echo "<div id='success_msg'>$response_msg</div>";
			echo '<form name="" action="" method="post" id="single_column_layout" enctype="multipart/form-data">';
			echo '<div class="awformmain awp_contactform_maindiv req">';
			 
			
			
			foreach ( $apptivoFieldsDisplay as $key => $value1 ) {
				if (is_array ( $value1 )) {
					foreach ( $value1 as $key1 => $value ) {
						if(in_array($value["field_name"], $createPageFieldNames)){
							$createPageFields[$value["field_name"]] = $value;
						}
					}
				}
			}
					foreach ( $createPageFieldNames as $key ) {
						
						$value = $createPageFields[$key];
						
						if($value['field_id'] == 'subject'){
// 							po1($value);
						}
						
						$selectedCustomField = $value ['selected_value'];
						$selectedRadioField = $value ['custom_radio_value'];
						$value_data = '';
						if (strcmp ( $value ['field_type'], "input" ) == 0 || strcmp ( $value ['field_type'], "Text box" ) == 0 || strcmp ( $value ['field_type'], "date" ) == 0 || strcmp ( $value ['field_type'], "number" ) == 0 || strcmp ( $value ['field_type'], "currency" ) == 0 || strcmp ( $value ['field_type'], "check" ) == 0 || strcmp ( $value ['field_type'], "link" ) == 0) {
							// if($value['field_id'] != 'email' && $value['field_id'] != 'case#' && $value['field_id'] != 'modifiedby' && $value['field_id'] != 'paidusers' && $value['field_id'] != 'releasedate' && $value['field_id'] != 'datecommitted' && $value['field_id'] != 'changestatus'&& $value['field_id'] != 'targetstartdate'&& $value['field_id'] != 'customerconstraints') {
							// $chkCss = '';
							// if( $value['field_id'] == 'email')
							
							if ($value ['field_id'] == 'email') {
								$value_data = getUserEmail ();
								$field_id = "required";
								$required = "<sup><font color=red>*</sup></font>";
								$field_type_val = 'text';
								echo '<div class="col-sm-6" ' . $chkCss . '><div class="form-group">';
								echo '<label>' . $value ['field_name'] . $required . '</label>';
								?><div class="vwfrmcnt">
			<input class="form-control <?php echo $field_id; ?>"
				type="<?php echo $field_type_val; ?>"
				name="<?php echo $value['field_id']; ?>"
				id="<?php echo $value['field_id']; ?>" size="5"
				value="<?php echo $value_data; ?>" />
		</div>
	</div>
</div>
<div class="clearfix"></div>
<?php
							} elseif ($value ['field_id'] == 'subject' || $value ['field_id'] == 'summary') {
								$field_id = "required";
								$required = "<sup><font color=red>*</sup></font>";
								$field_type_val = 'text';
								echo '<div class="col-sm-12" ' . $chkCss . '><div class="form-group">';
								echo '<label>' . $value ['field_name'] . $required . '</label>';
								?><div class="vwfrmcnt">
	<input class="form-control <?php echo $field_id; ?>"
		type="<?php echo $field_type_val; ?>"
		id="<?php echo $value['field_id']; ?>"
		name="<?php echo $value['field_id']; ?>" size="5"
		value="<?php echo $value_data; ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>
<?php
							} else {
								$field_id = "";
								$required = "";
								$field_type_val = 'text';
							}
							
							// }
						}
						if (strcmp ( $value ['field_type'], "textarea" ) == 0) {
							if ($value ['field_id'] == "description") {
								$fieldid = $value ['field_id'];
								echo '<div class="col-sm-12"><div class="form-group">';
								echo '<label>' . $value ['field_name'] . '</label>';
								echo '<div class="vwfrmcnt">';
								echo '<textarea  name="' . $fieldid . '" id="' . $fieldid . '" size="50" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 177px;"></textarea>';
								echo '</div></div></div>';
							}
						}
						

						
						
						if (strcmp ( $value ['field_type'], "select" ) == 0) {
							// echo $value['fieldname'];
							if (strcmp ( $value ['field_id'], "type" ) == 0) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value ['field_name'] . '<sup><font color=red>*</sup></font></label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value ['field_id'] . '_select', get_caseValues1 ( $type = 'caseType', $apptivoCasesData,'create'), $caseType, $value ['field_id'] . '_select' );
								echo '</div></div></div>';
							}
							if (strcmp ( $value ['field_id'], "priority" ) == 0) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value ['field_name'] . '<sup><font color=red>*</sup></font></label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value ['field_id'] . '_select', get_caseValues1 ( $type = 'casePriority', $apptivoCasesData,'create'), DEFAULT_PRIORITY_NAME, $value ['field_id'] . '_select' );
								echo '</div></div></div><div class="clearfix"></div>';
							}
						}
						
						if (strcmp ( $value ['field_id'], "contact" ) == 0) {
							
							$_SESSION ['contact'] = $value;
						}
					}
			?>



<?php
			
			echo '<div class="">';
			echo '<div class="col-sm-6"><div class="form-group">';
			echo '<label>Add Attachment</label>';
			echo '<div class="vwfrmcnt">';
			echo '<input name="image" type="file" />';
			echo '</div></div></div>';
			echo '</div>';
			
			echo '
				<input type="hidden" id="case_status_value" name="case_status_value" value="' . $caseStatus . '"/>
				<input type="hidden" id="case_status_key" name="case_status_key" value="' . $caseStatus_id . '"/>
				<input type="hidden" id="case_type_value" name="case_type_value" value="' . $caseType . '"/>
				<input type="hidden" id="case_type_key" name="case_type_key" value="' . $caseType_id . '"/>
				<input type="hidden" id="case_priority_value" name="case_priority_value" value="' . $casePriority . '"/>
				<input type="hidden" id="case_priority_key" name="case_priority_key" value="' . $casePriority_id . '"/>
				<input type="hidden" name="cust_id" id="cust_id">  
				<input type="hidden" name="cont_id" id="cont_id">
			';		
			$url = home_url ();
			echo '<div class="formsection"><div class="formlft"><label><span>&nbsp;</span></label></div>
            <div class="col-sm-offset-6 col-sm-6 text-right createcase-btn"><a class="mgnrgt5 cancelTxt" href="' . $url . '/my-open-'.strtolower(OBJECT_NAME_PLURAL).'/">Cancel</a> <input type="submit" value ="Submit" name="submit" id ="viewbtn" class="btn btn-primary"></div></div>';
			echo '</div></form>';
		}
		
		?>


</div>
</div>
<?php
	}
	?>
	
<script type="text/javascript"
	src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">

<script
	src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

	

	
	

	
<script type="text/javascript"
	src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">


function initCustomerTable(){

	var custT = jQuery('#customer_table').dataTable({
		  dom: 'Brtip',
      "aaSorting":[],
      "stateSave": true,
      "iDisplayLength": 25,
      "oLanguage": {
	          		"sEmptyTable":  "No Customer Found"
	      		 }

	
	 
  });
	
  return custT;

}

function initContactTable(){

	var contT = jQuery('#contact_table').dataTable({
	  dom: 'Brtip',
      "aaSorting":[],
      "stateSave": true,
      "iDisplayLength": 25,
      "oLanguage": {
	          		"sEmptyTable":  "No Contact Found"
	      		 }
  });
  return contT;

}

	function selectContact(contObject){
	var contparts = contObject.split(":");
	 jQuery('#cont_data').val(contparts[1]);
	 jQuery('#cont_id').val(contparts[0]);

	}

	function selectCustomer(custObject){
		var custparts = custObject.split(":");
		 jQuery('#cust_data').val(custparts[1]);
		 jQuery('#cust_id').val(custparts[0]);
		 $('#contact_srch').click();
		 
	
		 }

	

    jQuery(document).ready(function () {

    	
    		$('#success_msg').delay(10000).fadeOut();


    		jQuery("form").keypress(function (e) {
//         		alert("I'm also getting called");
        		 var key = e.which;
    			 if(key == 13)  // the enter key code
    			  {
       			  
    			    e.preventDefault();
    			    return false;  
    			  }
    		});   

    		
    		jQuery("#customer_text").keypress(function (e) {
//         		alert("I'm also getting called");
        		 var key = e.which;
    			 if(key == 13)  // the enter key code
    			  {
       			  
    			    $('#customer_srch1').click();
    			    return false;  
    			  }
    		});   

        	var custTable = initCustomerTable();
   
    		jQuery("#customer_srch1").click(function (e) {
//         		con.log("hello");
//         		alert("I'm geting called");
        		e.preventDefault();
			var customer = jQuery('#customer_text').val();
			 $.ajax(
	    	            {
	    	                type: 'POST',
	    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
	    	                data:{'action':'search_customer',"customer_name":customer},
	    	                success: function(response){
	    	                	if(response!=''){
		    	                	
	    	                		custTable.fnDestroy();
	    	                		$("#customer_table").html(response);
	    	                		custTable = initCustomerTable();
	    	                		
	    	                		
	    	                	}
	    	                	
		    	              	}	
	    	            });
	
    		});
    	
    		
    		var contTable = initContactTable();
			jQuery("#contact_srch").click(function (e) {

				e.preventDefault();
				
				var contact = jQuery('#contact_text').val();
				 var customerId = jQuery('#cust_id').val();
				 $.ajax(
		    	            {
		    	                type: 'POST',
		    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
		    	                data:{'action':'search_contact',"contact_name":contact,"customer_id":customerId},
		    	                success: function(response){
		    	                	contTable.fnDestroy();
		    	                	$("#contact_table").html(response);
		    	               
		    	                	contTable = initContactTable();
		    	                	
			    	                }	
		    	            });
	
        		
    		});

    		
    	//$("#email").prop("readonly", true);
    
        jQuery("#solution_select").change(function () {
             var sol_val=jQuery("#solution_select option:selected").text(); 
             if(sol_val!='Ascender Pay'){

            	 jQuery('#yourcurrentapptivoportalpayversion_select').val("");
          		jQuery('#yourcurrentapptivoportalpaycriticalpatch_select').val("");
          		jQuery('#apenvironment_select').val("");
         		jQuery('#payversion_div').hide();
             	jQuery('#criticalpatch_div').hide();
             	jQuery('#apenvironment_div').hide();
             	
//                  jQuery('#yourcurrentapptivoportalpayversion_select').hide();
//                  jQuery('#yourcurrentapptivoportalpaycriticalpatch_select').hide();
//                  jQuery('#version_label').hide();
//                  jQuery('#critical_label').hide();
//                  jQuery('#yourcurrentapptivoportalpayversion_select').val("");
//                  jQuery('#yourcurrentapptivoportalpaycriticalpatch_select').val("");
                 
             }else{

          		jQuery('#payversion_div').show();
             	jQuery('#criticalpatch_div').show();
            	jQuery('#apenvironment_div').show();
                 
//                  jQuery('#yourcurrentapptivoportalpayversion_select').show();
//                  jQuery('#yourcurrentapptivoportalpaycriticalpatch_select').show();
//                  jQuery('#version_label').show();
//                  jQuery('#critical_label').show();
             }
         });
         
        jQuery("#single_column_layout").validate({
        	submitHandler: function(e) { 
//         		var customerId = jQuery('#cust_id').val();
//         		var contactId = jQuery('#cont_id').val();
//         		var contactName = jQuery('#cont_data').val();
//         		if( customerId == ''){
//             		 alert("Please select valid customer.");
//             		 stopEvent(e);
//             	} else if(contactName != '' && contactId == '') {
//                 	 alert("Please select valid contact.");
//             		 stopEvent(e);
//         		}
				
         	      $('#viewbtn').attr('disabled','disabled');
        	       var $form = $(this);

        	                if ($form.data('submitted') === true) {             
        	                    e.preventDefault();
        	                } else {               
        	                    if($form.valid()) {
        	                        $form.data('submitted', true);
        	                    }
        	                    $("#viewbtn").submit();
        	                }
        	   },
        	   invalidHandler: function() {       
        	     // re-enable the button here as validation has failed
        	     $('#viewbtn').removeAttr('disabled');
        	   }
        	            

        });
        jQuery("#status_select").change(function () {
            jQuery("#case_status_value").val(jQuery("#status_select option:selected").text());
            jQuery("#case_status_key").val(jQuery("#status_select option:selected").val());
        });
        jQuery("#priority_select").change(function () {
            jQuery("#case_priority_value").val(jQuery("#priority_select option:selected").text());
            jQuery("#case_priority_key").val(jQuery("#priority_select option:selected").val());
        });
        jQuery("#type_select").change(function () {
        	
            jQuery("#case_type_value").val(jQuery("#type_select option:selected").text());
            jQuery("#case_type_key").val(jQuery("#type_select option:selected").val());
        });
        

        jQuery("#case_status_value").val(jQuery("#status_select option:selected").text());
        jQuery("#case_type_value").val(jQuery("#type_select option:selected").text());
        jQuery("#case_priority_value").val(jQuery("#priority_select option:selected").text());

        jQuery("#case_status_key").val(jQuery("#status_select option:selected").val());
        jQuery("#case_priority_key").val(jQuery("#priority_select option:selected").val());
        jQuery("#case_type_key").val(jQuery("#type_select option:selected").val());
        
        jQuery("#severity_select").change(function () {
            jQuery("#case_severity_value").val(jQuery("#severity_select option:selected").text());
            jQuery("#case_severity_key").val(jQuery("#severity_select option:selected").val());
        });
        jQuery("#apenvironment_select").change(function () {
            jQuery("#case_apenv_value").val(jQuery("#apenvironment_select option:selected").text());
            jQuery("#case_apenv_key").val(jQuery("#apenvironment_select option:selected").val());
        });
        jQuery("#yourcurrentapptivoportalpayversion_select").change(function () {
            jQuery("#case_payversion_value").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").text());
            jQuery("#case_payversion_key").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").val());
        });
         jQuery("#solution_select").change(function () {
            jQuery("#solution_value").val(jQuery("#solution_select option:selected").text());
            jQuery("#solution_key").val(jQuery("#solution_select option:selected").val());
        });



        jQuery("#internalgroup_select").change(function () {
        	 jQuery("#internalgroup_value").val(jQuery("#internalgroup_select option:selected").text());
             jQuery("#internalgroup_key").val(jQuery("#internalgroup_select option:selected").val());
        });
          
        jQuery("#yourcurrentapptivoportalpaycriticalpatch_select").change(function () {
            jQuery("#case_paycritical_value").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").text());
            jQuery("#case_paycritical_key").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").val());
        }); 
        
        jQuery("#case_severity_value").val(jQuery("#severity_select option:selected").text());
        jQuery("#case_severity_key").val(jQuery("#severity_select option:selected").val());
        
        jQuery("#case_apenv_value").val(jQuery("#apenvironment_select option:selected").text());
        jQuery("#case_apenv_key").val(jQuery("#apenvironment_select option:selected").val());
        
        jQuery("#case_payversion_value").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").text());
        jQuery("#case_payversion_key").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").val());

        jQuery("#solution_value").val(jQuery("#solution_select option:selected").text());
        jQuery("#solution_key").val(jQuery("#solution_select option:selected").val());


        jQuery("#internalgroup_value").val(jQuery("#internalgroup_select option:selected").text());
        jQuery("#internalgroup_key").val(jQuery("#internalgroup_select option:selected").val());
//      jQuery("#case_paycritical_value").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").text());
//      jQuery("#case_paycritical_key").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").val());

 });
</script>
       
<?php
}



?>