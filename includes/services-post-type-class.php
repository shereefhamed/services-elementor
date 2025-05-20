<?php
if(!class_exists('ServicesPostType')){
    class ServicesPostType{
        public function __construct() {
            add_action('init', array($this, 'createServicesPostType'));
        }

        public function createServicesPostType(){
            $labels = array(
                'name'                  => _x( 'Services', 'Post type general name', 'services-elementor' ),
                'singular_name'         => _x( 'Service', 'Post type singular name', 'services-elementor' ),
                'menu_name'             => _x( 'Services', 'Admin Menu text', 'services-elementor' ),
                'name_admin_bar'        => _x( 'Service', 'Add New on Toolbar', 'services-elementor' ),
                'add_new'               => __( 'Add New', 'textdomain' ),
                'add_new_item'          => __( 'Add New Service', 'textdomain' ),
                'new_item'              => __( 'New Service', 'textdomain' ),
                'edit_item'             => __( 'Edit Service', 'textdomain' ),
                'view_item'             => __( 'View Service', 'textdomain' ),
                'all_items'             => __( 'All Service', 'textdomain' ),
                'search_items'          => __( 'Search Services', 'textdomain' ),
                'parent_item_colon'     => __( 'Parent Service:', 'textdomain' ),
                'not_found'             => __( 'No Service found.', 'textdomain' ),
                'not_found_in_trash'    => __( 'No Services found in Trash.', 'textdomain' ),
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
            );
            register_post_type(
                'elevate-services',
                $args,
            );
        }
    }
}