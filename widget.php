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

        private $_arrDefaultSettings;
        private $_strTD = 'plugin_WPSP64in';

        public function __construct() {
            parent::__construct(
                'plugin_WPSP64in_email_widget',         // Base ID
                'SP@in (SP64in) email',                 // Name
                array(                                  // Args
                    'description' => __(
                        'CAPTCHA-protect email address',
                        $this->_strTD))
            );

            $this->_arrDefaultSettings = array(
                    'front_page_ok' => 'on',
                    'all_back_pages_ok' => 'on',
                    'text_alignment' => 'default',
                    'enclose_in_address_tag' => 'on',
                    'css_class' => '',
                    'css_style' => '',
                    'email_address' => 'webmaster@example.com',
                    'caption' => __('Send Email', $this->_strTD)
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
                <?=__('Show on the front page', $this->_strTD)?>
              </label>
            </p>
            <p>
              <input
                type='checkbox'
                id='<?=$this->get_field_id('all_back_pages_ok')?>'
                name='<?=$this->get_field_name('all_back_pages_ok')?>'
                <?=checked($instance['all_back_pages_ok'], 'on')?>>
              <label for='<?=$this->get_field_id('all_back_pages_ok')?>'>
                <?=__('Show on all back pages', $this->_strTD)?>
              </label>
            </p>
            <p>
              <label for='<?=$this->get_field_id('text_alignment')?>'>
                <?=__('Text alignment:', $this->_strTD)?>
              </label>
              <select
                id='<?=$this->get_field_id('text_alignment')?>'
                name='<?=$this->get_field_name('text_alignment')?>'>
                <option <?=selected($instance['text_alignment'], 'default')?>>
                  <?=__('default', $this->_strTD)?>
                </option>
                <option <?=selected($instance['text_alignment'], 'left')?>>
                  <?=__('left', $this->_strTD)?>
                </option>
                <option <?=selected($instance['text_alignment'], 'center')?>>
                  <?=__('center', $this->_strTD)?>
                </option>
                <option <?=selected($instance['text_alignment'], 'right')?>>
                  <?=__('right', $this->_strTD)?>
                </option>
              </select>
            </p>
            <p>
              <input
                type='checkbox'
                id='<?=$this->get_field_id('enclose_in_address_tag')?>'
                name='<?=$this->get_field_name('enclose_in_address_tag')?>'
                <?=checked($instance['enclose_in_address_tag'], 'on')?>>
              <label for='<?=$this->get_field_id('enclose_in_address_tag')?>'>
                <?=__('Enclose in &lt;address&gt; tag', $this->_strTD)?>
              </label>
            </p>
            <p>
              <label for='<?=$this->get_field_id('css_class')?>'>
                <?=__('CSS class:', $this->_strTD)?>
              </label>
              <input
                type='text'
                id='<?=$this->get_field_id('css_class')?>'
                name='<?=$this->get_field_name('css_class')?>'
                value='<?=$instance['css_class']?>'>
            </p>
            <p>
              <label for='<?=$this->get_field_id('css_style')?>'>
                <?=__('CSS style:', $this->_strTD)?>
              </label>
              <input
                type='text'
                id='<?=$this->get_field_id('css_style')?>'
                name='<?=$this->get_field_name('css_style')?>'
                value='<?=$instance['css_style']?>'>
            </p>
            <p>
              <label for='<?=$this->get_field_id('email_address')?>'>
                <?=__('Email address:', $this->_strTD)?>
              </label>
              <input
                type='text'
                id='<?=$this->get_field_id('email_address')?>'
                name='<?=$this->get_field_name('email_address')?>'
                value='<?=$instance['email_address']?>'>
            </p>
            <p>
              <label for='<?=$this->get_field_id('caption')?>'>
                <?=__('Caption:', $this->_strTD)?>
              </label>
              <input
                type='text'
                id='<?=$this->get_field_id('caption')?>'
                name='<?=$this->get_field_name('caption')?>'
                value='<?=$instance['caption']?>'>
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
            $instance['text_alignment'] = strip_tags(
                                             $new_instance['text_alignment']);
            $instance['enclose_in_address_tag'] = strip_tags(
                                     $new_instance['enclose_in_address_tag']);
            $instance['css_class'] = strip_tags($new_instance['css_class']);
            $instance['css_style'] = strip_tags($new_instance['css_style']);
            $instance['email_address'] = strip_tags(
                                              $new_instance['email_address']);
            $instance['caption'] = strip_tags($new_instance['caption']);

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

            echo '<span';
            switch ($instance['text_alignment']) {
                case 'left':
                case 'center':
                case 'right':
                    echo ' style=\'text-align:' .
                                           $instance['text_alignment'] . '\'';
            }
            echo '>';

            if ($instance['enclose_in_address_tag'] == 'on') {
                echo '<address>';
            }

            if ((is_front_page() && $instance['front_page_ok'] == 'on') ||
                (!is_front_page() && $instance['all_back_pages_ok'] == 'on'))
                {
                sp64inInjectTagForNonConfigEmail(
                    $instance['email_address'],
                    array(
                        'caption' => $instance['caption'],
                        'class' => $instance['css_class'],
                        'style' => $instance['css_style']));
            }

            if ($instance['enclose_in_address_tag'] == 'on') {
                echo '</address>';
            }

            echo '</span>';

            echo $args['after_widget'];
        }
    } // class EmailWidget
?>
