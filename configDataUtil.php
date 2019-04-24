<?php

/* Get Previleged User for Employee */

function getuserPrivilegeMap(){
	$userPrevilege = getEmpDetails()->userPrivilegeMap;
	$userPrevilege = get_object_vars($userPrevilege);
	return $userPrevilege;
}





function retrieveAccreditedOption() {
	$contactConfigData = getContactConfigData ();
	$layout = json_decode ( $contactConfigData->webLayout );
	
	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == 'Accredited User') {
				error_log ( "KORADA - ACCREDITED ATTR  => " . json_encode ( $attribute ) );
				setAccreditedAttributeId ( $attribute->attributeId );
				setUserAccreditedOptions ( $attribute->right );
				break;
			}
		}
	}
	
	error_log ( "KORADA - ACCREDITED VALUES => " . json_encode ( getUserAccreditedOptions () ) );
	error_log ( "KORADA - ACCREDITED ATTR ID => " . getAccreditedAttributeId () );
	
	// $contactConfigLayout = json_decode ( $contactConfigData->webLayout, true );
	
	// $contact_sections = $contactConfigLayout ['sections'];
	// // po1($contact_sections);
	
	// $ca_accredited_user_id = '';
	// foreach ( $contact_sections as $cont_sections ) {
	// if ($cont_sections ['id'] == 'addtional_inf_section' || $cont_sections ['id'] == 'contact_inf_section') {
	// // echo 'aa'; exit;
	// foreach ( $cont_sections ['attributes'] as $add_info_attributes ) {
	
	// if ($add_info_attributes ['type'] == 'Custom' && $add_info_attributes ['label'] ['modifiedLabel'] == 'Accredited User') {
	// $ca_accredited_user_id = $add_info_attributes ['attributeId'];
	// // echo $ca_accredited_user_id;
	// $_SESSION ['ACC_USER_OPTION'] = $add_info_attributes ['right'];
	// }
	// }
	// }
	// }
}

function getSubStatusAttrDefn() {
	$caseConfigData = getCaseConfigData();
	$layout = json_decode ( $caseConfigData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
// 			error_log("KORADA 47- option" .$attribute->label->modifiedLabel);
			if ($attribute->label->modifiedLabel == "Sub-Status") {
				error_log("KORADA - option found " . json_encode($attribute));
				return $attribute;
			}
		}
	}
	error_log("KORADA - no option found " );
}


function getSeverityAttrDefn() {
	$caseConfigData = getCaseConfigData();
	$layout = json_decode ( $caseConfigData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
// 			error_log("KORADA 47- option" .$attribute->label->modifiedLabel);
			if ($attribute->label->modifiedLabel == "Severity") {
				error_log("KORADA - option found " . json_encode($attribute));
				return $attribute;
			}
		}
	}
	error_log("KORADA - no option found " );
}


function getpayVersionAttrDefn(){
	$caseConfigData = getCaseConfigData();
	$layout = json_decode ( $caseConfigData->webLayout );
foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Your current Ascender Pay Version") {
				return $attribute;
			}
		}
	}
}

function getcriticalPatchAttrDefn(){
	$caseConfigData = getCaseConfigData();
	$layout = json_decode ( $caseConfigData->webLayout );
foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Your Current Ascender Pay Critical Patch") {
				return $attribute;
			}
		}
	}
}


function getapEnvironmentAttrDefn(){
	$caseConfigData = getCaseConfigData();
	$layout = json_decode ( $caseConfigData->webLayout );
foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "AP Environment") {
				return $attribute;
			}
		}
	}
}


function getSolutionAttrDefn(){
	$caseConfigData = getCaseConfigData();
	$layout = json_decode ( $caseConfigData->webLayout );
foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Solution") {
				return $attribute;
			}
		}
	}
}



function getClientRepliedOption($attribute){
	
	foreach($attribute->right[0]->optionValueList as $option){
		if($option->optionObject == "Client Replied"){
			return $option;
		}		
	}
	return null;
}


function getInProgressStatus(){
	$caseConfigData = getCaseConfigData ();
	$statuses = $caseConfigData->statuses;
	//po1($statuses);
	$inprogress = new stdClass();
	foreach ( $statuses as $status ) {
		if ($status->statusName == INPROGRESS_STATUS_NAME) {
			$inprogress->statusId = $status->statusId;
			$inprogress->statusCode = $status->statusCode;
			$inprogress->statusName = $status->statusName;
			return $inprogress;
		}
	}
}

function getStatusArray(){

	$statusIds = array();
	$caseConfigData = getCaseConfigData ();
	$statuses = $caseConfigData->statuses;
	foreach ( $statuses as $status ) {
		$statusIds[] = $status->statusId;
	}
	return $statusIds;
}


function getStatusValues() {
	$contactConfigData = getContactConfigData ();
	$layout = json_decode ( $contactConfigData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == 'Sub-Status') {
				return $attribute;
			}
		}
	}
}

function getContactInfo() {
	$contact =new stdClass();
	$contact->contactId = $_SESSION['contactId'];
	$contact->contactName = $_SESSION['contactName'];
	$contact->customerId = $_SESSION['customerId'];
	$contact->customerName = $_SESSION['customerName'];
	
	return $contact;
}


function getCustomerSupportLevelAttr($empCustomerData){

	$customerSupportLevelAttrDefn = getCustomerSupportLevelAttrDefn();

	$caseSupportLevelAttrDefn = getCaseSupportLevelAttrDefn();

	
	
	if(!isEmployeeSet()){
	$customer = getCustomerSessionData();
	}
	else{
	$customer = $empCustomerData;
	}



	$attrsCount = count($customer->customAttributes);

	for($i=0;$i<$attrsCount;$i++){

		if(isset($customerSupportLevelAttrDefn) && $customer->customAttributes[$i]->customAttributeId == $customerSupportLevelAttrDefn->attributeId){
				
			error_log("KORADA .. custom attribute support level => " . json_encode($customer->customAttributes[$i]));
			$customAttribute = new stdClass();
				
			$customAttribute->customAttributeId = $caseSupportLevelAttrDefn->attributeId;
			$customAttribute->customAttributeName = $caseSupportLevelAttrDefn->right[0]->tagName;
			$customAttribute->attributeId = $customer->customAttributes[$i]->customAttributeId;
			$customAttribute->customAttributeValue = $customer->customAttributes[$i]->customAttributeValue;
			$customAttribute->customAttributeValueId = $customer->customAttributes[$i]->customAttributeValueId;
			$customAttribute->attributeType = "referenceField";
				
			return $customAttribute;
		}
	

	}
	
if($customAttribute == null){		
			$customAttribute = new stdClass();
				
			$customAttribute->customAttributeId = $caseSupportLevelAttrDefn->attributeId;
			$customAttribute->customAttributeName = $caseSupportLevelAttrDefn->right[0]->tagName;
			$customAttribute->attributeId = $caseSupportLevelAttrDefn->attributeId;
			$customAttribute->customAttributeValue = "";
			$customAttribute->customAttributeValueId = "";
			$customAttribute->attributeType = "referenceField";
				
			return $customAttribute;
		
			
		}



}


function getCustomerAccountManagerAttrDefn() {
	$configData = getCustomerConfigData();
	$layout = json_decode ( $configData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Payroll AM") {
				return $attribute;
			}
		}
	}
}

function getCaseAccountManagerDefn() {
	$configData = getCaseConfigData();
	$layout = json_decode ( $configData->webLayout );
	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Account Manager") {
				return $attribute;
			}
		}
	}
}


function getCustomerAccountManagerAttr($empCustomerData){

	$customerAMAttrDefn = getCustomerAccountManagerAttrDefn();

	$caseAMAttrDefn = getCaseAccountManagerDefn();

	if(!isEmployeeSet()){
	$customer = getCustomerSessionData();
	}
	else{
	$customer = $empCustomerData;
	}

	$attrsCount = count($customer->customAttributes);

	for($i=0;$i<$attrsCount;$i++){

		if(isset($customerAMAttrDefn) && $customer->customAttributes[$i]->customAttributeId == $customerAMAttrDefn->attributeId){
				
			$customAttribute = new stdClass();
			$tag_name=	$caseAMAttrDefn->right[0]->tagName;
			$customAttribute->customAttributeId = $caseAMAttrDefn->attributeId;
			$customAttribute->customAttributeValue = $customer->customAttributes[$i]->customAttributeValue;
			$customAttribute->attributeType = "referenceField";
			$customAttribute->customAttributeTagName=$caseAMAttrDefn->right[0]->tagName;
			$customAttribute->customAttributeName = $caseAMAttrDefn->right[0]->tagName;
			$customAttribute->$tag_name = $customer->customAttributes[$i]->customAttributeValue;
			$customAttribute->attributeId = $customer->customAttributes[$i]->customAttributeId;
			$customAttribute->objectId = $customer->customAttributes[$i]->objectId;
			$customAttribute->objectRefId = $customer->customAttributes[$i]->objectRefId;
			$customAttribute->fieldType = "reference";
			$customAttribute->objectRefName = $customer->customAttributes[$i]->customAttributeValue;
			
			
			return $customAttribute;
		
		}
	}
	
	
}



function getCustomerServiceLevelAttrDefn() {
	$configData = getCustomerConfigData();
	$layout = json_decode ( $configData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Service Level") {
				return $attribute;
			}
		}
	}
}

function getCaseServiceLevelAttrDefn() {
	$configData = getCaseConfigData();
	$layout = json_decode ( $configData->webLayout );
	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Service Level") {
				return $attribute;
			}
		}
	}
}



function getCustomerServiceLevelAttr($empCustomerData){

	$customerServiceLevelAttrDefn = getCustomerServiceLevelAttrDefn();

	$caseServiceLevelAttrDefn = getCaseServiceLevelAttrDefn();



	if(!isEmployeeSet()){
		$customer = getCustomerSessionData();
	}
	else{
		$customer = $empCustomerData;
	}



	$attrsCount = count($customer->customAttributes);

	for($i=0;$i<$attrsCount;$i++){

		if(isset($customerServiceLevelAttrDefn) && $customer->customAttributes[$i]->customAttributeId == $customerServiceLevelAttrDefn->attributeId){

			//error_log("KORADA .. custom attribute support level => " . json_encode($customer->customAttributes[$i]));
			$customAttribute = new stdClass();

			$customAttribute->customAttributeId = $caseServiceLevelAttrDefn->attributeId;
			$customAttribute->customAttributeName = $caseServiceLevelAttrDefn->right[0]->tagName;
			$customAttribute->attributeId = $customer->customAttributes[$i]->customAttributeId;
			$customAttribute->customAttributeValue = $customer->customAttributes[$i]->customAttributeValue;
			$customAttribute->customAttributeValueId = $customer->customAttributes[$i]->customAttributeValueId;
			$customAttribute->attributeType = "referenceField";

			return $customAttribute;
		}


	}

	if($customAttribute == null){
		$customAttribute = new stdClass();

		$customAttribute->customAttributeId = $caseServiceLevelAttrDefn->attributeId;
		$customAttribute->customAttributeName = $caseServiceLevelAttrDefn->right[0]->tagName;
		$customAttribute->attributeId = $caseServiceLevelAttrDefn->attributeId;
		$customAttribute->customAttributeValue = "";
		$customAttribute->customAttributeValueId = "";
		$customAttribute->attributeType = "referenceField";

		return $customAttribute;

			
	}



}





function getCustomerCountryAttrDefn() {
	$configData = getCustomerConfigData();
	$layout = json_decode ( $configData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Country") {
				return $attribute;
			}
		}
	}
}


function getCaseCountryDefn() {
	$configData = getCaseConfigData();
	$layout = json_decode ( $configData->webLayout );
	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "Country") {
				return $attribute;
			}
		}
	}
}

function getCustomerCountryAttr($empCustomerData){

	$customerCountryAttrDefn = getCustomerCountryAttrDefn();

	$caseCountryAttrDefn = getCaseCountryAttrDefn();



	if(!isEmployeeSet()){
		$customer = getCustomerSessionData();
	}
	else{
		$customer = $empCustomerData;
	}



	$attrsCount = count($customer->customAttributes);

	for($i=0;$i<$attrsCount;$i++){

		if(isset($customerCountryAttrDefn) && $customer->customAttributes[$i]->customAttributeId == $customerCountryAttrDefn->attributeId){

			//error_log("KORADA .. custom attribute support level => " . json_encode($customer->customAttributes[$i]));
			$customAttribute = new stdClass();

			$customAttribute->customAttributeId = $caseCountryAttrDefn->attributeId;
			$customAttribute->customAttributeName = $caseCountryAttrDefn->right[0]->tagName;
			$customAttribute->attributeId = $customer->customAttributes[$i]->customAttributeId;
			$customAttribute->customAttributeValue = $customer->customAttributes[$i]->customAttributeValue;
			$customAttribute->customAttributeValueId = $customer->customAttributes[$i]->customAttributeValueId;
			$customAttribute->attributeType = "referenceField";

			return $customAttribute;
		}


	}

	if($customAttribute == null){
		$customAttribute = new stdClass();

		$customAttribute->customAttributeId = $caseCountryAttrDefn->attributeId;
		$customAttribute->customAttributeName = $caseCountryAttrDefn->right[0]->tagName;
		$customAttribute->attributeId = $caseCountryAttrDefn->attributeId;
		$customAttribute->customAttributeValue = "";
		$customAttribute->customAttributeValueId = "";
		$customAttribute->attributeType = "referenceField";

		return $customAttribute;

			
	}



}


function getCustomerStateAttrDefn() {
	$configData = getCustomerConfigData();
	$layout = json_decode ( $configData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "State") {
				return $attribute;
			}
		}
	}
}

function getCaseStateAttrDefn() {
	$configData = getCaseConfigData();
	$layout = json_decode ( $configData->webLayout );
	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			if ($attribute->label->modifiedLabel == "State") {
				return $attribute;
			}
		}
	}
}



function getCustomerStateAttr($empCustomerData){

	$customerStateAttrDefn = getCustomerStateAttrDefn();

	$caseStateAttrDefn = getCaseStateAttrDefn();



	if(!isEmployeeSet()){
		$customer = getCustomerSessionData();
	}
	else{
		$customer = $empCustomerData;
	}



	$attrsCount = count($customer->customAttributes);

	for($i=0;$i<$attrsCount;$i++){

		if(isset($customerStateAttrDefn) && $customer->customAttributes[$i]->customAttributeId == $customerStateAttrDefn->attributeId){

			//error_log("KORADA .. custom attribute support level => " . json_encode($customer->customAttributes[$i]));
			$customAttribute = new stdClass();

			$customAttribute->customAttributeId = $caseStateAttrDefn->attributeId;
			$customAttribute->customAttributeName = $caseStateAttrDefn->right[0]->tagName;
			$customAttribute->attributeId = $customer->customAttributes[$i]->customAttributeId;
			$customAttribute->customAttributeValue = $customer->customAttributes[$i]->customAttributeValue;
			$customAttribute->customAttributeValueId = $customer->customAttributes[$i]->customAttributeValueId;
			$customAttribute->attributeType = "referenceField";

			return $customAttribute;
		}


	}

	if($customAttribute == null){
		$customAttribute = new stdClass();

		$customAttribute->customAttributeId = $caseStateAttrDefn->attributeId;
		$customAttribute->customAttributeName = $caseStateAttrDefn->right[0]->tagName;
		$customAttribute->attributeId = $caseStateAttrDefn->attributeId;
		$customAttribute->customAttributeValue = "";
		$customAttribute->customAttributeValueId = "";
		$customAttribute->attributeType = "referenceField";

		return $customAttribute;

			
	}



}



function getCaseContactPhoneDefn() {
	$configData = getCaseConfigData();
	$layout = json_decode ( $configData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			// 			 			error_log("KORADA 47- option- " .$attribute->label->modifiedLabel);
			if ($attribute->label->modifiedLabel == "Phone") {
				// 				error_log("KORADA - Case Publish PST's " . json_encode($attribute));
				return $attribute;
			}
		}
	}
	// 	error_log("KORADA - Case Publish PST's found " );
}

function getCaseContactEmailDefn() {
	$configData = getCaseConfigData();
	$layout = json_decode ( $configData->webLayout );

	foreach ( $layout->sections as $section ) {
		foreach ( $section->attributes as $attribute ) {
			// 			 			error_log("KORADA 47- option- " .$attribute->label->modifiedLabel);
			if ($attribute->label->modifiedLabel == "Email") {
				// 				error_log("KORADA - Case Publish PST's " . json_encode($attribute));
				return $attribute;
			}
		}
	}
	// 	error_log("KORADA - Case Publish PST's found " );
}


function isQuestionMatched($question, $solutionAttr, $categoryAttr, $subCategoryAttr, $catVal,$subCatVal){
	
	$solutionValue = "";
	$catValue="";
	$subCatValue="";
	$customAttributes = $question->customAttributes;
	foreach($customAttributes as $attr){
		
		if($attr->customAttributeId == $solutionAttr){
			$solutionValue = $attr->customAttributeValue;
		}else if($attr->customAttributeId == $categoryAttr){
			$catValue = $attr->customAttributeValue;
		}else if($attr->customAttributeId == $subCategoryAttr){
			$subCatValue = $attr->customAttributeValue;
		}
		
	}
	error_log("KORADA => for question -> " . $question->id . " => " . $solutionValue. " => " .$catValue. " => " .$subCatValue);
	error_log("KORADA => for checking -> " . $question->id . " => " . "Solution". " => " .$catVal. " => " .$subCatVal);
	if($solutionValue == 'Solution'){
		if(isset($catVal)){
			if($catVal == $catValue) return true;
		}
		if(isset($subCatVal)){
			if($subCatVal == $subCatValue) return true;
		}
		
	}
	return false;

}


function getSolutionNumber($question){
	
	$questionNo = $question->questionNumber;
	return $questionNo;

}
?>