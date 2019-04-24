<?php
// These are the common settings to adjust for your firm
define ( 'APPTIVO_API_KEY', '9cccUPDATETHISKEYba-5d58-4c52-UPDATETHISKEY-d8caUPDATETHISKEYc5a1' );
define ( 'APPTIVO_ACCESS_KEY', 'rUGYYZUPDATETHISKEY-RKByBvJRLZNz-UPDATETHISKEY-bf1c-bUPDATETHISKEY1823b7' );
define ( 'API_USER_EMAIL' , 'apiuser@apptivo.com');
define ( 'EMPLOYEE_OBJECT_ID', 8);
define ( 'TEAM_OBJECT_ID', 91);
define ( 'DEFAULT_ASSIGNEE_TYPE_ID', TEAM_OBJECT_ID);
define ( 'DEFAULT_ASSIGNEE_OBJECT_ID', '10857');
define ( 'DEFAULT_ASSIGNEE_NAME', 'Services Team');
define ( 'AUTH_METHOD', 'Apptivo Login' ); //Check documentation for options
define ( 'OBJECT_NAME', 'Case' );
define ( 'OBJECT_NAME_PLURAL', 'Cases' );
define ( 'NEWS_FEED_NAME', 'Service Requests' );
define ( 'APPTIVO_PORTAL_API_URL', 'https://uptrendz-llc.portal.apptivo.com/portal/login' ); //Only required for Xinnect AUTH_METHOD
const CREATE_PAGE_FIELD_NAMES = array('Type','Priority','Summary','Description');
const VIEW_PAGE_FIELD_NAMES = array('Status','Type','Priority','Contact','Summary','Description','Source');
const EDIT_PAGE_FIELD_NAMES = array('Type','Priority','Summary','Description');
define ( 'DEFAULT_STATUS_NAME', 'New' );
define ( 'DEFAULT_SOURCE_NAME', 'Services Portal' );
define ( 'DEFAULT_PRIORITY_NAME', 'P2 - Medium' );
define ( 'PENDING_ACTION_NAME', 'Pending Customer');
define ( 'CLOSED_STATUS_NAME', 'Closed');
define ( 'CLOSED_STATUS_ID', 20959);
define ( 'REOPEN_STATUS_NAME', 'Reopened');
define ( 'REOPEN_STATUS_ID', 28311344);


define ( 'FILTER_TYPE', true );
const FILTER_TYPE_CREATE =  Array('Issue','Enhancement','Change','Question');
const FILTER_TYPE_VIEW =  Array('Configuration Change','Service Request','Product Issue','Enhancement Request','Feature Acceleration');

//These settings are typically left as-is for standard deployments
define ( 'APPTIVO_API_URL', 'https://api.apptivo.com' );
define ( 'CA_APPID', '59' );
define ( 'XINNECT_TAG', 'acportal' );
define ( 'CONTACT_OBJECT_ID', 2);
define ( 'AWP_WEBSITE_URL', '/');
define ( 'KB_APP_NAME', 'Knowledge Base');
define ( 'SITEURL', get_option ( 'siteurl' ) );
define ( 'PORTAL_LOGIN_URL', SITEURL . AWP_WEBSITE_URL . 'login/' );
define ( 'PORTAL_MYCASES_URL', SITEURL . AWP_WEBSITE_URL . 'my-open-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_ALLTICKETS_URL', SITEURL . AWP_WEBSITE_URL . 'all-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_OPENTICK_URL', SITEURL . AWP_WEBSITE_URL . 'all-open-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_CLOSETICK_URL', SITEURL . AWP_WEBSITE_URL . 'all-closed-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_CLIENTACTION_URL', SITEURL . AWP_WEBSITE_URL . ''.strtolower(OBJECT_NAME_PLURAL).'-pending-action/' );
define ( 'PORTAL_MYTEAMSOPENTICKETS_URL', SITEURL . AWP_WEBSITE_URL . 'my-teams-open-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_ALLMYTEAMSTICKETS_URL', SITEURL . AWP_WEBSITE_URL . 'all-my-teams-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_ANSWERS_URL', SITEURL . AWP_WEBSITE_URL . 'answers/' );
define ( 'PORTAL_CREATECASES_URL', SITEURL . AWP_WEBSITE_URL . 'create-'.strtolower(OBJECT_NAME).'/' );
define ( 'PORTAL_SEARCHCASES_URL', SITEURL . AWP_WEBSITE_URL . 'search-'.strtolower(OBJECT_NAME_PLURAL).'/' );
define ( 'PORTAL_URL', SITEURL . AWP_WEBSITE_URL );
define ( 'APPTIVO_CUSTOMER_OBJECT_ID', '3' );
define ( 'APPTIVO_CONTACT_OBJECT_ID', '2' );
define ( 'APPTIVO_CUSTOMER_API', APPTIVO_API_URL . '/app/dao/v6/customers' );
define ( 'APPTIVO_CONTACTS_API', APPTIVO_API_URL . '/app/dao/v6/contacts' );
define('ENABLE_SPLAH_SCREEN', "N");


?>
