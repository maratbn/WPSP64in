<?php
    /*
    Plugin Name: WPSP@in (WPSP64in)
    Plugin URI: http://www.maratbn.com/projects/sp64in
    Description: WordPress plugin for SP@in (SP64in) website component for CAPTCHA-protecting email addresses from email-address-harvesting web crawlers
    Author: Marat Nepomnyashy
    Author URI: http://www.maratbn.com
    License: GPL3
    Version: 0.0.1.next
    */

    /**
     *  WPSP@in (WPSP64in) -- WordPress plugin for SP@in (SP64in) website component
     *                        for CAPTCHA-protecting email addresses from email-
     *                        address-harvesting web crawlers
     *
     *  Version: 0.0.1.next
     *
     *  Copyright (C) 2013  Marat Nepomnyashy  http://maratbn.com  maratbn@gmail
     *
     *  http://maratbn.com/projects/sp64in
     *
     *  Module:         WPSP64in.php
     *
     *  Description:    Main PHP file for the WordPress plugin 'WPSP64in'.
     *
     *  Licensed under the GNU General Public License Version 3.
     *
     *  This file is part of WPSP@in (WPSP64in).
     *
     *  WPSP@in (WPSP64in) is free software: you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation, either version 3 of the License, or
     *  (at your option) any later version.
     *
     *  WPSP@in (WPSP64in) is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  You should have received a copy of the GNU General Public License
     *  along with WPSP@in (WPSP64in).  If not, see <http://www.gnu.org/licenses/>.
     */

    require_once 'widget.php';
    require_once 'SP64in/sp@in.php';

    add_action('init', 'plugin_WPSP64in_action_init');
    add_action('widgets_init', 'plugin_WPSP64in_action_widgets_init');
    add_action('wp_enqueue_scripts',
                                 'plugin_WPSP64in_action_wp_enqueue_scripts');

    add_shortcode('wpsp64in', 'plugin_WPSP64in_shortcode_wpsp64in');

    function plugin_WPSP64in_action_init() {
        sp64inInit();
    }

    function plugin_WPSP64in_action_widgets_init() {
        register_widget('plugin_WPSP64in\EmailWidget');
    }

    function plugin_WPSP64in_action_wp_enqueue_scripts() {
        $strURLToSP64in = plugins_url('/WPSP64in/SP64in');

        wp_enqueue_style(
            'plugin_WPSP64in_jquery.qtip',
            $strURLToSP64in .
                '/toolkits/jquery/jquery.qtip-nightly.custom/nightly-365741/jquery.qtip.css',
            null,
            null);

        wp_enqueue_script(
            'plugin_WPSP64in_jquery.qtip',
            $strURLToSP64in .
                '/toolkits/jquery/jquery.qtip-nightly.custom/nightly-365741/jquery.qtip.js',
            array('jquery'),
            null,
            true);
        wp_enqueue_script(
            'plugin_WPSP64in_sp@in',
            $strURLToSP64in . '/sp@in.js',
            array('jquery', 'plugin_WPSP64in_jquery.qtip'),
            null,
            true);
    }

    function plugin_WPSP64in_shortcode_wpsp64in($arrAttrs, $strContent=null) {
        $strEmail = $arrAttrs['email'];
        if (!strlen($strEmail)) return;

        ob_start();
        sp64inInjectTagForNonConfigEmail($strEmail,
                                             array('caption' => $strContent));
        return ob_get_clean();
    }
?>