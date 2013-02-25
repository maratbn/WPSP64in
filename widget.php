<?php
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
     *  Module:         widget.php
     *
     *  Description:    This is the logic for the sidebar widget.
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

    namespace plugin_WPSP64in;

    class EmailWidget extends \WP_Widget {

        private $_arrDefaultSettings = array(
                'front_page_ok' => 'on',
                'all_back_pages_ok' => 'on'
            );

        public function __construct() {
            parent::__construct(
                'plugin_WPSP64in_email_widget',         // Base ID
                'SP@in (SP64in) email',                 // Name
                array(                                  // Args
                    'description' => __(
                        'CAPTCHA-protect email address',
                        'text_domain'))
            );
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            $instance = wp_parse_args(
                                (array)$instance, $this->_arrDefaultSettings);

            ?>
            <p>
              <input
                type='checkbox'
                id='<?=$this->get_field_id('front_page_ok')?>'
                name='<?=$this->get_field_name('front_page_ok')?>'
                <?=checked($instance['front_page_ok'], 'on')?>>
              <label for='<?=$this->get_field_id('front_page_ok')?>'>
                Show on front page
              </label>
            </p>
            <p>
              <input
                type='checkbox'
                id='<?=$this->get_field_id('all_back_pages_ok')?>'
                name='<?=$this->get_field_name('all_back_pages_ok')?>'
                <?=checked($instance['all_back_pages_ok'], 'on')?>>
              <label for='<?=$this->get_field_id('all_back_pages_ok')?>'>
                Show on all back pages
              </label>
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();

            $instance['front_page_ok'] = strip_tags(
                                              $new_instance['front_page_ok']);
            $instance['all_back_pages_ok'] = strip_tags(
                                          $new_instance['all_back_pages_ok']);

            return $instance;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {
            $instance = wp_parse_args(
                                (array)$instance, $this->_arrDefaultSettings);

            echo $args['before_widget'];

            if (is_front_page() && $instance['front_page_ok'] == 'on') {
                sp64inInjectTag();
            }

            if (!is_front_page() && $instance['all_back_pages_ok'] == 'on') {
                sp64inInjectTag();
            }

            echo $args['after_widget'];
        }
    } // class EmailWidget
?>
