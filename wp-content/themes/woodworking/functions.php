<?php    
 
//code for theme styling
function add_style() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );//wp_enque_style->hook;
   
    // wp_enqueue_style( 'slider', get_template_directory_uri() . '/css/slider.css', array(), '1.1', 'all');
   
    // wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array ( 'jquery' ), 1.1, true);
   
    //   if ( is_singular() & comments_open() & get_option( 'thread_comments' ) ) {
    //     wp_enqueue_script( 'comment-reply' );
    //   }
  }

   //code for custom Menus
  add_action( 'wp_enqueue_scripts', 'add_style' );
  function menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu' ),
       
      )
    );
  }
  add_action( 'init', 'menus' );


// code for theme 

  function wooworking_theme_support() {
	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

}

// code for custom Sidebar

  function woodworking() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer-1', 'woodworking' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'woodworking' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
    );
    
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer-2', 'woodworking' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'woodworking' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
// code for custom post type name PORTFOLIO

add_action( 'widgets_init', 'woodworking' );

function custom_post_type() {
 
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Portfolio', 'Post Type General Name', 'twentytwenty' ),
			'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'twentytwenty' ),
			'menu_name'           => __( 'Portfolio', 'twentytwenty' ),
			'parent_item_colon'   => __( 'Parent Portfolio', 'twentytwenty' ),
			'all_items'           => __( 'All Portfolio', 'twentytwenty' ),
			'view_item'           => __( 'View Portfolio', 'twentytwenty' ),
			'add_new_item'        => __( 'Add New Portfolio', 'twentytwenty' ),
			'add_new'             => __( 'Add New', 'twentytwenty' ),
			'edit_item'           => __( 'Edit Portfolio', 'twentytwenty' ),
			'update_item'         => __( 'Update Portfolio', 'twentytwenty' ),
			'search_items'        => __( 'Search Portfolio', 'twentytwenty' ),
			'not_found'           => __( 'Not Found', 'twentytwenty' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
		);
		 
	// Set other options for Custom Post Type
		 
		$args = array(
			'label'               => __( 'Portfolio', 'twentytwenty' ), 
			'description'         => __( 'Portfolio news and reviews', 'twentytwenty' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
			'taxonomies'          => array( 'genres' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
	 
		);
		 
		// Registering your Custom Post Type
		register_post_type( 'Portfolio', $args );
	 
	}
	 
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	 
	add_action( 'init', 'custom_post_type', 0 );



// code for custom Widgets //Monday
	class wpb_widget extends WP_Widget {
  
		function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'wpb_widget', 
		  
		// Widget name will appear in UI
		__('WooCommerce Widget', 'wpb_widget_domain'), 
		  
		// Widget description
		array( 'description' => __( 'WooCommerce Widgets', 'wpb_widget_domain' ), ) 
		);
		}
		  
		// Creating widget front-end
		  
		public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		  
		// This is where you run the code and display the output
	
		global $pages;
		add_image_size('realty_widget_size', 85, 45, false);
		$ports = new WP_Query();
		$ports->query('post_type=portfolio');
		if ($ports->found_posts > 0) {
		echo '<ul class="realty_widget">';
		while ($ports->have_posts()) {
			$ports->the_post();
		
		     $Item = "<br>";
			$Item .= '<a href="' . get_permalink() . '">';
			$Item .= get_the_title() . '</a>';
			//$Item .= '<br><span style="color:red">Added ' . get_the_date() . '</span></li>';
			echo $Item;
		}
		echo '</ul>';
		wp_reset_postdata();
		} else {
		echo '<p style="padding:25px;">No listing found</p>';
		}


		
		echo $args['after_widget'];
		}
				  
		// Widget Backend 
		public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title', 'wpb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
		}
			  
		// Updating widget replacing old instances with new
		public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
		}
		 
		// Class wpb_widget ends here
		} 
		 
		 
		// Register and load the widget
		function wpb_load_widget() {
			register_widget( 'wpb_widget' );
		}
		add_action( 'widgets_init', 'wpb_load_widget' );



// code for custom taxonomy//Monday

		function wporg_register_taxonomy_Portfolio() {
			$labels = array(
				'name'              => _x( 'Portfolio Category', 'taxonomy general name' ),
				'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Portfolio' ),
				'all_items'         => __( 'All Portfolio' ),
				'parent_item'       => __( 'Parent Portfolio' ),
				'parent_item_colon' => __( 'Parent Portfolio:' ),
				'edit_item'         => __( 'Edit Portfolio' ),
				'update_item'       => __( 'Update Portfolio' ),
				'add_new_item'      => __( 'Add New Portfolio' ),
				'new_item_name'     => __( 'New Portfolio Name' ),
				'menu_name'         => __( 'Taxo_Portfolio' ),
			);
			$args   = array(
				'hierarchical'      => true, // make it hierarchical (like categories)
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => [ 'slug' => 'portfolio' ],
			);
			register_taxonomy( 'portfolio', [ 'portfolio' ], $args );
	   }
	   add_action( 'init', 'wporg_register_taxonomy_Portfolio' );




		
?>