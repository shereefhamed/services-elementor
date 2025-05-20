<?php
class Elementor_Services_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'elevate_services';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Services', 'services-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-carousel';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'elevate-category' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'services', 'url', 'link' ];
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	/* public function get_custom_help_url(): string {
		return 'https://developers.elementor.com/docs/widgets/';
	} */

    public function get_script_depends(): array {
		return [ 'owl-js', 'services-js' ];
	}

	public function get_style_depends(): array {
		return [ 'owl-css', 'services-style' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */

	protected function get_posts_types (){
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
		$output = 'names'; 
		$operator = 'and'; 
		$post_types = get_post_types( $args, $output, $operator );
		$post_type_options = array();
		foreach ( $post_types as $post_type ) {
			$post_type_obj = get_post_type_object( $post_type );
			$post_type_options[ $post_type ] = $post_type_obj->labels->singular_name;
		}
		return $post_type_options;
	}

	protected function register_controls(): void {
		
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__('Title', 'services-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'carousel_title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Title', 'services-elementor' ),
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'services-elementor' ),
			]	
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'post_type_section',
			[
				'label' => esc_html__('Post', 'services-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$post_type_options = $this->get_posts_types();

		$this->add_control(
			'post_type',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Post Type', 'services-elementor' ),
				'options' => $post_type_options,
				'default' => 'no',
			]	
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_setting',
			[
				'label' => esc_html__('Setting', 'services-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slides_count',
			[
				'label'   => esc_html__( 'Slides Per View', 'services-elementor' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min'     => 1,
                'max'     => 6,
                'step'    => 1,
			]
		);

		$this->add_control(
			'slide_autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'services-elementor' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
			]
		);

		$this->add_control(
			'slide_pagination',
			[
				'label'   => esc_html__( 'Pagination', 'services-elementor' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
			],
		);

		$this->end_controls_section();

		

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$post_type = $settings['post_type'] ?? 'elevate-services';
		$autoPlay = $settings['slide_autoplay'] == 'yes' ? 'true' : 'false';
		$pagintation = $settings['slide_pagination'] ==='yes' ? 'true': 'false';
		$slides_count = $settings['slides_count'] ?? 3;
		$title = $settings['carousel_title']?? 'Title';
		$args = array(
            'post_type' => $post_type,
            'post_status'   => 'publish',
        );
        $wp_query = new WP_Query($args);
        if( $wp_query->have_posts() ):
            ?>
				<div class="slider-title">
					<h1><?php esc_html_e($title, 'services-elementor') ?></h1>
				</div>
				<div id="news-slider" class="owl-carousel">
					<?php
					while( $wp_query->have_posts() ):
						$wp_query->the_post();
						?>
							<div class="post-slide">
								<div class="post-img">
									<?php the_post_thumbnail( 'full',array( 'class' =>  'img-fluid' ) ); ?>
									<a href="<?php the_permalink() ?>" class="over-layer"><i class="fa fa-link"></i></a>
								</div>
								<div class="post-content">
									<h3 class="post-title">
										<a href="#"><?php the_title() ?></a>
									</h3>
									<p class="post-description"><?php the_content() ?></p>
									<span class="post-date"><i class="fa fa-clock-o"></i><?php  the_time( 'F j, Y' ); ?></span>
									<a href="<?php the_permalink() ?>" class="read-more">read more</a>
								</div>
							</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<script>
					jQuery(document).ready(function() {
						jQuery("#news-slider").owlCarousel({
							items : <?php echo $slides_count ?>,
							itemsDesktop:[1199,3],
							itemsDesktopSmall:[980,2],
							itemsMobile : [600,1],
							navigation:<?php echo $pagintation ?>,
							navigationText:["",""],
							pagination:<?php echo $pagintation ?>,
							autoPlay:<?php  echo $autoPlay ?>
						});
					});
				</script>
            <?php else: ?>
                <p>There is no posts</p>
            <?php endif;
	}

}