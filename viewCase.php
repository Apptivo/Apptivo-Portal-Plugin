<?php
if (session_id () == '' || ! isset ( $_SESSION )) {
	session_start ();
}
/*
 * View All Cases
 */
function viewCase_form() {

$support_config_weblayout = getCaseConfigData ()->webLayout;
	// $support_config_weblayout = getAllCasesConfigData()->webLayout;
	$support_weblayout = json_decode ( $support_config_weblayout, true );
	$support_weblayout_sections = $support_weblayout ['sections'];
	// po1($support_weblayout_sections);
	$case_form_data = array ();
	foreach ( $support_weblayout_sections as $layout_sections ) {
		
		$section_attributes = $layout_sections ['attributes'];
		
		foreach ( $section_attributes as $sec_attrivbutes ) {
			
			$labe_name = $sec_attrivbutes ['label'] ['modifiedLabel'];
			$labe_name1 = $sec_attrivbutes ['label'] ['originalLabel'];

			switch ($labe_name) {
				case 'Type' :
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
				case 'Status' :
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
				case 'Priority' :
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
				case 'Source' : // custom
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
						
				default :
					break;
			}
		}
	}
	
	$view_case_url = esc_url ( get_permalink ( get_page_by_title ( OBJECT_NAME.' Overview' ) ) );
	$edit_case_url = esc_url ( get_permalink ( get_page_by_title ( 'Edit '.OBJECT_NAME ) ) );
	if (isset ( $_POST ['submit'] ) && $_POST ['submit'] == 'Add Comment') {
		$sessionKey = getSessionKey ();
		$caseId = $_POST ['case_id_value'];
		$caseName = $_POST ['case_name_value'];
		$notes = stripslashes($_POST ['addnotearea']);
	 if ($caseId != '' && $notes != '') {
			$response = add_notes_by_objectId1 ( $caseId, $caseName, $notes, $sessionKey );
			if ($response != '') {
				wp_redirect ( $view_case_url . '?id=' . $caseId . '&n=1');
				
				exit ();
			}
			
		}
	} elseif (isset ( $_POST ['submit'] ) && $_POST ['submit'] == 'Attach File') {
		
		$caseId = $_GET ['id'];
		if ($caseId != '') {
			$file_name = $_FILES ['image'] ['name'];
			if($file_name == ''){
				wp_redirect ( $view_case_url . '?id=' . $caseId);
				$response_msg = '<span style="color:red;font-weight:bold">Add attachment</span>';
			}
			else if ($file_name != '') {
				error_log ( "KORADA => " . $file_name );
				$file_ext = strtolower ( end ( explode ( '.', $file_name ) ) );
				$file_size = $_FILES ['image'] ['size'];
				$file_tmp = $_FILES ['image'] ['tmp_name'];
				
				$data = file_get_contents ( $file_tmp );
				$base64 = base64_encode ( $data );
				// echo "Base64 is ".$base64;exit;
				$upload_document = uploadDocument1 ( $caseId, $file_name, $file_ext, $file_size, $base64 );
				$_SESSION ['viewticket_attachment'] = $upload_document;
				if ($upload_document != '') {
// 					$cases = get_case_by_caseId1 ( $_REQUEST ['id'] );
// 					$createdcaseNumber = $cases->caseNumber;
// 					$summary = $cases->caseSummary;
// 					$desc = $cases->description;
// 					$case_attribute_json_str = $_SESSION ['customAttribute'];
// 					$case_client_custom_attr = getClientInfoCustomAttributes ();
// 					$case_attribute_json_str = json_decode ( $case_attribute_json_str );
// 					$case_attribute_json_str1 = array ();
// 					$customattr = array_merge ( $case_attribute_json_str, $_SESSION ['sub_status_data'] );
// 					$customattribute = array_merge ( $customattr, $case_client_custom_attr );
// 					$case_attribute_json_str1 = json_encode ( $customattribute );
					
// 					if ($case_attribute_json_str1 != '') {
// 						$customAttributes = ',"customAttributes":' . $case_attribute_json_str1;
// 					} else {
// 						$customAttributes = ',"customAttributes":[]';
// 					}
					
// 					$caseData = '{"id":"' . $caseId . '","caseId":' . $caseId . ',"objectId":' . CA_APPID . ',"caseNumber":"' . $createdcaseNumber . '","caseStatus":"' . $_SESSION ['inprogress_status_name'] . '","caseStatusId":' . $_SESSION ['inprogress_status_id'] . ',"caseSummary":"' . $summary . '","description":"' . $desc . '"' . $customAttributes . '}';
// 					$update_response = updateCasesForm2 ( $caseId, $caseData );
					
					// $file_name=$upload_document->documentName;
					// $document_id=$upload_document->documentId;
					// $file_download_url=get_download_url1($document_id);
					wp_redirect ( $view_case_url . '?id=' . $caseId . '&a=1' );
					exit ();
				}
			}
		}
	}
	
	if (! isset ( $_REQUEST ['id'] ) && ! is_numeric ( $_REQUEST ['id'] )) {
		echo "Case View not available..";
	} else {
		
		if (isset ( $_REQUEST ['id'] ) && is_numeric ( $_REQUEST ['id'] )) {
			
			$case_id_value = $_REQUEST ['id'];
			$sessionKey = getSessionKey ();
			$cases = get_case_by_caseId1 ( $_REQUEST ['id'] );
			//po1($cases);
			$_SESSION['ticket_status']=$cases->caseStatus;
			
			if (empty ( $cases->caseNumber )) {
				wp_redirect ( PORTAL_MYCASES_URL );
				exit ();
			}
		} else {
			wp_redirect ( PORTAL_MYCASES_URL );
			exit ();
		}
		
		if (isset ( $_GET ['created'] ) && $_GET ['created'] == 'true') {
			$response_msg = '<span style="color:green;font-weight:bold;padding-bottom:10px;">'.OBJECT_NAME.' created successfully.</span>';
		} elseif (isset ( $_GET ['updated'] ) && $_GET ['updated'] == 'true') {
			$response_msg = '<span style="color:green;font-weight:bold;padding-bottom:10px;">'.OBJECT_NAME.' updated successfully.</span>';
		} elseif (isset ( $_GET ['n'] ) && $_GET ['n'] == '1') {
			$response_msg = '<span style="color:green;font-weight:bold;padding-bottom:10px;">Your note has been saved and will appear shortly.</span>';
			        	
		} elseif (isset ( $_GET ['a'] ) && $_GET ['a'] == '1') {
			$response_msg = '<span style="color:green;font-weight:bold;padding-bottom:10px;">Attachment added successfully.</span>';
		}
		
		?>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
function downloadUrl(id){
	$.ajax(
            {
                type: 'POST',
                url:'<?php echo admin_url('admin-ajax.php'); ?>',
                data:{'action':'download_attachment',"docId":id},
                success:function(response){
                    window.open(response);
                }
});

}

$(document).ready(function(){
	$('#success_msg').delay(10000).fadeOut();
	
	
});
</script>



<style>
.editval {
	display: none;
}

label.error {
	font-size: 12px;
	font-weight: normal;
	color: red;
}

.formlft {
	width: 20%;
	float: left
}

.formrgt textarea {
	height: 100px;
}

.formrgt textarea {
	width: 55% !important;
	border: 1px solid #ccc;
}

.formrgt select {
	width: 25% !important;
}

.formrgt {
	width: 70%;
	display: inline-block
}

.formsectionn {
	background-color: rgb(249, 249, 249);
	padding: 20px;
}

.formsectionn .notesec {
	width: 100%;
	float: left;
	font-weight: bold;
	padding-bottom: 15px;
}

.notesec .noteseclft {
	float: left;
}

.notesec .notesecrgt {
	float: right;
}

.notesec .noteseccnt {
	clear: both;
}

@media screen and ( max-width: 782px ) {
	.formlft {
		width: 40%;
		float: left
	}
	.formrgt input, .formrgt textarea, .formrgt select {
		width: 50% !important;
	}
}
</style>



<div class="contnr">

	<div class="modal fade bs-example-modal-lg" role="dialog"
		aria-labelledby="gridSystemModalLabel" aria-hidden="false"
		style="padding-right: 17px;">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="gridSystemModalLabel">Confirm discard
						changes</h4>
				</div>
				<div class="modal-body">
					<p>You have unsaved changes. Do you want to discard?</p>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default bdr-rad"
						data-dismiss="modal">ok</button>
					<button type="button" class="btn btn-primary bdr-rad"
						data-dismiss="modal">cancel</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class=" spstybtn spst-1" style="clear: both; display: none">
		<div class="pull-right ">
			<a href="javascript:void(0)" data-toggle="modal"
				data-target=".bs-example-modal-md"
				class="btn btn-primary savelnk fltrgt btn"><i
				class="icon icon-save mgnrgt5 mgntp2"></i>Save </a>

			<button type="button" class="btn btn-default cancelact fltrgt btn"
				data-toggle="modal" data-target=".bs-example-modal-md">
				<i class="icon icon-remove mgnrgt5 mgntp2"></i><i
					class="fa fa-times cancel"></i>Cancel
			</button>


			<span class="fltrgt mgnrgt10 mgntp5 fnt14 fntbld text-center clrblue">
				Changes not saved</span>
		</div>
	</div>



<?php 
	$viewPagefields= VIEW_PAGE_FIELD_NAMES;
	$standardFields = VIEW_PAGE_FIELD_NAMES;
?>


<?php 
	
	

if(!isEmployeeSet() && $cases->caseCustomerId != $_SESSION['customerId']){
		echo "Ticket Not Found";exit;
}else{
	?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="blog-item-wrap">

				<div class="post-inner-content ticket-view-page">

					<div class="entry-content">
						<div class="formsectionpd">
							<div class="formlft" style="font-size: 24px; width: 80%;">
							
								<b><?php 
									if(strlen($cases->caseSummary) > 200) {
										echo('#'.$cases->caseNumber.' - '.substr($cases->caseSummary, 0, 200).'...');
									}else{
										echo('#'.$cases->caseNumber.' - '.$cases->caseSummary);
									}
								?></b>
							</div>
                            <?php  // if($cases->caseStatus!="Closed" & 1==2){ ?> 
                            
							
						<?php 
						//If open then we show button to edit & mark as closed, if closed we show a reopen button
						if($cases->caseStatus == CLOSED_STATUS_NAME) {
							echo '
									<div class="formrgt" style="width: 20%;">
										<a class="btn btn-primary btn-default" id="reopenBtn" style="float: right;margin-bottom:0px;">Reopen This '.OBJECT_NAME.'</a>
									</div>
								</div>
							';
						}else{
							echo '
									<div class="formrgt" style="width: 20%;">
										<a class="btn btn-primary btn-default" style="float: right;margin-bottom:0px;" href="'.$edit_case_url.'?id='.$_REQUEST['id'].'">Edit '.OBJECT_NAME.'</a>
										<a class="btn btn-primary btn-default" id="closeBtn" style="float: left;margin-bottom:0px;margin-left:25%;">Mark as Closed</a>
									</div>
								</div>
							';
						}
						echo '
							<div id="success_msg">'.$response_msg.'</div>
							<div class="bg-color">
						';
						foreach($viewPagefields as $field){
							$styleClass = "col-sm-6";
							$clearFix = false;
							if($field == "Case #"){
								$filedValue =  $cases->caseNumber;
								
							}else if($field == "Type"){
								$filedValue =  $cases->caseType;
							
							}else if($field == "Status"){
								$filedValue =  $cases->caseStatus;
							
							}else if($field == "Priority"){
								$filedValue =  $cases->casePriority;
							
							}else if($field == "Summary"){
								$filedValue =  $cases->caseSummary;
								$clearFix = true;
								$styleClass = "col-sm-12";
							
							}else if($field == "Description"){
								$filedValue =  "<textare style='white-space: pre-wrap'>$cases->description</textarea>";
								$clearFix = true;
								$styleClass = "col-sm-12";
							
							}else if($field == "Customer"){
								$filedValue =  $cases->caseCustomer;
							
							}else if($field == "Contact"){
								$filedValue =  $cases->caseContact;
							
							}else if($field == "Source"){
								$filedValue =  $cases->caseSourceName;
								$clearFix = true;
							
							}
							?>
							<div class="<?php echo $styleClass;?>">
								<div class="form-group">
									<label class="control-label"><font><?php echo $field;?></font><font class=""></font></label>
									<div class="vwfrmcnt">
										<div class="viewval1"><?php echo $filedValue; ?></div>
									</div>
								</div>
							</div>
							<?php 
							if($clearFix) echo '<div class="clearfix"></div>';
						}
						
						?>
							
                        
                        <div class="col-sm-6">
								<div class="form-group">
									<label class="control-label"><font>Created On</font><font
										class=""></font></label>
									<div class="vwfrmcnt">
										<div class="viewval1"><?php echo date('M d, Y g:i a',strtotime($cases->creationDate.' -12 hours -30 minutes')).' PT by '.$cases->createdByName; ?></div>
									</div>

									<div class="editval" style="">
										<input type="text" class="form-control input-sm"
											placeholder="MM/DD">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label"><font>Modified On</font><font
										class=""></font></label>
									<div class="vwfrmcnt">
										<div class="viewval1"><?php echo date('M d, Y g:ia',strtotime($cases->lastUpdateDate.' -12 hours -30 minutes')).' PT by '.$cases->lastUpdatedByName; ?></div>
									</div>
									<div class="editval" style="">
										<input type="text" class="form-control input-sm"
											placeholder="MM/DD">
									</div>

								</div>
							</div>
						</div>
                        
                        <?php if(isset($cases->dateResolved)){ ?>
                        <div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Date Resolved</font><font
									class=""></font></label>
								<div class="vwfrmcnt">
									<div class="viewval1"><?php echo $cases->dateResolved; ?></div>
								</div>

							</div>
						</div>
                        <?php } ?>
                        </div>
					
                        <?php
                  
                        $isNoteAndAttachmentVisible = false;
                     	  if(!isEmployeeSet()) {
                        	$username=$_SESSION['contactName'];
                        	    
                        	if($username == $cases->caseContact) {
                     	   		$isNoteAndAttachmentVisible = true;
                     	   	}
                     	   } else {
                     	   	$isNoteAndAttachmentVisible = true;
                     	   } 
                   	
                     	 
                     	   if($isNoteAndAttachmentVisible){
                        ?>
						<div class="entry-content btm-attach" id="attachList">
							<h4 class="entry-title">Attachments</h4>
							<div id="attachLoad">
								<img src="/wp-content/plugins/apptivo-portal/images/ajax-loader.gif" alt="loading_img" style="padding-bottom:10px">
							</div>
                        </div>
                        <?php //if($cases->caseStatus!="Resolved"){ ?>
                        <div class="entry-content btm-attach uploadCon">
                        <?php
                        	echo '<form name="upload_form" method="post" enctype="multipart/form-data" action="' . $_SERVER ['REQUEST_URI'] . '">';
                        	echo '<div class="formsection pad0"><div class="formlft" style="padding-top:5px;">';
                        	echo '<input name="image" type="file"></div>';
                        	echo '<div class="formrgt">';
                        	echo '<button class="btn btn-primary" type="submit" value="Attach File" name="submit">Attach File</button>';
                        	echo '</div></div>';
                        	echo '</form>';
                        ?>
                        </div>
                        <?php //} ?>
                        <!--                     <hr> -->
                        <div class="entry-content btm-attach" id="noteList">
                        	<h4 class="entry-title"><?php echo OBJECT_NAME; ?> History</h4>
							<div id="notesLoad">
								<img src="/wp-content/plugins/apptivo-portal/images/ajax-loader.gif" alt="loading_img" style="padding-bottom:10px">
							</div>
                        </div>
                    	<?php //if($cases->caseStatus!="Resolved"){ ?>
                     	<div class="entry-content viewcase">
							<form name="add_note" action="" method="post" id="add_note">
								<div class="formsection pad0">
									<div class="formlft">
										<h4 class="entry-title">Add a Note</h4>
									</div>
									<div class="formrgt svsubmit">
										<textarea class="required" name="addnotearea" id="addnotearea"
											size="50"></textarea>
									</div>
								</div>
								<div class="formsection">
									<div class="formlft">
										<label><span>&nbsp;</span></label>
									</div>
									<input type="hidden" id="case_id_value" name="case_id_value"
										value="<?php echo $case_id_value; ?>" /> <input type="hidden"
										id="case_name_value" name="case_name_value"
										value="<?php echo $cases->caseNumber; ?>" />
									<div class="formrgt svsubmit" style="float: right">
										<button type="submit" value="Add Comment"
											class="btn btn-primary" name="submit" id="viewbtn">Add Note</button>
									</div>
								</div>
							</form>
						</div>
                    	<?php } ?>
                    </div>
			</div>


		</article>

		</main>
		<!-- #main -->

	</div>
	<!-- #primary -->


<script type="text/javascript">
/*Set action for mark as closed button*/
$('#closeBtn').click(function() {
	$.ajax({ 
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		data: {'action': 'markClosed','caseData':<?php echo json_encode($cases); ?>},			
		type: 'post',
		success: function(data) {
			var url = window.location.href;  
			url += '&updated=true'
			window.location.href = url;
		}
	});	
});
//Same action for reopen button
$('#reopenBtn').click(function() {
	$.ajax({ 
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		data: {'action': 'reopen','caseData':<?php echo json_encode($cases); ?>},			
		type: 'post',
		success: function(data) {
			var url = window.location.href;  
			url += '&updated=true'
			window.location.href = url;
		}
	});	
});

/*lazy load attachments and notes to improve performance */
$(document).ready(function() {
	//Get Attachments
	$.ajax({ 
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		data: {'action': 'getAttachments','id':<?php echo $cases->caseId; ?>},				
		type: 'post',
		success: function(data) {
			var list = JSON.parse(data);
			if(list.count != 0){
				var documents = [];
				$('#attachLoad').hide();
				jQuery.each( list.results, function( i, curResult ) {
				  $('#attachList').append('<div class="formsectionn1"><div class="notesec1"><div class="noteseclft"><a href="javascript:void(0);" onclick="downloadUrl('+curResult.documentId+')">'+curResult.documentName+' </a></div></div></div>');
				 });
			}else{		
				$('#attachLoad').hide();	
				$('#attachList').append('<div class="formsectionn"><div class="notesec">No Attachments Added Yet</div></div>');
			}		
			
		}
	});	
	
	//Get Notes
	$.ajax({ 
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		data: {'action': 'getNotes','id':<?php echo $cases->caseId; ?>},				
		type: 'post',
		success: function(data) {
			var list = JSON.parse(data);
			if(list.wallEntries.count != 0){
				var documents = [];		
				$('#notesLoad').hide();
				var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
				jQuery.each( list.wallEntries, function( i, curResult ) {
					var dateObj = new Date(curResult.datePosted);
					if(dateObj.getHours() == 0) {
						var hourStr = 12;
						var merStr = 'am';
					}else if(dateObj.getHours() > 12) {
						var hourStr = dateObj.getHours()-12;
						var merStr = 'pm';
					}else{
						var hourStr = dateObj.getHours();
						var merStr = 'am';
					}
					var dateStr = months[dateObj.getMonth()]+' '+dateObj.getDay()+', '+dateObj.getFullYear()+' '+hourStr+':'+dateObj.getMinutes()+' '+merStr+' PT';
					var noteTextCollab = JSON.parse(curResult.collabObjectJSON);
					if(noteTextCollab && noteTextCollab.noteText) {
						$('#noteList').append('<div class="formsectionn"><div class="notesec"><div class="noteseclft">Updated by '+curResult.postingObjectRefName+'</div><div class="notesecrgt">'+dateStr+'</div></div><div class="noteseccnt">'+noteTextCollab.noteText+'</div></div>');
					}
				});
			}
			//Even if we have no news feed events yet, we'll always display the created date last
			$('#noteList').append('<div class="formsectionn" style="padding-bottom:40px;"><div class="notesec"><div class="noteseclft">Created by <?php echo $cases->createdByName; ?></div><div class="notesecrgt"><?php echo date('M d, Y g:i a',strtotime($cases->creationDate.' -12 hours -30 minutes')); ?> PT</div></div></div>');
		}
	});	
});
</script>


<?php

}
	}
}
?>