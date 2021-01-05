<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooboiler
 * @subpackage Wooboiler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wooboiler
 * @subpackage Wooboiler/admin
 * @author     cedcoss <cedcoss@gmail.com>
 */
class Wooboiler_Admin {

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
		 * defined in Wooboiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wooboiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wooboiler-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wooboiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wooboiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wooboiler-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name,'arr_ajax',array('ajax_url' =>admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('siddi')));
	}


public function addBoilermenu()
{    add_menu_page("Boiler", "Boiler", 'manage_options', "example-top-options", array($this,'boilermenu'));
	// add_submenu_page("example-top-options", "BoilerAdmin", "BoilerAdmin",'manage_options', "example-option-2", "option2");
}
function boilermenu()
{
  echo "hello boiler";
}

	public function brand_custom_box() {
	  $screens = [ 'post', 'wporg_cpt' ];

	  foreach ( $screens as $screen ) {
//print_r($screen);

		  add_meta_box(
			  'wporg_id',                 // Unique ID
			  'Brand Meta Box',      // Box title
			  array($this,'box_html'),  // Content callback, must be of type callable// becoz it is class that's why we call self class
			  $screen,
			  'advanced
			  ',
			  'high'                            // Post type
		  );
	  }
  }
  
  //Html for metabox
  public function box_html( $post ) {
	?>
	<label for="wporg_field"></label>
	<input type="text" id="brandnameid" name="brandname" placeholder="Enter the Brand"/>
	<label for="wporg_field"></label>
	<input type="button" id ="brandmetaid" name="Submit" value="Submit"/>
	<input type ="hidden"  id="metaid" value="<?php echo get_the_ID();?>"/>
   
	<?php
  }
  
  public function brand_save( int $post_id ) {
  
	if ( array_key_exists( 'brandname', $_POST ) ) {     
		update_post_meta(
			$post_id,
			'siddu_siddu',
			$_POST['brandname']
		);
		//add_action( 'admin_notices', 'sample_admin_notice__success' );
	}
}

function add_new_columns($columns){

    $column_meta = array( 'brand' => 'Brand' );
    $columns = array_slice( $columns, 0, 6, true ) + $column_meta + array_slice( $columns, 6, NULL, true );
    return $columns;

}

// Register the columns as sortable
function register_sortable_columns( $columns ) {
    $columns['brand'] = 'brand';
    return $columns;
}

//Add filter to the request to make the brand sorting process numeric, not string
function brand_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'brand' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'siddu_siddu',
            'orderby' => 'meta_value_num'
        ) );
    }

    return $vars;
}

/**
* Display data in new columns
*
* @param  $column Current column
*
* @return Data for the column
*/
function custom_columns($column) {

    global $post;

    switch ( $column ) {
        case 'brand':
			$brand = get_post_meta( $post->ID, 'siddu_siddu', true );
			if($brand==""){
				$brand="__";
			}
			echo $brand;
			
			
		break;
			
    }
}
function add_meta()
{
	//check_ajax_referer('siddi');
	$metaname= $_POST['name'];
	$result=$_POST['id'];
	update_post_meta(
		$result,
		'siddu_siddu',
		$metaname
	);

	echo "updated";
	


	

}







}


