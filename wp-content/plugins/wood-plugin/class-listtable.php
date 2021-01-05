<?php
//die("hiii");


if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Users_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

    }


/**
 * Retrieve customer’s data from the database
 *
 * @param int $per_page
 * @param int $page_number
 *
 * @return mixed
 */
public static function get_users( $per_page = 5, $page_number = 1 ) {

    global $wpdb;
  
    $sql = "SELECT * FROM wp_custom_plugin";
  
    if ( ! empty( $_REQUEST['orderby'] ) ) {
      $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
      $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
    }
  
    $sql .= " LIMIT $per_page";
  
    $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
  
  
    $result = $wpdb->get_results( $sql, 'ARRAY_A' );
    //print_r($result);
  
    return $result;
  }

  /**
 * Delete a customer record.
 *
 * @param int $id customer ID
 */
public static function delete_users( $id ) {
  global $wpdb;

  $wpdb->delete(
    "wp_custom_plugin",
    [ 'id' => $id ],
    [ '%d' ]
  );
}

            /**
         * Returns the count of records in the database.
         *
         * @return null|string
         */
        public static function record_count() {
            global $wpdb;
        
            $sql = "SELECT COUNT(*) FROM wp_custom_plugin";
        
            return $wpdb->get_var( $sql );
        }


        
     
        /**
 * Render a column when no column specific method exists.
 *
 * @param array $item
 * @param string $column_name
 *
 * @return mixed
 */
public function column_default( $item, $column_name ) {
  switch ( $column_name ) {
    case 'name':
      case 'phone':
    case 'email':
    case 'comment':
      return $item[ $column_name ];
    default:
      return print_r( $item, true ); //Show the whole array for troubleshooting purposes
  }
}

/**
 * Columns to make sortable.
 *
 * @return array
 */
public function get_sortable_columns() {
  $sortable_columns = array(
    'name' => array( 'name', true ),
    'email' => array( 'email', true ),
    'comment' => array( 'comment', true )
  );

  return $sortable_columns;
}

/**
 *  Associative array of columns
 *
 * @return array
 */
function get_columns() {
  $columns = [
   // 'cb'      => '<input type="checkbox" />',
    'name'    => __( 'name', 'sp' ),
    'phone' => __( 'phone', 'sp' ),
    'email' => __( 'email', 'sp' ),
    'comment'    => __( 'comment', 'sp' )
  ];

  return $columns;
}

/**
 * Returns an associative array containing the bulk action
 *
 * @return array
 */
public function get_bulk_actions() {
  $actions = [
    'bulk-delete' => 'Delete'
  ];

  return $actions;
}


/**
 * Handles data query and filter, sorting, and pagination.
 */
public function prepare_items() {

  $columns = $this->get_columns();
  $hidden = array();
  $sortable = $this->get_sortable_columns();
  $this->_column_headers = array($columns, $hidden, $sortable);

  /** Process bulk action */

  $this->process_bulk_action();

  $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
  $current_page = $this->get_pagenum();
  //$columns_page = $this->get_columns();
  $total_items  = self::record_count();

  $this->set_pagination_args( [
    'total_items' => $total_items, //WE have to calculate the total number of items
    'per_page'    => $per_page
    //'columns_page' => $columns_page //WE have to determine how many items to show on a page
  ] );


  $this->items = self::get_users( $per_page, $current_page );
}

        
    // add_action( 'plugins_loaded', function () {
    //   SP_Plugin::get_instance();
    // } );

    

      /**
* Screen options
*/
public function screen_option() {

	$option = 'per_page';
	$args   = [
		'label'   => 'Users',
		'default' => 5,
		'option'  => 'customers_per_page'
	];

	add_screen_option( $option, $args );

	$this->customers_obj = new Customers_List();
}

/**
* Plugin settings page
*/
public function plugin_settings_page() {
	?>
	<div class="wrap">
		<h2>WP_List_Table Class Example</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php
							$this->customers_obj->prepare_items();
							$this->customers_obj->display(); ?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
<?php
}
    /** Singleton instance */
    public static function get_instance() {
      if ( ! isset( self::$instance ) ) {
        self::$instance = new self();
      }

      return self::$instance;
    }

    }
  

  
   $list = new Users_List();
   $list->get_users();
   $list->prepare_items();
   $list->display();



   //custom post type blog

  //  add_action( 'init', 'activate_myplugin' );
  //       function activate_myplugin() {


  //               $args=array(
  //           'label' => 'Blog',
  //           'public' => true,
  //           'show_ui' => true,
  //           'capability_type' => 'post',
  //           'hierarchical' => false,
  //           'rewrite' => array(
  //               'slug' => 'mycustomposttype',
  //               'with_front' => false
  //               ),
  //           'query_var' => true,
  //           'supports' => array(
  //               'title',
  //               'editor',
  //               'excerpt',
  //               'trackbacks',
  //               'custom-fields',
  //               'revisions',
  //               'thumbnail',
  //               'author',
  //               'page-attributes'
  //               )
  //           ); 
  //               register_post_type( 'customposttype', $args );

  //       }



  //       function myplugin_flush_rewrites() {
  //               activate_myplugin();
  //               flush_rewrite_rules();
  //       }

  //       register_activation_hook( __FILE__, 'myplugin_flush_rewrites' );

  //       register_uninstall_hook( __FILE__, 'my_plugin_uninstall' );
  //       function my_plugin_uninstall() {
  //         // Uninstallation stuff here
  //            unregister_post_type( 'customposttype' );
  //       }


?>