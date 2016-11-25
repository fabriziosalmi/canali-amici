<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: Canali amici per Wordpress
Plugin URI: https://github.com/fabriziosalmi/canali-amici-wp-plugin
Description: Visualizza uno dei canali amici di KissTube.
Version: 0.1
Author: Fabrizio Salmi
Author URI: https://github.com/fabriziosalmi
License: GPL
*/
add_action( 'admin_menu', 'canaliamici_menu' );
function canaliamici_menu() {
	add_options_page( 'Canali', 'Canali', 'manage_options', 'canali-amici-wp-plugin', 'canaliamici_options' );
}
function canaliamici_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=canali-amici-wp-plugin.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'canaliamici_settings_link' );
/** Step 3. */
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<h2>Canali amici</h2>';
	echo '<p>Il plugin in questo momento funziona correttamente. In ogni pagina verrà visualizzato un link ad uno dei canali amici di KissTube.</p>';
}
function theme_slug_filter_the_content( $content ) {
$canale = wp_remote_get('https://code.kisstube.tv/api/canaliamici.php');
$canale = $canale['body'];
	$canali_title = '<strong>Iscriviti ai canali amici</strong><br>';
	$canali_item = $canale;
    	$canali_content = '<div style="color: #656c7a;font-family: Helvetica Neue,arial,sans-serif;font-size: 15px;font-weight:500;"><br>'.$canali_title.$canali_item.'<br></div>';
    	$canali_content = $canale .= $canali_content;
    	return $canali_content;
}
add_filter( 'the_content', 'theme_slug_filter_the_content' );
?>
