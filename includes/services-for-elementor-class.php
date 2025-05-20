<?php
if(!class_exists('ServicesForElementor')){
    class ServicesForElementor{
        public function __construct() {
            require_once(SERVICES_FOR_ELEMENTOR_PATH. 'includes/services-post-type-class.php');
            $services = new ServicesPostType();
            add_action( 'wp_enqueue_scripts', array($this, 'elementor_services_widgets_dependencies') );
            add_action( 'elementor/elements/categories_registered', array($this, 'add_elementor_widget_categories') );
            add_action( 'elementor/widgets/register', array($this, 'register_services_widget') );
            //add_action( 'wp_ajax_get_elementor_widget_posts', array($this, 'get_elementor_widget_posts') );
            //add_action( 'elementor/editor/after_enqueue_scripts', array($this, 'enqueue_owl_to_elementor'), 1000);
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
            //wp_register_script( 'services-js', SERVICES_FOR_ELEMENTOR_URL . 'assets/js/services-script.js',['owl-js'] );

            /* Styles */
            wp_register_style( 'owl-css', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css');
            wp_register_style( 'services-style', SERVICES_FOR_ELEMENTOR_URL . 'assets/css/services-style.css');
        }

        /* public function enqueue_owl_to_elementor(){
            
           
            wp_enqueue_style(
                'owl-carousel-css',
                'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css'
            );

            wp_enqueue_script(
                'owl-carousel-js',
                'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js',
                [ 'jquery' ], // jQuery must be a dependency
                null,
                true
            );

            // Load your custom preview script after owl-carousel
            wp_enqueue_script(
                'custom-widget-preview',
                SERVICES_FOR_ELEMENTOR_URL . 'assets/js/widget-preview.js',
                [ 'jquery', 'owl-carousel-js' ], // depends on owl-carousel-js
                null,
                true
            );
        } */

        /* public function get_elementor_widget_posts() {
            if ( ! current_user_can( 'edit_posts' ) ) {
                wp_send_json_error( 'Unauthorized', 403 );
            }

            $post_type = sanitize_text_field( $_POST['post_type'] ?? '' );
            if ( empty( $post_type ) ) {
                wp_send_json_error( 'Missing post type', 400 );
            }

            $query = new WP_Query( [
                'post_type' => $post_type,
                'post_status' => 'publish',
            ] );

            $data = [];

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $data[] = [
                        'title' => get_the_title(),
                        'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
                        'link' => get_permalink(),
                    ];
                }
                wp_reset_postdata();
            }

            wp_send_json_success( $data );
        } */

    }
}

