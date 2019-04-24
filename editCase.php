<?php
if(session_id() == '' || !isset($_SESSION)) { session_start(); }
/*
 * Edit page
 */
ob_start();
require_once('config.php');
function editCase_form() {
	require_once ('class.apptivo.php');
	$apptivoApi = new apptivoApi(APPTIVO_API_KEY, APPTIVO_ACCESS_KEY, API_USER_EMAIL);
	$caseData = get_case_by_caseId1($_GET['id'],$sessionKey);
	$selected_contact_id=$caseData->caseContactId;
	$selected_contact=$caseData->caseContact;
	$getAllCasesConfigData = getAllCasesConfigData();
	$support_config_weblayout = $getAllCasesConfigData->webLayout;
	$support_weblayout = json_decode($support_config_weblayout, true);
	$support_weblayout_sections = $support_weblayout['sections'];
	$case_form_data = array();
	foreach ( $support_weblayout_sections as $layout_sections ) {       
	   $section_attributes = $layout_sections['attributes'];       
	   foreach ( $section_attributes as $sec_attrivbutes ){           
		   $label_name = $sec_attrivbutes['label']['modifiedLabel'];           
		   switch ( $label_name ){
			   case 'Type':
			   case 'Status':
			   case 'Priority':
			   case 'Subject':
			   case 'Description':
			  default :
				  break;                   
		   }
	   }       
	}
    $view_case_url=esc_url( get_permalink( get_page_by_title( OBJECT_NAME.' Overview' ) ) ); 
 ?>
 <?php 
     
if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
	$attributeName = Array();
	$attributeIds = Array();
	if($caseData->caseStatus != $_POST['case_status_value']) {
		$caseData->caseStatus = $_POST['case_status_value'];
		$caseData->caseStatusId = $_POST['case_status_key'];
		array_push($attributeName,'caseStatus');
		array_push($attributeIds,'case_status_attr');
	}
	if($caseData->caseType != $_POST['case_type_value']) {
		$caseData->caseType = $_POST['case_type_value'];
		$caseData->caseTypeId = $_POST['case_type_key'];
		array_push($attributeName,'caseType');
	}
	if($caseData->casePriority != $_POST['case_priority_value']) {
		$caseData->casePriority = $_POST['case_priority_value'];
		$caseData->casePriorityId = $_POST['case_priority_key'];
		array_push($attributeName,'casePriority');
	}
	if($caseData->caseSummary != $_POST['summary']) {
		$caseData->caseSummary = $_POST['summary'];
		array_push($attributeName,'caseSummary');
	}
	if($caseData->description != $_POST['description']) {
		$caseData->description = $_POST['description'];
		array_push($attributeName,'description');
		array_push($attributeIds,'case_description_attr');
	}
	$newContactArr = explode(';',$_POST['contact']);
	if($caseData->caseContact != $newContactArr[0]) {
		$caseData->caseContact = $newContactArr[0];
		$caseData->caseContactId = $newContactArr[1];
		array_push($attributeName,'caseContact');
		array_push($attributeName,'caseContactNew');
		array_push($attributeIds,'case_contact_attr');
	}
	//Now call the API method to update the case
	$updatedCase = $apptivoApi->update('cases',$caseData->id,json_encode($attributeName),json_encode($caseData),'&attributeIds='.json_encode($attributeIds));
	if ($updatedCase != '') {
		$response_msg = '<span style="color:green;font-weight:bold">Your case updated successfully. <a href="'.$view_case_url.'?id='.$_REQUEST["id"].'">View</a></span>';
		 wp_redirect($view_case_url . '?id=' . $_REQUEST["id"].'&updated=true');
		 exit; 
	} else {
		$response_msg = '<span style="color:red">Your request was not sent. Please try again later</span>';
	}
}
elseif (isset($_POST['submit']) && $_POST['submit'] == 'Add Comment') {
    $sessionKey=$_SESSION['sessionKey'];
    $caseId = $_POST['case_id_value'];
    $notes = $_POST['addnotearea'];
    if($caseId != '' && $notes != ''){
        $response = add_notes_by_objectId1($caseId,$notes,$sessionKey);
        if ($response != '') {
            $response_msg = '<span style="color:green;font-weight:bold">Your note added successfully.</span>';
        }
    }
}

?>
<style>
    label.error {font-size: 12px;font-weight: normal;color: red;}    
    .formsection{clear: both; margin-top: 20px !important;}    
    .formlft{width: 20%;float: left}    
    .formrgt textarea{width: auto !important}
    .formrgt input,.formrgt textarea, .formrgt select {width: 50% !important;}
    .formrgt {width: 70%;display: inline-block}
    .formsectionn{background-color: rgb(249, 249, 249); padding: 20px;}
    .formsectionn .notesec{width: 100%; float: left; font-weight: bold; padding-bottom: 15px;}
    .notesec .noteseclft{float: left;}
    .notesec .notesecrgt{float: right;}
    .notesec .noteseccnt{clear: both;}
    label.error {font-size: 12px;font-weight: normal;color: red;}    
    .formsection{clear: both; margin-top: 20px !important;}    
    .formlft{width: 20%;float: left}    
    .formrgt textarea{width: auto !important}
    .formrgt input, .formrgt textarea {width:80% !important; border:1px solid #ccc}
    .svsubmit input {width:auto !important}
    .formrgt textarea{height:100px}
    .err {margin-top: 50px;color: red;}
    @media screen and ( max-width: 782px ) {
        .formlft{width: 100% !important;float: left}    
        .formrgt {width: 100% !important;}
        .formrgt input,.formrgt textarea, .formrgt select {width: 100% !important;}
    }
</style> 
<?php

if (1 == 2) {
    echo '<div class="contnr"><p class="text-center err">You are not Authenticated to Create and Update Tickets</p></div>';
}else{

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    if(empty($caseData->caseNumber)){
        wp_redirect( AWP_WEBSITE_URL.'my-open-'.strtolower(OBJECT_NAME_PLURAL).'/' );
       exit;
    }
} else {
    wp_redirect( AWP_WEBSITE_URL.'my-open-'.strtolower(OBJECT_NAME_PLURAL).'/' );
    exit;
}


?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript">

function selectCustomer(custObject){
	var custparts = custObject.split(":");
	 jQuery('#cust_data').val(custparts[1]);
	 jQuery('#cust_id').val(custparts[0]);
	 jQuery('#customer').hide();
	 
	
}

function selectContact(contObject){
	var contparts = contObject.split(":");
	 jQuery('#cont_data').val(contparts[1]);
	 jQuery('#cont_id').val(contparts[0]);
	 jQuery('#contact').hide();
	
}




    jQuery(document).ready(function () {
    	var solution=jQuery("#apptivoportalpay").val();

    	jQuery("#customer_srch").click(function () {
			var customer = jQuery('#customer_text').val();
			 $.ajax(
	    	            {
	    	                type: 'POST',
	    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
	    	                data:{'action':'search_customer',"customer_name":customer},
	    	                success: function(response){
	    	                	$("#customer_table").html(response);
	    	                	
	    	                	
		    	                }	
	    	            });
	
    		});
    	

    	jQuery("#contact_srch").click(function () {
			var contact = jQuery('#contact_text').val();
			 $.ajax(
	    	            {
	    	                type: 'POST',
	    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
	    	                data:{'action':'search_contact',"contact_name":contact},
	    	                success: function(response){
	    	                	$("#contact_table").html(response);
	    	                	
	    	                	
		    	                }	
	    	            });

    		
		});
		

        jQuery("#single_column_layout").validate();
        jQuery("#priority_select").change(function () {
            jQuery("#case_priority_value").val(jQuery("#priority_select option:selected").text());
            jQuery("#case_priority_key").val(jQuery("#priority_select option:selected").val());
        });
        jQuery("#type_select").change(function () {
            jQuery("#case_type_value").val(jQuery("#type_select option:selected").text());
            jQuery("#case_type_key").val(jQuery("#type_select option:selected").val());
        });

        jQuery("#case_type_value").val(jQuery("#type_select option:selected").text());
        jQuery("#case_priority_value").val(jQuery("#priority_select option:selected").text());

        jQuery("#case_priority_key").val(jQuery("#priority_select option:selected").val());
        jQuery("#case_type_key").val(jQuery("#type_select option:selected").val());



    });
</script>

  
<div class="contnr createpage">

<div class="bg-color col-sm-12">
                    <div class="entry-content">
                        <div class="formsectionpd">
                            <div class="formlft" style="font-size: 24px; width: 90%;"><b><?php echo $caseData->caseNumber.' - '.substr($caseData->caseSummary, 0, 250); ?></b></div>
                            
                        </div> 
                        <hr>
        <?php
		$editPageFields = Array();
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
						if(in_array($value["field_name"], EDIT_PAGE_FIELD_NAMES)){
							$editPageFields[$value["field_name"]] = $value;
						}
					}
				}
			}
					foreach ( EDIT_PAGE_FIELD_NAMES as $key ) {
						
						$value = $editPageFields[$key];
						
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
								echo '
									<div class="col-sm-12" ' . $chkCss . '>
										<div class="form-group">
											<label>' . $value ['field_name'] . $required . '</label>
											<div class="vwfrmcnt">
												<input class="form-control '.$field_id.'" type="'.$field_type_val.'" id="'.$value['field_id'].'" name="'.$value['field_id'].'" size="5"	value="'.$caseData->caseSummary.'" />
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
								';
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
								echo '<textarea  name="' . $fieldid . '" id="' . $fieldid . '" size="50" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 177px;">'.$caseData->description.'</textarea>';
								echo '</div></div></div>';
							}
						}
						

						
						
						if (strcmp ( $value ['field_type'], "select" ) == 0) {
							// echo $value['fieldname'];
							if (strcmp ( $value ['field_id'], "type" ) == 0) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value ['field_name'] . '<sup><font color=red>*</sup></font></label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value ['field_id'] . '_select', get_caseValues1 ( $type = 'caseType', $apptivoCasesData,'create'), $caseData->caseType, $value ['field_id'] . '_select' );
								echo '</div></div></div>';
							}
							if (strcmp ( $value ['field_id'], "priority" ) == 0) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value ['field_name'] . '<sup><font color=red>*</sup></font></label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value ['field_id'] . '_select', get_caseValues1 ( $type = 'casePriority', $apptivoCasesData,'create'), $caseData->casePriority, $value ['field_id'] . '_select' );
								echo '</div></div></div><div class="clearfix"></div>';
								$contactNext = true;
							}
							if($contactNext == true) {
								$contactNext = false;
								$value=$_SESSION ['contact'];
								if (in_array ( strcmp ( $value ['field_id'], "contact" ) == 0 || strcmp ( $value ['field_id'], "contact" ) == 0 , EDIT_PAGE_FIELD_NAMES )) {
									echo '
										<div class="col-sm-6">
											<div class="form-group">
												<label>' . $value ['field_name'] . $required . '</label>
												<div class="vwfrmcnt">
													<select class="form-control '.$field_id.'" id="'.$value['field_id'].'"name="'.$value['field_id'].'" >
									';
									$contactDetails = get_customer_contacts($caseData->caseCustomerId);
									$contacts=$contactDetails->data;
									foreach($contacts as $contact){
										if($contact->contactId == $selected_contact_id ){
											$value=$selected_contact;
											$value_id=$selected_contact_id;
										}
										$contact_id=$contact->contactId;
										$contact_name=$contact->firstName. " " .$contact->lastName;
										if($value_id==$contact_id){ $selected = "selected";}else{$selected = '';}
										echo 			'<option value="'.$contact_name.';'.$contact->contactId.'" '.$selected.'>'.$contact_name.'</option>';
									}
									echo '
													</select>
												</div>
											</div>
										</div>
									';
								}
							}
						}
					}
			?>



<?php
            echo '
				<input type="hidden" id="case_status_value" name="case_status_value" value="' . $caseData->caseStatus . '"/>
				<input type="hidden" id="case_status_key" name="case_status_key" value="' . $caseData->caseStatusId . '"/>
				<input type="hidden" id="case_type_value" name="case_type_value" value="' . $caseType . '"/>
				<input type="hidden" id="case_type_key" name="case_type_key" value="' . $caseType_id . '"/>
				<input type="hidden" id="case_priority_value" name="case_priority_value" value="' . $casePriority . '"/>
				<input type="hidden" id="case_priority_key" name="case_priority_key" value="' . $casePriority_id . '"/>
				<input type="hidden" id="case_id_value" name="case_id_value" value="' . $case_id_value . '"/>    
				<input type="hidden" id="case_contact_value" name="case_contact_value" value="'.$value.'"/>
				<input type="hidden" id="case_contact_key" name="case_contact_key" value="'.$value_id.'"/>
				<input type="hidden" name="cust_id" id="cust_id" value="'.$case_cust_id.'">  
				<input type="hidden" name="cont_id" id="cont_id" value="'.$case_cont_id.'">
			';	
			$url = home_url ();
			echo '
				<div class="formsection"><div class="formlft"><label><span>&nbsp;</span></label></div>
				<div class="col-sm-offset-6 col-sm-6 text-right createcase-btn"><a href="'.$url.'/'.strtolower(OBJECT_NAME).'-overview/?id='.$_GET['id'].'" class="mgnrgt5">Cancel</a>&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value ="Update" name="submit" id ="viewbtn"></div></div>
			';
			echo '
				</div>
			</form>
			';
		}
		?>
        </div>
	</div>
<?php
	}
}
 ?>