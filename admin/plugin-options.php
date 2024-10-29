<?php

/**
 * Option page for this plugin
 */
if ( !class_exists('AZASBWP_Settings' ) ):
class AZASBWP_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new AZASBWP_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu'), 100 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 'options-general.php', esc_html__('AZ Scrollbar Settings', 'azasbwp'), esc_html__('AZ Scrollbar Settings', 'azasbwp'), 'manage_options', 'azasbwp_options', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'azasbwp_settings',
                'title' => esc_html__( 'AZ Scrollbar Settings', 'azasbwp' )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {

        $settings_fields = array(
            'azasbwp_settings' => array(

                array(
                    'name'              => 'bar_status',
                    'label'             => esc_html__( 'Enable Custom Scrollbar', 'azasbwp' ),
                    'type'              => 'checkbox',
                    'default'           => 'on',
                    'class' => 'azasbwp',
                ),

                array(
                    'name'              => 'bar_color',
                    'label'             => esc_html__( 'Bar Color', 'azasbwp' ),
                    'type'              => 'color',
                    'default'           => '#0099ff',
                    'class' => 'azasbwp',
                ),

                array(
                    'name'              => 'bar_bg_color',
                    'label'             => esc_html__( 'Rails Background Color', 'azasbwp' ),
                    'type'              => 'color',
                    'default'           => '',
                    'class' => 'azasbwp',
                ),

                array(
                    'name'  => 'bar_width',
                    'label' => esc_html__( 'Bar Width', 'azasbwp' ),
                    'desc'  => esc_html__( 'Example: 12px', 'azasbwp' ),
                    'type'  => 'text',
                ),

                array(
                    'name'    => 'bar_border_radius',
                    'label'   => esc_html__( 'Bar Border Radius', 'azasbwp' ),
                    'desc'    => esc_html__( 'Example: 5px', 'azasbwp' ),
                    'type'    => 'text',
                ),

                array(
                    'name'    => 'bar_border_style',
                    'label'   => esc_html__( 'Bar Border Style', 'azasbwp' ),
                    'desc'    => esc_html__( 'Scrollbar border style here. Example: 2px solid #000 or 1px solid red.', 'azasbwp' ),
                    'type'    => 'text',
                ),

                array(
                    'name'    => 'bar_scroll_speed',
                    'label'   => esc_html__( 'Bar Scroll Speed', 'azasbwp' ),
                    'desc'    => esc_html__( 'Write scrollbar speed here. Example: 50. Less vlaue increase speed & grater value decrease speed.', 'azasbwp' ),
                    'type'    => 'text',
                ),

                array(
                    'name'    => 'bar_enable_auto_hide',
                    'label'   => esc_html__( 'Bar Auto Hide', 'azasbwp' ),
                    'type'    => 'radio',
                    'options' => array(
                        'yes'   => esc_html__( 'Yes', 'azasbwp' ),
                        ''      => esc_html__( 'No', 'azasbwp' )
                    ),
                    'default'   => 'yes'
                ),
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

new AZASBWP_Settings();

/**
 * Get plugin option value
 */
function azasbwp_get_option($opt_name = '', $section, $default = ''){
    if($section && $opt_name){
        $options = get_option( $section );
        if ( isset( $options[$opt_name] ) ) {
            return $options[$opt_name];
        } else {
            return $default;
        }
    } else {
        return $default;
    }
}