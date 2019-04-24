<?php

function initSession(){
	
	if (session_id () == '' || ! isset ( $_SESSION )) {
		session_start ();
	}
}
function getCaseConfigData(){
	
	return $_SESSION['caseConfigData'];
	
}

function setCaseConfigData($paramConfigData){
	
// 	error_log("KORADA .. setting the config data into session");
// 	error_log("KORDA and the data is .. " . print_r($paramConfigData,true));

	$_SESSION['caseConfigData'] = $paramConfigData;
	//po1($_SESSION['caseConfigData'] );

}

function setKBConfigData($configData){
	$_SESSION['KBconfigData'] = $configData;
}

function getKBConfigData()
{
	return $_SESSION['KBconfigData'];
}

function getLeadConfigData(){

	return $_SESSION['leadConfigData'];

}

function setLeadConfigData($configData){

	$_SESSION['leadConfigData'] = $configData;

}


function getContactConfigData(){

	return $_SESSION['contactConfigData'];

}

function setContactConfigData($configData){

	$_SESSION['contactConfigData'] = $configData;

}


function getCustomerConfigData(){

	return $_SESSION['customerConfigData'];

}

function setCustomerConfigData($configData){

	$_SESSION['customerConfigData'] = $configData;

}

function getSessionKey(){
	return $_SESSION ['sessionKey'];
}

function setSessionKey($sessionKey){
	$_SESSION ['sessionKey'] = $sessionKey;
}

function setUserEmail($userEmail){
	
	$_SESSION['userEmail'] = $userEmail;
}

function isUserSet(){
	return isset($_SESSION['userEmail']);
}

function isEmployeeSet(){
	return isset($_SESSION['setemp']);
}



function getUserEmail(){
	return $_SESSION['userEmail'];
}


function setEmpTeams($empTeams){
	$_SESSION['EMP_TEAMS'] = $empTeams;
}

function getEmpTeams(){
	return $_SESSION['EMP_TEAMS'];
}
?>