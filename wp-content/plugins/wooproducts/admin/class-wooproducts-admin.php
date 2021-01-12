<?php


/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooproducts
 * @subpackage Wooproducts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wooproducts
 * @subpackage Wooproducts/admin
 * @author     Cedcoss <cedcoss@gmail.com>
 */
class Wooproducts_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wooproducts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wooproducts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wooproducts-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wooproducts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wooproducts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wooproducts-admin.js', array( 'jquery' ), $this->version, false );
		


	}        
        /**
         * activate_myplugin
		 * @since 1.0
		 * @version 1.0.0
         *function for creating custom post type while activating plugin
         * @return void
         */
        function activate_myplugin() {


                $args=array(
            'label' => 'Products',
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array(
                'slug' => 'mycustomposttype',
                'with_front' => false
                ),
            'query_var' => true,
            'supports' => array(
                'title',
                'editor',              
                'revisions',
                'thumbnail',                
                )
            ); 
                register_post_type( 'customposttype', $args );

        }
        
        /**
         * activate_wooproducts
		 *function for activating plugin 
		 *@since 1.0
		 *@version 1.0.0
         * @return void
         */
        function activate_wooproducts() {
                activate_myplugin();
                flush_rewrite_rules();
        }        
        /**
         * my_plugin_uninstall
		 *function for removing post type while deactivating plugin
		 *since 1.0
		 *version 1.0.0
         * @return void
         */
        function my_plugin_uninstall() {
             unregister_post_type( 'customposttype' );
		}

/**
     *custom_meta_box inventry
     *function for creating custom meta box inventry
     *@since 1.0.0
     *version 1.0
     * @return void
     */
    public function inventry_custom_box()
    {    
		
            add_meta_box(
                'inventry_meta', // Unique ID
                'Inventry Meta Box', // Box title
				[$this, 'inventry_box_html'], // Content callback, must be of type callable// becoz it is class that's why we call self class
				'customposttype',
				'side'
			);        
    }		
    //Html for metabox
    /**
     * box_html
     *function for meta box html
     *@since 1.0.0
     *version 1.0
     * @param  mixed $post
     * @return void
     */
    public function inventry_box_html($post)
    {
		$post_id = get_the_ID();
		$result = get_post_meta($post_id, 'inventry_meta', 1);

	
        ?>
	<label for="wporg_field"></label>
	<input type="number" id="inventryid" max="" min="0" name="inventry" value="<?php echo $result ;?>" />
	<?php
	}
	
/**
     * brand_save
     *function for saving meta box values
     * @param  mixed $post_id
     * @since 1.0.0
     * @version 1.0
     * @return void
     */
    public function inventry_save(int $post_id)
    {		
        if (array_key_exists('inventry', $_POST)) {
			update_post_meta($post_id, 'inventry_meta', $_POST['inventry']);	  
        }
	}
	
	/**
     * pricing_custom_box
     *function for creating custom meta box pricing
     *@since 1.0.0
     *version 1.0
     * @return void
     */
    public function pricing_custom_box()
    {			
            add_meta_box(
                'price_meta', // Unique ID
                'Pricing Meta Box', // Box title
				[$this, 'pricing_box_html'], // Content callback, must be of type callable// becoz it is class that's why we call self class
				'customposttype',
                'side'   
            );
        
    }
	   
		
    //Html for metabox
    /**
     * box_html
     *function for meta box html
     *@since 1.0.0
     *version 1.0
     * @param  mixed $post
     * @return void
     */
    public function pricing_box_html($post)
     {
	$id = get_the_ID();
	$res = get_post_meta($id, 'price_meta', 1);
        ?>
	<label for="wporg_field">Discounted Price</label>
	<input type="number" id="discounted" max="" min="1" name="discount" value="<?php echo $res['discount_price']; ?>"  />
	<label for="wporg_field">Regular Price</label>
	<input type="number" id="regular" max="" min="1" name="regular" value="<?php echo $res['regular_price'] ;?>"  required  />
	<label for="wporg_field"></label>	
	<input type="hidden" id="metaid" value="" />

	<?php
	}
	
/**
     * brand_save
     *function for saving meta box values
     * @param  mixed $post_id
     * @since 1.0.0
     * @version 1.0
     * @return void
     */
    public function pricing_save(int $post_id)
    {
		
        if (array_key_exists('regular', $_POST)) {
			$result = array('regular_price'=>$_POST['regular'], 'discount_price'=>$_POST['discount']);
            update_post_meta($post_id, 'price_meta', $result);
           
		}
		
	}
	
	/**
	 * register_taxonomy_Products
	 * function to register taxonomy products
	 * @version 1.0.0
	 * @since 1.0
	 *
	 * @return void
	 */
	function register_taxonomy_Products() {
		$labels = array(
			'name'              => _x( 'products Category', 'taxonomy general name' ),
			'singular_name'     => _x( 'products Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search products' ),
			
		);
		$args   = array(
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'products' ],
		);
		register_taxonomy( 'customposttype', [ 'customposttype' ], $args );

   }
  

   



}
