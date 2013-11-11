<?php
/**
* Plugin Name: WP Personalize
* Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5GB537F64NUDE
* Plugin URI: http://wordpress.org/plugins/wp-personalize/
* Version: 1.0
* Author: Ecalon IT LTD.
* Author URI: http://www.ecalon.it/
* Description: Personalize and customize your WordPress site with your own CSS, Javascript, HTML and PHP code fragments.
* License: GPL2
*/

/*  Copyright 2013 WP Personalize (email : info@ecalon.it)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* @package WP Personalize
* @author Ecalon IT LTD.
* @version 1.0
* @copyright Ecalon IT LTD.
*/
class WPPersonalize {

	function WPPersonalize() {
		$this->plugin = new stdClass;
		$this->plugin->name 				= 'wp-personalize';
		$this->plugin->displayName 	= 'WP Personalize';
		$this->plugin->version 			= '1.0.0';
		$this->plugin->folder 			= WP_PLUGIN_DIR.'/'.$this->plugin->name;
		$this->plugin->pluginURL 		= WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__),"",plugin_basename(__FILE__));
		$this->plugin->contentURL		= WP_CONTENT_URL.'/wp-personalize/';
		
		$this->plugin->cssCode 	= WP_CONTENT_DIR.'/'.$this->plugin->name.'/cssCode.css';
		$this->plugin->jsCode 	= WP_CONTENT_DIR.'/'.$this->plugin->name.'/jsCode.js';
		$this->plugin->headCode = WP_CONTENT_DIR.'/'.$this->plugin->name.'/headCode.php';
		$this->plugin->bodyCode = WP_CONTENT_DIR.'/'.$this->plugin->name.'/bodyCode.php';
		$this->plugin->footCode = WP_CONTENT_DIR.'/'.$this->plugin->name.'/footCode.php';
		
		$this->plugin->failed 		= false;
		
		//Hooks
		register_activation_hook(__FILE__, array($this, 'activation'));
		register_deactivation_hook(__FILE__, array($this, 'deactivation'));
		
		add_action('admin_enqueue_scripts', array($this, 'adminCSS'));
		add_action('admin_menu', array($this, 'adminMenu'));
		add_action('wp_enqueue_scripts', array($this, 'cssCode'), 9999999999);
		add_action('wp_enqueue_scripts', array($this, 'jsCode'), 9999999999);
		add_action('wp_head', array($this, 'headCode'), 9999999999);
		add_action('the_content', array($this, 'bodyCode'));
		add_action('wp_footer', array($this, 'footCode'), 9999999999);
	}
	
	function activation() {
		update_option($this->plugin->name, $this->plugin->version);
		
		if (!is_dir(WP_CONTENT_DIR.'/'.$this->plugin->name.'/')) {
			//Create plugin dir
			if (mkdir(WP_CONTENT_DIR.'/'.$this->plugin->name, 0775)) {
				$this->copyFiles();
			} else {
				$this->plugin->failed = true;
				$this->showMessage(__('WP Personalize: Creation of the folder "'). 
													 		 WP_CONTENT_DIR.'/'.$this->plugin->name.'/'.
													 __('" failed, please create it.'), true);
			}
		} else {
			$this->copyFiles();
		}
	}

	function deactivation() {
		
	}
	
	function copyFiles() {
		if (!file_exists($this->plugin->cssCode)) {
			if (!copy(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/cssCode.css', $this->plugin->cssCode)) {
				$this->plugin->failed = true;
				$this->showMessage(__('WP Personalize: Copying the file "'). 
													 		 WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/cssCode.css'.
													 __('" failed, please copy it to folder "'). 
													 			WP_CONTENT_DIR.'/'.$this->plugin->name.'/"', true);
			}
		}
		if (!file_exists($this->plugin->jsCode)) {
			if (!copy(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/jsCode.js', $this->plugin->jsCode)) {
				$this->plugin->failed = true;
				$this->showMessage(__('WP Personalize: Copying the file "'). 
													 		 WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/jsCode.js'.
													 __('" failed, please copy it to folder "'). 
													 			WP_CONTENT_DIR.'/'.$this->plugin->name.'/"', true);
			}
		}
		if (!file_exists($this->plugin->headCode)) {
			if (!copy(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/headCode.php', $this->plugin->headCode)) {
				$this->plugin->failed = true;
				$this->showMessage(__('WP Personalize: Copying the file "'). 
													 		 WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/headCode.php'.
													 __('" failed, please copy it to folder "'). 
													 			WP_CONTENT_DIR.'/'.$this->plugin->name.'/"', true);
			}
		}
		if (!file_exists($this->plugin->bodyCode)) {
			if (!copy(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/bodyCode.php', $this->plugin->bodyCode)) {
				$this->plugin->failed = true;
				$this->showMessage(__('WP Personalize: Copying the file "'). 
													 		 WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/bodyCode.php'.
													 __('" failed, please copy it to folder "'). 
													 			WP_CONTENT_DIR.'/'.$this->plugin->name.'/"', true);
			}
		}
		if (!file_exists($this->plugin->footCode)) {
			if (!copy(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/footCode.php', $this->plugin->footCode)) {
				$this->plugin->failed = true;
				$this->showMessage(__('WP Personalize: Copying the file "'). 
													 		 WP_PLUGIN_DIR.'/'.$this->plugin->name.'/files/footCode.php'.
													 __('" failed, please copy it to folder "'). 
													 			WP_CONTENT_DIR.'/'.$this->plugin->name.'/"', true);
			}
		}
	}
	
	function showMessage($message, $errormsg = false) {
		if ($errormsg) {
			echo '<div id="message" class="error">';
		} else {
			echo '<div id="message" class="updated fade">';
		}
		echo "<p><strong>$message</strong></p></div>";
	} 
	
	function adminCSS() {
		wp_register_style($this->plugin->name.'-admin', WP_PLUGIN_URL.'/'.$this->plugin->name.'/css/admin.css');
		wp_enqueue_style($this->plugin->name.'-admin');
	}
    
	function adminMenu() {
		add_menu_page($this->plugin->displayName, 
									$this->plugin->displayName, 
									'manage_options', 
									$this->plugin->name, 
									array(&$this, 'adminPanel'), 
									WP_PLUGIN_URL.'/'.$this->plugin->name.'/images/icons/source_code-16.png');
	}

	function adminPanel() {
		if (!current_user_can('manage_options')) {
        wp_die(_e('You do not have sufficient permissions to access this page.'));
    }
		include_once(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/information.php');  
	}
    
	function cssCode() {
		if (file_exists($this->plugin->cssCode)) {
			wp_register_style($this->plugin->name, WP_CONTENT_URL.'/'.$this->plugin->name.'/cssCode.css');
			wp_enqueue_style($this->plugin->name);
		}
	}
  
  function jsCode() {
		if (file_exists($this->plugin->jsCode)) {
			wp_register_script($this->plugin->name, WP_CONTENT_URL.'/'.$this->plugin->name.'/jsCode.js');
			wp_enqueue_script($this->plugin->name);
		}
	}
	
	function headCode() {
		if (file_exists($this->plugin->headCode)) {
			include_once($this->plugin->headCode);
		}
	}
	
	function bodyCode($content) {
		if (file_exists($this->plugin->bodyCode)) {
			ob_start();
			include_once($this->plugin->bodyCode);
			$content .= ob_get_clean();
		}
		return $content;
	}
	
	function footCode() {
		if (file_exists($this->plugin->footCode)) {
			include_once($this->plugin->footCode);
		}
	}
}

$wpPersonalize = new WPPersonalize();
?>
