<?php
/*
Plugin Name: Magazine Issues
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Use this plugin to manage and create Magazine Issues.
	It will create a new Issue taxonomy and a new Page for the issue,
	list Posts under that Issue on the Issue page,
	and change the "Current Issue" link to point to this new Page.
Version: 0.0.1
Author: Per Nilsson
Author URI: http://sproutlab.com
License: GPL2
*/

/*  Copyright 2013  Per Nilsson  (email : per@sproutlab.com)

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

if (!class_exists('MagazineIssues')) {
    Class MagazineIssues {

        var $pluginOptions = array(
            'adminPageTitle'    => 'Add Magazine Issue',
            'adminMenuTitle'    => 'Issues',
            'adminCapability'   => 'publish_pages',
            'adminMenuSlug'     => 'add_magazine_issue',
            'adminMenuIconUrl'  => null,
            'adminMenuPosition' => 6, // After 'Posts'

            'taxonomySlug'      => 'issue',
            'taxonomy'          => ''
        );

        /* Constructor. */
        function MagazineIssues() {
            // nothing here
        }

        /* This is run on plugin activation. */
        function activate() {
            // nothing yet
        }

        /* Registers a menu item in the WP admin interface. */
        function addAdminMenuItem() {
            add_menu_page(
                $this->pluginOptions['adminPageTitle'],
                $this->pluginOptions['adminMenuTitle'],
                $this->pluginOptions['adminCapability'],
                $this->pluginOptions['adminMenuSlug'],
                array($this, 'renderAdminPage'),
                $this->pluginOptions['adminMenuIconUrl'],
                $this->pluginOptions['adminMenuPosition']
            );
        }

        /* Registers a custom 'issue' taxonomy. */
        function registerIssueTaxonomy() {
            // $taxonomyLabels = array(
            //     'name' => 'Issues', //_x( 'Issues', 'taxonomy general name' ),
            //     'singular_name' => 'Issue', //_x( 'Issue', 'taxonomy singular name' ),
            //     'search_items' =>  __( 'Search Issues' ),
            //     'popular_items' => __( 'Popular Issues' ),
            //     'all_items' => __( 'All Issues' ),
            //     'parent_item' => null,
            //     'parent_item_colon' => null,
            //     'edit_item' => __( 'Edit Issue' ), 
            //     'update_item' => __( 'Update Issue' ),
            //     'add_new_item' => __( 'Add New Issue' ),
            //     'new_item_name' => __( 'New Issue Name' ),
            //     'separate_items_with_commas' => __( 'Separate issues with commas' ),
            //     'add_or_remove_items' => __( 'Add or remove issues' ),
            //     'choose_from_most_used' => __( 'Choose from the most issues' ),
            //     'menu_name' => __( 'Issues' ),
            // );
            register_taxonomy('issue', 'post', array(
                'hierarchical' => false,
                'label' => 'Issues',
                'labels' => array(
                    'add_new_item' => 'Add New Issue'
                ),
                'show_ui' => true,              // TODO
                'show_admin_column' => true,    // TODO
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,            // TODO
                'rewrite' => array( 'slug' => 'issue' ),
            ));
        }

        /* Renders the admin page available via the admin menu item. */
        function renderAdminPage() {
            if (sizeof($_POST) == 0) {
                // Render the form
                include_once('php/magazine-issues-admin.html.php');
            } else {
                // The user has POSTed the form!
                print_r($_POST);
            }
        }
    }
}

if (class_exists('MagazineIssues')) {
    $magazineIssuesPlugin = new MagazineIssues();
}

if (isset($magazineIssuesPlugin)) {
    // Actions

    // Activation of plugin (once)
    add_action('activate_magazine-issues/magazine-issues.php', array(&$magazineIssuesPlugin, 'activate'));
    // Admin menu item
    add_action('admin_menu', array(&$magazineIssuesPlugin, 'addAdminMenuItem'));
    // On each loop
    add_action('init', array(&$magazineIssuesPlugin, 'registerIssueTaxonomy'));
}



