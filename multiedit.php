<?php
/*
Plugin Name: Page.ly MultiEdit
Plugin URI: http://blog.page.ly/multiedit-plugin
Description: Multi-Editable Region Support for Page Templates
Version: 0.9c
Author: Joshua Strebel
Author URI: http://page.ly
*/

/*
/--------------------------------------------------------------------\
|                                                                    |  
| License: GPL                                                       |
|                                                                    |
| Page.ly MultiEdit- Adds editable Blocks to page templates in       |
| WordPress                                                          |
| Copyright (C) 2010, Joshua Strebel,                                |
| http://page.ly                                                     |
| All rights reserved.                                               |
|                                                                    |
| This program is free software; you can redistribute it and/or      |
| modify it under the terms of the GNU General Public License        |
| as published by the Free Software Foundation; either version 2     |
| of the License, or (at your option) any later version.             |
|                                                                    |
| This program is distributed in the hope that it will be useful,    |
| but WITHOUT ANY WARRANTY; without even the implied warranty of     |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
| GNU General Public License for more details.                       |
|                                                                    |
| You should have received a copy of the GNU General Public License  |
| along with this program; if not, write to the                      |
| Free Software Foundation, Inc.                                     |
| 51 Franklin Street, Fifth Floor                                    |
| Boston, MA  02110-1301, USA                                        |   
|                                                                    |
\--------------------------------------------------------------------/
*/
define ('PLUGINASSETS',WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'');
function multiedit() {
	add_action ('edit_page_form', 'multieditAdminEditor', 1);
	add_action ('edit_form_advanced', 'multieditAdminEditor', 1);
	add_action ('admin_head', 'testforMultiMeta', 1);

	if (in_array(basename($_SERVER['PHP_SELF']),array('page-new.php','page.php')) ) {
		add_action ('admin_head', 'multieditAdminHeader', 1);
		//add_action ('save_post', 'multieditSavePost');
	}
}

$GLOBALS['multiEditDisplay'] = false;

// api for templates
function multieditDisplay($index) {
	if ($GLOBALS['multiEditDisplay'] === false) {
		$GLOBALS['multiEditDisplay'] = get_post_custom(0);
	}
	$index = "multiedit_$index";	

	if (isset($GLOBALS['multiEditDisplay'][$index])) {
		echo $GLOBALS['multiEditDisplay'][$index][0];
	}

}


function multieditAdminHeader() {
	echo '<link rel="stylesheet" type="text/css" href="' . PLUGINASSETS .'/multiedit.css" />';	
	echo '<script type="text/javascript" src="' .  PLUGINASSETS .'/multiedit.js" ></script>';	
}

function multieditAdminEditor() {
	global $post;
	echo '<div id="multiEditControl"></div>';
	echo '<div id="multiEditHidden"><span class="multieditbutton selected" id="default">Main Content</span>';
	if (isset($_GET['post'])) {
		$meta = has_meta($_GET['post']);

		if (is_array($meta)) {
			foreach($meta as $item) {
				if (preg_match('/^multiedit_(.+)/',$item['meta_key'])) {
					echo "<span class='multieditbutton' id='hs_$item[meta_key]' rel='$item[meta_id]'>$item[meta_key]</span><input type='hidden' id='hs_$item[meta_key]' name='$item[meta_key]' value=\"".htmlspecialchars($item['meta_value']).'" />';
				}
			}
		}
	}
	echo "<div id='multiEditFreezer' style='display:none'>".$post->post_content."</div></div>\n";
}

function testforMultiMeta() {
	global $post;
	if (isset($_GET['post']) && isset($_GET['edit']) && !empty($post->page_template)) {
		$meta = has_meta($post->ID);
		//print_r($meta);

		// get current page template
		$templatefile = locate_template(array($post->page_template));	
		$template_data = implode('', array_slice(file($templatefile), 0, 10));	
		$matches = '';
		//check for multiedit declaration
		if (preg_match( '|MultiEdit:(.*)$|mi', $template_data, $matches)) {
			 $multi = explode(',',_cleanup_header_comment($matches[1]));
			 
			 //	echo $region;
			 
			 foreach($meta as $k=>$v) {
			 	 foreach($multi as $region) {
			 	  	if (in_array('multiedit_'.$region,$v)) {
			 	  		$present[$region] = true;
			 	  	}
			 	 }
			 }
			 
			foreach($multi as $region) {
				if(!isset($present[$region])) {
						update_post_meta($post->ID, 'multiedit_'.$region, '');
	
				}
			}
					 
		}		 
	}
}

multiedit();
