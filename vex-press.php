<?php
/*
Plugin Name: VexPress
Plugin URI: https://github.com/mindsharestudios/vexpress/
Description: VexPress - basic modal dialog using the Vex library
Version: 0.1
Author: Mindshare Studios, Inc.
Author URI: http://mind.sh/are/
License: GNU General Public License
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
Text Domain: vex-press
Domain Path: /lang
*/

/**
 * Original code by Winston Riley @ https://github.com/mason505/VexPress
 *
 * Copyright 2015  Mindshare Studios, Inc. (https://mind.sh/are/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3, as
 * published by the Free Software Foundation.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

// deny direct access
if(!function_exists('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

if(!defined('VEXPRESS_VERSION')) {
	define('VEXPRESS_VERSION', '0.1');
}

if(!defined('VEXPRESS_MIN_WP_VERSION')) {
	define('VEXPRESS_MIN_WP_VERSION', '4.2');
}

if(!defined('VEXPRESS_PLUGIN_NAME')) {
	define('VEXPRESS_PLUGIN_NAME', 'VexPress');
}

if(!defined('VEXPRESS_PLUGIN_SLUG')) {
	define('VEXPRESS_PLUGIN_SLUG', dirname(plugin_basename(__FILE__))); // vex-press
}

if(!defined('VEXPRESS_DIR_PATH')) {
	define('VEXPRESS_DIR_PATH', plugin_dir_path(__FILE__));
}

if(!defined('VEXPRESS_DIR_URL')) {
	define('VEXPRESS_DIR_URL', trailingslashit(plugins_url(NULL, __FILE__)));
}

if(!defined('VEXPRESS_OPTIONS')) {
	define('VEXPRESS_OPTIONS', 'vex_press_options');
}

if(!defined('VEXPRESS_TEMPLATE_PATH')) {
	define('VEXPRESS_TEMPLATE_PATH', trailingslashit(get_template_directory()) . trailingslashit(VEXPRESS_PLUGIN_SLUG));
	// e.g. /wp-content/themes/__ACTIVE_THEME__/plugin-slug
}

// check WordPress version
global $wp_version;
if(version_compare($wp_version, VEXPRESS_MIN_WP_VERSION, "<")) {
	exit(VEXPRESS_PLUGIN_NAME . ' requires WordPress ' . VEXPRESS_MIN_WP_VERSION . ' or newer.');
}

if(!class_exists('VEX_PRESS')) :
	/**
	 * Class VEX_PRESS
	 */
	class VEX_PRESS {

		/**
		 * @var vex_press_settings
		 */
		private $settings_framework;

		/**
		 * @var string Default Vex Stylesheet.
		 */
		public $vexStyleSheet;
		/**
		 * @var string Default Vex Yes/confrim text..
		 */
		public $vexBtnYes;
		/**
		 * @var string Default Vex No/cancel text.
		 */
		public $vexBtnNo;
		
		/**
		 * Initialize the plugin. Set up actions / filters.
		 */
		public function __construct() {

			// i8n, uncomment for translation support
			//add_action('plugins_loaded', array($this, 'load_textdomain'));

			// Admin scripts
			//add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
			//add_action('admin_enqueue_scripts', array($this, 'register_admin_styles'));

			// Plugin action links
			add_filter('plugin_action_links', array($this, 'plugin_action_links'), 10, 2);

			// Frontend scripts
			add_action('get_footer', array($this, 'register_scripts'));
			add_action('get_footer', array($this, 'register_styles'));

			// Activation hooks
			//register_activation_hook(__FILE__, array($this, 'activate'));
			//register_deactivation_hook(__FILE__, array($this, 'deactivate'));

			// Uninstall hook
			register_uninstall_hook(VEXPRESS_DIR_PATH . 'uninstall.php', NULL);

			// Settings Framework
			add_action('admin_menu', array($this, 'admin_menu'), 99);
			require_once(VEXPRESS_DIR_PATH . 'lib/settings-framework/settings-framework.php');
			$this->settings_framework = new vex_press_settings(VEXPRESS_DIR_PATH . 'views/settings.php', VEXPRESS_OPTIONS);

			// Add an optional settings validation filter (recommended)
			add_filter($this->settings_framework->get_option_group() . '_validate', array($this, 'validate_settings'));

			// uncomment to disable the Uninstall and Reset Default buttons
			//$this->settings_framework->show_reset_button = FALSE;
			//$this->settings_framework->show_uninstall_button = FALSE;

			// allow user to override the default vex stuff
			$this->vexStyleSheet = apply_filters('vex_press_theme', 'vex-theme-plain');
			$this->vexBtnNo = apply_filters('vex_press_no', __('CANCEL', 'vex-press'));
			$this->vexBtnYes = apply_filters('vex_press_yes', __('OK', 'vex-press'));

			add_action('init', array($this, 'init'), 0, 0); // filterable init action

		}

		/**
		 * Allows user to override the default action used to enqueue scripts.
		 */
		public function init() {

			// allow user to override the init action
			$init_action = apply_filters('vex_press_init_action', 'wp_head');
			add_action($init_action, array($this, 'init'));
		}

		/**
		 * Returns the class name and version.
		 *
		 * @return string
		 */
		public function __toString() {
			return get_class($this) . ' ' . $this->get_version();
		}

		/**
		 * Returns the plugin version number.
		 *
		 * @return string
		 */
		public function get_version() {
			return VEXPRESS_VERSION;
		}

		/**
		 * @return string
		 */
		public function get_plugin_url() {
			return VEXPRESS_DIR_URL;
		}

		/**
		 * @return string
		 */
		public function get_plugin_path() {
			return VEXPRESS_DIR_PATH;
		}

		/**
		 * Register the plugin text domain for translation
		 */
		public function load_textdomain() {
			load_plugin_textdomain(VEXPRESS_PLUGIN_SLUG, FALSE, VEXPRESS_DIR_PATH . '/lang');
		}

		/**
		 * Activation
		 */
		public function activate() {
		}

		/**
		 * Deactivation
		 */
		public function deactivate() {
		}

		/**
		 * Install
		 */
		public function install() {
		}

		/**
		 * WordPress options page
		 */
		public function admin_menu() {
			// top level page
			//add_menu_page(__(VEXPRESS_PLUGIN_NAME, 'vex-press'), __(VEXPRESS_PLUGIN_NAME, 'vex-press'), 'manage_options', VEXPRESS_PLUGIN_SLUG, array($this,'settings_page'));

			// Settings page
			add_submenu_page('options-general.php', __(VEXPRESS_PLUGIN_NAME . ' Settings', 'vex-press'), __(VEXPRESS_PLUGIN_NAME . ' Settings', 'vex-press'), 'manage_options', VEXPRESS_PLUGIN_SLUG, array(
				$this,
				'settings_page'
			));
		}

		/**
		 *  Settings page
		 */
		public function settings_page() {

			?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div>
				<h2><?php echo VEXPRESS_PLUGIN_NAME; ?></h2>
				<?php
				// Output settings-framework form
				$this->settings_framework->settings();
				?>
			</div>
			<?php

			// Get settings
			//$settings = $this->get_settings(VEXPRESS_OPTIONS);
			//echo '<pre>'.print_r($settings, TRUE).'</pre>';

			// Get individual setting
			//$setting = $this->get_setting(VEXPRESS_OPTIONS, 'general', 'text');
			//var_dump($setting);
		}

		/**
		 * Settings validation
		 *
		 * @see $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
		 *
		 * @param $input
		 *
		 * @return mixed
		 */
		public function validate_settings($input) {
			return $input;
		}

		/**
		 * Converts the settings-framework filename to option group id
		 *
		 * @param $settings_file string settings-framework file
		 *
		 * @return string option group id
		 */
		public function get_option_group($settings_file) {
			$option_group = preg_replace("/[^a-z0-9]+/i", "", basename($settings_file, '.php'));

			return $option_group;
		}

		/**
		 * Get the settings from a settings-framework file/option group
		 *
		 * @param $option_group string option group id
		 *
		 * @return array settings
		 */
		public function get_settings($option_group) {
			return get_option($option_group);
		}

		/**
		 * Get a setting from an option group
		 *
		 * @param $option_group string option group id
		 * @param $section_id   string section id
		 * @param $field_id     string field id
		 *
		 * @return mixed setting or false if no setting exists
		 */
		public function get_setting($option_group, $section_id, $field_id) {
			$options = get_option($option_group);
			if(isset($options[ $option_group . '_' . $section_id . '_' . $field_id ])) {
				return $options[ $option_group . '_' . $section_id . '_' . $field_id ];
			}

			return FALSE;
		}

		/**
		 * Delete all the saved settings from a settings-framework file/option group
		 *
		 * @param $option_group string option group id
		 */
		public function delete_settings($option_group) {
			delete_option($option_group);
		}

		/**
		 * Deletes a setting from an option group
		 *
		 * @param $option_group string option group id
		 * @param $section_id   string section id
		 * @param $field_id     string field id
		 *
		 * @return mixed setting or false if no setting exists
		 */
		public function delete_setting($option_group, $section_id, $field_id) {
			$options = get_option($option_group);
			if(isset($options[ $option_group . '_' . $section_id . '_' . $field_id ])) {
				$options[ $option_group . '_' . $section_id . '_' . $field_id ] = NULL;

				return update_option($option_group, $options);
			}

			return FALSE;
		}

		/**
		 * Add a settings link to plugins page
		 *
		 * @param $links
		 * @param $file
		 *
		 * @return array
		 */
		public function plugin_action_links($links, $file) {
			if($file == plugin_basename(__FILE__)) {
				$settings_link = '<a href="options-general.php?page=' . VEXPRESS_PLUGIN_SLUG . '" title="' . __(VEXPRESS_PLUGIN_NAME, 'vex-press') . '">' . __('Settings', 'vex-press') . '</a>';
				array_unshift($links, $settings_link);
			}

			return $links;
		}

		/**
		 * Enqueue and register JavaScript
		 */
		public function register_admin_scripts() {
			/*wp_register_script('vex-press', VEXPRESS_DIR_URL.'/assets/js/vex-press.js');
			$translation_array = array(
				'js_handle' => __('Text to use in JavaScript', 'vex-press')
			);
			wp_localize_script('vex-press', 'vex_press_text', $translation_array);
			wp_enqueue_script('vex-press');*/
		}

		/**
		 * Enqueue and register Admin CSS
		 */
		public function register_admin_styles() {
		}

		/**
		 * Enqueue and register JavaScript
		 */
		public function register_scripts() {
			wp_enqueue_script('vex', VEXPRESS_DIR_URL . "lib/vex/js/vex.combined.min.js", array('jquery')); // vex js

      if ( ! $this->showModal() ) return;  

      wp_enqueue_script('showModal', VEXPRESS_DIR_URL . "/assets/js/showModal.js", array('vex'));
			wp_localize_script('showModal', 'wp_vars', array(
        'vexStyle'        => $this->vexStyleSheet, // sets the dialog box style inside JS.
        'vexStyle_'       => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_vexstyle'),
				'vexBtnNo'        => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_disagreeText'),
				'vexBtnYes'       => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_agreeText'),
        // 'vexOverlayStyle' => $this->vexOverlayStyle,
        'vexOverlayStyle' => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_backgroundColor'),
				'message'         => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_message'),
        'opacity'         => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_opacity'),
        'priBtnColor'     => $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_agreeColor')
			));
		}

		/**
		 * Enqueue and register CSS
		 */
		public function register_styles() {
      
      $style = $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_vexstyle');
      if ($style){  
			  wp_enqueue_style("vex-theme-os", VEXPRESS_DIR_URL . "lib/vex/css/" . $style . ".css");
      } else {
        wp_enqueue_style("vex-theme-os", VEXPRESS_DIR_URL . "lib/vex/css/" . 'vex-theme-plain' . ".css");
      }
			
      wp_enqueue_style("vex-base", VEXPRESS_DIR_URL . "lib/vex/css/vex.css");
		}
    
    // function to determin is the moda should be envoked or not.
    private function showModal()
    {
      $pageTitle = $this->get_setting(VEXPRESS_OPTIONS, 'general', 'vexp_pageid'); 

      //show on all pages:
      if (strtolower($pageTitle) == 'all') return true;
      
      // show on the front page
      if ($pageTitle == "") return is_front_page(); // default behavior
      
      // show on the specified page
      return get_the_title(get_the_ID()) == $pageTitle;
    }
	}
endif;

$vex_press = new VEX_PRESS();
