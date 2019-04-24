<?php
if(session_id() == '' || !isset($_SESSION)) { session_start(); }
/*
 * List All Cases
 */
require_once('config.php');
function listCases_form(){
	
	echo "listcases entered.. exiting ";exit;
	
//print_r($_SESSION);
$emailId = $_SESSION['user']['email'];
$sessionKey=$_SESSION['sessionKey'];
//$employeId = get_employeeId_by_email($emailId);
$customerId=$_SESSION['customerId'];
$myCases = get_all_tickets($customerId);
$myCaseList = $myCases->data;
//echo '<pre>'; print_r($myCases->data);echo '</pre>';
if($emailId==''){
    
    echo "Please Login and continue..";
}else{
    $view_case_url=esc_url( get_permalink( get_page_by_title( OBJECT_NAME.' Overview') ) );
    $edit_case_url=esc_url( get_permalink( get_page_by_title( 'Edit '.OBJECT_NAME ) ) );
?>
<?php //get_sidebar('sidebar2');?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#mycaseslist').dataTable({
            "aaSorting":[]
        });
        $('.siconckz').on('click',function(){
        	   $(".aside").show();
        	   $(".aside").css("top","195px");
        	 });

        	$('.close').click(function(){
        	 $(".aside").hide();
        	});
        	  
        	$('.maintgle').on('click',function(){

        	 $('body').toggleClass('toggles');

        	});

        	$('#advanceSearch').click(function(){ 
        		//alert("hai");
        			   var caseStatus=jQuery("#case_status_value").val();
        			   var casestatusId=jQuery("#case_status_key").val();
        			   var caseType=jQuery("#case_type_value").val(); 
        			   var casetypeId=jQuery("#case_type_key").val();
        	           var casePriority=jQuery("#case_priority_value").val();
        	           var casepriorityId=jQuery("#case_priority_key").val();
        	           var caseSolution=jQuery("#case_solution_value").val();
        	           var casesolutionId=jQuery("#case_solution_key").val();
        	           var caseSeverity=jQuery("#case_severity_value").val();
        	           var caseseverityId=jQuery("#case_severity_key").val();
        	           var payVersion=jQuery("#case_payversion_value").val();
        	           var payversionId=jQuery("#case_payversion_key").val();
        	           var payCritical=jQuery("#case_paycritical_value").val();
        	           var paycriticalId=jQuery("#case_paycritical_key").val();
        	           var subject=jQuery("#case_subject_value").val();
        	           

        			    	 $.ajax(
        			    	            {
        			    	                type: 'POST',
        			    	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
        			    	                data: {'action':'search_ticket',"typeId":casetypeId,"statusId":casestatusId,"priorityId":casepriorityId,"solutionId":casesolutionId,"solution_value":caseSolution,"severityId":caseseverityId,"severity_value":caseSeverity,"payversionId":payversionId,"payversion_value":payVersion,"paycriticalId":paycriticalId,"paycritical_value":payCritical,"subject":subject},
        			    	                success: function(response)	
        			    	                { 
        				    	                if(response!=''){
        												$("#mycaseslist").html(response);
        												$("#adv_search").hide();
        												
        				    	                	      }
        				    	                else
        				    	                {
        				    	                	alert("sorry"); 	
        				    	                }   
        			    	                }
        			    	                
        										    	               
        			    	            });
        			    	                
        			    
        				
        	});

        	$('input[name=subject]').keyup(function() {
        	    var dInput = this.value;
        	    jQuery("#case_subject_value").val(dInput);
        	    
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

        	        jQuery("#solution_select").change(function () {
        	            jQuery("#case_solution_value").val(jQuery("#solution_select option:selected").text());
        	            jQuery("#case_solution_key").val(jQuery("#solution_select option:selected").val());
        	        });
        	        jQuery("#yourcurrentapptivoportalpayversion_select").change(function () {
        	            jQuery("#case_payversion_value").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").text());
        	            jQuery("#case_payversion_key").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").val());
        	        });
        	        jQuery("#yourcurrentapptivoportalpaycriticalpatch_select").change(function () {
        	            jQuery("#case_paycritical_value").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").text());
        	            jQuery("#case_paycritical_key").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").val());
        	        });
        	        
        	        jQuery("#case_severity_value").val(jQuery("#severity_select option:selected").text());
        	        jQuery("#case_severity_key").val(jQuery("#severity_select option:selected").val());
        	        jQuery("#case_payversion_value").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").text());
        	        jQuery("#case_payversion_key").val(jQuery("#yourcurrentapptivoportalpayversion_select option:selected").val());
        	        jQuery("#case_paycritical_value").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").text());
        	        jQuery("#case_paycritical_key").val(jQuery("#yourcurrentapptivoportalpaycriticalpatch_select option:selected").val());
       
    });
</script>
  <div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-item-wrap">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
			 	<?php the_post_thumbnail( 'sparkling-featured', array( 'class' => 'single-featured' )); ?>
			</a>
		<div class="post-inner-content">
			

			<div class="entry-content ">
                            <div class="pull-right mrg30p adv-srch">

<section class="advsrchbginpnew posrel">
              <block class="deleteicon">
                <input type="text" class="advsearchinput1 bxsdw fltlft brdnone" id="advance-search" placeholder="search">
                <block></block>
              </block>
              <span title="Advanced Search" data-placement="bottom" data-toggle="tooltip" class="fltlft siconckz advsrh advarrow "><i class="fa fa-chevron-down"></i> </span> </section>


    </div>
			<div class="contnr">
                            <table id="mycaseslist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Case #</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Priority</th>
                                        <th>Summary</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                if (is_array($myCaseList)) {
                                foreach ($myCaseList as $key => $myCase) { 
                                    echo '<tr id="'.$myCase->caseId.'">
                                        <td>'.$myCase->caseNumber.'</td>
                                        <td>'.$myCase->caseStatus.'</td>
                                        <td>'.$myCase->caseType.'</td>
                                        <td>'.$myCase->casePriority.'</td>
                                        <td>'.$myCase->caseSummary.'</td>
                                        <td><a class="vieww" href="'.$view_case_url.'?id='.$myCase->caseId.'"></a></td>
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

    </main><!-- #main -->

  </div><!-- #primary -->
   <div class="aside col-sm-6 pd0 ng-scope right am-fade-and-slide-right" id="adv_search">
  
  <div class="aside-header mnbtngroup">
    <div class="btn-group btn-group-sm pull-right pad05 brdrgt">
    
     
      <button type="button" class="btn btn-default close" data-toggle="tooltip" data-placement="bottom" title="close"><i class="fa fa-times"></i></button>
    </div>
   
    <h4 class="aside-title forallmore">Advanced Search</h4>
  </div>
  <div class="aside-body"> 
    <div class="panels">
      <h4 class="">Ticket Details</h4>
    
<div class="bg-color asidefrm">
             <form id="single_column_layout" method="post" action="" name="" novalidate="novalidate">


                 <div class="awformmain awp_contactform_maindiv"><?php
                     /* Getting Apptivo's Weblayout From API calls */
                        
                        
                        //$AJPFields = getAllCasesLayoutData1();
                        $AJPFields = getAllSupportLayoutData1();
                        //po1($AJPFields);
                        if (isset($AJPFields)) {
                            $apptivoFields = json_decode($AJPFields->webLayout);    //$modelObj->po(json_decode($AJPFields->webLayout));
                            $apptivoFieldsDisplay = display_cases_fields1($apptivoFields);
                            $getAllCasesConfigData = getAllLeadConfigData1(); //po1($AJPFields);
                            $apptivoCasesData = ajp_cases_data1($getAllCasesConfigData, $AJPFields->statuses, $AJPFields->priorities, $AJPFields->types); //$modelObj->po($apptivoCasesData);
                            $apptivoCasesData = json_decode($apptivoCasesData, true);
                        }
                        if (is_array($apptivoFieldsDisplay)) {
                        echo "<div id='success_msg'>$response_msg</div>";
                        echo '<form name="" action="" method="post" id="single_column_layout" enctype="multipart/form-data" >';
                        echo '<div class="awformmain awp_contactform_maindiv">';
                        
                        foreach ($apptivoFieldsDisplay as $key => $value1) { //echo "<pre>";print_r($r);echo "</pre>";exit;
                            if (is_array($value1)) {
                                foreach ($value1 as $key1 => $value) {
                                    //echo "<pre>";print_r($value1);echo "</pre>";
                                    $selectedCustomField = $value['selected_value'];
                                    $selectedRadioField = $value['custom_radio_value'];
                                    $value_data = '';
                                    if (strcmp($value['field_type'], "input") == 0 || strcmp($value['field_type'], "Text box") == 0 || strcmp($value['field_type'], "date") == 0 || strcmp($value['field_type'], "number") == 0 || strcmp($value['field_type'], "currency") == 0 || strcmp($value['field_type'], "check") == 0 || strcmp($value['field_type'], "link") == 0) {
                                        if($value['field_id']!='assignee(s)' && $value['field_id'] != 'case#' && $value['field_id'] != 'paidusers' && $value['field_id'] != 'releasedate' && $value['field_id'] != 'datecommitted') {
					$chkCss = '';
                                        if( $value['field_id'] == 'email') $chkCss = 'style="display:none"';

                                        if( $value['field_id'] == 'modifiedby') $chkCss = 'style="display:none"'; 
                                                                                
                                        if ($value['field_id'] == 'email') {
                                            $field_type_val= 'email';                                            
                                            if(isset($_SESSION['user']['email']))
                                                $value_data = $_SESSION['user']['email'];
                                        } elseif ($value['field_id'] == 'subject' ) {
                                            $field_id = "required";
                                            $required = "<sup><font color=red>*</sup></font>";
                                            $field_type_val= 'text';
                                        } else {
                                            $field_id = "";
                                            $required = "";
                                            $field_type_val= 'text';
                                        }
                                        echo '<div class="col-sm-6" '.$chkCss.'><div class="form-group">';
                                        echo '<label>' . $value['field_name'] . $required . '</label>';
                                        ?>
                                        <div class="vwfrmcnt">
                                            <input class="form-control <?php echo $field_id; ?>" type="<?php echo $field_type_val; ?>" name= "<?php echo $value['field_id']; ?>" size="5" value="<?php echo $value_data; ?>"/>
                                        </div></div></div>

                                        <?php
                                        }
                                    }
                                    
                              if(strcmp($value['field_type'], "select")== 0 && count($value['values'])!=0 && $value['field_type']!=''){ 
                              	//print_r($value1);
                              	
                                  if($value1[$key1]['field_name']=='Severity'){
				echo '<div class="col-sm-6"><div class="form-group">';
                                echo '<label>' . $value1[$key1]['field_name'] . '</label>';
                                echo '<div class="vwfrmcnt">';
                                echo create1('customOption', $value1[$key1]['field_id'] . '_select', get_caseValues1($type='selectCustomFields', $value['values']), $caseStatus, $value['field_id'] . '_select');
                                echo '</div></div></div>';
				echo '<input type="hidden" name='.$value['field_id'].'_value value="'.$selectedCustomField.'" id="custom_select_value">
				      <input type="hidden" name='.$value['field_id'].'_key value="" id="custom_select_key">';
                                  }
                              if($value1[$key1]['field_name']=='Solution' ){
				echo '<div class="col-sm-6"><div class="form-group">';
                                echo '<label>' . $value1[$key1]['field_name'] . '</label>';
                                echo '<div class="vwfrmcnt">';
                                echo create1('customOption', $value1[$key1]['field_id'] . '_select', get_caseValues1($type='selectCustomFields', $value['values']), $caseStatus, $value['field_id'] . '_select');
                                echo '</div></div></div>';
				echo '<input type="hidden" name='.$value['field_id'].'_value value="'.$selectedCustomField.'" id="solution_value">
				      <input type="hidden" name='.$value['field_id'].'_key value="" id="solution_key">';
                                  }
                                  if($value1[$key1]['field_name']=='Your current Ascender Pay Version' ){
				echo '<div class="col-sm-6"><div class="form-group">';
                                echo '<label>' . $value1[$key1]['field_name'] . '</label>';
                                echo '<div class="vwfrmcnt">';
                                echo create1('customOption', $value1[$key1]['field_id'] . '_select', get_caseValues1($type='selectCustomFields', $value['values']), $caseStatus, $value['field_id'] . '_select');
                                echo '</div></div></div>';
				echo '<input type="hidden" name='.$value['field_id'].'_value value="'.$selectedCustomField.'" id="custom_select_value">
				      <input type="hidden" name='.$value['field_id'].'_key value="" id="custom_select_key">';
                                  }
                                  if($value1[$key1]['field_name']=='Your Current Ascender Pay Critical Patch'){
				echo '<div class="col-sm-6"><div class="form-group">';
                                echo '<label>' . $value1[$key1]['field_name'] . '</label>';
                                echo '<div class="vwfrmcnt">';
                                echo create1('customOption', $value1[$key1]['field_id'] . '_select', get_caseValues1($type='selectCustomFields', $value['values']), $caseStatus, $value['field_id'] . '_select');
                                echo '</div></div></div>';
				echo '<input type="hidden" name='.$value['field_id'].'_value value="'.$selectedCustomField.'" id="custom_select_value">
				      <input type="hidden" name='.$value['field_id'].'_key value="" id="custom_select_key">';
                                  }
                                }

                                    if (strcmp($value['field_type'], "select") == 0) {
                                        //echo $value['fieldname'];
                                        if (strcmp($value['field_id'], "status") == 0) {
                                            echo '<div class="col-sm-6"><div class="form-group">';
                                            echo '<label>' . $value1[$key1]['field_name'] . '</label>';
                                            echo '<div class="vwfrmcnt">';
                                            echo create1('option', $value1[$key1]['field_id'] . '_select', get_caseValues1($type = 'caseStatus', $apptivoCasesData), $caseStatus, $value['field_id'] . '_select');
                                            echo '</div></div></div>';
                                        }
                                        if (strcmp($value['tag_name'], "caseType") == 0) {
                                            echo '<div class="col-sm-6"><div class="form-group">';
                                            echo '<label>' . $value1[$key1]['field_name'] . '</label>';
                                            echo '<div class="vwfrmcnt">';
                                            echo create1('option', $value1[$key1]['field_id'] . '_select', get_caseValues1($type = 'caseType', $apptivoCasesData), $caseType, $value['field_id'] . '_select');
                                            echo '</div></div></div>';
                                        }
                                        if (strcmp($value['field_id'], "priority") == 0) {
                                            echo '<div class="col-sm-6"><div class="form-group">';
                                            echo '<label>' . $value['field_name'] . '</label>';
                                            echo '<div class="vwfrmcnt">';
                                            echo create1('option', $value['field_id'] . '_select', get_caseValues1($type = 'casePriority', $apptivoCasesData), $casePriority, $value['field_id'] . '_select');
                                            echo '</div></div></div>';
                                        }
                                       
                                    }

                                    /* if (strcmp($value['field_type'], "captcha") == 0) {
                                      if (strcmp($value['field_id'], "captcha") == 0) {
                                      echo '<div class="formsection">';
                                      echo '<label>' . $value['field_name'] . '</label>';
                                      echo '<div class="formrgt">';
                                      awp_captcha($field_id, $postValue);
                                      echo '</div></div>';
                                      }
                                      } */
                                }
                            }
                           
                        }?>
                        <div class="col-sm-offset-6 col-sm-6 text-right createcase-btn pad0"><input type="button" value ="Search" name="submit" id ="advanceSearch" class="btn btn-primary"></div></div>
                        
                   </div></form>  

    </div>
  </div>
</div>

</div>

<?php
}

 echo '<input type="hidden" id="case_status_value" name="case_status_value" value="' . $caseStatus . '"/>
	      <input type="hidden" id="case_status_key" name="case_status_key" value="' . $caseStatus_id . '"/>
	      <input type="hidden" id="case_type_value" name="case_type_value" value="' . $caseType . '"/>
	      <input type="hidden" id="case_type_key" name="case_type_key" value="' . $caseType_id . '"/>
	      <input type="hidden" id="case_priority_value" name="case_priority_value" value="' . $casePriority . '"/>
	      <input type="hidden" id="case_priority_key" name="case_priority_key" value="' . $casePriority_id . '"/>
	      <input type="hidden" id="case_solution_value" name="case_solution_value" value="' . $caseSolution . '"/>
	      <input type="hidden" id="case_solution_key" name="case_solution_key" value="' . $caseSolution_id . '"/>
	      <input type="hidden" id="case_employee_id" name="case_employee_id" value="' . $employeId_user . '"/>
              <input type="hidden" id="case_severity_value" name="case_severity_value" value="' . $caseSeverity . '"/>
	      <input type="hidden" id="case_severity_key" name="case_severity_key" value="' . $caseSeverityId . '"/>
              <input type="hidden" id="case_payversion_value" name="case_payversion_value" value="' . $casePayVersion . '"/>
	      <input type="hidden" id="case_payversion_key" name="case_payversion_key" value="' . $casePayVersionId. '"/>
              <input type="hidden" id="case_paycritical_value" name="case_paycritical_value" value="' . $casePayCritical . '"/>
	      <input type="hidden" id="case_paycritical_key" name="case_paycritical_key" value="' . $casePayCriticalId. '"/>
              <input type="hidden" id="case_subject_value" name="case_subject_value" value=""/>'; 
}
}
?>