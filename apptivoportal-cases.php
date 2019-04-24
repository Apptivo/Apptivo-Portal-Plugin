<?php
/*
 * Plugin Name: Apptivo Portal
 * Plugin URI: http://www.apptivo.com
 * Description: Apptivo Customer Portal for Ticketing
 * Version: 1.0
 * Author: Apptivo
 * Author URI: http://www.apptivo.com/
 */
include_once ('config.php');
require_once ('commonFunctions.php');
include_once ('sessionDataUtil.php');
include_once ('configDataUtil.php');
include_once ('createCase.php');
include_once ('viewCase.php');
include_once ('loginPage.php');
//include_once ('registerPage.php');
include_once ('editCase.php');
//include_once ('questions.php');
//include_once ('viewAnswer.php');
//include_once ('createQuestion.php');
include_once ('casesList.php');
include_once ('parameterUtil.php');
include_once ('changePassword.php');

add_shortcode ( 'login_page', 'login_shortcode' );
function login_shortcode() {
	ob_start ();

	login_form_code ();

	return ob_get_clean ();
}


add_shortcode( 'employee_login_page', 'emp_login_shortcode' );
function emp_login_shortcode() {
	ob_start ();

	login_form_code ();

	return ob_get_clean ();
}



add_shortcode ( 'register_page', 'register_shortcode' );
function register_shortcode() {
	ob_start ();

	register_form_code ();

	return ob_get_clean ();
}


add_shortcode ( 'create_case_page', 'createCase_shortcode' );
function createCase_shortcode() {
	ob_start ();

	createCase_form ();

	return ob_get_clean ();
}
//My Open Tickets
add_shortcode ( 'my_case_page', 'myCase_shortcode' );
function myCase_shortcode() {
	initSession ();
	ob_start ();
	if(!isEmployeeSet()){
		$params = getAllMyTicketsParams ();
		// listCases_form ();
		ticket_list ( $params );
	}
	else
	{
		$params = getEmployeeMyOpenTicketsParams();
		ticket_list ( $params );
		 
	}
	return ob_get_clean ();
}

// All Tickets
add_shortcode ( 'all_cases_page', 'allCases_shortcode' );
function allCases_shortcode() {

	initSession ();
	ob_start ();
	if(!isEmployeeSet()){
		$params = getAllTicketsParams ();
		// listCases_form ();
		ticket_list ( $params );
	}
	else
	{
		$params = getEmployeeAllTicketsParams ();
		ticket_list ( $params );
	}
	return ob_get_clean ();
}

add_shortcode ( 'search_cases_page', 'searchCases_shortcode' );
function searchCases_shortcode() {
	initSession ();
	ob_start ();
	if (!empty ($_POST) && isset($_POST['submit']) && $_POST['submit'] == 'Search'){

		$params = getSearchTicketsParams ();
		$_SESSION ['searched_params'] = $params;

	}else{
		$params = $_SESSION ['searched_params'];
	}
	ticket_list ( $params );

	return ob_get_clean ();
}

//All Open Ticekts
add_shortcode ( 'open_ticket_page', 'open_ticket_shortcode' );
function open_ticket_shortcode() {
	ob_start ();
	if(!isEmployeeSet()){
		$params = getAllOpenTicketsParams ();
		// open_ticket_form();
		ticket_list ( $params );
	}
	else
	{
		$params = getEmployeeAllOpenTicketsParams ();
		ticket_list ( $params );
	}
	return ob_get_clean ();
}


//My Closed Tickets
add_shortcode ( 'close_ticket_page', 'close_ticket_shortcode' );
function close_ticket_shortcode() {
	ob_start ();
	if(!isEmployeeSet()){
		$params = getAllClosedTicketsParams ();
		// close_ticket_form();
		ticket_list ( $params );
	}
	else
	{
		$params = getEmployeeAllClosedTicketsParams();
		ticket_list ( $params );
		 
	}
	return ob_get_clean ();
}

//Tickets Pending Action
add_shortcode ( 'client_ticket_page', 'client_ticket_shortcode' );
function client_ticket_shortcode() {
	ob_start ();
	if(!isEmployeeSet()){
		$params = getMyPendingActionTicketsParams ();
		// client_ticket_form();
		ticket_list ( $params );
	}
	else
	{
		$params = getEmployeePendingActionTicketsParams();
		ticket_list ( $params );
	}
	return ob_get_clean ();
}


//My Team's Open Tickets
add_shortcode ( 'myteam_open_ticket_page', 'myteam_open_ticket_shortcode' );
function myteam_open_ticket_shortcode() {
	ob_start ();
	if(isEmployeeSet()){
		$params = getEmployeeMyTeamOpenTicketsParams();
		// client_ticket_form();
		ticket_list ( $params );
	}
	return ob_get_clean ();
}


//All My Team's Open Tickets
add_shortcode ( 'all_myteam_ticket_page', 'all_myteam_ticket_shortcode' );
function all_myteam_ticket_shortcode() {
	ob_start ();
	if(isEmployeeSet()){
		$params = getEmployeeAllMyTeamTicketsParams();
		// client_ticket_form();
		ticket_list ( $params );
	}
	return ob_get_clean ();
}



add_shortcode ( 'view_case_page', 'viewCase_shortcode' );
function viewCase_shortcode() {
	ob_start ();

	viewCase_form ();
	return ob_get_clean ();
}

add_shortcode ( 'edit_case_page', 'editCase_shortcode' );
function editCase_shortcode() {
	ob_start ();
	editCase_form ();
	return ob_get_clean ();
}

add_shortcode ( 'answers_page', 'answers_shortcode' );
function answers_shortcode() {
	ob_start ();

	answers_form ();
	return ob_get_clean ();
}

add_shortcode ( 'view_answers_page', 'view_answers_shortcode' );
function view_answers_shortcode() {
	ob_start ();

	view_answers_form ();
	return ob_get_clean ();
}

add_shortcode ( 'create_question_page', 'create_question_shortcode' );
function create_question_shortcode() {
	ob_start ();

	create_question_form ();
	return ob_get_clean ();
}

add_shortcode ( 'change_password_page', 'change_password_shortcode' );
function change_password_shortcode() {
	ob_start ();

	change_password_form ();
	return ob_get_clean ();
}

add_filter ( 'wp_nav_menu_items', 'wti_loginout_menu_link1', 10, 2 );
function wti_loginout_menu_link1($items, $args) {
	$login_case_url = esc_url ( get_permalink ( get_page_by_title ( 'Login' ) ) );
	if (session_id () == '' || ! isset ( $_SESSION )) {
		session_start ();
	}
	if (isset ( $_SESSION ['user'] ['email'] ) && $_SESSION ['user'] ['email'] != '') {
		$my_case_url = esc_url ( get_permalink ( get_page_by_title ( 'My '.OBJECT_NAME_PLURAL ) ) );
		$knowledge_url = esc_url ( get_permalink ( get_page_by_title ( 'Answers' ) ) );
	}

	return $items;
}


add_action ( 'wp_ajax_download_attachment', 'download_attachment' );
add_action ( 'wp_ajax_nopriv_download_attachment', 'download_attachment' );
function download_attachment(){
	$docId = $_POST['docId'];
	$dUrl = get_download_url1 ( $docId );
	echo $dUrl;

	exit;

}


/*
 * view case back
 */

add_action ( 'wp_ajax_view_back_url', 'view_back_url' );
add_action ( 'wp_ajax_nopriv_view_back_url', 'view_back_url' );

function view_back_url(){
	if(isset($_SESSION['url']) && $_SESSION['url'] !='' ){
		unset($_SESSION['url']);
	}
	//echo "hai";
	$_SESSION['url']=$_POST['url'];
	//echo $_SESSION['url'];
	exit;
}



/*
 * Search Customer
 */
add_action ( 'wp_ajax_search_customer', 'search_customer' );
add_action ( 'wp_ajax_nopriv_search_customer', 'search_customer' );
function search_customer() {
	$customer = $_POST['customer_name'];
	$response = getAllCustomers($customer);


	echo '<thead>';
	echo '<tr>
                                        <th >Customer Name</th>
                                        <th>Action</th>
                                         </tr>
                                </thead>';
	$cust_data = $response -> data;
	foreach($cust_data as $data){
		$custId = $data->customerId;
		$custName = $data->customerName;
		?>
<tr id="<?php echo $data->customerId;?>">
	<td><?php echo $data->customerName;?></td>
	<td style="text-align: center;"><button type="button"
			data-dismiss="modal" aria-label="Close" class="Close btn btn-primary"
			id="get_customer"
			onclick="selectCustomer('<?php echo $custId. ":".$custName;?>')">Select</button>
	</td>
</tr>
		<?php
	}



	exit;
}


/*
 * Change Password
 */
add_action ( 'wp_ajax_change_password', 'change_password' );
add_action ( 'wp_ajax_nopriv_change_password', 'change_password' );
function change_password(){
	$oldPwd = $_POST['oldPsswd'];
	$newPwd = $_POST['newPsswd'];
	$confPwd = $_POST['confirmPsswd'];
	$response =changePassword($oldPwd,$newPwd,$confPwd);
	if($response->errorCode == 100){
		echo "101";
	}
	else {
		echo "100";
	}
	exit;
}



/*
 * Forgot Password
 */
add_action ( 'wp_ajax_forgot_password', 'forgot_password' );
add_action ( 'wp_ajax_nopriv_forgot_password', 'forgot_password' );
function forgot_password(){
	$emailId = $_POST['emailid'];
	$response = forgotPassword($emailId);
	//po1($response);
	if($response->results == "success"){
		echo '100';
	}
	else {
		echo '101';
	}

	exit;

}


/*
 *Update Password
 */
add_action ( 'wp_ajax_update_password', 'update_password' );
add_action ( 'wp_ajax_nopriv_update_password', 'update_password' );
function update_password(){
	$newPswd = $_POST['newPswd'];
	$emailId = $_POST['emailId'];
	$secCode = $_POST['secCode'];
	$response = updatePassword($newPswd,$emailId,$secCode);
	if($response->results == "success"){
		echo '100';
	}
	else{
		echo '101';
	} 
	
	exit;
}


/*
 * Search Contact
 */

add_action ( 'wp_ajax_search_contact', 'search_contact' );
add_action ( 'wp_ajax_nopriv_search_contact', 'search_contact' );
function search_contact() {
	$contactName = $_POST['contact_name'];
	$customerId = $_POST['customer_id'];
	//$response = getAllSearchContacts($contact);
	$response = get_customer_contacts($customerId,$contactName);
	echo '
		<thead>
			<tr>
				<th>Contact Name</th>
				<th>Action</th>
			<tr>
		</thead>
	';
	$contact_data = $response -> data;
	foreach($contact_data as $data){
		$contId = $data->contactId;
		$firstName = $data->firstName;
		$lastName = $data->lastName;
		$fullName = $firstName . ' '.	$lastName;
		?>
<tr id="<?php echo $data->contactId;?>">
	<td><?php echo $fullName;?></td>
	<td style="text-align: center;"><button type="button"
			data-dismiss="modal" aria-label="Close" class="Close btn btn-primary"
			id="get_contact"
			onclick="selectContact('<?php echo $contId. ":".$fullName;?>')">Select</button>
	</td>
</tr>
		<?php
	}



	exit;
}



/*
 * Advanced Search Contact
 */

add_action ( 'wp_ajax_search_contact1', 'search_contact1' );
add_action ( 'wp_ajax_nopriv_search_contact1', 'search_contact1' );
function search_contact1() {
	$contact = $_POST['contact_name'];
	$response = getAllSearchContacts($contact);

	//	po1($response);


	echo '<thead>';
	echo '<tr>
                                        <th>Contact Name</th>
                                        <th>Action</th>
                                         </tr>
                                </thead>';
	$contact_data = $response -> data;
	foreach($contact_data as $data){
		$contId = $data->contactId;
		$firstName = $data->firstName;
		$lastName = $data->lastName;
		$fullName = $firstName.$lastName;

		?>
<tr id="<?php echo $data->contactId;?>">
	<td><?php echo $fullName;?></td>
	<td style="text-align: center;"><button type="button"
			data-dismiss="modal" aria-label="Close" class="Close btn btn-primary"
			id="get_contact"
			onclick="selectContact('<?php echo $contId. ":".$fullName;?>')">Select</button>
	</td>
</tr>
		<?php
	}



	exit;
}




/*
 * View Category
 */
add_action ( 'wp_ajax_view_category', 'view_category' );
add_action ( 'wp_ajax_nopriv_view_category', 'view_category' );
function view_category() {

	$view_answer_url = esc_url ( get_permalink ( get_page_by_title ( 'View Answers' ) ) );



	$category=$_POST['category'];
	$parent_category=$_POST['parent_category'];
	$sub_category=$_POST['sub_category'];
	//echo $sub_category;
	$case_form_data = array ();
	$weblayout=getAnswersConfigData()-> webLayout;
	$support_weblayout = json_decode ( $weblayout, true );
	$support_weblayout_sections = $support_weblayout ['sections'];
	foreach ( $support_weblayout_sections as $layout_sections ) {

		$section_attributes = $layout_sections ['attributes'];

		foreach ( $section_attributes as $sec_attrivbutes ) {
			//echo '<pre>';print_r($sec_attrivbutes);
			$labe_name = $sec_attrivbutes ['label'] ['modifiedLabel'];
			switch ($labe_name) {
				case 'Status' :
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
				case 'Category' :
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
				case 'Sub-Category' :
					$case_form_data [$labe_name] = $sec_attrivbutes;
					break;
			}
		}
	}

	$ans_status_data ['customAttributeId'] = $case_form_data['Status']['attributeId'];
	$ans_status_data ['customAttributeType'] = 'select';
	$ans_status_data ['customAttributeTagName'] = $case_form_data ['Status'] ['right'] ['0'] ['tagName'];
	$ans_status_data ['customAttributeName'] = $case_form_data ['Status'] ['right'] ['0'] ['tagName'];

	$ans_status_option_list = $case_form_data ['Status'] ['right'] ['0'] ['optionValueList'];

	$attribute_valuse = array ();
	// echo '<pre>';print_r($case_seve_option_list);
	foreach ( $ans_status_option_list as $ans_status ) {
			
		if ($ans_status [optionObject] == 'Solution') {
			$attribute_valuse [] = array (
						'id' => $ans_status[optionId] . '||' .  $ans_status[optionObject]. '|| || ||true',
						'attributeId' => "$ans_status[optionId]",
						'attributeValue' => "$ans_status[optionObject]" 
			);
		}
	}
	$ans_status_data ['attributeValues'] = $attribute_valuse;

	// echo'<pre>';print_r($case_seve_srch);
	$custom_ans_status_data = json_encode ( $ans_status_data );
	//po1($case_form_data[Category]);
	if($category != ''){
		$ans_accred_data ['customAttributeId'] = $case_form_data['Category']['attributeId'];
		$ans_accred_data ['customAttributeType'] = 'select';
		$ans_accred_data ['customAttributeTagName'] = $case_form_data ['Category'] ['right'] ['0'] ['tagName'];
		$ans_accred_data ['customAttributeName'] = $case_form_data ['Category'] ['right'] ['0'] ['tagName'];

		$ans_accred_option_list = $case_form_data ['Category'] ['right'] ['0'] ['optionValueList'];

		$attribute_valuse = array ();
		// echo '<pre>';print_r($case_seve_option_list);
		foreach ( $ans_accred_option_list as $ans_accred ) {
			//echo $ans_category [optionObject];
				
				
			if ($ans_accred[optionObject] == $category) {
				$attribute_valuse [] = array (
						'id' => $ans_accred[optionId] . '||' .  $ans_accred[optionObject]. '|| || ||true',
						'attributeId' => "$ans_accred[optionId]",
						'attributeValue' => "$ans_accred[optionObject]" 
				);
			}
				
		}

		$ans_accred_data ['attributeValues'] = $attribute_valuse;

		// echo'<pre>';print_r($case_seve_srch);
		$custom_ans_accred_data = json_encode ( $ans_accred_data );
		//po1($custom_ans_accred_data);




	}






	if($sub_category != ''){

		$ans_bullet_data ['customAttributeId'] = $case_form_data['Category']['attributeId'];
		$ans_bullet_data ['customAttributeType'] = 'select';
		$ans_bullet_data ['customAttributeTagName'] = $case_form_data ['Category'] ['right'] ['0'] ['tagName'];
		$ans_bullet_data ['customAttributeName'] = $case_form_data ['Category'] ['right'] ['0'] ['tagName'];

		$ans_category_option_list = $case_form_data ['Category'] ['right'] ['0'] ['optionValueList'];


		$drive_values=$case_form_data['Sub-Category']['value']['criteria'][0]['groups'];
		//po1($drive_values);
		$ans_category_attrid = $case_form_data['Category']['attributeId'];
		$categories=array();
		//$attribute_valuse=array();
		foreach ( $ans_category_option_list as $ans_cate ) {
			//echo '<pre>';print_r($ans_cate);
			$ans_category['categoryId']=$ans_cate[optionId];
			$ans_category['categoryName']=$ans_cate[optionObject];
			//echo $ans_category['categoryName'];
			$categories[]=$ans_category;
			foreach($drive_values as $drive){
				$depen_category_id=$drive['condition']['selectedDrivingValues'][0]['id'];
				$selected_category_name=$drive['condition']['selectedDrivingValues'][0]['name'];
				$cat_id=$drive['condition']['drivingAttribute']['id'];
				if($ans_category_attrid==$cat_id){
					if($ans_category['categoryId']==$depen_category_id){
						$sub_cat_value=$ans_category['categoryName'];
						//echo $ans_category['categoryName'];echo '<br>';

						// echo '<pre>';print_r($case_seve_option_list);

						//echo $ans_category [optionObject];

						//echo $ans_cate[optionObject];
						if($selected_category_name==$parent_category){
							if($selected_category_name==$sub_cat_value){
									
								$attribute_valuse1 [] = array (
						'id' => $depen_category_id . '||' .  $selected_category_name. '|| || ||true',
						'attributeId' => "$depen_category_id",
						'attributeValue' => "$selected_category_name" 
								);
									
							}
								
								
						}
							

							
					}
				}
			}

		}






		$ans_bullet_data ['attributeValues'] = $attribute_valuse1;

		// echo'<pre>';print_r($case_seve_srch);
		//po1($case_form_data['Sub Category']);
		$custom_ans_bullet_data = json_encode ( $ans_bullet_data );

		$ans_subbullet_data ['customAttributeId'] = $case_form_data['Sub-Category']['attributeId'];
		$ans_subbullet_data ['customAttributeType'] = 'select';
		$ans_subbullet_data ['customAttributeTagName'] = $case_form_data ['Sub-Category'] ['right'] ['0'] ['tagName'];
		$ans_subbullet_data ['customAttributeName'] = $case_form_data ['Sub-Category'] ['right'] ['0'] ['tagName'];

		$ans_subbullet_option_list = $case_form_data ['Sub-Category'] ['right'] ['0'] ['optionValueList'];

		$attribute_valuse = array ();
		// echo '<pre>';print_r($case_seve_option_list);
		foreach ( $ans_subbullet_option_list as $ans_bullet ) {
			//echo $ans_category [optionObject];


			if ($ans_bullet[optionObject] == $sub_category) {
				$attribute_valuse [] = array (
						'id' => $ans_bullet[optionId] . '||' .  $ans_bullet[optionObject]. '|| || ||true',
						'attributeId' => "$ans_bullet[optionId]",
						'attributeValue' => "$ans_bullet[optionObject]" 
				);
			}
				
		}

		$ans_subbullet_data ['attributeValues'] = $attribute_valuse;

		// echo'<pre>';print_r($case_seve_srch);
		$custom_ans_bullet_data1 = json_encode ( $ans_subbullet_data );
		$custom_bullet_sub_category=$custom_ans_bullet_data.','.$custom_ans_bullet_data1;
			
	}


	$case_attribute_json_str = $custom_ans_status_data;

	if (isset ( $custom_ans_accred_data ) && $custom_ans_accred_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_ans_accred_data;
		} else {
			$case_attribute_json_str = $custom_ans_accred_data;
		}
		// po1($case_attribute_json_str);
	}

	if (isset ( $custom_ans_alesco_data ) && $custom_ans_alesco_data != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_ans_alesco_data;
		} else {
			$case_attribute_json_str = $custom_ans_alesco_data;
		}
		// po1($case_attribute_json_str);
	}
	if (isset ( $custom_bullet_sub_category ) && $custom_bullet_sub_category != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_bullet_sub_category;
		} else {
			$case_attribute_json_str = $custom_bullet_sub_category;
		}
		// po1($case_attribute_json_str);
	}


	if (isset ( $custom_cp_sub_category ) && $custom_cp_sub_category != '') {
		if ($case_attribute_json_str != '') {
				
			$case_attribute_json_str = $case_attribute_json_str . ',' . $custom_cp_sub_category;
		} else {
			$case_attribute_json_str = $custom_cp_sub_category;
		}
		// po1($case_attribute_json_str);
	}
	if ($case_attribute_json_str != '') {

		// po1($case_attribute_json_str);
		$customAttributes = '"customAttributes":[' . $case_attribute_json_str . ']';
	} else {
		$customAttributes = ',"customAttributes":[]';
	}


	$api_url = APPTIVO_API_URL . '/app/dao/v6/answers';
	$params = array (
			"a" => "getAllByAdvancedSearch",
			"numRecords" => 500,
			"searchData" => '{"questionText":"","postedByName":"","followUpDescription":"","metaDescription":"","metaTitle":"","metaKeywords":"","labels":[],'.$customAttributes.'}',
			"questionStatus" => - 1,
			"startIndex" => 0,
			"sortColumn" => 'creationDate',
			"sortDir" => 'desc',
			"objectId"=>KB_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
	);


	/*$params = array (
	 "a" => "getAll",
	 "numRecords" => 500,
	 "startIndex" => 0,
	 "sortColumn" => 'creationDate',
	 "sortDir" => 'desc',
	 "apiKey" => APPTIVO_API_KEY,
	 "accessKey" => APPTIVO_ACCESS_KEY
	 );
	 */

	//echo "<pre>";print_r($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//echo "<pre>";print_r($response);
	$matchedQuestions=array();
	if(isset($response->data)){

		foreach ( $response->data as $singleQuestion ){
				
				
			$category=$_POST['category'];
			$sub_category=$_POST['sub_category'];
				
			$catValue = null;
			$subCatValue = null;
				
			if($category!=null){
				$catValue = $category;
			}
			else if($sub_category!=null){
				$subCatValue = $sub_category;
			}
				
				
				
			$statusAttribId = $case_form_data['Status']['attributeId'];
			$catAttribId = $case_form_data['Category']['attributeId'];
			$subCatAttribId = $case_form_data['Sub-Category']['attributeId'];
				
			$isMatch = isQuestionMatched($singleQuestion, $statusAttribId, $catAttribId, $subCatAttribId, $catValue, $subCatValue);
			if($isMatch) $matchedQuestions[] = $singleQuestion;
		}
		// now loop through each of the record.. and check if the category passed


	}
	// 	po1($matchedQuestions);
	if (!empty($matchedQuestions)) {

		foreach ( $matchedQuestions as $ques ) {
				
			?>
<a href="<?php echo $view_answer_url.'?id='.$ques->questionId;?>">
	<li type="circle"><?php echo "#".getSolutionNumber($ques) . " - " . htmlentities(utf8_decode(stripcslashes($ques->questionText)));?>

</a>
<br>
			<?php
			echo "<font size=2px>" .$ques->creationDate.'</font>';
			//. " by " .$ques->postedByName
		
			?>
</li>

			<?php
		}
	} else {
		echo "No Articals Found";
	}
	//po1($customAttributes);



	exit;
}



/*
 * Register Action
 */
add_action ( 'wp_ajax_register_ticket', 'register_ticket' );
add_action ( 'wp_ajax_nopriv_register_ticket', 'register_ticket' );
function register_ticket() {

	$password = sanitize_text_field ( $_POST ['password'] );
	$confirm_password = sanitize_text_field ( $_POST ['confirm_password'] );
	$ticket_code = sanitize_text_field ( $_POST ['ticket_code'] );
	//echo "hello".$ticket_code;
	$api_url = APPTIVO_API_URL . '/app/dao/signup';
	$params = array (
			"a" => "acceptXinnectInvitation",
			"invitationCode" => $ticket_code,
			"password" => $password 
	);
	//po1($params);
	$response = getRestAPICall1 ( 'POST', $api_url, $params );
	//po1($response);
	if (isset ( $response->responseCode ) && $response->responseCode == 0) {
		$ticketSessionKey = $response->responseObject->authenticationKey;
		echo "100";
	} else {
		echo "101";
	}

	exit ();
}

add_action('template_redirect','case_export2');
function case_export2() {
	if ($_SERVER['REQUEST_URI']=='/custportal/index.php/downloads/data.csv') {
		$caseIds = $_POST ['case_ids_string'];
		$data=exportCases($caseIds);
		header("Content-type: application/x-msdownload",true,200);
		header("Content-Disposition: attachment; filename=data.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $data;
		exit();
	}
}


/*
 * Login Action
 */
add_action ( 'wp_ajax_cases_login', 'cases_login' );
add_action ( 'wp_ajax_nopriv_cases_login', 'cases_login' );
function cases_login() {
	$email = sanitize_text_field ( $_POST ['user_name'] );
	$password = sanitize_text_field ( $_POST ['password'] );
	switch(AUTH_METHOD) {
		case 'Xinnect':
			$api_url = APPTIVO_PORTAL_API_URL;
			$params = array (
					"a" => "login",
					"userName" => $email,
					"password" => $password
			);
			$response = getRestAPICall1 ( 'POST', $api_url, $params );
			$response = $response->response;
			if (isset ( $response->statusCode ) && $response->statusCode == 0) {
				if (session_id () == '' || ! isset ( $_SESSION )) {
					session_start ();
				}
				$_SESSION ['contactId'] = $response->relatedContactId;
				$_SESSION ['customerId'] = $response->relatedCustomerId;
				$_SESSION ['customerName'] = $response->firmName;
				setUserEmail($email);
				setSessionKey($response->responseObject->authenticationKey);
				$caseConfigurationData = getAllCasesConfigData ();
				if($caseConfigurationData == null){
					echo '102';
					exit;
				}
				setCaseConfigData ( $caseConfigurationData );
				$contactConfigData = getAllContactConfigData1 ();
				if($contactConfigData == null){
					echo '104';exit;
				}
				setContactConfigData($contactConfigData);
				$customerConfigData = getAllCustomerConfigData();
				if($customerConfigData == null){
					echo '105';exit;
				}
				setCustomerConfigData($customerConfigData);
					
				echo '100';
			} else {
				echo '101';
			}
		break;
		default:
			//AUTH_METHOD == 'Apptivo Login'
			$api_url = APPTIVO_API_URL . '/app/loginservlet';
			$params = array (
					"a" => "login",
					"emailId" => $email,
					"password" => $password,
					"isWebLogin"=>$isWebLogin
			);
			$response = getRestAPICall1 ( 'POST', $api_url, $params );
			if (isset ( $response->responseCode ) && $response->responseCode == 0) {
				if (session_id () == '' || ! isset ( $_SESSION )) {
					session_start ();
				}
				//The above response proves they can access this email via Apptivo, so let's find the contact which matches the same email in our firm
				$contact = getContactByEmailId($email);
				$_SESSION ['contactId'] = $contact->contactId;
				$_SESSION ['contactName'] = $contact->firstName.' '.$contact->lastName;
				$_SESSION ['customerId'] = $contact->accountId;
				$_SESSION ['customerName'] = $contact->accountName;
				setUserEmail($email);
				$caseConfigurationData = getAllCasesConfigData ();
				if($caseConfigurationData == null){
					echo '102';
					exit;
				}
				setCaseConfigData ( $caseConfigurationData );				
				echo '100';
			} else {
				echo '101';
			}
		break;
	}	
	exit ();
}

	/* Create Question */
	/*
	 add_action ( 'wp_ajax_create_question', 'create_question' );
	 add_action ( 'wp_ajax_nopriv_create_question', 'create_question' );
	 function create_question() {
	 $api_url = APPTIVO_API_URL . '/app/dao/answers';
	 $question = sanitize_text_field ( $_POST ['question'] );
	 $sessionKey = sanitize_text_field ( $_POST ['sessionkey'] );
	 // echo $sessionKey;
	 if ($sessionKey != '') {
		$params = array (
		"a" => "createQuestion",
		"questionData" => '{"":"","questionText":"' . $question . '","postedByName":"prabhu","datePosted":"","products":[],"assignedToObjectRefName":"Prabhu","assignedToObjectRefId":43374,"assignedToObjectId":8,"answerDate":null,"answerCount":null,"followUpDate":null,"followUpDescription":null,"createdByName":"","lastUpdatedByName":"","creationDate":"","lastUpdateDate":"","isFeatured":"Y","metaDescription":"","metaTitle":"","metaKeywords":"","forumId":10107,"labels":[],"addresses":[],"customAttributes":[{"customAttributeType":"on_off","id":"is_featured_on_off","customAttributeId":"isFeatured","customAttributeName":"isFeatured","customAttributeValue":"is_featured_on_off|~|~|~|"}],"createdBy":null,"lastUpdatedBy":null}',
		"sessionKey" => $sessionKey
		);
		} else {
		$params = array (
		"a" => "createQuestion",
		"questionData" => '{"":"","questionText":"' . $question . '","postedByName":"prabhu","datePosted":"","products":[],"assignedToObjectRefName":"Prabhu","assignedToObjectRefId":43374,"assignedToObjectId":8,"answerDate":null,"answerCount":null,"followUpDate":null,"followUpDescription":null,"createdByName":"","lastUpdatedByName":"","creationDate":"","lastUpdateDate":"","isFeatured":"Y","metaDescription":"","metaTitle":"","metaKeywords":"","forumId":10107,"labels":[],"addresses":[],"customAttributes":[{"customAttributeType":"on_off","id":"is_featured_on_off","customAttributeId":"isFeatured","customAttributeName":"isFeatured","customAttributeValue":"is_featured_on_off|~|~|~|"}],"createdBy":null,"lastUpdatedBy":null}',
		"apiKey" => APPTIVO_API_KEY,
		"accessKey" => APPTIVO_ACCESS_KEY
		);
		}
		// print_r($params);
		$response = getRestAPICall1 ( 'POST', $api_url, $params );

		if ($response->questionId != '') {
		echo "100";
		}
		exit ();
		}
		*/
	/* Search Question */
/*
	add_action ( 'wp_ajax_search_question', 'search_question' );
	add_action ( 'wp_ajax_nopriv_search_question', 'search_question' );
	function search_question() {
		$view_answer_url = esc_url ( get_permalink ( get_page_by_title ( 'View Answers' ) ) );
		$questiontext = sanitize_text_field ( $_POST ['searchquestion'] );
		$sessionKey = sanitize_text_field ( $_POST ['sessionkey'] );
		if(is_numeric($questiontext)){
			$questionNo = $questiontext;
		}
		else
		{
			$questionText = $questiontext;
		}


		// echo $sessionKey;
		$api_url = APPTIVO_API_URL . '/app/dao/v6/answers';
		$params = array (
			"a" => "getAllByAdvancedSearch",
			"numRecords" => 50,
			"objectId" => KB_APPID,
		//"searchData" => '{"questionText":"' . $questiontext . '","postedByName":"","postedByObjectId":null,"postedByObjectRefId":null,"postedByObjectRefName":null,"datePosted":"","datePostedTo":"","questionStatus":"-1","products":[],"assignedToObjectRefName":null,"assignedToObjectId":null,"assignedToObjectRefId":null,"answerDate":"","answerDateTo":"","isFeatured":"Y","metaDescription":"","metaTitle":"","metaKeywords":"","labels":[],"searchColumn":"","addresses":[],"customAttributes":[]}',
			"searchData" => '{"questionText":"' . $questionText . '","questionNumber":"'.$questionNo.'","postedByName":"","followUpDescription":"","metaDescription":"","metaTitle":"","metaKeywords":"","labels":[],"customAttributes":[]}',
			"questionStatus" => - 1,
			"startIndex" => 0,
			"sortColumn" => 'creationDate',
			"sortDir" => 'desc',
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
		);

		/*		$params = array (
			"a" => "getAllSearchText",
			"numRecords" => 500,
			"objectId" => KB_APPID,
			//"searchData" => '{"questionText":"' . $questiontext . '","postedByName":"","postedByObjectId":null,"postedByObjectRefId":null,"postedByObjectRefName":null,"datePosted":"","datePostedTo":"","questionStatus":"-1","products":[],"assignedToObjectRefName":null,"assignedToObjectId":null,"assignedToObjectRefId":null,"answerDate":"","answerDateTo":"","isFeatured":"Y","metaDescription":"","metaTitle":"","metaKeywords":"","labels":[],"searchColumn":"","addresses":[],"customAttributes":[]}',
			"searchText" => $questiontext,
			"questionStatus" => - 1,
			"startIndex" => 0,
			"sortColumn" => 'creationDate',
			"sortDir" => 'desc',
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY
			); 
		$response = getRestAPICall1 ( 'POST', $api_url, $params );
		if (isset ( $response->data )) {

			foreach ( $response->data as $ques ) {
					
				?>
<a href="<?php echo $view_answer_url.'?id='.$ques->questionId;?>">
	<li type="circle"><?php echo  "#".getSolutionNumber($ques) . " - " . htmlentities(utf8_decode(stripcslashes($ques->questionText)));?>

</a>
<br>
				<?php
				echo "<font size=2px>" .$ques->creationDate.'</font>';
				//. " by " .$ques->postedByName
		
				?>
</li>

				<?php
			}
		} else {
			echo "Questions Not found...";
		}

		exit ();
	}*/

	/* Advanced Search Ticket */

	add_action ( 'wp_ajax_search_ticket', 'search_ticket' );
	add_action ( 'wp_ajax_nopriv_search_ticket', 'search_ticket' );
	function search_ticket() {
		$customerId = $_SESSION ['customerId'];
		$customerName = $_SESSION ['customerName'];
		$api_url = APPTIVO_API_URL . '/app/dao/v6/cases';
		$status_id = $_POST ['statusId'];
		$type_id = $_POST ['typeId'];
		$priority_id = $_POST ['priorityId'];
		$severity_id = $_POST ['severityId'];
		$solution_id = $_POST ['solutionId'];
		$payversion_id = $_POST ['payversionId'];
		$paycritical_id = $_POST ['paycriticalId'];
		$solution_value = $_POST ['solution_value'];
		$severity_value = $_POST ['severity_value'];
		$payversion_value = $_POST ['payversion_value'];
		$paycritical_value = $_POST ['paycritical_value'];
		$subject = $_POST ['subject'];
		$description = $_POST ['description'];
		$email = $_POST ['emailid'];
		// echo $description;

		if ($solution_value != "Select One" && $solution_value != "") {
			$case_soln_srch ['customAttributeId'] = $_SESSION ['solution_attribute_id'];
			$case_soln_srch ['customAttributeValue'] = $solution_value;
			$case_soln_srch ['customAttributeType'] = 'select';
			$case_soln_srch ['customAttributeTagName'] = $_SESSION ['solution_tag_name'];
			$case_soln_srch ['customAttributeName'] = $_SESSION ['solution_tag_name'];
			$case_soln_srch ['customAttributeId'] = $_SESSION ['solution_attribute_id'];

			$attribute_valuse = array ();
			foreach ( $_SESSION ['acceptedSolution'] as $acc_solution ) {
					
				if ($acc_solution == $solution_value) {
					$attribute_valuse [] = array (
						'id' => $solution_id . '||' . $solution_value . '|| || ||true',
						'attributeId' => "$solution_id",
						'attributeValue' => "$solution_value" 
					);
				}
			}
			$case_soln_srch ['attributeValues'] = $attribute_valuse;

			// echo'<pre>';print_r($case_soln_srch);
			$custom_req_soln_data = json_encode ( $case_soln_srch );
			// echo'<pre>';print_r($case_search_base_required);
		}

		if ($severity_value != "Select One" && $severity_value != "") {

			$case_seve_srch ['customAttributeId'] = $_SESSION ['severity_attribute_id'];
			$case_seve_srch ['customAttributeValue'] = $severity_value;
			$case_seve_srch ['customAttributeType'] = 'select';
			$case_seve_srch ['customAttributeTagName'] = $_SESSION ['severity_tag_name'];
			$case_seve_srch ['customAttributeName'] = $_SESSION ['severity_tag_name'];
			$case_seve_srch ['customAttributeId'] = $_SESSION ['severity_attribute_id'];
			$case_seve_option_list = $_SESSION ['severity_option_lists'];

			$attribute_valuse = array ();
			// echo '<pre>';print_r($case_seve_option_list);
			foreach ( $case_seve_option_list as $acc_severity ) {
					
				if ($acc_severity [optionObject] == $severity_value) {
					$attribute_valuse [] = array (
						'id' => $severity_id . '||' . $severity_value . '|| || ||true',
						'attributeId' => "$severity_id",
						'attributeValue' => "$severity_value" 
					);
				}
			}
			$case_seve_srch ['attributeValues'] = $attribute_valuse;

			// echo'<pre>';print_r($case_seve_srch);
			$custom_req_seve_data = json_encode ( $case_seve_srch );
			// echo'<pre>';print_r($case_search_base_required);
		}

		if ($payversion_value != "Select One" && $payversion_value != "") {

			$case_payver_srch ['customAttributeId'] = $_SESSION ['pay_version_attribute_id'];
			$case_payver_srch ['customAttributeValue'] = $payversion_value;
			$case_payver_srch ['customAttributeType'] = 'select';
			$case_payver_srch ['customAttributeTagName'] = $_SESSION ['pay_version_tag_name'];
			$case_payver_srch ['customAttributeName'] = $_SESSION ['pay_version_tag_name'];
			$case_payver_srch ['customAttributeId'] = $_SESSION ['pay_version_attribute_id'];
			$case_payver_option_list = $_SESSION ['pay_version_option_lists'];

			$attribute_valuse = array ();
			// echo '<pre>';print_r($case_payver_option_list);
			foreach ( $case_payver_option_list as $acc_payver ) {
					
				if ($acc_payver [optionObject] == $payversion_value) {
					$attribute_valuse [] = array (
						'id' => $payversion_id . '||' . $payversion_value . '|| || ||true',
						'attributeId' => "$payversion_id",
						'attributeValue' => "$payversion_value" 
					);
				}
			}
			$case_payver_srch ['attributeValues'] = $attribute_valuse;

			// echo'<pre>';print_r($case_seve_srch);
			$custom_req_payver_data = json_encode ( $case_payver_srch );
			// echo'<pre>';print_r($case_search_base_required);
		}

		if ($paycritical_value != "Select One" && $paycritical_value != "") {

			$case_paycrit_srch ['customAttributeId'] = $_SESSION ['critical_patch_attribute_id'];
			$case_paycrit_srch ['customAttributeValue'] = $paycritical_value;
			$case_paycrit_srch ['customAttributeType'] = 'select';
			$case_paycrit_srch ['customAttributeTagName'] = $_SESSION ['critical_patch_tag_name'];
			$case_paycrit_srch ['customAttributeName'] = $_SESSION ['critical_patch_tag_name'];
			$case_paycrit_srch ['customAttributeId'] = $_SESSION ['critical_patch_attribute_id'];
			$case_paycrit_option_list = $_SESSION ['critical_patch_option_lists'];

			$attribute_valuse = array ();
			// echo '<pre>';print_r($case_seve_option_list);
			foreach ( $case_paycrit_option_list as $acc_paycrit ) {
					
				if ($acc_paycrit [optionObject] == $paycritical_value) {
					$attribute_valuse [] = array (
						'id' => $paycritical_id . '||' . $paycritical_value . '|| || ||true',
						'attributeId' => "$paycritical_id",
						'attributeValue' => "$paycritical_value" 
					);
				}
			}
			$case_paycrit_srch ['attributeValues'] = $attribute_valuse;

			// echo'<pre>';print_r($case_seve_srch);
			$custom_req_paycrit_data = json_encode ( $case_paycrit_srch );
			// echo'<pre>';print_r($case_search_base_required);
		}

		// po1($case_attribute_json_str );
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

		// echo $custom_attr_required;
		$searchData = '{"caseNumber":"","followUpDescription":"","createdByName":null,"createdByObjectId":null,"createdByObjectRefId":null,"lastUpdatedByName":null,"lastUpdatedByObjectId":null,"lastUpdatedByObjectRefId":null,"caseSummary":"' . $subject . '","description":"' . $description . '","caseCustomerId":"' . $customerId . '","caseCustomer":"' . $customerName . '","caseEmail":""' . $customAttributes . ',"labels":[]}';
		// ,"caseCustomerId":"'.$customerId.'","caseCustomer":"'.$customerName.'","description":""

		$params = array (
			"a" => "getAllByAdvancedSearch",
			"sortColumn" => "creationDate",
			"sortDir" => "desc",
			"searchData" => $searchData,
			"multiSelectData" => '{"statusIds":[' . $status_id . '],"priorityIds":[' . $priority_id . '],"typeIds":[' . $type_id . '],"slaIds":[],"caseSourceIds":[]}',
			"objectId" => CA_APPID,
			"apiKey" => APPTIVO_API_KEY,
			"accessKey" => APPTIVO_ACCESS_KEY 
		);

		//po1($params);
		$response = getRestAPICall1 ( 'POST', $api_url, $params );
		// po1($response);

		$myCaseList = $response->data;
		// po1($myCaseList);
		$view_case_url = esc_url ( get_permalink ( get_page_by_title ( OBJECT_NAME.' Overview' ) ) );

		echo '<thead>';
		echo '<tr>
                                        <th style="width:100px">'.OBJECT_NAME.' #</th>
                                        <th style="width:150px">Status</th>
                                        <th style="width:150px">Type</th>
                                        <th style="width:150px">Priority</th>
                                        <th style="width:250px">Summary</th>
                                        <th style="width:80px">Action</th>
                                    </tr>
                                </thead>';
		if (! empty ( $myCaseList )) {
			if (is_array ( $myCaseList )) {
				foreach ( $myCaseList as $key => $myCase ) {

					echo '<tr id="' . $myCase->caseId . '">
                                        <td>' . $myCase->caseNumber . '</td>
                                        <td>' . $myCase->caseStatus . '</td>
                                        <td>' . $myCase->caseType . '</td>
                                        <td>' . $myCase->casePriority . '</td>
                                        <td>' . $myCase->caseSummary . '</td>
                                        <td><a class="vieww" href="' . $view_case_url . '?id=' . $myCase->caseId . '"></a></td>
                                        </tr>';
				}
			}
		} else {

			// 		echo "<tr><td colspan='6'>No Product Ticket Found</td></tr>";
		}

		exit ();
	}

	/* side panel view case */
	add_action ( 'wp_ajax_view_case_sidepanel', 'view_case_sidepanel' );
	add_action ( 'wp_ajax_nopriv_view_case_sidepanel', 'view_case_sidepanel' );
	function view_case_sidepanel() {
		$caseId = $_POST ['caseId'];
		$_SESSION ['caseid'] = $caseId;
		$sessionKey = $_SESSION ['sessionKey'];
		$cases = get_case_by_caseId1 ( $caseId, $sessionKey );

		?>
<script type="text/javascript">
$('.close, .cancelact').on('click',function(){
	  $(".aside1").hide();
	 });

$("#viewbtn").click(function(){
	var notes=$("#addnotearea").val();
	 $.ajax(
	            {
	                type: 'POST',
	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
	                data: {'action':'add_note',"note":notes},
                	success:function(response){
                    	
                		$("#add_notes").html(response);
                	}
            	
	            });	

});

$("#addattachment").click(function(){
	var file=$("#file_name").val().replace(/C:\\fakepath\\/i, '');
	var extension = file.replace(/^.*\./, '');
	var size=$("#file_name")[0].files[0].size;
	//alert(size);
	if(extension==file)
	{
		extension='';
	}
	
	 $.ajax(
	            {
	                type: 'POST',
	                url:'<?php echo admin_url('admin-ajax.php'); ?>',
	                data: {'action':'add_attachment',"file_name":file,"extend":extension,"size":size},
                	success:function(response){
                    	
                		$("#add_attach").html(response);
                	}
            	
	            });	

});

</script>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main"> <article
		id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-item-wrap">

		<div class="post-inner-content ticket-view-page">

			<!--  <div class="entry-content"> -->
			<!--   <div class="formsectionpd"> -->

			<div class="aside-header mnbtngroup">
				<div class="btn-group btn-group-sm pull-right pad05 brdrgt">


					<button type="button" class="btn btn-default close close-click "
						data-toggle="tooltip" data-placement="bottom" title="close">
						<i class="fa fa-times"></i>
					</button>
				</div>



				<div class="formlft" style="font-size: 24px; width: 90%;">
					<b><?php echo $cases->caseNumber.' - '.substr($cases->caseSummary, 0, 50); ?>
					</b>...
				</div>


			</div>
			<?php

			?>


			<!--</div>  -->
			<div class="aside-body">
				<div class="panels">
					<hr>
					<?php echo "<div id='success_msg'>$response_msg</div>";?>
					<div class="bg-color view-space">

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Ticket Number</font><font
									class=""></font> </label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->caseNumber; ?>
									</div>
								</div>

							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Type</font><font class=""></font>
								</label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->caseType; ?>
									</div>
								</div>

							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Status</font><font class=""></font>
								</label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->caseStatus; ?>
									</div>
								</div>


							</div>
						</div>


						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Priority</font><font class=""></font>
								</label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->casePriority; ?>
									</div>
								</div>

							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Subject</font><font class=""></font>
								</label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->caseSummary; ?>
									</div>
								</div>

							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label"><font>Description</font><font
									class=""></font> </label>
								<div class="vwfrmcnt">
									<div class="viewval1">
										<textare style="height:177px;float:left;"> <?php echo $cases->description; ?>
										</textarea>
									
									</div>
								</div>

							</div>
						</div>

						<!-- <div class="formsection">
                            <div class="formlft"><label>Item</label></div>
                            <div class="formrgt">: <?php echo $cases->caseItem; ?></div>
                        </div> -->

						<?php
						// echo $_SESSION['severity_attribute_id'];
						// echo $_SESSION['severity_tag_name'];
						// po1($cases->customAttributes);
						// echo CA_SEVERITY_ID;
						?>
						<?php

						foreach ( $cases->customAttributes as $key => $value ) {
							if ($value->customAttributeId == $_SESSION ['severity_attribute_id']) {
								?>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Severity</font><font class=""></font>
								</label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $value->customAttributeValue; ?>
									</div>
								</div>
							</div>
						</div>
						<?php
							}
							if ($value->customAttributeId == $_SESSION ['solution_attribute_id']) {
								$solutionValue = $value->customAttributeValue;
								?>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Solution</font><font class=""></font>
								</label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $value->customAttributeValue; ?>
									</div>
								</div>
							</div>
						</div>
						<?php
							}
							if ($value->customAttributeId == $_SESSION ['pay_version_attribute_id']) {
								if ($solutionValue == 'Ascender Pay') {
									?>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Your current Ascender Pay
										Version</font><font class=""></font> </label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $value->customAttributeValue; ?>
									</div>
								</div>
							</div>
						</div>
						<?php
								}
							}
							if ($value->customAttributeId == $_SESSION ['critical_patch_attribute_id']) {
								if ($solutionValue == 'Ascender Pay') {
									?>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Your Current Ascender Pay
										Critical Patch</font><font class=""></font> </label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $value->customAttributeValue; ?>
									</div>
								</div>
							</div>
						</div>
						<?php
								}
							}
						}
						?>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Raised On</font><font
									class=""></font> </label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->creationDate; ?>
									</div>
								</div>


							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><font>Modified On</font><font
									class=""></font> </label>
								<div class="vwfrmcnt">
									<div class="viewval1">
									<?php echo $cases->lastUpdateDate; ?>
									</div>
								</div>


							</div>
						</div>
					</div>

					<?php if(isset($cases->dateResolved)){ ?>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label"><font>Date Resolved</font><font
								class=""></font> </label>
							<div class="vwfrmcnt">
								<div class="viewval1">
								<?php echo $cases->dateResolved; ?>
								</div>
							</div>

						</div>
					</div>
					<?php } ?>
					<!-- </div> -->
					<hr>
					<div class="entry-content btm-attach">
						<h4 class="entry-title">Attachments</h4>
						<p id="add_attach" name="add_attach"></p>
						<?php
						$attachments = get_all_documents_objId1 ( $caseId );
						$attachmentList = $attachments->aaData;
						if (is_array ( $attachmentList ) && $attachmentList [0]->documentId != '') {
							foreach ( $attachmentList as $key => $attach ) {
								$dUrl = get_download_url1 ( $attach->documentId );
								echo '<div class="formsectionn1">
                                <div class="notesec1"><div class="noteseclft"><a target="_blank" href="' . $dUrl . '">' . $attach->documentName . '</a></div></div>
                                </div>';
							}
						} else {
							echo 'No data found';
						}
						?>
					</div>
					<?php if($cases->caseStatus!="Resolved"){ ?>
					<div class="entry-content btm-attach">

					<?php
					//
					// echo '<form name="upload_form" method="post" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">';
					echo '<div class="formsection pad0"><div class="formlft">';
					echo '<input name="image" type="file" id="file_name"></div>';
					echo '<div class="formrgt">';
					echo '<button class="btn btn-primary" type="button"  id="addattachment" value="Attach File" name="attach">Attach File</button>';
					echo '</div></div>';
					echo '</form>';
					?>
					</div>
					<?php } ?>
					<hr>
					<div class="entry-content btm-attach">
						<h4 class="entry-title">Notes</h4>
						<p id="add_notes" name="add_notes"></p>
						<?php

						$notes = get_notes_by_objectId1 ( $caseId, $_SESSION ['sessionKey'] );
						$notesList = $notes->notes; // echo "<pre>";print_r($_SESSION);

						if (is_array ( $notesList ) && $notesList [0]->noteText != '') {
							foreach ( $notesList as $key => $note ) {
									
								if (isset ( $note->isDisplayToCustomer ) && $note->isDisplayToCustomer == 'Y') {

									echo '<div class="formsectionn">';
									echo '<div class="notesec"><div class="noteseclft">Posted by ' . $note->createdByName . '</div><div class="notesecrgt">' . $note->creationDate . '</div></div>';
									// echo '<div class="notesec"><div class="noteseclft">Posted by '.$_SESSION['contactName'].', on '.$note->creationDate.'</div></div>';
									echo '<div class="noteseccnt">' . $note->noteText . '</div>';
									echo '</div>';
								}
							}
						} else {
							echo 'No data found';
						}
						?>
					</div>
					<?php if($cases->caseStatus!="Resolved"){ ?>
					<div class="entry-content viewcase">
						<form name="add_note" action="" method="post" id="add_note">
							<div class="formsection pad0">
								<div class="formlft">
									<h4 class="entry-title">Add Notes</h4>
								</div>
								<div class="formrgt svsubmit">
									<textarea class="required" name="addnotearea" id="addnotearea"
										size="50"></textarea>
								</div>
							</div>
							<div class="formsection">
								<div class="formlft">
									<label><span>&nbsp;</span> </label>
								</div>
								<input type="hidden" id="case_id_value" name="case_id_value"
									value="<?php echo $case_id_value; ?>" />
								<div class="formrgt svsubmit" style="float: right">
									<button type="button" value="Add Comment"
										class="btn btn-primary" name="submit" id="viewbtn">Add Notes</button>
								</div>
							</div>
						</form>

					</div>
					<?php } ?>
				</div>
			</div>
	
	</article> </main>
	<!-- #main -->

</div>
<!-- #primary -->


					<?php
					exit ();
	}

	add_action ( 'wp_ajax_add_note', 'add_note' );
	add_action ( 'wp_ajax_nopriv_add_note', 'add_note' );
	function add_note() {
		// echo "hai";
		$notes = $_POST ['note'];
		$caseId = $_SESSION ['caseid'];
		$sessionKey = $_SESSION ['sessionKey'];
		if ($caseId != '' && $notes != '') {
			$response = add_notes_by_objectId1 ( $caseId, $notes, $sessionKey );
			if ($response != '') {
				$response_msg = '<span style="color:green;font-weight:bold">Your note added successfully.</span>';
			}
		}
		echo $response_msg;
		exit ();
	}

	add_action ( 'wp_ajax_add_attachment', 'add_attachment' );
	add_action ( 'wp_ajax_nopriv_add_attachment', 'add_attachment' );
	function add_attachment() {
		$caseId = $_SESSION ['caseid'];
		// echo $caseId;
		$sessionKey = $_SESSION ['sessionKey'];
		$file_name = $_POST ['file_name'];
		// echo $file_name;
		if ($caseId != '') {

			// $file_name =$_FILES['image']['name'];
			$_FILES ['image'] ['name'] = $file_name;
			// echo $_FILES['image']['name'];
			if ($file_name != '') {
					
				$file_ext = $_POST ['extend'];
				$file_size = $_POST ['size'];
				$file_tmp = $_FILES ['image'] ['tmp_name'];
				// echo $file_tmp . "" .$file_ext . " " .$file_size;exit;
					
				// $data = file_get_contents($file_tmp);
				$data = '';
				$base64 = base64_encode ( $data );
				// echo "Base64 is ".$base64;exit;
				$upload_document = uploadDocument1 ( $caseId, $file_name, $file_ext, $file_size, $base64 );
				if ($upload_document != '') {
					$file_name = $upload_document->documentName;
					$document_id = $upload_document->documentId;
					$file_download_url = get_download_url1 ( $document_id );
					$response_msg = '<span style="color:green;font-weight:bold">Attachment added successfully.</span>';
				}
			}
			echo $response_msg;
		}
		exit ();
	}

	/* upload file */

	add_action ( 'wp_ajax_upload_file', 'upload_file' );
	add_action ( 'wp_ajax_nopriv_upload_file', 'upload_file' );
	function upload_file() {
		$question_id = sanitize_text_field ( $_POST ['question_id'] );
		$file_size = sanitize_text_field ( $_POST ['file_size'] );
		$file_tmp = sanitize_text_field ( $_POST ['file_tmp'] );

		if ($question_id != '') {
			// $file_name =$_FILES['image']['name'];
			$file_name = sanitize_text_field ( $_POST ['file_name'] );

			if ($file_name != '') {
				$file_ext = strtolower ( end ( explode ( '.', $file_name ) ) );
				// $data = file_get_contents($file_tmp);
				$data = "";
				$base64 = base64_encode ( $data );
				// echo "Base64 is ".$base64;exit;
				$upload_document = uploadDocument1 ( $question_id, $file_name, $file_ext, $file_size, $base64 );
				// print_r($upload_document);
				if ($upload_document != '') {
					$file_name = $upload_document->documentName;
					$document_id = $upload_document->documentId;
					$file_download_url = get_download_url1 ( $document_id );
					echo $document_id;
					// echo '<span style="color:green;font-weight:bold">File Uploaded successfully.</span>';
				}
			}
		}

		exit ();
	}

	/* Save Answer */

	add_action ( 'wp_ajax_save_answer', 'save_answer' );
	add_action ( 'wp_ajax_nopriv_save_answer', 'save_answer' );
	function save_answer() {
		$answerText = sanitize_text_field ( $_POST ['answerText'] );
		$questionText = sanitize_text_field ( $_POST ['questionText'] );
		$question_id = sanitize_text_field ( $_POST ['question_id'] );
		$document_id = sanitize_text_field ( $_POST ['document_id'] );
		$youtubeurl = sanitize_text_field ( $_POST ['youtubeUrl'] );
		$sessionKey = sanitize_text_field ( $_POST ['sessionkey'] );
		// echo $sessionKey;

		$api_url = APPTIVO_API_URL . '/app/dao/answers';
		if ($sessionKey != '') {
			$params = array (
				"a" => "saveAnswer",
				"answerStatus" => "FINAL",
				"answerText" => $answerText,
				"forumId" => 10107,
				"documentList" => '[' . $document_id . ']',
				"questionId" => $question_id,
				"questionText" => $questionText,
				"youtubeUrl" => $youtubeurl,
				"sessionKey" => $sessionKey 
			);
		} else {
			$params = array (
				"a" => "saveAnswer",
				"answerStatus" => "FINAL",
				"answerText" => $answerText,
				"forumId" => 10107,
				"documentList" => '[' . $document_id . ']',
				"questionId" => $question_id,
				"questionText" => $questionText,
				"youtubeUrl" => $youtubeurl,
				"apiKey" => APPTIVO_API_KEY,
				"accessKey" => APPTIVO_ACCESS_KEY 
			);
		}
		// po1($params);
		$response = getRestAPICall1 ( 'POST', $api_url, $params );
		// print_r($response);
		if ($response != '') {
			echo "100";
		}
		exit ();
	}
	/*
	 * My open Ticket
	 */

	register_activation_hook ( __FILE__, 'my_cases_page' );
	function my_cases_page() {
		global $wpdb;

		$the_page_title = 'My Open '.OBJECT_NAME_PLURAL;
		$the_page_name = 'My Open '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "my_case_page_title" );
		add_option ( "my_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "my_case_page_name" );
		add_option ( "my_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "my_case_page_id" );
		add_option ( "my_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[my_case_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'my_case_page_id' );
		add_option ( 'my_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'my_case_remove' );
	function my_case_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'my_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "my_case_page_title" );
		delete_option ( "my_case_page_name" );
		delete_option ( "my_case_page_id" );
	}

/*
 * Search Ticket
 */

	register_activation_hook ( __FILE__, 'search_cases_page' );
	function search_cases_page() {
		global $wpdb;

		$the_page_title = 'Search '.OBJECT_NAME_PLURAL;
		$the_page_name = 'Search '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "search_cases_page_title" );
		add_option ( "search_cases_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "search_cases_page_name" );
		add_option ( "search_cases_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "search_cases_page_id" );
		add_option ( "search_cases_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[search_cases_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
				
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'search_cases_page_id' );
		add_option ( 'search_cases_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'search_cases_page_remove' );

	function search_cases_page_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'search_cases_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "search_cases_page_title" );
		delete_option ( "search_cases_page_name" );
		delete_option ( "search_cases_page_id" );
	}

/*
 * All ticket
 */

	register_activation_hook ( __FILE__, 'all_cases_page' );
	function all_cases_page() {
		global $wpdb;

		$the_page_title = 'All '.OBJECT_NAME_PLURAL;
		$the_page_name = 'All '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "all_cases_page_title" );
		add_option ( "all_cases_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "all_cases_page_name" );
		add_option ( "all_cases_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "all_cases_page_id" );
		add_option ( "all_cases_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[all_cases_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
				
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'all_cases_page_id' );
		add_option ( 'all_cases_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'all_cases_page_remove' );
	function all_cases_page_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'all_cases_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "all_cases_page_title" );
		delete_option ( "all_cases_page_name" );
		delete_option ( "all_cases_page_id" );
	}
	/*
	 register_activation_hook ( __FILE__, 'create_question_page' );
	 function create_question_page() {
	 global $wpdb;

	 $the_page_title = 'Create Question';
	 $the_page_name = 'Create Question';

	 // the menu entry...
	 delete_option ( "create_question_page_title" );
	 add_option ( "create_question_page_title", $the_page_title, '', 'yes' );
	 // the slug...
	 delete_option ( "create_question_page_name" );
	 add_option ( "create_question_page_name", $the_page_name, '', 'yes' );
	 // the id...
	 delete_option ( "create_question_page_id" );
	 add_option ( "create_question_page_id", '0', '', 'yes' );

	 $the_page = get_page_by_title ( $the_page_title );

	 if (! $the_page) {

		// Create post object
		$_p = array ();
		$_p ['post_title'] = $the_page_title;
		$_p ['post_content'] = "[create_question_page]";
		$_p ['post_status'] = 'publish';
		$_p ['post_type'] = 'page';
		$_p ['comment_status'] = 'closed';
		$_p ['ping_status'] = 'closed';
		$_p ['post_category'] = array (
		1
		); // the default 'Uncatrgorised'
		 
		// Insert the post into the database
		$the_page_id = wp_insert_post ( $_p );
		} else {
		// the plugin may have been previously active and the page may just be trashed...

		$the_page_id = $the_page->ID;

		// make sure the page is not trashed...
		$the_page->post_status = 'publish';
		$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'create_question_page_id' );
		add_option ( 'create_question_page_id', $the_page_id );
		}

		register_deactivation_hook ( __FILE__, 'create_question_remove' );
		function create_question_remove() {
		$the_page_id = get_option ( 'create_question_page_id' );
		if ($the_page_id) {

		wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "create_question_page_title" );
		delete_option ( "create_question_page_name" );
		delete_option ( "create_question_page_id" );
		}

		*/
	/*
	 * Create Ticket
	 */

	register_activation_hook ( __FILE__, 'create_cases_page' );
	function create_cases_page() {
		global $wpdb;

		$the_page_title = 'Create '.OBJECT_NAME;
		$the_page_name = 'Create '.OBJECT_NAME;

		// the menu entry...
		delete_option ( "create_case_page_title" );
		add_option ( "create_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "create_case_page_name" );
		add_option ( "create_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "create_case_page_id" );
		add_option ( "create_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[create_case_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'create_case_page_id' );
		add_option ( 'create_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'create_case_remove' );
	function create_case_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'create_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "create_case_page_title" );
		delete_option ( "create_case_page_name" );
		delete_option ( "create_case_page_id" );
	}
	/*
	 * View ticket
	 */

	register_activation_hook ( __FILE__, 'view_cases_page' );
	function view_cases_page() {
		global $wpdb;

		$the_page_title = OBJECT_NAME.' Overview';
		$the_page_name = OBJECT_NAME.' Overview';

		// the menu entry...
		delete_option ( "view_case_page_title" );
		add_option ( "view_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "view_case_page_name" );
		add_option ( "view_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "view_case_page_id" );
		add_option ( "view_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[view_case_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'view_case_page_id' );
		add_option ( 'view_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'view_case_remove' );
	function view_case_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'view_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "view_case_page_title" );
		delete_option ( "view_case_page_name" );
		delete_option ( "view_case_page_id" );
	}
/*
 * Ticket Edit Page
 */
	register_activation_hook ( __FILE__, 'case_edit_page' );
	function case_edit_page() {
		global $wpdb;

		$the_page_title = 'Edit '.OBJECT_NAME;
		$the_page_name = 'Edit '.OBJECT_NAME;

		// the menu entry...
		delete_option ( "edit_case_page_title" );
		add_option ( "edit_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "edit_case_page_name" );
		add_option ( "edit_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "edit_case_page_id" );
		add_option ( "edit_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[edit_case_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'edit_case_page_id' );
		add_option ( 'edit_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'edit_case_remove' );
	function edit_case_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'edit_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "edit_case_page_title" );
		delete_option ( "edit_case_page_name" );
		delete_option ( "edit_case_page_id" );
	}
	
	/*
	 * Login Page
	 */

	register_activation_hook ( __FILE__, 'login_cases_page' );
	function login_cases_page() {
		global $wpdb;

		$the_page_title = 'Login';
		$the_page_name = 'Login';

		// the menu entry...
		delete_option ( "login_case_page_title" );
		add_option ( "login_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "login_case_page_name" );
		add_option ( "login_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "login_case_page_id" );
		add_option ( "login_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[login_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'login_case_page_id' );
		add_option ( 'login_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'login_case_remove' );
	function login_case_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'login_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "login_case_page_title" );
		delete_option ( "login_case_page_name" );
		delete_option ( "login_case_page_id" );
	}
	
	/*
	 * Register Page
	 */

	register_activation_hook ( __FILE__, 'register_cases_page' );
	function register_cases_page() {
		global $wpdb;

		$the_page_title = 'Register';
		$the_page_name = 'Register';

		// the menu entry...
		delete_option ( "register_case_page_title" );
		add_option ( "register_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "register_case_page_name" );
		add_option ( "register_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "register_case_page_id" );
		add_option ( "register_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[register_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'register_case_page_id' );
		add_option ( 'register_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'register_case_remove' );
	function register_case_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'register_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "register_case_page_title" );
		delete_option ( "register_case_page_name" );
		delete_option ( "register_case_page_id" );
	}

/*
 * Emplogin page
 */

	register_activation_hook ( __FILE__, 'emp_login_page' );
	function emp_login_page() {
		global $wpdb;

		$the_page_title = 'Emplogin';
		$the_page_name = 'Emplogin';

		// the menu entry...
		delete_option ( "emp_login_page_title" );
		add_option ( "emp_login_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "emp_login_page_name" );
		add_option ( "emp_login_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "emp_login_page_id" );
		add_option ( "emp_login_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[employee_login_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
				
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'emp_login_page_id' );
		add_option ( 'emp_login_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'emp_login_page_remove' );
	function emp_login_page_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'emp_login_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "emp_login_page_title" );
		delete_option ( "emp_login_page_name" );
		delete_option ( "emp_login_page_id" );
	}
/*
 * SSO Login Page
 */
	
	register_activation_hook ( __FILE__, 'sso_login_page' );
	function sso_login_page() {
		global $wpdb;

		$the_page_title = 'sso';
		$the_page_name = 'sso';

		// the menu entry...
		delete_option ( "sso_login_page_title" );
		add_option ( "sso_login_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "sso_login_page_name" );
		add_option ( "sso_login_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "sso_login_page_id" );
		add_option ( "sso_login_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			//$_p ['post_content'] = "[sso_login_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
				
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'sso_login_page_id' );
		add_option ( 'sso_login_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'sso_login_page_remove' );
	function sso_login_page_remove() {

		// the id of our page...
		$the_page_id = get_option ( 'sso_login_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "sso_login_page_title" );
		delete_option ( "sso_login_page_name" );
		delete_option ( "sso_login_page_id" );
	}
	
/*
 * Answers Page
 */


	register_activation_hook ( __FILE__, 'answers_cases_page' );
	function answers_cases_page() {
		global $wpdb;

		$the_page_title = 'Answers';
		$the_page_name = 'Answers';

		// the menu entry...
		delete_option ( "answers_case_page_title" );
		add_option ( "answers_case_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "answers_case_page_name" );
		add_option ( "answers_case_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "answers_case_page_id" );
		add_option ( "answers_case_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[answers_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'answers_case_page_id' );
		add_option ( 'answers_case_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'answers_case_remove' );
	function answers_case_remove() {
		$the_page_id = get_option ( 'answers_case_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "answers_case_page_title" );
		delete_option ( "answers_case_page_name" );
		delete_option ( "answers_case_page_id" );
	}

	register_activation_hook ( __FILE__, 'view_answer_page' );
	function view_answer_page() {
		global $wpdb;

		$the_page_title = 'View Answers';
		$the_page_name = 'View Answers';

		// the menu entry...
		delete_option ( "answers_view_page_title" );
		add_option ( "answers_view_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "answers_view_page_name" );
		add_option ( "answers_view_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "answers_view_page_id" );
		add_option ( "answers_view_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[view_answers_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'answers_view_page_id' );
		add_option ( 'answers_view_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'answers_view_remove' );
	function answers_view_remove() {
		$the_page_id = get_option ( 'answers_view_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "answers_view_page_title" );
		delete_option ( "answers_view_page_name" );
		delete_option ( "answers_view_page_id" );
	}

	register_activation_hook ( __FILE__, 'open_ticket_page' );
	function open_ticket_page() {
		global $wpdb;

		$the_page_title = 'All Open '.OBJECT_NAME_PLURAL;
		$the_page_name = 'All Open '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "open_ticket_page_title" );
		add_option ( "open_ticket_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "open_ticket_page_name" );
		add_option ( "open_ticket_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "open_ticket_page_id" );
		add_option ( "open_ticket_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[open_ticket_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'open_ticket_page_id' );
		add_option ( 'open_ticket_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'open_ticket_remove' );
	function open_ticket_remove() {
		$the_page_id = get_option ( 'open_ticket_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "open_ticket_page_title" );
		delete_option ( "open_ticket_page_name" );
		delete_option ( "open_ticket_page_id" );
	}

	register_activation_hook ( __FILE__, 'close_ticket_page' );
	function close_ticket_page() {
		global $wpdb;

		$the_page_title = 'All Closed '.OBJECT_NAME_PLURAL;
		$the_page_name = 'All Closed '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "close_ticket_page_title" );
		add_option ( "close_ticket_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "close_ticket_page_name" );
		add_option ( "close_ticket_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "close_ticket_page_id" );
		add_option ( "close_ticket_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[close_ticket_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'close_ticket_page_id' );
		add_option ( 'close_ticket_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'close_ticket_remove' );
	function close_ticket_remove() {
		$the_page_id = get_option ( 'close_ticket_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "close_ticket_page_title" );
		delete_option ( "close_ticket_page_name" );
		delete_option ( "close_ticket_page_id" );
	}

	register_activation_hook ( __FILE__, 'client_ticket_page' );
	function client_ticket_page() {
		global $wpdb;

		$the_page_title = OBJECT_NAME_PLURAL.' Pending Action';
		$the_page_name = OBJECT_NAME_PLURAL.' Pending Action';

		// the menu entry...
		delete_option ( "client_ticket_page_title" );
		add_option ( "client_ticket_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "client_ticket_page_name" );
		add_option ( "client_ticket_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "client_ticket_page_id" );
		add_option ( "client_ticket_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[client_ticket_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'client_ticket_page_id' );
		add_option ( 'client_ticket_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'client_ticket_remove' );
	function client_ticket_remove() {
		$the_page_id = get_option ( 'client_ticket_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "client_ticket_page_title" );
		delete_option ( "client_ticket_page_name" );
		delete_option ( "client_ticket_page_id" );
	}

	register_activation_hook ( __FILE__, 'myteam_open_ticket_page' );
	function myteam_open_ticket_page() {
		global $wpdb;

		$the_page_title = 'My Team\'s Open '.OBJECT_NAME_PLURAL;
		$the_page_name = 'My Team\'s Open '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "myteam_open_ticket_page_title" );
		add_option ( "myteam_open_ticket_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "myteam_open_ticket_page_name" );
		add_option ( "myteam_open_ticket_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "myteam_open_ticket_page_id" );
		add_option ( "myteam_open_ticket_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[myteam_open_ticket_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'myteam_open_ticket_page_id' );
		add_option ( 'myteam_open_ticket_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'myteam_open_ticket_page_remove' );
	function myteam_open_ticket_page_remove() {
		$the_page_id = get_option ( 'myteam_open_ticket_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "myteam_open_ticket_page_title" );
		delete_option ( "myteam_open_ticket_page_name" );
		delete_option ( "myteam_open_ticket_page_id" );
	}


	register_activation_hook ( __FILE__, 'all_myteam_ticket_page' );
	function all_myteam_ticket_page() {
		global $wpdb;

		$the_page_title = 'All My Team\'s '.OBJECT_NAME_PLURAL;
		$the_page_name = 'All My Team\'s '.OBJECT_NAME_PLURAL;

		// the menu entry...
		delete_option ( "all_myteam_ticket_page_title" );
		add_option ( "all_myteam_ticket_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "all_myteam_ticket_page_name" );
		add_option ( "all_myteam_ticket_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "all_myteam_ticket_page_id" );
		add_option ( "all_myteam_ticket_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[all_myteam_ticket_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'all_myteam_ticket_page_id' );
		add_option ( 'all_myteam_ticket_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'all_myteam_ticket_page_remove' );
	function all_myteam_ticket_page_remove() {
		$the_page_id = get_option ( 'all_myteam_ticket_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "all_myteam_ticket_page_title" );
		delete_option ( "all_myteam_ticket_page_name" );
		delete_option ( "all_myteam_ticket_page_id" );
	}

	/*
	 * Change password
	 *
	 */

	register_activation_hook ( __FILE__, 'change_password_page' );
	function change_password_page() {
		global $wpdb;

		$the_page_title = 'Change Password';
		$the_page_name = 'Change Password';

		// the menu entry...
		delete_option ( "change_password_page_title" );
		add_option ( "change_password_page_title", $the_page_title, '', 'yes' );
		// the slug...
		delete_option ( "change_password_page_name" );
		add_option ( "change_password_page_name", $the_page_name, '', 'yes' );
		// the id...
		delete_option ( "change_password_page_id" );
		add_option ( "change_password_page_id", '0', '', 'yes' );

		$the_page = get_page_by_title ( $the_page_title );

		if (! $the_page) {

			// Create post object
			$_p = array ();
			$_p ['post_title'] = $the_page_title;
			$_p ['post_content'] = "[change_password_page]";
			$_p ['post_status'] = 'publish';
			$_p ['post_type'] = 'page';
			$_p ['comment_status'] = 'closed';
			$_p ['ping_status'] = 'closed';
			$_p ['post_category'] = array (
			1
			); // the default 'Uncatrgorised'
			 
			// Insert the post into the database
			$the_page_id = wp_insert_post ( $_p );
		} else {
			// the plugin may have been previously active and the page may just be trashed...

			$the_page_id = $the_page->ID;

			// make sure the page is not trashed...
			$the_page->post_status = 'publish';
			$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'change_password_page_id' );
		add_option ( 'change_password_page_id', $the_page_id );
	}
	register_deactivation_hook ( __FILE__, 'change_password_page_remove' );
	function change_password_page_remove() {
		$the_page_id = get_option ( 'change_password_page_id' );
		if ($the_page_id) {

			wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "change_password_page_title" );
		delete_option ( "change_password_page_name" );
		delete_option ( "change_password_page_id" );
	}




	/*
	 register_activation_hook ( __FILE__, 'my_open_ticket_page' );
	 function my_open_ticket_page() {
	 global $wpdb;

	 $the_page_title = 'My Opened '.OBJECT_NAME_PLURAL;
	 $the_page_name = 'My Opened '.OBJECT_NAME_PLURAL;

	 // the menu entry...
	 delete_option ( "my_open_ticket_page_title" );
	 add_option ( "my_open_ticket_page_title", $the_page_title, '', 'yes' );
	 // the slug...
	 delete_option ( "my_open_ticket_page_name" );
	 add_option ( "my_open_ticket_page_name", $the_page_name, '', 'yes' );
	 // the id...
	 delete_option ( "my_open_ticket_page_id" );
	 add_option ( "my_open_ticket_page_id", '0', '', 'yes' );

	 $the_page = get_page_by_title ( $the_page_title );

	 if (! $the_page) {

		// Create post object
		$_p = array ();
		$_p ['post_title'] = $the_page_title;
		$_p ['post_content'] = "[my_open_ticket_page]";
		$_p ['post_status'] = 'publish';
		$_p ['post_type'] = 'page';
		$_p ['comment_status'] = 'closed';
		$_p ['ping_status'] = 'closed';
		$_p ['post_category'] = array (
		1
		); // the default 'Uncatrgorised'
		 
		// Insert the post into the database
		$the_page_id = wp_insert_post ( $_p );
		} else {
		// the plugin may have been previously active and the page may just be trashed...

		$the_page_id = $the_page->ID;

		// make sure the page is not trashed...
		$the_page->post_status = 'publish';
		$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'my_open_ticket_page_id' );
		add_option ( 'my_open_ticket_page_id', $the_page_id );
		}
		register_deactivation_hook ( __FILE__, 'my_open_ticket_remove' );
		function my_open_ticket_remove() {
		$the_page_id = get_option ( 'my_open_ticket_page_id' );
		if ($the_page_id) {

		wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "my_open_ticket_page_title" );
		delete_option ( "my_open_ticket_page_name" );
		delete_option ( "my_open_ticket_page_id" );
		}
		*/

	/*
	 register_activation_hook ( __FILE__, 'my_close_ticket_page' );
	 function my_close_ticket_page() {
	 global $wpdb;

	 $the_page_title = 'My Closed '.OBJECT_NAME_PLURAL;
	 $the_page_name = 'My Closed '.OBJECT_NAME_PLURAL;

	 // the menu entry...
	 delete_option ( "my_close_ticket_page_title" );
	 add_option ( "my_close_ticket_page_title", $the_page_title, '', 'yes' );
	 // the slug...
	 delete_option ( "my_close_ticket_page_name" );
	 add_option ( "my_close_ticket_page_name", $the_page_name, '', 'yes' );
	 // the id...
	 delete_option ( "my_close_ticket_page_id" );
	 add_option ( "my_close_ticket_page_id", '0', '', 'yes' );

	 $the_page = get_page_by_title ( $the_page_title );

	 if (! $the_page) {

		// Create post object
		$_p = array ();
		$_p ['post_title'] = $the_page_title;
		$_p ['post_content'] = "[my_close_ticket_page]";
		$_p ['post_status'] = 'publish';
		$_p ['post_type'] = 'page';
		$_p ['comment_status'] = 'closed';
		$_p ['ping_status'] = 'closed';
		$_p ['post_category'] = array (
		1
		); // the default 'Uncatrgorised'
		 
		// Insert the post into the database
		$the_page_id = wp_insert_post ( $_p );
		} else {
		// the plugin may have been previously active and the page may just be trashed...

		$the_page_id = $the_page->ID;

		// make sure the page is not trashed...
		$the_page->post_status = 'publish';
		$the_page_id = wp_update_post ( $the_page );
		}

		delete_option ( 'my_close_ticket_page_id' );
		add_option ( 'my_close_ticket_page_id', $the_page_id );
		}
		register_deactivation_hook ( __FILE__, 'my_close_ticket_remove' );
		function my_close_ticket_remove() {
		$the_page_id = get_option ( 'my_close_ticket_page_id' );
		if ($the_page_id) {

		wp_delete_post ( $the_page_id ); // this will trash, not delete
		}

		delete_option ( "my_close_ticket_page_title" );
		delete_option ( "my_close_ticket_page_name" );
		delete_option ( "my_close_ticket_page_id" );
		}
		*/

	?>
