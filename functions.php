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
    define('LEAFYDOC_THEME_VERSION', '1.0.0');
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

// Load includes
require_once LEAFYDOC_THEME_DIR . 'inc/palette.php';



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

/*---------------------------------------------------------------*/
/*---------------------- Theme Palette --------------------------*/
/*---------------------------------------------------------------*/

add_filter('kadence_global_palette_defaults', 'leafydoc_palette_defaults', 20);

function leafydoc_palette_defaults($palettes) {
    $palettes = '{
        "palette":[
            {
                "color":"#91705C",
                "slug":"palette1",
                "name":"Palette Color 1"
            },{
                "color":"#FBE46E",
                "slug":"palette2",
                "name":"Palette Color 2"
            },{
                "color":"#092D2A",
                "slug":"palette3",
                "name":"Palette Color 3"
            },{
                "color":"#FDCA85",
                "slug":"palette4",
                "name":"Palette Color 4"
            },{
                "color":"#FFF9C7",
                "slug":"palette5",
                "name":"Palette Color 5"
            },{
                "color":"#FBFBF4",
                "slug":"palette6",
                "name":"Palette Color 6"
            },{
                "color":"#EDF2F7",
                "slug":"palette7",
                "name":"Palette Color 7"
            },{
                "color":"#F7FAFC",
                "slug":"palette8",
                "name":"Palette Color 8"
            },{
                "color":"#ffffff",
                "slug":"palette9",
                "name":"Palette Color 9"
            }
        ],
        "second-palette":[
            {
                "color":"#dd6b20",
                "slug":"palette1",
                "name":"Palette Color 1"
            },{
                "color":"#cf3033",
                "slug":"palette2",
                "name":"Palette Color 2"
            },{
                "color":"#27241d",
                "slug":"palette3",
                "name":"Palette Color 3"
            },{
                "color":"#423d33",
                "slug":"palette4",
                "name":"Palette Color 4"
            },{
                "color":"#504a40",
                "slug":"palette5",
                "name":"Palette Color 5"
            },{
                "color":"#625d52",
                "slug":"palette6",
                "name":"Palette Color 6"
            },{
                "color":"#e8e6e1",
                "slug":"palette7",
                "name":"Palette Color 7"
            },{
                "color":"#faf9f7",
                "slug":"palette8",
                "name":"Palette Color 8"
            },{
                "color":"#ffffff",
                "slug":"palette9",
                "name":"Palette Color 9"
            }
        ],
        "third-palette":[
            {
                "color":"#3296ff",
                "slug":"palette1",
                "name":"Palette Color 1"
            },{
                "color":"#003174",
                "slug":"palette2",
                "name":"Palette Color 2"
            },{
                "color":"#ffffff",
                "slug":"palette3",
                "name":"Palette Color 3"
            },{
                "color":"#f7fafc",
                "slug":"palette4",
                "name":"Palette Color 4"
            },{
                "color":"#edf2f7",
                "slug":"palette5",
                "name":"Palette Color 5"
            },{
                "color":"#cbd2d9",
                "slug":"palette6",
                "name":"Palette Color 6"
            },{
                "color":"#1A202C",
                "slug":"palette7",
                "name":"Palette Color 7"
            },{
                "color":"#252c39",
                "slug":"palette8",
                "name":"Palette Color 8"
            },{
                "color":"#2D3748",
                "slug":"palette9",
                "name":"Palette Color 9"
            }
        ],
        "active":"second-palette"}';
    return $palettes;
}