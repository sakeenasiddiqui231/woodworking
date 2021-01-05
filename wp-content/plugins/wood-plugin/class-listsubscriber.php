<?php
//die("hiii");

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class subscriber_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

    }


    //$ID_array;
function subscribers(){

    $args = array(
      'post_type'     => 'any',
      'post_status'   => 'publish',
      'fields'        => 'ids',
      'meta_query'    => array(
        array(
          'key'    => 'siddi_siddi',
          'compare'       => 'exist'
        ),
      ),
    );
  
    $result_query = new WP_Query( $args );
  
    $ID_array = $result_query->posts;
  // print_r($ID_array);
  // die;
    wp_reset_postdata();
    $res = array();

    foreach($ID_array as $val)
    {

        $value = get_post_meta($val, 'siddi_siddi', 1);
      // echo $val;
      // die;
        foreach($value as $result)
        {
          $post_title = get_the_title($val);
           $res[]  = array('posttile'=> $post_title,'post_id'=>$val, 'email'=> $result);
        }
    }
   // print_r($res);//die;
    return $res;
}

/**
 * Delete a customer record.
 *
 * @param int $id customer ID 
 */
public static function delete_users( $id ) {
  global $wpdb;

  $wpdb->delete(
    "custom_table",
    [ 'id' => $id ],
    [ '%d' ]
  );
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
  // print_r($item);
  // die;
  switch ( $column_name ) {
    case 'posttile':
      $item[ $column_name ];
    case 'post_id':
      $item[ $column_name ];
    case 'email':
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
    'posttile' => array( 'posttile', true ),
    'post_id' => array( 'post_id', true ),
    'email' => array( 'email', true )
    
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
    'posttile'    => __( 'posttile', 'sp' ),
   
    'post_id' => __( 'post_id', 'sp' ),
    'email'    => __( 'email', 'sp' )
  ];

  return $columns;
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


  $this->items = $this->subscribers( $per_page, $current_page );
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

	$this->customers_obj = new subscriber_List();
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
 
   $list = new subscriber_List();
  
   $list->prepare_items();
   $list->display(); 

?>