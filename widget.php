<?php
    namespace plugin_WPSP64in;

    class EmailWidget extends \WP_Widget {

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
            ?>
            <p>
              <input
                type='checkbox'
                id='<?=$this->get_field_id('front_page_only')?>'
                name='<?=$this->get_field_name('front_page_only')?>'
                <?=checked($instance['front_page_only'], true )?>>
              <label for='<?=$this->get_field_id('front_page_only')?>'>
                Display on front page only
              </label>
            </p>
            <?php
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
            echo $args['before_widget'];
            sp64inInjectTag();
            echo $args['after_widget'];
        }
    } // class EmailWidget
?>
