<?php
/**
 * Template Name: Quill Redirect  Florida
 *
 * @package   Wellness_Wag_Theme
 * @link      https://rankfoundry.com
 * @copyright Copyright (C) 2021-2023, Rank Foundry LLC - support@rankfoundry.com
 * @since     1.0.3
 * @license   GPL-2.0+
 *
 */

// Get the GET parameters from the URL
$first_name = isset($_GET['fname']) ? sanitize_text_field($_GET['fname']) : '';
$last_name = isset($_GET['lname']) ? sanitize_text_field($_GET['lname']) : '';
$email = isset($_GET['email']) ? sanitize_email($_GET['email']) : '';
$phone = isset($_GET['phone']) ? sanitize_text_field($_GET['phone']) : '';
$state = isset($_GET['state']) ? sanitize_text_field($_GET['state']) : '';

$trackingData = array();
if (isset($_COOKIE['_utd'])) {
    $trackingData = json_decode(stripslashes($_COOKIE['_utd']), true);
}


// Format the phone number
if (!empty($phone)) {
    $phone = preg_replace('/[^0-9]/', '', $phone); // Remove non-numeric characters
    $phone = preg_replace('/(\d{1})(\d{3})(\d{3})(\d{4})/', '$1-$2-$3-$4', $phone); // Format as 1-XXX-XXX-XXXX
}



function isNextDayDST($stateCode) {
    $nextDay = new DateTime('tomorrow');
    $timeZone = new DateTimeZone(getTimeZoneByState($stateCode));
    $nextDay->setTimezone($timeZone);
    
    $transitions = $timeZone->getTransitions($nextDay->getTimestamp(), $nextDay->getTimestamp());

    if (isset($transitions[0]) && $transitions[0]['isdst']) {
        return true;
    }

    return false;
}

function getTimeZoneByState($stateCode) {
    $stateToTimeZone = [
        'AL' => 'America/Chicago',
        'AK' => 'America/Anchorage',
        'AZ' => 'America/Phoenix',
        'AR' => 'America/Chicago',
        'CA' => 'America/Los_Angeles',
        'CO' => 'America/Denver',
        'CT' => 'America/New_York',
        'DE' => 'America/New_York',
        'FL' => 'America/New_York',
        'GA' => 'America/New_York',
        'HI' => 'Pacific/Honolulu',
        'ID' => 'America/Denver',
        'IL' => 'America/Chicago',
        'IN' => 'America/Indiana/Indianapolis',
        'IA' => 'America/Chicago',
        'KS' => 'America/Chicago',
        'KY' => 'America/New_York',
        'LA' => 'America/Chicago',
        'ME' => 'America/New_York',
        'MD' => 'America/New_York',
        'MA' => 'America/New_York',
        'MI' => 'America/New_York',
        'MN' => 'America/Chicago',
        'MS' => 'America/Chicago',
        'MO' => 'America/Chicago',
        'MT' => 'America/Denver',
        'NE' => 'America/Chicago',
        'NV' => 'America/Los_Angeles',
        'NH' => 'America/New_York',
        'NJ' => 'America/New_York',
        'NM' => 'America/Denver',
        'NY' => 'America/New_York',
        'NC' => 'America/New_York',
        'ND' => 'America/Chicago',
        'OH' => 'America/New_York',
        'OK' => 'America/Chicago',
        'OR' => 'America/Los_Angeles',
        'PA' => 'America/New_York',
        'RI' => 'America/New_York',
        'SC' => 'America/New_York',
        'SD' => 'America/Chicago',
        'TN' => 'America/Chicago',
        'TX' => 'America/Chicago',
        'UT' => 'America/Denver',
        'VT' => 'America/New_York',
        'VA' => 'America/New_York',
        'WA' => 'America/Los_Angeles',
        'WV' => 'America/New_York',
        'WI' => 'America/Chicago',
        'WY' => 'America/Denver'
    ];

    return $stateToTimeZone[$stateCode] ?? 'UTC';
}

function getStateTimezone($stateCode) {
    $isDST = isNextDayDST($stateCode);
	
     $stateTimezones = [
        'AL' => 'CST',
        'AK' => 'AKST',
        'AZ' => 'MST',
        'AR' => 'CST',
        'CA' => 'PST',
        'CO' => 'MST',
        'CT' => 'EST',
        'DE' => 'EST',
        'FL' => 'EST',
        'GA' => 'EST',
        'HI' => 'HST',
        'ID' => 'MST',
        'IL' => 'CST',
        'IN' => 'EST',
        'IA' => 'CST',
        'KS' => 'CST',
        'KY' => 'EST',
        'LA' => 'CST',
        'ME' => 'EST',
        'MD' => 'EST',
        'MA' => 'EST',
        'MI' => 'EST',
        'MN' => 'CST',
        'MS' => 'CST',
        'MO' => 'CST',
        'MT' => 'MST',
        'NE' => 'CST',
        'NV' => 'PST',
        'NH' => 'EST',
        'NJ' => 'EST',
        'NM' => 'MST',
        'NY' => 'EST',
        'NC' => 'EST',
        'ND' => 'CST',
        'OH' => 'EST',
        'OK' => 'CST',
        'OR' => 'PST',
        'PA' => 'EST',
        'RI' => 'EST',
        'SC' => 'EST',
        'SD' => 'CST',
        'TN' => 'CST',
        'TX' => 'CST',
        'UT' => 'MST',
        'VT' => 'EST',
        'VA' => 'EST',
        'WA' => 'PST',
        'WV' => 'EST',
        'WI' => 'CST',
        'WY' => 'MST'
    ];

    $noDST = ['AZ', 'HI'];

    if ($isDST && !in_array($stateCode, $noDST)) {
        switch ($stateTimezones[$stateCode]) {
            case 'PST':
                return 'PDT';
            case 'MST':
                return 'MDT';
            case 'CST':
                return 'CDT';
            case 'EST':
                return 'EDT';
            case 'AKST':
                return 'AKDT';
            case 'HST':
                return 'HST'; // Hawaii doesn't observe DST, but added for clarity.
            default:
                return 'CST';
        }
    }

    return $stateTimezones[$stateCode] ?? 'CST';
}


// Create the data array
$data = array(
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email,
    'phone' => $phone,
    'birthdate' => '',
    'state_of_evaluation' => $state,
    'state' => $state,
    'city' => '',
    'address' => '',
    'zip_code' => '',
    'gender' => 'Male',
    'timezone' => getStateTimezone($state),
    'extra_data' => array(
        'contact[contact_type]' => 'Patient',
        'contact[audiences]' => 'LD Newsletter, LM Newsletter, LD Webinar Marketing',
        'product[name]' => 'Medical Card - '.$state,
	'contact[irclickid]' => isset($trackingData['irclickid']) ? sanitize_text_field($trackingData['irclickid']) : '',
        
		'gclid' => isset($trackingData['gclid']) ? sanitize_text_field($trackingData['gclid']) : '',
        'gaclient' => isset($trackingData['ga_client']) ? sanitize_text_field($trackingData['ga_client']) : '',
        'irclickid' => isset($trackingData['irclickid']) ? sanitize_text_field($trackingData['irclickid']) : '',
        'utm_source' => isset($trackingData['utm_source']) ? sanitize_text_field($trackingData['utm_source']) : '',
        'utm_medium' => isset($trackingData['utm_medium']) ? sanitize_text_field($trackingData['utm_medium']) : '',
        'utm_campaign' => isset($trackingData['utm_campaign']) ? sanitize_text_field($trackingData['utm_campaign']) : '',
        'utm_term' => isset($trackingData['utm_term']) ? sanitize_text_field($trackingData['utm_term']) : '',
        'utm_content' => isset($trackingData['utm_content']) ? sanitize_text_field($trackingData['utm_content']) : '',
		
    ),
);

//echo '<pre>';print_r($data);echo '</pre>'; die;

// Convert the data to JSON
$json_data = json_encode($data);

// Base64 encode the JSON
$base64_encoded_data = base64_encode($json_data);
//$url = 'https://webhook.site/b2c93b84-3d04-4e24-bda9-3d86857c2e99';

		 $utm_params = [];
		 $utm_params['from'] = 'leafydoc';
		 isset($trackingData['gclid']) ? $utm_params['gclid']  = sanitize_text_field($trackingData['gclid']) : false;
         isset($trackingData['ga_client']) ? $utm_params['gaclient']  = sanitize_text_field($trackingData['ga_client']) : false;
         isset($trackingData['utm_source']) ? $utm_params['utm_source']  = sanitize_text_field($trackingData['utm_source']) : false;
         isset($trackingData['utm_medium']) ? $utm_params['utm_medium']  = sanitize_text_field($trackingData['utm_medium']) : false;
         isset($trackingData['utm_campaign']) ? $utm_params['utm_campaign']  = sanitize_text_field($trackingData['utm_campaign']) : false;
         isset($trackingData['utm_term']) ? $utm_params['utm_term']  = sanitize_text_field($trackingData['utm_term']) : false;
         isset($trackingData['utm_content']) ? $utm_params['utm_content']  = sanitize_text_field($trackingData['utm_content']) : false;
 	 isset($trackingData['irclickid']) ? $utm_params['irclickid'] = sanitize_text_field($trackingData['irclickid']) : false;
		 $utm_params['cuid'] = $_COOKIE['cuid'];
		 $utm_params['creferrer'] = $_COOKIE['creferrer'];
		


$url = 'https://lddocmj.com?'. http_build_query($utm_params);

//var_dump($url,$data); die;

if( isset($_GET['email']) && isset($_GET['lname']) && isset($_GET['fname']) && isset($_GET['phone']) && isset($_GET['state']) )
wp_redirect($url);
else
wp_redirect('/get-started/intake-florida');

exit; 
?>

<!-- Output the JSON data (optional) -->
