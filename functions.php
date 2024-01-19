<?php
/**
 * LeafyDOC Theme
 *
 * @package   LeafyDOC_Theme
 * @link      https://rankfoundry.com
 * @copyright Copyright (C) 2021-2023, Rank Foundry LLC - support@rankfoundry.com
 * @since     1.0.0
 * @license   GPL-2.0+
 *
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;



/*--------------------------------------------------------------*/
/*---------------------- Theme Setup ---------------------------*/
/*--------------------------------------------------------------*/
// Define theme version
if (!defined('LEAFYDOC_THEME_VERSION')) {
    define('LEAFYDOC_THEME_VERSION', '1.0.1');
}

// Define theme directory path
if (!defined('LEAFYDOC_THEME_DIR')) {
    define('LEAFYDOC_THEME_DIR', trailingslashit( get_stylesheet_directory() ));
}

// Define theme directory URI
if (!defined('LEAFYDOC_THEME_DIR_URI')) {
    define('LEAFYDOC_THEME_DIR_URI', trailingslashit( esc_url( get_stylesheet_directory_uri() )));
}

// Define current theme name
if (!defined('CURRENT_THEME_NAME')) {
    $current_theme_obj = wp_get_theme();
    define('CURRENT_THEME_NAME', $current_theme_obj->get('Name'));
}

// Load the Composer autoloader.
require_once LEAFYDOC_THEME_DIR . 'vendor/autoload.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;



/*--------------------------------------------------------------*/
/*------------------ Theme Update Checker ----------------------*/
/*--------------------------------------------------------------*/
if ( 'leafydoc' === CURRENT_THEME_NAME ) {
	$minimalUpdateChecker = PucFactory::buildUpdateChecker(
		'https://github.com/rankfoundry/leafydoc-theme/',
		LEAFYDOC_THEME_DIR . '/functions.php',
		'leafydoc',
		48
	);
	$minimalUpdateChecker->setBranch('main');
}



/*--------------------------------------------------------------*/
/*--------------------- WP Auto Updates ------------------------*/
/*--------------------------------------------------------------*/

// allows WP plugins to automatically update.
add_filter('auto_update_plugin', '__return_true');

// allow themes to automatically update.
add_filter('auto_update_theme', '__return_true');

// allow WP core updates.
add_filter('allow_minor_auto_core_updates', '__return_true');
add_filter('allow_major_auto_core_updates', '__return_true');

// force auto updates even for version controlled code enviroments.
add_filter('automatic_updates_is_vcs_checkout', '__return_false', 1);




/*---------------------------------------------------------------*/
/*---------------------- Theme Styles ---------------------------*/
/*---------------------------------------------------------------*/

add_action('wp_enqueue_scripts', 'child_enqueue_assets');

function child_enqueue_assets() {
    // CSS
    wp_enqueue_style( 'leafydoc-fontawesome', get_stylesheet_directory_uri() . '/assets/css/fontawesome.min.css', array(), 100 );
    wp_enqueue_style( 'leafydoc-custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), 100 );
    wp_enqueue_style( 'leafydoc', get_stylesheet_directory_uri() . '/style.css', array(), 100 );

    // JS 
    wp_enqueue_script( 'leafydoc-custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), 100, true );
}
function leafydoc_custom_styles() {
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/assets/css/custom.css' );
}
add_action( 'wp_enqueue_scripts', 'leafydoc_custom_styles' );

function custom_quill_scripts() {
	$inline_script = <<<SCRIPT
	
	document.addEventListener("DOMContentLoaded", function() {
		function generateString(length) {
			const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			let result = '';
			const charactersLength = characters.length;
			for (let i = 0; i < length; i++) {
				result += characters.charAt(Math.floor(Math.random() * charactersLength));
			}
			return result;
		}
		
		function getParameterByName(name) {
			name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
			const regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
				results = regex.exec(location.search);
			return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		}

		function setCookie(name, value, days) {
			const d = new Date();
			d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
			const expires = "expires=" + d.toUTCString();
			document.cookie = name + "=" + value + ";" + expires + ";path=/";
		}

		function getCookie(cname) {
			const name = cname + "=";
			const decodedCookie = decodeURIComponent(document.cookie);
			const ca = decodedCookie.split(';');
			for(let i = 0; i < ca.length; i++) {
				let c = ca[i];
				while (c.charAt(0) === ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) === 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}
		
		const deleteCookie = name => setCookie(name, '', -1);
		
		let customUserId;
		customUserId = localStorage.getItem("tcustom_user_id") || generateString(10);
		localStorage.setItem("tcustom_user_id", customUserId);
		setCookie('cuid', customUserId);

		let creferrer;
		creferrer = localStorage.getItem("tcreferrer") || document.referrer || null;
		localStorage.setItem("tcreferrer", creferrer);
		setCookie('creferrer', creferrer);

		if (!getCookie('_utd')) {
			const parameters = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid','ga_client','irclickid'];
			let trackingData = {};

			parameters.forEach(param => {
				const value = getParameterByName(param);
				if (value) trackingData[param] = value;
			});

			if (Object.keys(trackingData).length > 0) {
				setCookie('_utd', JSON.stringify(trackingData), 30); // 30 days expiry
			}
		}
		
		posthog?.identify(customUserId, {creferrer});
	});

	SCRIPT;

	wp_add_inline_script('jquery', $inline_script); // This adds your script after jQuery
}
add_action( 'wp_enqueue_scripts', 'custom_quill_scripts' ); 
