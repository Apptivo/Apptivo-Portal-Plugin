<?php
if (session_id () == '' || ! isset ( $_SESSION )) {
	session_start ();
}
/*
 * List All Cases
 */
require_once ('config.php');
function ticket_list($params) {
	require_once ('class.apptivo.php');
	$apptivoApi = new apptivoApi(APPTIVO_API_KEY, APPTIVO_ACCESS_KEY, API_USER_EMAIL);
	$emailId = getUserEmail();
	$caseIds = array();
	if('Y' == ENABLE_SPLAH_SCREEN){
		echo "<h2><p style='text-align: center; white-space: pre-wrap'>Welcome to the Apptivo Client Portal!

This is a temporary holding page.

If you have any issues please contact Apptivo Services.</p></h2>";
	
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.titlebg').hide();
		
	});
	</script>
	<?php }else{
	if ($emailId == '') {
		echo "Please Login and continue..";
	} else {
		if (!empty ($_POST) && isset($_POST['submit']) && $_POST['submit'] == 'Search'){
			$_SESSION['search_flag']="true";
		}
		if (!empty ($_POST) && isset($_POST ['case_ids_string'])) {
			$sessionKey = getSessionKey ();
			$caseIds = $_POST ['case_ids_string'];
			if ($caseIds != '') {
				$params = getBulkExportParams($caseIds);
				$response = exportCases($params);
				if ($response != '') {
					error_log(print_r($response,true));
					exit ();
				}
			}
		}
		$myCases = getCases($params);
		$myCaseList = $myCases->data;	
		$view_case_url = esc_url ( get_permalink ( get_page_by_title ( OBJECT_NAME.' Overview' ) ) );
		$edit_case_url = esc_url ( get_permalink ( get_page_by_title ( 'Edit '.OBJECT_NAME ) ) );
		$my_case_url=esc_url( get_permalink( get_page_by_title( 'My Open '.OBJECT_NAME_PLURAL ) ) );
		?>
<?php //get_sidebar('sidebar2');?>

<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">


 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 
 	

	
<script type="text/javascript"
	src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

	    <script type="text/javascript"
	src="https://cdn.datatables.net/buttons/1.1.1/js/dataTables.buttons.min.js"></script> 
 

	<script type="text/javascript"
	src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<script>


		
	function initCaseTable(){

		var vT = jQuery('#mycaseslist').dataTable({
  		  dom: 'Brtip',
          "aaSorting":[],
          "stateSave": true,
          "iDisplayLength": 25,
          buttons:[
       				{
       		            text: 'Export',
       		            action: function ( e, dt, node, config ) {

								$("#export_form").submit();
								//$("#exportSubmit").click();
       		                
       		            }
       		        }
                   ],
	         	"oLanguage": {
		          		"sEmptyTable":  "No <?php echo OBJECT_NAME_PLURAL; ?> Found"
		      		 }
      });
	  return vT;

	}

	function home_page(){
		var url=window.location.href;
		//alert(url);
		$.ajax({
			type: 'POST',
		    url:'<?php echo admin_url('admin-ajax.php'); ?>',
		    data: {'action':'view_back_url',"url":url}
		    
		    
		});
		}

		function initContactTable(){

			var contT = jQuery('#contact_table').dataTable({
			   dom: 'rtip',
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
			 jQuery('#case_contact_value').val(contparts[1]);
			 jQuery('#cont_id').val(contparts[0]);
			 jQuery('#case_contact_key').val(contparts[0]);
			 //jQuery('#contactModal').hide();
			
		}


	
    jQuery(document).ready(function() {


    	jQuery("#advance-search").keypress(function (e) {
//     		alert("I'm also getting called");
    		 var key = e.which;
			 if(key == 13)  // the enter key code
			  {
				 
				 $("#simple_search").val($("#advance-search").val());
			    $('#advanceSearch').click();
			    return false;  
			  }
		});   
	
        

    	jQuery('#suppreq').hide();
    	jQuery('#servreq').hide();
    	jQuery('#incidenttype').hide();
    	  
    	var dTable = initCaseTable();
    	$(".clickable-row").click(function() {
    	        window.document.location = $(this).data("href");
    	});  
        $('.siconckz').on('click',function(){
        	   $(".aside").show();
        	   $(".aside").css("top","195px");
        	 });

        	$('.close').click(function(){
        	 $(".aside").hide();
        	});
       
			//reason for comment : for the following issue ->click on action it shows side_panel after that loads caseoverview
        	/*$('table#mycaseslist tr td').on('click',function(){
        		var id = $(this).closest('tr').attr('id');
        		$.ajax({
        			type: 'POST',
        		     url: '<?php echo admin_url('admin-ajax.php'); ?>',
        		     data:{'action':'view_case_sidepanel',"caseId":id},
        		     success:function(response){
        		    	 $("#viewcase_aside").html(response);
        		    	 	     
        		     }
        		});
        		$(".aside1").show();
			});*/
			$('table#mycaseslist tr td').on('click',function(){
        		var id = $(this).closest('tr').attr('id');
				window.location = $(this).find('a').attr('/<?php echo strtolower(OBJECT_NAME); ?>-overview/?id='+id);
			}).hover( function() {
				$(this).toggleClass('hover');
			});
        	$('#advanceSearch1').click(function(){ 
        			   var caseStatus=jQuery("#case_status_value").val();
        			   var casestatusId=jQuery("#case_status_key").val();
        			   var caseType=jQuery("#case_type_value").val(); 
        			   var casetypeId=jQuery("#case_type_key").val();
        	           var casePriority=jQuery("#case_priority_value").val();
        	           var casepriorityId=jQuery("#case_priority_key").val();
        	           var subject=jQuery("#case_summary_value").val();
        	           var desc=jQuery("#description").val();
        	           
        	           $('#loadimage1').show();

        			    	 $.ajax(
        			    	            {
        			    	                type: 'POST',
        			    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
        			    	                data: {'action':'search_ticket',"typeId":casetypeId,"statusId":casestatusId,"priorityId":casepriorityId,"solutionId":casesolutionId,"solution_value":caseSolution,"severityId":caseseverityId,"severity_value":caseSeverity,"payversionId":payversionId,"payversion_value":payVersion,"paycriticalId":paycriticalId,"paycritical_value":payCritical,"subject":subject,"description":desc,"emailid":email},
        			    	                success: function(response)	
        			    	                { 
        				    	                if(response!=''){
    				    	                		dTable.fnDestroy();
    												$("#mycaseslist").html(response);

    												dTable = initCaseTable();
        												
        												$('.titlebg').html("<h4>Search Results</h4>");
        												$("#status_select").val("");
        												$("#type_select").val("");
        												$("#priority_select").val("");
        												$("#summary").val("");
        												$("#description").val("");
        												$("#adv_search").hide();
        												$('#loadimage1').hide();
        												
        				    	                	      }
        				    	                else
        				    	                {
        				    	                	alert("Sorry, something went wrong.  Try again or contact an admin."); 	
        				    	                }   
        			    	                }
        			    	                
        										    	               
        			    	            });
        			    	                
        			    
        				
        	});

        	$('input[name=summary]').keyup(function() {
        	    var dsum = this.value;
        	    jQuery("#case_summary_value").val(dsum);
        	    
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


        	        jQuery("#contact").change(function () {
        	            jQuery("#case_contact_value").val(jQuery("#contact option:selected").text());
        	            jQuery("#case_contact_key").val(jQuery("#contact option:selected").val());
        	        });
        	    	var contTable = initContactTable();
        	    	jQuery("#contact_srch").click(function (e) {

        	    		e.preventDefault();
        	    		
        	    		var contact = jQuery('#contact_text').val();
        	    		 var customerId = jQuery('#cust_id').val();
        	    		 $.ajax({
								type: 'POST',
								url:'<?php echo admin_url('admin-ajax.php'); ?>',
								data:{'action':'search_contact1',"contact_name":contact,"customer_id":customerId},
								success: function(response){
									contTable.fnDestroy();
									$("#contact_table").html(response);
							   
									contTable = initContactTable();
									
									}	
						});
        	    	});		        
    });
</script>

	
<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="blog-item-wrap">
			<a href="<?php the_permalink(); ?>"
				title="<?php the_title_attribute(); ?>">
			 	<?php the_post_thumbnail( 'sparkling-featured', array( 'class' => 'single-featured' )); ?>
			</a>
			<div class="post-inner-content">


				<div class="entry-content ">
					<div class="pull-right mrg30p adv-srch">
						<section class="advsrchbginpnew posrel">
							<block class="deleteicon"> <input type="text"
								class="advsearchinput1 bxsdw fltlft brdnone" id="advance-search"
								placeholder="search"> <block> <span title="Advanced Search"
								data-placement="bottom" data-toggle="tooltip"
								class="fltlft siconckz advsrh advarrow "><i
								class="fa fa-chevron-down"></i> </span>
						
						</section>
					</div>
					<div class="contnr">
						<table id="mycaseslist" class="table table-striped table-bordered"
							cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="7%"><?php echo OBJECT_NAME; ?> #</th>
									<th width="10%">Status</th>
									<th width="10%">Type</th>
									<th width="10%">Priority</th>
									<th width="10%">Contact</th>
									<th width="68%">Summary</th>
								</tr>
							</thead>

							<tbody>
                                <?php
                               
                          
                                
		if (is_array ( $myCaseList )) {
			foreach ( $myCaseList as $key => $myCase ) {
				$caseIds[] = $myCase->caseId;
				echo '<tr id="' . $myCase->caseId . '" class="clickable-row" data-href="'.$view_case_url . '?id=' . $myCase->caseId .'" onclick="home_page();">
                                        <td>' . $myCase->caseNumber . '</td>
                                        <td>' . $myCase->caseStatus . '</td>
                                        <td>' . $myCase->caseType . '</td>
                                        <td>' . $myCase->casePriority . '</td>
                                        <td>' . $myCase->caseContact . '</td>
                                        <td>' . $myCase->caseSummary . '</td>
                                        </tr>';
			}
		}
                          	
                                
		?>        
                                </tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</article>

	</main>
	<!-- #main -->

</div>




  <div class="aside1 col-sm-6 pd0 ng-scope right am-fade-and-slide-right"
	id="viewcase_aside">
	
	<div class="aside-body">
		<div class="panels">
	
			
			
			


</div>
</div>
</div>

<div class="aside col-sm-6 pd0 ng-scope right am-fade-and-slide-right"
	id="adv_search">

	<div class="aside-header mnbtngroup">
		<div class="btn-group btn-group-sm pull-right pad05 brdrgt">


			<button type="button" class="btn btn-default close"
				data-toggle="tooltip" data-placement="bottom" title="close">
				<i class="fa fa-times"></i>
			</button>
		</div>

		<h4 class="aside-title forallmore">Advanced Search</h4>
	</div>
	<div class="aside-body">
		<div class="panels">
			<h4 class=""><?php echo OBJECT_NAME; ?> Details</h4>


<!-- 			<form id="single_column_layout" method="post" action="" name="" novalidate="novalidate"> -->
				<div class="bg-color asidefrm">

					<div class="awformmain awp_contactform_maindiv"><?php
		/* Getting Apptivo's Weblayout From API calls */
		// $AJPFields = getAllCasesLayoutData1();
		$search_fields = array (
				"case#",
				"type",
				"status",
				"priority",
				"contact",
				"casesource",
				"summary"
		);
		$AJPFields = getCaseConfigData();
		
		if (isset ( $AJPFields )) {
			$apptivoFields = json_decode ( $AJPFields->webLayout );
			$apptivoFieldsDisplay = display_cases_fields1 ( $apptivoFields );
			$getAllCasesConfigData = getLeadConfigData(); 
			$apptivoCasesData = ajp_cases_data1 ( $getAllCasesConfigData, $AJPFields->statuses, $AJPFields->priorities, $AJPFields->types ); 
			$apptivoCasesData = json_decode ( $apptivoCasesData, true );
		}
		if (is_array ( $apptivoFieldsDisplay )) {
			echo "<div id='success_msg'>$response_msg</div>";
			echo '<form name="" action="'.PORTAL_SEARCHCASES_URL.'" method="post" id="single_column_layout" enctype="multipart/form-data" >';
			echo '<div class="awformmain awp_contactform_maindiv">';
			foreach ( $apptivoFieldsDisplay as $key => $value1 ) { 
				if (is_array ( $value1 )) {
					foreach ( $value1 as $key1 => $value ) {
						if ( $value ['field_id'] == 'ticket#' ||$value ['field_id'] == 'type' || $value ['field_id'] == 'status' || $value ['field_id'] == 'contact' || $value ['field_id'] == 'priority'  || $value ['field_id'] == 'solution'  || $value ['field_id'] == 'severity' || $value ['field_id'] == 'apptivoportalpayversion'  || $value ['field_id'] == 'yourcurrentapptivoportalpayversion'  || $value ['field_id'] == 'yourcurrentapptivoportalpaycriticalpatch' ||$value ['field_id'] == 'ticketsource' || $value ['field_id'] == 'supportrequesttype' || $value ['field_id'] == 'incidenttype' || $value ['field_id'] == 'servicerequesttype'  || $value ['field_id'] == 'sub-status'  ) {
							if (in_array ( strcmp ( $value ['field_id'], "status" ) == 0, $search_fields )) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value1 [$key1] ['field_name'] . '</label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value1 [$key1] ['field_id'] . '_select', get_caseValues1 ( $type = 'caseStatus', $apptivoCasesData ), $caseStatus, $value ['field_id'] . '_select' , '');
								echo '</div></div></div>';
							}
							if (in_array ( strcmp ( $value ['tag_name'], "caseType" ) == 0, $search_fields )) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value1 [$key1] ['field_name'] . '</label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value1 [$key1] ['field_id'] . '_select', get_caseValues1 ( $type = 'caseType', $apptivoCasesData ), $caseType, $value ['field_id'] . '_select' , '');
								echo '</div></div></div>';
							}
							if (in_array ( strcmp ( $value ['field_id'], "priority" ) == 0, $search_fields )) {
								echo '<div class="col-sm-6"><div class="form-group">';
								echo '<label>' . $value ['field_name'] . '</label>';
								echo '<div class="vwfrmcnt">';
								echo create1 ( 'option', $value ['field_id'] . '_select', get_caseValues1 ( $type = 'casePriority', $apptivoCasesData ), $casePriority, $value ['field_id'] . '_select' , '');
								echo '</div></div></div>';
							}
						}
						if( strcmp ( $value ['field_id'], "contact" ) == 0 ){
							$_SESSION ['contact']=$value;
						}
						if( strcmp ( $value ['field_id'], "subject" ) == 0 || strcmp ( $value ['field_id'], "summary" ) == 0){	
							$_SESSION ['subject']=$value;
						}
						if( strcmp ( $value ['field_id'], "description" ) == 0 ){
							$_SESSION ['desc']=$value;
						}
						if( strcmp ( $value ['field_id'], OBJECT_NAME." #" ) == 0 ){
							
							$_SESSION ['caseNumber']=$value;
						}
					}
				}
			}
			$value = $_SESSION ['subject'];
			if (strcmp ( $value ['field_type'], "input" ) == 0) {
				if (in_array ( strcmp ( $value ['field_id'], "subject" ) == 0 || strcmp ( $value ['field_id'], "summary" ) == 0 , $search_fields )) {
					$field_type_val = 'text';
					echo '<div class="col-sm-12"><div class="form-group">';
					echo '<label>' . $value ['field_name'] . $required . '</label>';
					?>
                                             <div class="vwfrmcnt">
		<input class="form-control <?php echo $field_id; ?>"
			type="<?php echo $field_type_val; ?>"
			id="<?php echo $value['field_id']; ?>"
			name="<?php echo $value['field_id']; ?>" size="5"
			value="<?php echo $value_data; ?>" />
	</div>
</div>
</div><?php
				}
				$value = $_SESSION ['caseNumber'];
				if (in_array ( strcmp ( $value ['field_id'], "ticket#" ) == 0  , $search_fields )) {
				
					$field_type_val = 'text';
					echo '<div class="col-sm-6"><div class="form-group">';
					echo '<label>' . $value ['field_name'] . $required . '</label>';
					?>
                                             <div class="vwfrmcnt">
		<input class="form-control <?php echo $field_id; ?>"
			type="<?php echo $field_type_val; ?>"
			id="<?php echo $value['field_id']; ?>"
			name="<?php echo $value['field_id']; ?>" size="5"
			value="<?php echo $value_data; ?>" />
	</div>
</div>
</div><?php
				}
				
			
				
			}
				$value=$_SESSION ['contact'];
				if (in_array ( strcmp ( $value ['field_id'], "contact" ) == 0 || strcmp ( $value ['field_id'], "contact" ) == 0 , $search_fields )) {	
					echo '<div class="col-sm-6"><div class="form-group">';
					echo '<label>' . $value ['field_name'] . $required . '</label>';
					?>
				                                             <div class="vwfrmcnt">
						<select class="form-control  <?php echo $field_id; ?>"
							
							id="<?php echo $value['field_id']; ?>"
							name="<?php echo $value['field_id']; ?>" >
							<option>Select One</option>
							<?php 
							$searchData = Array(
								'accountName' => urlencode($_SESSION['customerName']),
								'accountId' => $_SESSION['customerId']
							);
							$contactDetails = $apptivoApi->getAllByAdvancedSearch('contacts',json_encode($searchData));
							po1($contactDetails);
							$contacts = $contactDetails->data;
							po1($contacts);
							if(is_array($contacts)) {
								foreach($contacts as $contact){
									echo '<option value="'.$contact->contactId.'"> '.$contact->firstName." ".$contact->lastName.' </option>';
								}
							}
							?>
							</select>
						
					</div>
				</div>
				</div><?php
								}
								
							}
			
			$value=$_SESSION ['desc'];
			if (strcmp($value['field_type'], "textarea") == 0) {
                                        if( $value['field_id']=="description"){
                                        $fieldid=$value['field_id'];
                                        echo '<div class="col-sm-12"><div class="form-group">';
                                        echo '<label>' . $value['field_name'] . '</label>';
                                        echo '<div class="vwfrmcnt">';
                                        echo '<textarea  name="' . $fieldid . '" id="' . $fieldid . '" size="50" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 177px;"></textarea>';
                                        echo '</div></div></div>';
                                        }
                                    } 
			
			?>
</div>
</div>
</div>
<div class="col-sm-offset-6 col-sm-6 text-right createcase-btn pad0">
	<span style="display: none;" id="loadimage1"><img
		src="https://apptivoapp.cachefly.net/site/v1.0.5/images/aloading.gif"
		style="padding:5px 0px 10px"></span><input
		type="submit" value="Search" name="submit" id="advanceSearch"
		class="btn btn-primary">
</div>

<?php 

echo '<input type="hidden" id="case_status_value" name="case_status_value" value="' . $caseStatus . '"/>
	      <input type="hidden" id="case_status_key" name="case_status_key" value="' . $caseStatus_id . '"/>
	      <input type="hidden" id="case_type_value" name="case_type_value" value="' . $caseType . '"/>
	      <input type="hidden" id="case_type_key" name="case_type_key" value="' . $caseType_id . '"/>
	      <input type="hidden" id="case_priority_value" name="case_priority_value" value="' . $casePriority . '"/>
	      <input type="hidden" id="case_priority_key" name="case_priority_key" value="' . $casePriority_id . '"/>
	       <input type="hidden" id="case_solution_value" name="case_solution_value" value="' . $caseSolution . '"/>
	      <input type="hidden" id="case_solution_key" name="case_solution_key" value="' . $caseSolution_id . '"/>
	       
	      <input type="hidden" id="case_substatus_key" name="case_substatus_key" value="' . $caseSubstatus_id . '"/>
	        <input type="hidden" id="case_substatus_value" name="case_substatus_value" value="' . $caseSubstatus_value . '"/>
	      <input type="hidden" id="case_apenvironment_key" name="case_apenvironmen_key" value="' . $caseAPenvironment_id . '"/>
	        <input type="hidden" id="case_apenvironment_value" name="case_apenvironmen_value" value="' . $caseAPenvironment_value . '"/>
	        <input type="hidden" id="case_suppreqtype_key" name="case_suppreqtype_key" value="' . $caseSuppreqtype_id . '"/>
	        <input type="hidden" id="case_suppreqtype_value" name="case_suppreqtype_value" value="' . $caseSuppreqtype_value . '"/>
	        
	        <input type="hidden" id="case_servreqtype_key" name="case_servreqtype_key" value="' . $caseServreqtype_id . '"/>
	        <input type="hidden" id="case_servreqtype_value" name="case_servreqtype_value" value="' . $caseServreqtype_value . '"/>
	        
	        <input type="hidden" id="case_incireqtype_key" name="case_incireqtype_key" value="' . $caseIncireqtype_id . '"/>
	        <input type="hidden" id="case_incireqtype_value" name="case_incireqtype_value" value="' . $caseIncireqtype_value . '"/>
	      
	      
	      <input type="hidden" id="case_contact_value" name="case_contact_value" />
	      <input type="hidden" id="case_contact_key" name="case_contact_key" />
	      
	      <input type="hidden" id="case_employee_id" name="case_employee_id" value="' . $employeId_user . '"/>
              <input type="hidden" id="case_severity_value" name="case_severity_value" value="' . $caseSeverity . '"/>
	      <input type="hidden" id="case_severity_key" name="case_severity_key" value="' . $caseSeverityId . '"/>
              <input type="hidden" id="case_payversion_value" name="case_payversion_value" value="' . $casePayVersion . '"/>
	      <input type="hidden" id="case_payversion_key" name="case_payversion_key" value="' . $casePayVersionId. '"/>
              <input type="hidden" id="case_paycritical_value" name="case_paycritical_value" value="' . $casePayCritical . '"/>
	      <input type="hidden" id="case_paycritical_key" name="case_paycritical_key" value="' . $casePayCriticalId. '"/>
	      	      <input type="hidden" id="case_email_value" name="case_email_value" value=""/>
	      	       <input type="hidden" name="cust_id" id="cust_id">  
	      <input type="hidden" name="cont_id" id="cont_id">
	      <input type="hidden" name="simple_search" id="simple_search">
	   
	   
              <input type="hidden" id="case_summary_value" name="case_summary_value" value=""/>';

			  

			


?>

</form>

</div>

<?php

		$caseIdscsv = implode(',', $caseIds);
		echo "<form id='export_form' method='post' action='/custportal/index.php/downloads/data.csv'>";
		echo "<input type='hidden' id='case_ids_string' name='case_ids_string' value='" . $caseIdscsv. "'/>";
		echo "</form>'";
		
	}
	
	}
}
?>