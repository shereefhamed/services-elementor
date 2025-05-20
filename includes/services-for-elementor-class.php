<?php
if(!class_exists('ServicesForElementor')){
    class ServicesForElementor{
        public function __construct() {
            require_once(SERVICES_FOR_ELEMENTOR_PATH. 'includes/services-post-type-class.php');
            $services = new ServicesPostType();
            add_action( 'wp_enqueue_scripts', array($this, 'elementor_services_widgets_dependencies') );
            add_action( 'elementor/elements/categories_registered', array($this, 'add_elementor_widget_categories') );
            add_action( 'elementor/widgets/register', array($this, 'register_services_widget') );
   
        }

        static public function activate(){
             update_option('rewrite_rules','');
        }

        static public function deactivate(){
            flush_rewrite_rules();
            unregister_post_type('elevate-services');
        }

        static public function uninstall(){
            $posts = get_posts(
                array(
                    'post_type' =>  'elevate-services',
                    'numnumberposts'    =>  -1,
                    'status'    =>  'any',
                )
            );
            foreach( $posts as $post ){
                wp_delete_post(
                    $post->ID,
                    true,
                );
            }
        }

        public function add_elementor_widget_categories($elements_manager){
            $elements_manager->add_category(
                'elevate-category',
                [
                    'title' => esc_html__( 'Elevate', 'services-elementor' ),
                    'icon' => 'fa fa-plug',
                ]
            );
        }

        public function register_services_widget($widgets_manager){
            require_once( SERVICES_FOR_ELEMENTOR_PATH . 'widgets/services-widget.php' );
            $elementorServices = new Elementor_Services_Widget();
	        $widgets_manager->register( $elementorServices );
        }

        public function elementor_services_widgets_dependencies(){
            /* Scripts */
            wp_register_script( 'owl-js', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js',  );
  

            /* Styles */
            wp_register_style( 'owl-css', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css');
            wp_register_style( 'services-style', SERVICES_FOR_ELEMENTOR_URL . 'assets/css/services-style.css');
        }

        

    }
}

