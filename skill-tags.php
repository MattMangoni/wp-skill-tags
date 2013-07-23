<?php
/*
	Plugin Name: Skill Tags
	Description: Dynamic custom skill tags plugin to easily let everyone know what you can do.
	Author: @MattMangoni87
	Author URI: http://mattmangoni.net
	Version: 0.1

	License: GPL2

	Copyright 2013  Matteo Mangoni  (email : matt.mangoni@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

*/

if (!class_exists('Matt_Skill_Tags_Plugin')) 
{
	class Matt_Skill_Tags_Plugin
	{
		public function __construct()
		{
			add_action('admin_init', array(&$this, 'admin_init')); 
			add_action('admin_menu', array(&$this, 'add_menu'));
			add_action('wp_enqueue_scripts', array(&$this, 'add_stylesheets'));
			add_shortcode('skill-tags', array(&$this, 'show_skill_tags'));
		}

		public function admin_init()
		{
			$this->init_settings();
		}

		public function init_settings()
		{
			register_setting('matt_skill_tags_plugin-group', 'skill-fields');
			
			$tags = $this->get_tags();
			
			foreach($tags as $tag)
			{
				$the_tag = $tag."-tags";
				register_setting('matt_skill_tags_plugin-group', $the_tag);
			}
		}

		public function get_tags()
		{
			$tags = explode(',', get_option('skill-fields'));
			return $tags;
		}

		// ADD THE OPTIONS PAGE TO THE WP DASHBOARD
		public function add_menu()
		{
			add_options_page('Skill Tags', 'Manage Skill Tags', 'manage_options', 'matt-skill-tags', array($this, 'settings_page'));
		}

		// DISPLAYS THE ACTUAL OPTIONs PAGE
		public function settings_page()
		{
			if(!current_user_can('manage_options')) 
			{ 
				wp_die(__('You do not have sufficient permissions to access this page.')); 
			}

			include(sprintf("%s/settings.php", dirname(__FILE__)));
		}

		public function show_skill_tags($atts)
		{

			extract( shortcode_atts( array('tag' => ''), $atts ) );

			$tag_name = $tag."-tags";

			if ($tag != '')
			{
				$skill_tags = explode(",", get_option($tag_name));

				$text = '';

				foreach ($skill_tags as $t)
				{
					$text .= '<span class="tags">'.$t.'</span>';
				}

				return $text;
			}
			else
			{
				return "Nessun tag presente";
			}
		}

		public function add_stylesheets()
		{
	        wp_register_style( 'skill_tags', plugins_url('skill-tags.css', __FILE__) );
	        wp_enqueue_style( 'skill_tags' );
		}

		// THIS WILL RUN WHEN THE PLUGIN IS ACTIVATED
		public static function activate()
		{
			//
		}

		// THIS WILL RUN WHEN THE PLUGIN IS DEACTIVATED
		public static function deactivate()
		{
			//
		}
	}
}

if (class_exists('Matt_Skill_Tags_Plugin'))
{
	register_activation_hook(__FILE__, array('Matt_Skill_Tags_Plugin', 'activate')); 
	register_deactivation_hook(__FILE__, array('Matt_Skill_Tags_Plugin', 'deactivate')); 

	$matt_skill_tags_plugin = new Matt_Skill_Tags_Plugin();
}