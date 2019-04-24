<?php
function getSearchTicketsParams(){
	$customerId = $_SESSION ['customerId'];
	$customerName = $_SESSION ['customerName'];
	if(isset($_POST['simple_search']) && !empty($_POST['simple_search'])){
		$searchText = $_POST['simple_search'];
		if(!isEmployeeSet()){
			$searchData = '{"caseCustomerId":"' . $customerId . '","caseCustomer":"' . $customerName.   '"}';
		}else{
			return getQuickSearchParamsForEmp($searchText);
		}
		$params = array (
				"a" => "getAllBySearchText",
				"sortDir" => "desc",
				"startIndex"=>0,
				"numRecords"=>500,
				"searchText"=>$searchText,
				"searchData" => $searchData,
				"objectId" => CA_APPID,
				"apiKey" => APPTIVO_API_KEY,
				"accessKey" => APPTIVO_ACCESS_KEY
		);
		return $params;
	}
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$status_id = $_POST ['case_status_key'];
	$type_id = $_POST ['case_type_key'];
	$priority_id = $_POST ['case_priority_key'];
	$caseContact= $_POST['case_contact_value'];
	$caseContactid=$_POST['case_contact_key'];
	$subject = $_POST['case_subject_value'];
	$description = $_POST ['description'];
	$caseNumber=$_POST['case#'];
	$simpleSearchVal = $_POST['simple_search'];
	$case_attribute_json_str = '';
	if (! empty ( $custom_req_soln_data )) {
		$case_attribute_json_str = $custom_req_soln_data;
	}
	
	if (isset ( $custom_req_seve_data ) && $custom_req_seve_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_seve_data;
		} else {
			$case_attribute_json_str = $custom_req_seve_data;
		}
		// po1($case_attribute_json_str);
	}
	
	if (isset ( $custom_req_payver_data ) && $custom_req_payver_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_payver_data;
		} else {
			$case_attribute_json_str = $custom_req_payver_data;
		}
		// po1($case_attribute_json_str);
	}
	
if (isset ( $custom_req_substatus_data ) && $custom_req_substatus_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_substatus_data;
		} else {
			$case_attribute_json_str = $custom_req_substatus_data;
		}
		// po1($case_attribute_json_str);
	}
	

	if (isset ( $custom_req_supportreqtype_data ) && $custom_req_supportreqtype_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_supportreqtype_data;
		} else {
			$case_attribute_json_str = $custom_req_supportreqtype_data;
		}
		// po1($case_attribute_json_str);
	}
	
if (isset ( $custom_req_servicereqtype_data ) && $custom_req_servicereqtype_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_servicereqtype_data;
		} else {
			$case_attribute_json_str = $custom_req_servicereqtype_data;
		}
		// po1($case_attribute_json_str);
	}
	
	
	
if (isset ( $custom_req_incidenttype_data ) && $custom_req_incidenttype_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_incidenttype_data;
		} else {
			$case_attribute_json_str = $custom_req_incidenttype_data;
		}
		// po1($case_attribute_json_str);
	}
	
	
	if (isset ( $custom_req_paycrit_data ) && $custom_req_paycrit_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_req_paycrit_data;
		} else {
			$case_attribute_json_str = $custom_req_paycrit_data;
		}
		// po1($case_attribute_json_str);
	}
	$custom_reference_field1 ['customAttributeId'] = $_SESSION ['reference_customfield1_attribute_id'];
	$custom_reference_field1 ['customAttributeType'] = 'reference';
	$custom_reference_field1 ['customAttributeTagName'] = $_SESSION ['reference_customfield1_tag_name'];
	$custom_reference_field1 ['customAttributeName'] = $_SESSION ['reference_customfield1_tag_name'];
	$custom_refer_field1 = json_encode ( $custom_reference_field1 );
	
	$custom_reference_field2 ['customAttributeId'] = $_SESSION ['reference_customfield2_attribute_id'];
	$custom_reference_field2 ['customAttributeType'] = 'reference';
	$custom_reference_field2 ['customAttributeTagName'] = $_SESSION ['reference_customfield2_tag_name'];
	$custom_reference_field2 ['customAttributeName'] = $_SESSION ['reference_customfield2_tag_name'];
	$custom_refer_field2 = json_encode ( $custom_reference_field2 );
	
	$custom_reference_field3 ['customAttributeId'] = $_SESSION ['reference_customfield3_attribute_id'];
	$custom_reference_field3 ['customAttributeType'] = 'reference';
	$custom_reference_field3 ['customAttributeTagName'] = $_SESSION ['reference_customfield3_tag_name'];
	$custom_reference_field3 ['customAttributeName'] = $_SESSION ['reference_customfield3_tag_name'];
	$custom_refer_field3 = json_encode ( $custom_reference_field3 );
	
	if ($case_attribute_json_str != '') {
	
		// po1($case_attribute_json_str);
		$custom_reference = $custom_refer_field1 . ',' . $custom_refer_field2 . ',' . $custom_refer_field3;
		$customAttributes = ',"customAttributes":[' . $case_attribute_json_str . ',' . $custom_reference . ']';
	} else {
		$customAttributes = ',"customAttributes":[]';
	}
	
	
	$caseContactString ="";
	if(!empty($caseContactid) && $caseContact!= ""){
		$caseContactString = '","caseContactId":"' . $caseContactid . '","caseContact":"' . $caseContact ; 
	}
	$searchData = '{"caseNumber":"'.$caseNumber.'","followUpDescription":"","createdByName":null,"createdByObjectId":null,"createdByObjectRefId":null,"lastUpdatedByName":null,"lastUpdatedByObjectId":null,"lastUpdatedByObjectRefId":null,"caseSummary":"' . $subject . '","description":"' . $description .'","caseCustomerId":"' . $customerId . '","caseCustomer":"' . $customerName. $caseContactString .  '","caseEmail":""' . $customAttributes . ',"labels":[]}';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"startIndex"=>0,
			"numRecords"=>5000,
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":[' . $status_id . '],"priorityIds":[' . $priority_id . '],"typeIds":[' . $type_id . '],"slaIds":[],"caseSourceIds":[]}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);
	return $params;
}


function updateTicket(){
	$caseId = $_GET['id'];
  	$caseContactdata =$_POST['case_contact_value'];
	$caseContactdataid = $_POST['case_contact_key'];
	
	$caseData = get_case_by_caseId1($caseId);
	$caseData->lastUpdatedByObjectId = CONTACT_OBJECT_ID;
	$caseData->lastUpdatedByObjectRefId = "" . getContactInfo()->contactId;

	if(!empty($caseContactdataid) && $caseContactdataid != null)
	{
		$caseData->caseContact =$caseContactdata;
		$caseData->caseContactId = $caseContactdataid;
	}
	$caseJson = json_encode($caseData);
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';

	$params = array (
			"a" => "update",
			"caseId" => $caseId,
			"caseData" => $caseJson,
			"attributeName" => '["caseContact","caseContactNew","caseCustomer","caseCustNew",customAttributes"]',
			"isCustomAttributesUpdate" => "true",
			"isAddressUpdate" => "false",
			"appId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	return $response;
}

function getBulkExportParams($caseIds){
	$caseIds = '{"id":[' . $caseIds . ']}' ;
	$caseStatuses = '{"statusIds":[' . implode(",", getStatusArray()) . ']}' ;
	$subStatusId = getSubStatusAttrDefn()->right[0]->tagName; 		
	$severityId = getSeverityAttrDefn()->right[0]->tagName;
	$solutionId = getSolutionAttrDefn()-> right[0]->tagName;
	$payVerionId = getpayVersionAttrDefn()->right[0]->tagName;
	$criticalPatchId =getcriticalPatchAttrDefn()->right[0]->tagName;
	//error_log("SRKORADA CASE IDS=> " . $caseIds);

	$displayString = '[{"id":"case_number_attr","name":"Ticket #"},{"id":"case_status_attr","name":"Status"},{"id":"case_type_attr","name":"Type"},{"id":"case_contact_attr","name":"Contact"},{"id":"summary_attr","name":"Summary"},{"id":"case_description_attr","name":"Description"},{"id":"case_priority_attr","name":"Priority"},{ "id": "'.$subStatusId.'","name": "Sub-Status"},{"id": "'.$severityId.'","name": "Severity"},{"id": "'.$solutionId.'","name": "Solution"},{"id": "'.$payVerionId.'","name": "Your current Ascender Pay Version"},{"id": "'.$criticalPatchId.'","name": "Your Current Ascender Pay Critical Patch"},{"id": "created_on_attr","name":"Created Date"},{"id": "modified_on_attr","name":"Modified Date"}]';
	$params = array(
			"a" => "bulkExport",
			"currentTab"=>"ADVANCEDSEARCH",
			"bulkUpdateType" => "SELECTED",
			"caseIds" => $caseIds,
			"isCurrentView"=>"Y",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"displayColumnArray"=> $displayString,
			"multiSelectData"=>$caseStatuses,
			"objectId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);
	//po1($params);
	return $params;

}

function getAllTicketsParams(){

	$caseConfigData = getCaseConfigData();

	$emailId = $_SESSION ['user'] ['email'];
	$customerId=$_SESSION['customerId'];
	$customerName=$_SESSION['customerName'];
	$custom_attr_required=$_SESSION['case_search_base_required'];

	if ( empty($custom_attr_required)) {
		$custom_attr_required = '';
	}
	
	$searchData = '{"caseCustomerId":'.$customerId.',"caseCustomer":"'.$customerName.'","customAttributes":['.$custom_attr_required.']}';
	//po1(getCaseConfigData());
	$params = array(
			"a" => "getAllByAdvancedSearch",
			"startIndex"=>0,
			"numRecords"=>5000,
			"sortColumn"   => "creationDate",
			"sortDir"   => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":[' . implode(",", getStatusArray()) . '],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);

	//po1($params);
	//error_log("PARMS => " . json_encode($params));
	return $params;

}


function getAllMyTicketsParams(){

	$caseConfigData = getCaseConfigData();
	$sessionKey = $_SESSION ['sessionKey'];
	
	$statuses = $caseConfigData->statuses;
	
	$statusesArray = array();
	//po1($statuses);
	foreach ( $statuses as $status ) {
		if ($status->meaning != "Closed" && $status->isEnabled == 'Y') {
			$statusesArray[] = $status->statusId;
			//echo $open_status_id;
		}
	}
	$emailId = $_SESSION ['user'] ['email'];
	$customerId=$_SESSION['customerId'];
	$contactId=$_SESSION['contactId'];
	$custom_attr_required=$_SESSION['case_search_base_required'];

	if ( empty($custom_attr_required)) {
		$custom_attr_required = '';
	}
	
    $searchData = '{"caseCustomerId":'.$customerId.',"caseContactId":'.$contactId.',"customAttributes":['.$custom_attr_required.']}';
    
// 	po1($searchData);
	$params = array(
			"a" => "getAllByAdvancedSearch",
			"startIndex"=>0,
			"numRecords"=>5000,
			"sortColumn"   => "casePriority.untouched",
			"sortDir"   => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":['.implode(',', $statusesArray).'],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
			//"sessionKey" => $sessionKey
	);
//po1($params);
	return $params;

}

function getAllOpenTicketsParams(){

	$caseConfigData = getCaseConfigData();

	 
	$statuses = $caseConfigData->statuses;
	//po1($statuses);
	$statusesArray = array();
	//po1($statuses);
	foreach ( $statuses as $status ) {
		if ($status->statusName != "Closed" && $status->isEnabled == 'Y') {
			$statusesArray[] = $status->statusId;
			//echo $open_status_id;
		}
	}
	//echo $open_status_id;
	$emailId = $_SESSION ['user'] ['email'];
	$customerId=$_SESSION['customerId'];
	$customerName=$_SESSION['customerName'];
	$custom_attr_required=$_SESSION['case_search_base_required'];

	if ( empty($custom_attr_required)) {
		$custom_attr_required = '';
	}
	
    //$searchData = '{"caseCustomerId":'.$customerId.',"caseCustomer":"'.$customerName.'","customAttributes":['.$custom_attr_required.']}';
	$searchData = '{"caseCustomerId":'.$customerId.',"caseNumber":"","followUpDescription":"","createdByName":null,"createdByObjectId":null,"createdByObjectRefId":null,"lastUpdatedByName":null,"lastUpdatedByObjectId":null,"lastUpdatedByObjectRefId":null,"caseSummary":"","description":"","isBillable":null,"contractValueFrom":null,"contractValueTo":null,"caseEmail":"","customAttributes":[],"labels":[]}';
  
	
	//error_log("KOSRINIV .. search data => " . $searchData);

	$params = array(
			"a" => "getAllByAdvancedSearch",
			"startIndex"=>0,
			"numRecords"=>5000,
			"sortColumn"   => "creationDate",
			"sortDir"   => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":['.implode(',', $statusesArray).'],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);

	return $params;

}


function getAllClosedTicketsParams(){
	$caseConfigData = getCaseConfigData();
	$statuses = $caseConfigData->statuses;
	foreach ( $statuses as $status ) {
		if ($status->meaning == "Closed") {
			if($closed_status_id) {
				$closed_status_id = $closed_status_id.','.$status->statusId;
			}else{
				$closed_status_id = $status->statusId;
			}
		}
	}
	$emailId = $_SESSION ['user'] ['email'];
	$customerId=$_SESSION['customerId'];
	$customerName=$_SESSION['customerName'];
	$custom_attr_required=$_SESSION['case_search_base_required'];
	if ( empty($custom_attr_required)) {
		$custom_attr_required = '';
	}
    $searchData = '{"caseCustomerId":'.$customerId.',"caseCustomer":"'.$customerName.'","customAttributes":['.$custom_attr_required.']}';
	$params = array(
			"a" => "getAllByAdvancedSearch",
			"startIndex"=>0,
			"numRecords"=>5000,
			"sortColumn"   => "creationDate",
			"sortDir"   => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":['.$closed_status_id.'],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);

	return $params;

}

function getMyPendingActionTicketsParams(){
	$caseConfigData = getCaseConfigData();
	$statuses = $caseConfigData->statuses;
	foreach($statuses as $status){
		if($status->statusName==PENDING_ACTION_NAME){
			$pending_action_status_id=$status->statusId;
		}
		
	}
	$emailId = $_SESSION ['user'] ['email'];
	$customerId=$_SESSION['customerId'];
	$customerName=$_SESSION['customerName'];
	$custom_attr_required=$_SESSION['case_search_base_required'];
	if ( empty($custom_attr_required)) {
		$custom_attr_required = '';
	}
    $searchData = '{"caseCustomerId":'.$customerId.',"caseCustomer":"'.$customerName.'","customAttributes":['.$custom_attr_required.']}';
	$params = array(
			"a" => "getAllByAdvancedSearch",
			"startIndex"=>0,
			"numRecords"=>5000,
			"sortColumn"   => "creationDate",
			"sortDir"   => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":['.$pending_action_status_id.'],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId"=>CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);
	return $params;

}
?>