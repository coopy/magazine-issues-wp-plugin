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
            'adminPageTitle' => 'Add Magazine Issue',
            'adminMenuTitle' => 'Issues',
            'adminCapability' => 'publish_pages',
            'adminMenuSlug' => 'add_magazine_issue',
            //'adminPageFunction' => array($this, 'renderAdminPage'),
            'adminMenuIconUrl' => null,
            'adminMenuPosition' => 6 // After 'Posts'
        );

        /* Constructor. */
        function MagazineIssues() {
            // nothing here
        }

        /* This is run on plugin activation. */
        function init() {
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

        /* Renders the admin page available via the admin menu item. */
        function renderAdminPage() {
            //
        }
    }
}

if (class_exists('MagazineIssues')) {
    $magazineIssuesPlugin = new MagazineIssues();
}

if (isset($magazineIssuesPlugin)) {
    // Actions
    add_action('activate_magazine-issues/magazine-issues.php', array(&$magazineIssuesPlugin, 'init'));
    add_action( 'admin_menu', array(&$magazineIssuesPlugin, 'addAdminMenuItem'));
}



