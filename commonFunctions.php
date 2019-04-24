<?php
//Copy-pasted all previous functions out of config.php

/*
 * API method
 */
function getRestAPICall1($method, $url, $data = false) {
	
	// echo $url; exit;
	$ch = curl_init ();
	
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array (
			"Content-Type: application/x-www-form-urlencoded;charset=utf-8" 
	) );
	
	if ($method == "POST") {
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		if ($data) {
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		}
	} else {
		if ($data)
			$url = sprintf ( "%s?%s", $url, http_build_query ( $data ) );
	}
	
	// echo '<pre>';print_r($data);
	//echo $url.'?'.http_build_query($data);
	
	curl_setopt ( $ch, CURLOPT_URL, $url );
	
	// curl_setopt( $ch, CURLOPT_SSL_CIPHER_LIST, '3DES' );
	//PayPalHttpConfig::$defaultCurlOptions[CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1_2;

	
	curl_setopt ( $ch, CURLOPT_SSLVERSION,1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
	
	$date1 = microtime ( false );
	$response = curl_exec ( $ch );
	$date2 = microtime ( false );
	$timespent = $date2 - $date1;
// 	error_log ( "SRINI: Response recieved => " . $timespent . " => " . $response);
	//print_r( curl_getinfo( $ch ) );
	curl_close ( $ch );
	$result = json_decode ( $response );
	//po1($result);
	return $result;
}


/*
 * API method got getting URL
 */

function getRestAPICallForUrl($method, $url, $data = false) {
	
	// echo $url; exit;
	$ch = curl_init ();
	
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array (
			"Content-Type: application/x-www-form-urlencoded;charset=utf-8" 
	) );
	
	if ($method == "POST") {
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		if ($data) {
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		}
	} else {
		if ($data)
			$url = sprintf ( "%s?%s", $url, http_build_query ( $data ) );
	}
	
	$hitUrl = $url.'?'.http_build_query($data);
	return $hitUrl;
}


/*
 * API method
 */
function getRestAPICallForFile($method, $url, $data = false) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array (
			"Content-Type: application/x-www-form-urlencoded;charset=utf-8"
			) );

	if ($method == "POST") {
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		if ($data) {
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		}
	} else {
		if ($data)
			$url = sprintf ( "%s?%s", $url, http_build_query ( $data ) );
	}
	curl_setopt ( $ch, CURLOPT_URL, $url );
	// curl_setopt( $ch, CURLOPT_SSL_CIPHER_LIST, '3DES' );
	curl_setopt ( $ch, CURLOPT_SSLVERSION, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
	$date1 = microtime ( false );
	$response = curl_exec ( $ch );
	$date2 = microtime ( false );
	$timespent = $date2 - $date1;
	error_log ( "SRINIKORADA: Response recieved for file download.=> " . $timespent . " => " . $response);
	curl_close ( $ch );
	$result = $response;
	return $result;
}

function getRestAPICall10($method, $url, $data = false) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, Array (
			"Content-Type: application/x-www-form-urlencoded;charset=utf-8" 
	) );
	if ($method == "POST") {
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		if ($data) {
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		}
	} else {
		if ($data)
			$url = sprintf ( "%s?%s", $url, http_build_query ( $data ) );
	}
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_SSLVERSION, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
	$response = curl_exec ( $ch );
	curl_close ( $ch );
	$result = json_decode ( $response );
	return $result;
}
function getAllCustomers($customer)
{	
	$sessionKey = $_SESSION ['sessionKey'];
	$api_url = APPTIVO_API_URL . '/app/dao/v6/customers';
	$params = array (
			"a" => "getAllBySearchText",
			"iDisplayStart" => 0,
			"numRecords" => 50,
			"objectId" => 3,
			"searchText" => $customer,
			"sortColumn" => "",
			"startIndex" => 0,
			"sessionKey" => $sessionKey
	
			//"apiKey" => APPTIVO_API_KEY,
			//"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
	
}


function getAllSearchContacts($contact)
{	
	$sessionKey = $_SESSION ['sessionKey'];
	$api_url = APPTIVO_API_URL . '/app/dao/v5/contacts';
	$params = array (
			"a" => "getAllContactsBySearchText",
			"iDisplayStart" => 0,
			"numRecords" => 500,
			"objectId" => 2,
			"searchText" => $contact,
			"sSortDir_0" => "asc",
			"sortDir" => "asc",
			"startIndex" => 0,
			"sessionKey" => $sessionKey
	
			//"apiKey" => APPTIVO_API_KEY,
			//"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
	
}


function get_employeeId_by_email1($emailId) {
	$api_url = APPTIVO_API_URL . '/app/dao/employee';
	$searchData = '{"emailId":"' . $emailId . '","personStatus":"0","maritalStatus":"0","registeredDisabled":"0"}';
	$params = array (
			"a" => "getEmployeeByAdvancedSearch",
			"searchData" => $searchData,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	if (isset ( $response->aaData [0]->employeeId ))
		return $response->aaData [0]->employeeId;
	else
		return '';
}


/*
 * Change password
 */
function changePassword($oldPwd,$newPwd,$confPwd) {
	$api_url = APPTIVO_API_URL . '/app/commonservlet';
	$sessionKey = $_SESSION ['sessionKey'];
	$pwddetails = '{"oldPsswd":"'.$oldPwd.'","newPsswd":"'.$newPwd.'","confirmPsswd":"'.$confPwd.'"}';
	$params = array (
			"a" => "savePasswordDetails",
			"preferencesPasswordDetails" => $pwddetails,
			"sessionKey"=>$sessionKey
	);
	//po1($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//po1($response);
	return $response;
}


/*
 * Forgot password
 */
function forgotPassword($emailId) {
	$api_url = APPTIVO_API_URL . '/app/login';
	//$sessionKey = $_SESSION ['sessionKey'];
	
	$params = array (
			"a" => "forgotPassword",
			"emailId" => $emailId,
			"resetType"=>"code"
	);
	//po1($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//po1($response);
	return $response;
}


/*
 * Update Password 
 */
function updatePassword($newPwd, $emailId, $secCode){
	$api_url = APPTIVO_API_URL . '/app/login';
	$params = array (
			"a" => "updatePassword",
			"password" => $newPwd,
			"emailId" => $emailId,
			"resetCode" => $secCode,
			"resetType"=>"code"
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}



/*
 * get Searched Tickets
 */
function getSerachedTickets($params) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	 //po1($params);
	return $response;
}


/*
 * get Tickets
 */
function getCases($params) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * get session key
 * https://cqa-t2-211.apptivo.net/app/login?a=login&generateSessionkey=true&isExpire=false&sessionType=mobile&v=1&sessionToken=3z2NRjsRl4s5iiHLL3aaaUU3VJuro11x
 */
function getSession($sessionToken){
	$api_url = APPTIVO_API_URL . '/app/login';
	$params = array(
			"a" => "login",
			"generateSessionkey" => "true",
			"isExpire" => "false",
			"sessionType" => "mobile",
			"v" => 1,
			"sessionToken" => $sessionToken
			);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * get Tickets
 */
function exportCases($caseIds) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$params = getBulkExportParams($caseIds);
	$response = getRestAPICallForFile( 'POST', $api_url, $params );
	// po1($params);
	return $response;
}

/*
 * get All open tickets
 */
function get_all_open_tickets($open_status_id, $inprogress_status_id, $customerId) {
	$customerName = $_SESSION ['customerName'];
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$custom_attr_required = $_SESSION ['case_search_base_required'];
	if (empty ( $custom_attr_required )) {
		$custom_attr_required = '';
	}
	$searchData = '{"caseNumber":"","followUpDescription":"","createdByName":null,"createdByObjectId":null,"createdByObjectRefId":null,"lastUpdatedByName":null,"lastUpdatedByObjectId":null,"lastUpdatedByObjectRefId":null,"caseSummary":"","description":"","isBillable":null,"contractValueFrom":null,"contractValueTo":null,"caseEmail":"","customAttributes":[],"labels":[]}';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":[' . $open_status_id . ',' . $inprogress_status_id . '],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * get All closed tickets
 */
function get_all_closed_tickets($closed_status_id, $resolved_status_id, $customerId) {
	$customerName = $_SESSION ['customerName'];
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';	
	if (empty ( $custom_attr_required )) {
		$custom_attr_required = '';
	}
	$searchData = '{"caseCustomerId":"' . $customerId . '","caseCustomer":"' . $customerName . '",caseNumber":"","followUpDescription":"","caseSummary":"","description":"","caseEmail":"","customAttributes":[' . $custom_attr_required . '],"labels":[]}';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":[' . $closed_status_id . ',' . $resolved_status_id . '],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * get All tickets
 */
function get_all_tickets($customerId) {
	$customerName = $_SESSION ['customerName'];
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';	
	if (empty ( $custom_attr_required )) {
		$custom_attr_required = '';
	}
	$searchData = '{"caseNumber":"","followUpDescription":"","createdByName":null,"createdByObjectId":null,"createdByObjectRefId":null,"lastUpdatedByName":null,"lastUpdatedByObjectId":null,"lastUpdatedByObjectRefId":null,"caseSummary":"","description":"","isBillable":null,"contractValueFrom":null,"contractValueTo":null,"caseEmail":"","customAttributes":[],"labels":[]}';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":[],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * get All pending tickets
 */
function get_all_pending_tickets($status_id, $customerId) {
	$customerName = $_SESSION ['customerName'];
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	if (empty ( $custom_attr_required )) {
		$custom_attr_required = '';
	}
	$searchData = '{"caseCustomerId":"' . $customerId . '","caseCustomer":"' . $customerName . '","caseNumber":"","followUpDescription":"","caseSummary":"","description":"","caseEmail":"","customAttributes":[' . $custom_attr_required . '],"labels":[]}';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":["' . $status_id . '"],"priorityIds":[],"typeIds":[],"slaIds":[],"caseSourceIds":[]}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * get All cases by employee ID
 */
function get_all_cases_by_emailId1($emailId, $sessionKey) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$searchData = '{"caseEmail":"' . $emailId . '"}';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}
function po1($a) {
	echo "<pre>";
	print_r ( $a );
	echo "</pre>";
}

function po2($a) {
	echo "<pre>";
	print_r ( $a );
	echo "</pre>";
}

/*
 * get Case by Case ID
 */
function get_case_by_caseId1($caseId) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$params = array (
			"a" => "getById",
			"isSla" => "Y",
			"caseId" => $caseId,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

/*
 * Add Notes by Case ID
 */
function add_notes_by_objectId1($objId, $objName, $notes, $sessionKey) {
	$api_url = APPTIVO_API_URL . '/app/dao/note';

    $contactId=$_SESSION['contactId'];
    $contactName=$_SESSION['contactName'];
    $customerId=$_SESSION['customerId'];
    $customerName=$_SESSION['customerName']; 
	$note = new stdClass();
	$note->createdByObjectId = CONTACT_OBJECT_ID;
	$note->createdByObjectRefId = $contactId;
	$note->noteText = $notes;
	$note->labels = array();
	$note->objectId = CA_APPID;
	$note->objectRefId = $objId;
	$note->isDisplayToCustomer = "Y";
	$note->isSendEmail = "Y";
	$note->isNotifyAssignee = "Y";
	$note->isNotifyCustomer = "Y";
	$note->assigneeNotificationType = "ALL";
	$note->isRemindMeEnabled = "N";
	
	$associations = new stdClass();
	$associations->objectRefId = $objId;
	$associations->objectRefName = $objName;
	$associations->objectId=CA_APPID;
	
	$note->associations = array();
	$note->associations[] = $associations;
	if(isEmployeeSet()){
		$params = array (
			"a" => "createNote",
			"noteDetails" => json_encode($note),
			"sessionKey" => $sessionKey
	);
	}
	else{
	$params = array (
			"a" => "createNote",
			"noteDetails" => json_encode($note),
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	}
	po1($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}


/*
 * get customer by id
 */
function get_customer_by_objectId($objId) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/customers';

	$params = array (
			"a" => "getById",
			"customerId" => $objId,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);
	
	//po1($params);
	$response = getRestAPICall1 ( 'GET', $api_url, $params );

	// 	echo '<pre>';print_r($response);exit;

	return $response;
}


/*
 * get contact by id
 */
function get_contact_by_objectId($objId) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/contacts';

	$params = array (
			"a" => "getById",
			"contactId" => $objId,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);
	
	//po1($params);
	$response = getRestAPICall1 ( 'GET', $api_url, $params );

	// 	echo '<pre>';print_r($response);exit;

	return $response;
}


/*
 * get Notes and Email by Case ID
 */

function getNotesEmailByObjectId($objId){
	//Changed to external news feeed events instead
	$api_url = APPTIVO_API_URL . '/app/dao/newsfeed';
	$params = array (
			'a' => 'getWallMessagesBySelectedEmployeeIds',
			'eventType' => 'EVENT_TYPES_EXTERNAL',
			'getLatest' => 'false',
			'objectId'=> CA_APPID,
			"objectRefId" => $objId,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY,
			"wallEntryId" => '',
			"userName" => 'todd@apptivo.com'
	);
	$response = getRestAPICall1 ( 'GET', $api_url, $params );	
	return json_encode($response);

}
/*
 * get Notes by Case ID
 */
function get_notes_by_objectId1($objId, $sessionKey) {
	$api_url = APPTIVO_API_URL . '/app/dao/note';
	
	$params = array (
			"a" => "getNotes",
			"b"=>1,
			"selectedObjectId" => CA_APPID,
			"startIndex" => 0,
			"isFrom" => "App",
			"numRecords" => 100,
			"noteData" => '{}',
			"selectedObjectRefId" => $objId,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	
	
	$response = getRestAPICall1 ( 'GET', $api_url, $params );
	
// 	echo '<pre>';print_r($response);exit;
	
	return $response;
}


// get all contacts
function get_customer_contacts($customerId,$contactName=''){
	$api_url = APPTIVO_API_URL . '/app/dao/v6/customers';
	
	$params = array (
			"a" => "getCustomerContacts",
			"customerId" => $customerId,
			"iDisplayLength" => 10,
			"iDisplayStart" => 0,
			"objectId" => 2,
			"sSortDir_0" => 'asc',
			"startIndex" => 0,
			"sortDir" => 'asc',
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	//po1($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//po1($response);
	return $response;
}


// get all contacts
function get_all_contacts(){
	$api_url = APPTIVO_API_URL . '/app/dao/v6/customers';
	$customerName=$_SESSION ['customerName'];
	$customerId=$_SESSION ['customerId'];
	$params = array (
			"a" => "getCustomerContacts",
			"customerId" => $customerId,
			"iDisplayLength" => 10,
			"iDisplayStart" => 0,
			"objectId" => 2,
			"sSortDir_0" => 'asc',
			"startIndex" => 0,
			"sortDir" => 'asc',
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	//po1($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//po1($response);
	return $response;
}







/*
 * Get All documents
 */
function get_all_documents_objId1($objRefId) {
	$api_url = APPTIVO_API_URL . '/app/dao/document';
	$params = array (
			"a" => "getAllDocumentsByObjectIdObjectRefId",
			"objRefId" => $objRefId,
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}

function get_all_documents_objId2($objRefId) {
	$api_url = APPTIVO_API_URL . '/app/dao/document';
	$params = array (
			"a" => "getAllDocumentsByObjectIdObjectRefId",
			"objRefId" => $objRefId,
			"objectId" => KB_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	return $response;
}




/*
 * Download URL
 */
function get_download_url1($id) {
	$api_url = APPTIVO_API_URL . '/app/dao/document';
	$params = array (
			"a" => "getDocumentDownloadUrl",
			"id" => $id,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//po1($response);
	return $response;
}

/*
 * get All cases
 */
function get_all_cases1() {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	
	$params = array (
			"a" => "getAll",
			"sortColumn" => "creationDate",
			"sortDir" => "Desc",
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	/*
	 * if ( !empty ( $_SESSION['case_search_base_required'])) {
	 * $params['customAttributes'] = json_decode($_SESSION['case_search_base_required'], true );
	 *
	 * }
	 *
	 */
	
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	
	return $response;
}

/*
 * Create Case
 */
function saveCasesForm1($employeeId, $firstName, $lastName, $caseNumber, $caseStatus, $caseStatusId, $caseType, $caseTypeId, $casePriority, $casePriorityId, $assignedName, $assigneeObjId, $assigneeObjRefId, $caseSummary, $caseDescription, $emailId, $case_assignee, $caseAssociates, $createAssociates, $case_custom_fields, $useCaseId) {
	$sessionKey = $_SESSION ['sessionKey'];
	if (isset ( $useCaseId ) && $useCaseId != '') {
		$customAttributes = ',"customAttributes":[{"customAttributeId":"' . CA_USECASEID_ID . '","customAttributeValue":"' . $useCaseId . '","customAttributeType":"input","customAttributeTagName":"' . CA_USECASEID_NAME . '","customAttributeName":"' . CA_USECASEID_NAME . '"}]';
	} else {
		$customAttributes = ',"customAttributes":[]';
	}
	$api_params = '{"caseNumber":"Auto generated number","caseStatus":"' . $caseStatus . '","caseStatusId":' . $caseStatusId . ',"caseType":"' . $caseType . '"
,"caseTypeId":' . $caseTypeId . ',"casePriority":"' . $casePriority . '","casePriorityId":' . $casePriorityId . ',"caseSummary":"' . $caseSummary . '","description"
:"' . $caseDescription . '","dateResolved":null, "caseItem":null,"caseItemId":null,"caseProject"
:null,"caseProjectId":null,"labels":[]' . $customAttributes . ',"caseEmail":"' . $emailId . '","caseItem":"' . CASE_ITEM_NAME . '","caseItemId":' . CASE_ITEM_ID . '}';
	
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	if ($sessionKey != "") {
		$params = array (
				"a" => "save",
				"caseData" => $api_params,
				"sessionKey" => $sessionKey 
		);
	} else {
		$params = array (
				"a" => "save",
				"caseData" => $api_params,
				"apiKey" => APPTIVO_API_KEY,
				"accessKey" => APPTIVO_ACCESS_KEY 
		);
	}
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	// echo '<pre>';print_r($response);echo '</pre>';exit;
	return $response;
}

/*
 * Update Case
 */
function updateCasesForm1($caseId, $employeeId, $firstName, $lastName, $caseNumber, $caseStatus, $caseStatusId, $caseType, $caseTypeId, $casePriority, $casePriorityId, $assignedName, $assigneeObjId, $assigneeObjRefId, $caseSummary, $caseDescription, $emailId, $case_assignee, $caseAssociates, $createAssociates, $case_custom_fields, $useCaseId) {
	$sessionKey = $_SESSION ['sessionKey'];
	$caseData = '{"caseId":' . $caseId . ',"caseStatus":"' . $caseStatus . '","caseStatusId":' . $caseStatusId . ',"caseType":"' . $caseType . '","caseTypeId":' . $caseTypeId . ',"casePriority":"' . $casePriority . '","casePriorityId":' . $casePriorityId . ',"caseSummary":"' . $caseSummary . '","description":"' . $caseDescription . '","customAttributes":[{"customAttributeId":"' . CA_USECASEID_ID . '","customAttributeValue":"' . $useCaseId . '","customAttributeType":"input","customAttributeTagName":"' . CA_USECASEID_NAME . '","customAttributeName":"' . CA_USECASEID_NAME . '"}]}';
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	if ($sessionKey != '') {
		$params = array (
				"a" => "update",
				"caseId" => $caseId,
				"caseData" => $caseData,
				"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","customAttributes","' . CA_USECASEID_NAME . '"]',
				"isCustomAttributesUpdate" => "false",
				"isAddressUpdate" => "false",
				"sessionKey" => $sessionKey 
		);
	} else {
		$params = array (
				"a" => "update",
				"caseId" => $caseId,
				"caseData" => $caseData,
				"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","customAttributes","' . CA_USECASEID_NAME . '"]',
				"isCustomAttributesUpdate" => "false",
				"isAddressUpdate" => "false",
				"apiKey" => APPTIVO_API_KEY,
				"accessKey" => APPTIVO_ACCESS_KEY 
		);
	}
	
	$response1 = getRestAPICall1 ( "POST", $api_url, $params );
	
	if ($sessionKey != '') {
		$params1 = array (
				"a" => "update",
				"caseId" => $caseId,
				"caseData" => $caseData,
				"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","customAttributes","' . CA_USECASEID_NAME . '"]',
				"isCustomAttributesUpdate" => "true",
				"isAddressUpdate" => "false",
				"sessionKey" => $sessionKey 
		);
	} else {
		$params1 = array (
				"a" => "update",
				"caseId" => $caseId,
				"caseData" => $caseData,
				"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","customAttributes","' . CA_USECASEID_NAME . '"]',
				"isCustomAttributesUpdate" => "true",
				"isAddressUpdate" => "false",
				"apiKey" => APPTIVO_API_KEY,
				"accessKey" => APPTIVO_ACCESS_KEY 
		);
	}
	$response = getRestAPICall1 ( "POST", $api_url, $params1 );
	
	return $response;
}

/*
 * Get Contact By EmailID
 */
function getContactByEmailId($emailId) {
	$contactParams = array (
			"a" => "getAllBySearchText",
			"searchText" => $emailId,
			"objectId" => APPTIVO_CONTACT_OBJECT_ID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$contactResponse = getRestAPICall1 ( "POST", APPTIVO_CONTACTS_API, $contactParams );
	foreach($contactResponse->data[0]->emailAddresses as $curEmail) {
		//If we match the email on our first record we'll return the object json
		if(strtolower($curEmail->emailAddress) == strtolower($emailId)) {
			return $contactResponse->data[0];
		}
	}
	//If we didn't match an email return false
	return false;
}

/*
 * Get Customer By EmailID
 */
function getCustomerByEmailId($emailId) {
	$searchData = '{"emailAddresses":[{"emailAddress":"' . $emailId . '","emailTypeCode":"-1","emailType":"","id":"cont_email_input"}]}';
	$customerParams = array (
			"a" => "getAllCustomersByAdvancedSearch",
			"objectId" => APPTIVO_CUSTOMER_OBJECT_ID,
			"startIndex" => "0",
			"numRecords" => "1",
			"sortColumn" => "_score",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => "{}",
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$customerResponse = getRestAPICall1 ( "POST", APPTIVO_CUSTOMER_API, $customerParams );
	if (isset ( $customerResponse->customers )) {
		foreach ( $customerResponse->customers as $key => $customerData ) {
			if (isset ( $customerData->emailAddresses )) {
				foreach ( $customerData->emailAddresses as $key1 => $emailData ) {
					if ($emailData->emailAddress == $emailId) {
						$customerAccountId = $customerData->customerId;
						$customerAccountName = $customerData->customerName;
					}
				}
			}
		}
	}
	$customerDetails ['caseCustomerId'] = $customerAccountId;
	$customerDetails ['caseCustomer'] = $customerAccountName;
	return $customerDetails;
}

/* Get all questions */
function get_all_questions($sessionKey) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/answers';
	$params = array (
			"a" => "getAll",
			"numRecords" => 1000,
			"objectId"=>KB_APPID,
			"sortDir"=>"desc",
			"sortColumn"=>"creationDate",
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params );
// 	 print_r($response);
	return $response;
}

/* Get question by question Id */
function get_question_by_question_id($quest_id, $sessionKey) {
	$api_url = APPTIVO_API_URL . '/app/dao/answers';
	$params = array (
			"a" => "getQuestionByQuestionId",
			"questionId" => $quest_id,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	return $response;
}

/* Create Case Methods */
function display_cases_fields1($fields) {
	 //po1($fields);
	$apptivoFields = array ();
	// $customFieldValue=array();
	foreach ( $fields->sections as $key => $value ) {
		foreach ( $value->attributes as $fields ) {
			//echo '<pre>';print_r($fields);echo '</pre>';
		if($fields->label->modifiedLabel=='Contact'){
			$fieldid = str_replace ( ' ', '', $fields->label->modifiedLabel );
				
					$fieldsLabel1 = array (
						$fields->label->modifiedLabel => array (
								'field_id' => strtolower ( $fieldid ),
								'field_show' => array (
										'on' => 'On',
										'off' => 'Off' 
								),
								'field_name' => $fields->label->modifiedLabel,
								'defaulttext' => $fields->label->modifiedLabel,
								'show_order' => '',
								'validation' => $fields->right [0]->tag,
								'field_type' => $fields->right [0]->tag,
								'tag_id' => $fields->right [0]->tagId,
								'tag_name' => $fields->right [0]->tagName,
								'attribute_id' => $fields->attributeId,
								
						) 
				);
				}
			
			if ($fields->label->modifiedLabel != ''  && $fields->label->modifiedLabel != 'Threat Date' && $fields->label->modifiedLabel != 'Threat URL' && $fields->label->modifiedLabel != 'Released in Alpha/Custom/Retro Patch' && $fields->label->modifiedLabel != 'Follow Up Date' && $fields->label->modifiedLabel != 'Released in Alpha/Custom/Retro Patch' && $fields->label->modifiedLabel != 'Patch Ready for Test' && $fields->label->modifiedLabel != 'Start Time' && $fields->label->modifiedLabel != 'End Time' && $fields->label->modifiedLabel != 'Duration' && $fields->label->modifiedLabel != 'Impact' && $fields->label->modifiedLabel != 'Time Spent (999.99)' && $fields->label->modifiedLabel != 'Comments' && $fields->label->modifiedLabel != 'BAU/Dev Estimate (Hrs)' && $fields->label->modifiedLabel != 'BAU/Dev Actual Time Spent (Hrs)' && $fields->label->modifiedLabel != 'Created Date' && $fields->label->modifiedLabel != 'Modified Date' && $fields->label->modifiedLabel != 'Custom Attr' && $fields->label->modifiedLabel != 'Customer' && $fields->label->modifiedLabel != 'Contact' && $fields->label->modifiedLabel != 'Date Resolved' && $fields->label->modifiedLabel != 'Project' && $fields->label->modifiedLabel != 'Need By Date' && $fields->label->modifiedLabel != 'Item' && $fields->label->modifiedLabel != 'Follow Up Description' && $fields->label->modifiedLabel != 'Follow Up Date' && $fields->label->modifiedLabel != 'Assigned To' && $fields->label->modifiedLabel != 'Referred By' && $fields->label->modifiedLabel != 'Campaign' && $fields->label->modifiedLabel != 'Territory' && $fields->label->modifiedLabel != 'Created by' && $fields->label->modifiedLabel != 'Modified by' && $fields->label->modifiedLabel != 'Created on' && $fields->label->modifiedLabel != 'Modified on' && $fields->label->modifiedLabel != 'Ownership') {
				//echo '<pre>';print_r($fields);echo '</pre>';
				
			
				$fieldid = str_replace ( ' ', '', $fields->label->modifiedLabel );
				
				if (isset ( $fields->right [0]->options ) && $fields->right [0]->tag == 'radio') {

					foreach ( $fields->right as $key => $val ) :
						if ($val->tagId != '' && $val->tagName != '') {
							unset ( $customFieldValue [$key] );
						}
						$customFieldValue [$val->tagId . ',' . $val->tagName] = $val->options [0];
					endforeach
					;
				} else {
					$customFieldValue = $fields->right [0]->options;
					
				}

				$fieldsLabel = array (
						$fields->label->modifiedLabel => array (
								'field_id' => strtolower ( $fieldid ),
								'field_show' => array (
										'on' => 'On',
										'off' => 'Off' 
								),
								'field_name' => $fields->label->modifiedLabel,
								'defaulttext' => $fields->label->modifiedLabel,
								'show_order' => '',
								'validation' => $fields->right [0]->tag,
								'field_type' => $fields->right [0]->tag,
								'tag_id' => $fields->right [0]->tagId,
								'tag_name' => $fields->right [0]->tagName,
								'attribute_id' => $fields->attributeId,
								'values' => $customFieldValue 
						) 
				);
				
				array_push ( $apptivoFields, $fieldsLabel );
			}
		}
	}
	
	array_push($apptivoFields,$fieldsLabel1);
	//echo '<pre>';print_r($apptivoFields);exit;
	
	// $subject_field=array('subject'=> array('field_id' => 'subject','field_show' => array('on'=>'On','off'=>'Off'),'field_name' => 'Subject','defaulttext' => 'Subject','show_order' => '','validation' => 'input','field_type' => 'input'));
	$captcha_field = array (
			'captcha' => array (
					'field_id' => 'captcha',
					'field_show' => array (
							'on' => 'On',
							'off' => 'Off' 
					),
					'field_name' => 'Captcha',
					'defaulttext' => 'Captcha',
					'show_order' => '',
					'validation' => 'input',
					'field_type' => 'captcha' 
			) 
	);
	// $country_field=array('country'=> array('field_id' => 'country','field_show' => array('on'=>'On','off'=>'Off'),'field_name' => 'Country','defaulttext' => 'Country','show_order' => '','validation' => 'input','field_type' => 'country'));
	if (isset ( $apptivoFields )) {
		array_push ( $apptivoFields, $captcha_field, $country_field, $first_name, $last_name );
	}
	
	return $apptivoFields;
}
function ajp_cases_data1($contactConfigData, $status, $priority, $type) {
	$cases_status = array ();
	$cases_type = array ();
	$cases_priority = array ();
	$cases_severity = array ();
	
	if (isset ( $status )) {
		foreach ( $status as $caseStatus ) {
			if ($caseStatus->isActive == 'Y') {
				array_push ( $cases_status, $caseStatus );
			}
		}
	}
	if (isset ( $type )) {
		foreach ( $type as $caseType ) {
			if ($caseType->isActive == 'Y') {
				array_push ( $cases_type, $caseType );
			}
		}
	}
	if (isset ( $priority )) {
		foreach ( $priority as $casePriority ) {
			if ($casePriority->isEnabled == 'Y') {
				array_push ( $cases_priority, $casePriority );
			}
		}
	}
	$lead_assignee = $contactConfigData->assigneesList;
	$cases_config = array (
			"caseStatus" => $cases_status,
			"caseType" => $cases_type,
			"casePriority" => $cases_priority,
			'leadAssignee' => $lead_assignee 
	);
	// echo '<pre>';print_r($cases_config);echo '</pre>';exit;
	
	$contact_configDatas = json_encode ( $cases_config );
	
	return $contact_configDatas;
}

function getAnswersConfigData(){
	$api_url = APPTIVO_API_URL . '/app/dao/v6/answers';
	$params = array (
			"a" => "getConfigData",
			"objectId" => KB_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	//echo "<pre>";print_r($response);echo "</pre>";exit;
	return $response;
}
function getAllLeadConfigData1() {
	$params = array (
			"a" => "getLeadConfigData",
			"objectId" => 4,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", APPTIVO_LEAD_API, $params );
	// echo "<pre>";print_r($response);echo "</pre>";exit;
	return $response;
}
function getAllContactConfigData1() {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/contacts';
	$params = array (
			"a" => "getConfigData",
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1( "POST", $api_url, $params );
	// echo "<pre>";print_r($response);echo "</pre>";exit;
	return $response;
}
function getAllCustomerConfigData() {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/customers';
	$params = array (
			"a" => "getConfigData",
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
	);

	$response = getRestAPICall1( "POST", $api_url, $params );
	// echo "<pre>";print_r($response);echo "</pre>";exit;
	return $response;
}
function getAllCasesConfigData() {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$params = array (
			"a" => "getConfigData",
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params );
// 	error_log("KORADA - got case config data as => " . json_encode($response));
	return $response;
}

/*
 * Get All Cases Web Layouts
 */
function getAllCasesLayoutData1() {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$params = array (
			"a" => "getConfigData",
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	// echo "<pre>";print_r($response);echo "</pre>";exit;
	return $response;
}

/*
 * Get All Product Support Ticket Web Layouts
 */
function getAllSupportLayoutData1() {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$params = array (
			"a" => "getConfigData",
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	// po1($params);exit;
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	// echo "<pre>";print_r($response);echo "</pre>";exit;
	return $response;
}
function create1($type, $name, $data, $select, $id, $required = 'required') {
	
	//po1($data);
	session_start ();
	
	if ($name == 'assignee_team') {
		if ($data == '') {
			$data = array (
					'no team' => 'No Team' 
			);
		}
	}
	if ($name == 'assignee_employee') {
		if ($data == '') {
			$data = array (
					'no employee' => 'No Employee' 
			);
		}
	}
	switch ($type) {
		case 'radioButton' :
			$info = null;
			foreach ( $data as $key => $value ) {
				// if statement that detects the selected radioButton
				if ($select == $value) {
					$info .= '<input type="radio" id="' . $id . '" name="' . $name . '" value="' . $value . '" checked=checked  />' . $value;
				} else {
					if ($value == 'Samepage' || $value == 'Button') {
						$check = "checked=checked";
					} else {
						$check = "";
					}
					$info .= '<input type="radio" id="' . $id . '" name="' . $name . '" value="' . $value . '" ' . $check . ' />' . $value;
				}
			}
			return $info;
			break;
		case 'checkBox' :
			$info = null;
			foreach ( $data as $key => $value ) {
				// if statement that detects the selected Checkboxes
				if (isset ( $_POST [$name] ) && in_array ( $value, $_POST [$name] )) {
					$info .= '<input type="checkbox" id="' . $id . '" name="' . $name . '[]' . '" value="' . $value . '" checked=checked />' . $value;
				} else {
					$info .= '<input type="checkbox" id="' . $id . '" name="' . $name . '[]' . '" value="' . $value . '"  />' . $value;
				}
			}
			return $info;
			break;
		case 'option' :
			$field_id = explode ( '_', $id );
			if ($field_id [2] == 'show' || $field_id [2] == 'required') {
				$list_style = "style=width:92px;";
			}
			if ($field_id [1] == 'show' || $field_id [1] == 'required') {
				$list_style = "style=width:92px;";
			}
			if ($field_id [1] == 'show') {
				$onchange = 'onChange=contactform_enablefield("' . $id . '")';
			}
			if ($id == "type_select") {
				$class_style = "class=form-control " . $required;
			}
			if ($id == "status_select") {
				$class_style = "class=form-control " . $required;
			}
			if ($id == "priority_select") {
				$class_style = "class=form-control " . $required;
			}
			
			echo '<select name="' . $name . '" id="' . $id . '" ' . $list_style . ' ' . $class_style . ' ' . $onchange . ' class="form-control">';
			$info .= '<option value="" selected=selected>Select One</option>';
			foreach ( $data as $key => $value ) {
				// if statement that detects the selected Dropdown Item
				if ($select == $value || $select == $key) {
					$info .= '<option value="' . $key . '" selected=selected>' . $value . '</option>';
				} else {
					$info .= '<option value="' . $key . '">' . $value . '</option>';
				}
			}
			return $info . '</select>';
			break;
		case 'customRadio' :
			$info = null;
			foreach ( $data as $key => $value ) {
				// if statement that detects the selected radioButton
				if ($select == $value) {
					$info .= '<input type="radio" id="' . $id . '" name="' . $name . '" value="' . $key . '" checked=checked  />';
					$info .= '<label>' . $value . '</label>';
				} else {
					$info .= '<input type="radio" id="' . $id . '" name="' . $name . '" value="' . $key . '" ' . $check . ' />';
					$info .= '<label>' . $value . '</label>';
				}
			}
			return $info;
			break;
		case 'customOption' :



		
		
		
			echo '<select name="' . $name . '" id="' . $id . '" ' . $list_style . ' ' . $class_style . ' ' . $onchange . ' >';
			
			foreach ( $data as $key => $value ) {
				
				if ($id == 'solution_select' && ($key == 'select one' || ! in_array ( trim ( $value ), $solArray))) {
					continue;
				}else if ($id == 'internalgroup_select'){
					
					if($key == 'select one')
					{
						if($skipSelectOne) continue;
					}
					else if(!in_array ( trim ( $value ), $empTeams))continue;;
					}
				// if statement that detects the selected Dropdown Item
				//po1($select);
				
				
				
			if ($select == $value || $select == $key) {
					
					$info .= '<option value="' . $key . '" selected=selected>' . $value . '</option>';
					
				} else {
					if ($key == 'select one') {
						$key = "";
					}
					$info .= '<option value="' . $key . '">' . $value . '</option>';
				}
			}
			return $info . '</select>';
		
	}
	
}
function array_push_assoc1(&$array, $key, $value) {
	$array [$key] = $value;
	return $array;
}

// function to collect leadstatus,leadType,leadsource leadRank, assignee data from Apptivo
//Context will be create, edit, or view to filter data returned
function get_caseValues1($type, $apptivoCasesData,$context = 'create') {
	if ($type == 'selectCustomFields') {
		$customFields = array (
				'select one' => 'Select One' 
		);
		foreach ( $apptivoCasesData as $val ) {
			$fields = explode ( '||', $val );
			if(isset($fields[4]) && $fields[4] == "true"){
				$customFields [$fields [0]] = $fields [1];
			}
		}
		
		return $customFields;
	}
	if (isset ( $apptivoCasesData )) {
		$con = $apptivoCasesData;
	} //po1($con);
	
	$leadStatus = array ();
	$leadType = array (
			'select one' => 'Select One' 
	);
	$leadSource = array (
			'select one' => 'Select One' 
	);
	$leadRank = array ();
	$leadAssignee = array (
			'' => 'Select' 
	);
	switch ($type) {
		case 'caseStatus' :
			foreach ( $con as $c_key => $c_val ) {
				if ($c_key == 'caseStatus') {
					for($i = 0; $i <= $c_val [$i]; $i ++) {
						if ($c_val [$i] ['isEnabled'] == 'Y') {
							array_push_assoc1 ( $caseStatus, $c_val [$i] ['statusId'], $c_val [$i] ['statusName'] );
						}
					}
					return $caseStatus;
				}
			}
			break;
		case 'casePriority' :
			foreach ( $con as $c_key => $c_val ) {
				if ($c_key == 'casePriority') {
					for($i = 0; $i <= $c_val [$i]; $i ++) {
						if ($c_val [$i] ['isEnabled'] == 'Y') {
							array_push_assoc1 ( $casePriority, $c_val [$i] ['id'], $c_val [$i] ['name'] );
						}
					}
					return $casePriority;
				}
			}
			break;
		case 'caseType' :
			foreach ( $con as $c_key => $c_val ) {
				if ($c_key == 'caseType') {
					for($i = 0; $i <= $c_val [$i]; $i ++) {
						if ($c_val [$i] ['isEnabled'] == 'Y') {
							//If we have a filter enabled we need to check if this status is in the list.  We're going to check that filtering is enabled, then check that the type is in the array that matches our context
							if(FILTER_TYPE && (($context == 'create' && in_array($c_val [$i] ['typeName'],FILTER_TYPE_CREATE)) || ($context == 'edit' && in_array($c_val [$i] ['typeName'],FILTER_TYPE_VIEW)) )){
								array_push_assoc1 ( $caseType, $c_val [$i] ['typeId'], $c_val [$i] ['typeName'] );
							}
						}
					}
					return $caseType;
				}
			}
			break;
		case 'caseSeverity' :
			foreach ( $con as $c_key => $c_val ) {
				if ($c_key == 'caseSeverity') {
					for($i = 0; $i <= $c_val [$i]; $i ++) {
						if ($c_val [$i] ['isEnabled'] == 'Y') {
							array_push_assoc1 ( $caseSeverity, $c_val [$i] ['typeId'], $c_val [$i] ['typeName'] );
						}
					}
					return $caseType;
				}
			}
			break;
		case 'leadEmployee' :
			foreach ( $con as $c_key => $c_val ) {
				if ($c_key == 'leadAssignee') {
					for($i = 0; $i <= $c_val [$i]; $i ++) {
						if ($c_val [$i] ['assigneeObjectId'] == APPTIVO_EMPLOYEE_OBJECT_ID) {
							array_push_assoc1 ( $leadEmployees, $c_val [$i] ['assigneeObjectRefId'], $c_val [$i] ['assigneeName'] );
						}
					}
					return $leadEmployees;
				}
			}
			break;
		case 'leadTeam' :
			foreach ( $con as $c_key => $c_val ) {
				if ($c_key == 'leadAssignee') {
					for($i = 0; $i <= $c_val [$i]; $i ++) {
						if ($c_val [$i] ['assigneeObjectId'] == APPTIVO_TEAM_OBJECT_ID) {
							array_push_assoc1 ( $leadTeams, $c_val [$i] ['assigneeObjectRefId'], $c_val [$i] ['assigneeName'] );
						}
					}
					return $leadTeams;
				}
			}
			break;
	}
}

/*
 * upload document
 */
function uploadDocument1($caseId, $file_name, $file_ext, $file_size, $base64) {
	$api_url = APPTIVO_API_URL . '/app/dao/document';
	
	$sessionKey=$_SESSION['sessionKey'];
	
	$emp_id = $emp->employeeId;
	
	if ($emp_id ==  '') {
		$emp_id = 'null';
	}
	
	$contactName =getContactInfo()->contactName;
	$contactId = getContactInfo()->contactId;
	if(!isEmployeeSet()){
	$params = array (
			"a" => "uploadDoc",
			"createdByObjectId" => CONTACT_OBJECT_ID,
			"createdByObjectRefId" => $contactId,
			"objectId" => CA_APPID,
			"objectRefId" => $caseId,
			"docName" => $file_name,
			"docTitle" => $file_name,
			"docType" => $file_ext,
			"docSize" => $file_size,
			"encodedDocStr" => $base64,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	}
	else {
		$params = array (
			"a" => "uploadDoc",
			"createdByObjectId" => EMPLOYEE_OBJECT_ID,
			"createdByObjectRefId" =>$emp_id,
			"objectId" => CA_APPID,
			"objectRefId" => $caseId,
			"docName" => $file_name,
			"docTitle" => $file_name,
			"docType" => $file_ext,
			"docSize" => $file_size,
			"encodedDocStr" => $base64,
			"sessionKey" => $sessionKey,
			 
		);
		
	}
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	return $response;
}

/*
 * get ContactsID
 */
function getXinnectContactId($sessionKey) {
	$api_url = APPTIVO_API_URL . '/app/dao/v6/xinnect';
	
	$params = array (
			"a" => "getContact",
			"sessionKey" => $sessionKey 
	);
	 po1($params);
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	 po1($response);
	return $response;
}

/*
 * get CustomerID
 */
function getXinnectCustomerId($sessionKey) {
	$api_url = APPTIVO_API_URL . '/dao/v5/carm';
	
	$params = array (
			"a" => "getCustomer",
			"sessionKey" => $sessionKey 
	);
	// po1($params);
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	// po1($response);
	return $response;
}

/*
 * Create Product Support Ticket
 */
function saveTicketForm($employeeId, $firstName, $lastName, $caseNumber, $caseStatus, $caseStatusId, $caseSource, $caseSourceId, $caseType, $caseTypeId, $casePriority, $casePriorityId, $assignedName, $assigneeObjId, $assigneeObjRefId, $caseSummary, $caseDescription, $emailId, $case_assignee, $caseAssociates, $createAssociates, $case_custom_fields, $caseSeverity, $caseSeverityId, $casePayVersion, $casePayVersionId, $casePayCritical, $casePayCriticalId, $case_attribute_json_str = '') {
	
	
	$sessionKey = $_SESSION ['sessionKey'];
	$contactId = $_SESSION ['contactId'];
	$contactName = $_SESSION ['contactName'];
	$customerId = $_SESSION ['customerId'];
	$customerName = $_SESSION ['customerName'];
	
	
	if ($contactId == '' && $contactName == '') {
		$contactId = 'null';
		$contactName = "";
	}
	if ($customerId == '' && $customerName == '') {
		$customerId = 'null';
		$customerName = "";
	}
	$emailId = getUserEmail();
	if ($casePriority == 'Select One' && $casePriorityId == '') {
		$casePriority = '';
		$casePriorityId = 'null';
	}
	if ($caseType == 'Select One' && $caseTypeId == '') {
		$caseType = '';
		$caseTypeId = 'null';
	}
	if ($caseStatus == 'Select One' && $caseStatusId == '') {
		$caseStatus = '';
		$caseStatusId = 'null';
	}
	$customAttributes = ',"customAttributes":[]';
	$case = new stdClass();
	$case->createdByObjectId = CONTACT_OBJECT_ID;
	$case->createdByObjectRefId = "" . $contactId;
	$case->lastUpdatedByObjectId = CONTACT_OBJECT_ID;
	$case->lastUpdatedByObjectRefId = "" . $contactId;
	$case->caseContactId = $contactId;
	$case->caseContact = $contactName;
	$case->caseCustomerId = $customerId;
	$case->caseCustomer = $customerName;
	$case->assignedObjectId = DEFAULT_ASSIGNEE_TYPE_ID;
	$case->assignedObjectRefId = DEFAULT_ASSIGNEE_OBJECT_ID;
	$case->assignedObjectRefName = DEFAULT_ASSIGNEE_NAME;
	$case->caseType = $caseType;
	$case->caseTypeId = $caseTypeId;
	$case->caseStatus = $caseStatus;
	$case->caseStatusId = $caseStatusId;
	$case->casePriority = $casePriority;
	$case->casePriorityId = $casePriorityId;
	$case->caseEmail = $emailId;
	$case->caseNumber = "Auto generated number";
	$case->caseSummary = $caseSummary;
	$case->description = $caseDescription;
	$case->caseContactId = $contactId;
	$case->caseContact = $contactName; 
	$case->caseCustomerId = $customerId; 
	$case->caseCustomer = $customerName;
	

	$case->caseSourceName = $caseSource;
	$case->caseSourceId = $caseSourceId;
	$api_params = json_encode($case);
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	
	if(isEmployeeSet()){
		
		$params = array (
				"a" => "save",
				"caseData" => $api_params,
				"appId" => CA_APPID,
				"sessionKey" => $sessionKey
				//"apiKey" => APPTIVO_API_KEY,
				//"accessKey" => APPTIVO_ACCESS_KEY
		);
		
	}else{
		$params = array (
				"a" => "save",
				"caseData" => $api_params,
				"appId" => CA_APPID,
				"apiKey" => APPTIVO_API_KEY,
				"accessKey" => APPTIVO_ACCESS_KEY
		);
	}
	
	
	//po1($params);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	
	
	return $response;
}

/*
 * Update Case
 */
function updateCasesForm2($caseId, $caseData) {
	$sessionKey = $_SESSION ['sessionKey'];
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	$params = array (
			"a" => "update",
			"caseId" => $caseId,
			"caseData" => $caseData,
			"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","caseContact","caseContactNew","customAttributes"]',
			"isCustomAttributesUpdate" => "true",
			"isAddressUpdate" => "false",
			"appId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	$response = getRestAPICall1 ( "POST", $api_url, $params );
	return $response;
}

/*
 * Update Product Support Ticket
 */
function updateTicketForm($caseId, $employeeId, $firstName, $lastName, $caseNumber, $caseStatus, $caseStatusId, $caseType, $caseTypeId, $casePriority, $casePriorityId, $assignedName, $assigneeObjId, $assigneeObjRefId, $caseSummary, $caseDescription, $emailId, $case_assignee, $caseAssociates, $createAssociates, $case_custom_fields, $caseSeverity, $caseSeverityId, $casePayVersion, $casePayVersionId, $casePayCritical, $casePayCriticalId, $case_attribute_json_str = '') {
	$sessionKey = $_SESSION ['sessionKey'];
	$contactId = $_SESSION ['contactId'];
	$contactName = $_SESSION ['contactName'];
	$customerId = $_SESSION ['customerId'];
	$customerName = $_SESSION ['customerName'];
	if ($contactId == '' && $contactName == '') {
		$contactId = 'null';
		$contactName = "";
	}
	if ($customerId == '' && $customerName == '') {
		$customerId = 'null';
		$customerName = "";
	}
	$emailId = getUserEmail();
	
	if ($case_attribute_json_str != '') {
		$customAttributes = ',"customAttributes":' . $case_attribute_json_str;
	} else {
		$customAttributes = ',"customAttributes":[]';
	}
	
	$caseData = '{"caseId":' . $caseId . ',"caseStatus":"' . $caseStatus . '","caseStatusId":' . $caseStatusId . ',"caseType":"' . $caseType . '","caseTypeId":' . $caseTypeId . ',"casePriority":"' . $casePriority . '","casePriorityId":' . $casePriorityId . ',"caseSummary":"' . $caseSummary . '","description":"' . $caseDescription . '","caseContactId":' . $contactId . ',"caseContact":"' . $contactName . '","accountId":' . $customerId . ',"accountName":"' . $customerName . '"' . $customAttributes . '}';
	$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
	
	$params = array (
			"a" => "update",
			"caseId" => $caseId,
			"caseData" => $caseData,
			"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","customAttributes"]',
			"isCustomAttributesUpdate" => "true",
			"isAddressUpdate" => "false",
			"appId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
//po1($params);
	// $response1 = getRestAPICall1("POST", $api_url , $params);
	
	$params1 = array (
			"a" => "update",
			"caseId" => $caseId,
			"caseData" => $caseData,
			"attributeName" => '["caseType","caseSummary","description","caseStatus","casePriority","customAttributes","' . CA_SEVERITY_NAME . '","customAttributes","' . CA_PAYVERSION_NAME . '","customAttributes","' . CA_PAYCRITICAL_NAME . '"]',
			"isCustomAttributesUpdate" => "true",
			"isAddressUpdate" => "false",
			"appId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);
	
	$response = getRestAPICall1 ( "POST", $api_url, $params1 );
	
	return $response;
}

if ($_GET ['a'] == 'logout') {
	if (session_id () == '' || ! isset ( $_SESSION )) {
		session_start ();
	}
	session_destroy ();
}

//ajax calls for lazy loading
add_action ( 'wp_ajax_getAttachments', 'getAttachments' );
add_action ( 'wp_ajax_nopriv_getAttachments', 'getAttachments' );
function getAttachments() {
	$caseId = $_POST ['id'];
	$attachments = get_all_documents_objId1 ( $caseId );
	$attachmentList = $attachments->aaData;	
	$outputArr = Array(
		"count" => count($attachmentList),
		"results" => $attachmentList,
	);	
	print json_encode($outputArr);
	exit ();
}
add_action ( 'wp_ajax_getNotes', 'getNotes' );
add_action ( 'wp_ajax_nopriv_getNotes', 'getNotes' );
function getNotes() {
	$caseId = $_POST ['id'];
	$notesEmailList = getNotesEmailByObjectId($caseId);
	$notesList = $notesEmailList->wallEntries; 
	$outputArr = Array(
		"count" => count($notesList),
		"results" => $notesList,
	);	
	print $notesEmailList;
	exit ();
}
add_action ( 'wp_ajax_markClosed', 'markClosed' );
add_action ( 'wp_ajax_nopriv_markClosed', 'markClosed' );
function markClosed() {
	$caseData = $_POST ['caseData'];
	$caseData['caseStatus'] = CLOSED_STATUS_NAME;
	$caseData['caseStatusId'] = CLOSED_STATUS_ID;
	//Now call the API method to update the case
	require_once ('class.apptivo.php');
	$apptivoApi = new apptivoApi(APPTIVO_API_KEY, APPTIVO_ACCESS_KEY, API_USER_EMAIL);
	$updatedCase = $apptivoApi->update('cases',$caseData['caseId'],'["caseStatus"]',json_encode($caseData),'&attributeIds=["case_status_attr"]');
	if ($updatedCase != '') {
		echo 'success';
	} else {
		echo 'failure';
	}
	exit ();	
}
add_action ( 'wp_ajax_reopen', 'reopen' );
add_action ( 'wp_ajax_nopriv_reopen', 'reopen' );
function reopen() {
	$caseData = $_POST ['caseData'];
	$caseData['caseStatus'] = REOPEN_STATUS_NAME;
	$caseData['caseStatusId'] = REOPEN_STATUS_ID;
	//Now call the API method to update the case
	require_once ('class.apptivo.php');
	$apptivoApi = new apptivoApi(APPTIVO_API_KEY, APPTIVO_ACCESS_KEY, API_USER_EMAIL);
	$updatedCase = $apptivoApi->update('cases',$caseData['caseId'],'["caseStatus"]',json_encode($caseData),'&attributeIds=["case_status_attr"]');
	if ($updatedCase != '') {
		echo 'success';
	} else {
		echo 'failure';
	}
	exit ();	
}
?>