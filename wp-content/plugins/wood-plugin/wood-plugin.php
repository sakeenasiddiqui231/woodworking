<?php
/*
Plugin Name: Woodworking Plugin
Version: 1.0.0
Author: Sakeena Siddiqui
Author URI: https://cedcommerce.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: cedwoodworking
*/
   
      global $wpdb;
      if ( isset( $_POST['submit'] ) ){
      $wpdb->insert( 'wp_custom_plugin', array(
      'name' => $_POST['Name'],
      'phone' => $_POST['PhoneNumber'],
      'email' => $_POST['FromEmailAddress'],
      'comment' => $_POST['Comments'],
    
      ));

    }


    // global $wpdb;

    //   if ( isset( $_POST['subscribe'] ) ){
    //   $wpdb->insert( 'custom_table', array(
    //   'email' => $_POST['email'],    
    //   ));

    // }


    if( isset($_POST['subscribe']))
    {
      $elements= array();
    
      $key = "siddi_siddi";
      $postid = $_POST['postid'];
      $email = $_POST['email'];
       $result=get_post_meta($postid, $key, 1);
      if(!empty($result))
      {
        $result[] = $_POST['email'];
      }
      else{
        $result = array($_POST['email']);
      }
      $res = update_post_meta($postid, $key, $result);
    }
    

add_action("admin_menu", "addMenu");
/**
 * addMenu
 *
 * @return void
 */
function addMenu()
{
    add_menu_page("Woodworking", "Woodworking", 'manage_options', "example-options", "woodMenu");
    add_submenu_page("example-options", "option 1", "option 1",'manage_options', "example-option-1", "option1");
    add_submenu_page("example-options", "Admin", "Admin",'manage_options', "example-option-2", "custom_meta_box");
}
/**
 * woodMenu
 *
 * @return void
 */
function woodMenu()
{
    //echo "Hello Woodworking";
  // echo do_shortcode('[custom_db]');
  require_once 'class-listtable.php'; 
}
   
//  add_shortcode('custom_db', function(){

//         global $wpdb;
//         // $table_name = $wpdb->prefix . 'wp_custom_plugin';
//         // this will get the data from your table
//         $retrieve_data = $wpdb->get_results( "SELECT * FROM wp_custom_plugin " );
//         // foreach ($retrieve_data as $retrieved_data){ 
            
//         //     $name = $retrieved_data->name;
//         //     $phone = $retrieved_data->phone;
//         //     $email = $retrieved_data->email;
//         //     $comment = $retrieved_data->comment;
//         // }
//             $output = '<div class="wrap">
//                             <h2>Table of Users.</h2>
//                             <table border= "1">
//                               <tr>
//                                 <th>Name</th>
//                                 <th>Phone Number</th>
//                                 <th>Email</th>
//                                 <th>Comment</th>
//                               </tr> ';


//                               foreach ($retrieve_data as $retrieved_data){ 
            
//                                 $name = $retrieved_data->name;
//                                 $phone = $retrieved_data->phone;
//                                 $email = $retrieved_data->email;
//                                 $comment = $retrieved_data->comment;
                            
//                               $output.='<tr>
//                                 <td>'. $name .'</td>
//                                 <td>'. $phone .'</td>
//                                 <td>'. $email .'</td>
//                                 <td>'. $comment .'</td>
//                               </tr>';
//                               }
//                             '</table>          
//                         </div>';
//             return $output;

//         } );





function option1()
{
  require_once 'class-listsubscriber.php'; 
}
// function option2()
// {
//   require_once 'class-menu.php'; 
// }



// function for creating a shortcode

add_shortcode('wporg', 'wporg_shortcode');
function wporg_shortcode() {
   
  $content = '<form action="" id="ContactUs100" method="post">
  <script type="text/javascript">
  
  </script>
  <table style="width:100%;max-width:550px;border:0;" cellpadding="8" cellspacing="0">
  <tr> <td>
  <label for="Name">Name*:</label>
  </td> <td>
  <input name="Name" type="text" maxlength="60" style="width:100%;max-width:250px;" />
  </td> </tr> <tr> <td>
  <label for="PhoneNumber">Phone number:</label>
  </td> <td>
  <input name="PhoneNumber" type="text" maxlength="43" style="width:100%;max-width:250px;" />
  </td> </tr> <tr> <td>
  <label for="FromEmailAddress">Email address*:</label>
  </td> <td>
  <input name="FromEmailAddress" type="text" maxlength="90" style="width:100%;max-width:250px;" />
  </td> </tr> <tr> <td>
  <label for="Comments">Comments*:</label>
  </td> <td>
  <textarea name="Comments" rows="7" cols="40" style="width:100%;max-width:350px;"></textarea>
  </td> </tr> <tr> <td>
 
  </td> <td>
  
  <input name="submit" type="submit" value="Submit" />
 
  </td> </tr>
  </table>
  </form>';

    return $content;
}

// code for generating table dynamically while activating plugin

global $jal_db_version;


function custom_plugin_table() {
	global $table_prefix, $wpdb;

    $tblname = 'wp_custom_plugin';
    $wp_track_table = $table_prefix . "$tblname ";

    #Check to see if the table exists already, if not, then create it

    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 

	$sql = "CREATE TABLE `wp_custom_plugin` (      
        
        `name` varchar(255) NOT NULL,
        `phone` int(250) NOT NULL,
        `email` varchar(255) NOT NULL,
        `comment` varchar(255) NOT NULL
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	dbDelta( $sql );
}

register_activation_hook( __FILE__, 'custom_plugin_table' );



// custom post type Blog

add_action( 'init', 'activate_myplugin' );
        function activate_myplugin() {


                $args=array(
            'label' => 'Blog',
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
                'excerpt',
                'trackbacks',
                'custom-fields',
                'revisions',
                'thumbnail',
                'author',
                'page-attributes'
                )
            ); 
                register_post_type( 'blog', $args );

        }



        function myplugin_flush_rewrites() {
                activate_myplugin();
                flush_rewrite_rules();
        }

        register_activation_hook( __FILE__, 'myplugin_flush_rewrites' );

        register_uninstall_hook( __FILE__, 'my_plugin_uninstall' );
        function my_plugin_uninstall() {
          // Uninstallation stuff here
             unregister_post_type( 'blog' );
        }


// custom widget subscribe now

// code for custom Widgets //Monday
class custom_widget extends WP_Widget {
  
  function __construct() {
  parent::__construct(
    
  // Base ID of your widget
  'custom_widget', 
    
  // Widget name will appear in UI
  __('subscribe', 'wpb_widget_domain'), 
    
  // Widget description
  array( 'description' => __( 'subscribe', 'wpb_widget_domain' ), ) 
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
    
  

  // global $pages;
  
  
    //    $Item = "<br>";
    // $Item .= '<a href="' . get_permalink() . '">';
    // $Item .= get_the_title() . '</a>';
    $id=get_the_ID();
    
  ?>
  <?php
//global $post;
$post_type = get_post_type($id);

?>
<?php if(is_array($instance['posttype'])) : ?>
  <?php if(is_single() && in_array($post_type, $instance['posttype'])) :?>
    <form method="post">
    <input type="hidden" name="postid" value="<?php echo $id; ?>" placeholder="email"/>
   
    <input type="text" name="email" value="" placeholder="email"/>
    <input type="submit" name="subscribe" value="Subscribe" />
    </form>
  <?php endif;?>
  <?php endif;?>
  <?php
  echo '</ul>';
 
  
}
        
  // Widget Backend   
  /**
   * form
   *
   * @param  mixed $instance
   * @return void
   */
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
  <?php
  $args = array(
    'public'   => true,
    '_builtin' => false,
 );

 $output = 'names'; // names or objects, note names is the default
 $operator = 'or'; // 'and' or 'or'

 $post_types = get_post_types( $args, $output, $operator ); 


 foreach ( $post_types  as $post_type ) {

    //echo '<p>' . $post_type . '</p>';
    // $id = $this->get_field_id('posttype');
    // $name = $this->get_field_id('posttype[]');
 echo '<input type="checkbox" id="' .$this->get_field_id('posttype').$post_type .'" name='. $this->get_field_name('posttype[]').' value="' . $post_type . '">' . $post_type . ''; ?>

  </p>
  <?php 
  }
}   
  // Updating widget replacing old instances with new  
  /**
   * update
   *
   * @param  mixed $new_instance
   * @param  mixed $old_instance
   * @return void
   */
  public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  $instance['posttype'] = isset($new_instance['posttype'])  ? $new_instance['posttype']  : false;
  // print_r($instance);
  // die;
  return $instance;
  }  
  // Class wpb_widget ends here
  }   
  
  /**
   * wpb_custom_widget
   *function for registering the widget
   * @return void
   */
  function wpb_custom_widget() {
    register_widget( 'custom_widget' );
  }
  add_action( 'widgets_init', 'wpb_custom_widget' );

 // Adding a Metabox
 class custom_metabox{
  public static function custom_box() {
    $res = get_option('sid_sid');
    $screens = [ $res, 'wporg_cpt' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 // Unique ID
            'Color Meta Box',      // Box title
            [self::class,'custom_box_html'],  // Content callback, must be of type callable// becoz it is class that's why we call self class
            $screen                            // Post type
        );
    }
    add_option('sid_sid');

}

//Html for metabox
/**
 * custom_box_html
 *custom_box_html for creating a html input field
 * @param  mixed $post
 * @return void
 */
public static function custom_box_html( $post ) {
  ?>
  <label for="wporg_field"></label>
  <input type="text" name="colorname" placeholder="Enter the Color"/>
 
  <?php
}
// $eid = get_the_ID();
// echo($eid);
// die;

/**
 * save
 *sava function for saving the value of meta box
 * @param  mixed $post_id
 * @return void
 */
public static function save( int $post_id ) {

  if ( array_key_exists( 'colorname', $_POST ) ) {     
      update_post_meta(
          $post_id,
          'sakku',
          $_POST['colorname']
      );
  }
}
 }
 
add_action('add_meta_boxes',['custom_metabox', 'custom_box']);
add_action('save_post', ['custom_metabox', 'save']);


/**
 * custom_meta_box
 *custom meta box that display all post type and display only checked post type on front end
 * @return void
 */
function custom_meta_box(){?>
  <html>
  <h1><?php _e('All Post Types', 'cedwoodworking'); ?></h1><?php
  $args = array(
      'public'   => true,
        '_builtin' => false,
      );
  
      $output = 'names'; // names or objects, note names is the default
      $operator = 'or'; // 'and' or 'or'
  
      $post_types = get_post_types( $args, $output, $operator ); 
      $post_choices=get_option('sid_sid');
      $checked='';?>
      <form action="" method="post"><?php
      foreach($post_types as $post_type):
          if($post_type=="attachment"){
              continue;
              }
              $checked='';
              if(is_array($post_choices)){
                  if(in_array($post_type,$post_choices)){
                      $checked="checked";
                  } else {
                      $checked="";
                  }
              } else {
                  $checked='';
              }
      ?>

      <p><input id="post_choice" name='post_choice[]'  type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?></p>
         
      <?php 
      endforeach;?>
      <input type="submit"  value="<?php _e('Submit','cedwoodworking');?>" name="wood">
      </form>
      <?php
}




if(isset($_POST['wood'])){
  $choice=$_POST['post_choice'];
  update_option( 'sid_sid', $choice);

  function my_update_notice() {
      ?>
          <div class="notice notice-success">
              <p><?php _e( 'The update completed successfully!', 'cedwoodworking' ); ?></p>
          </div>
      <?php
      }   
  
  if( ! empty( get_option( 'sid_sid' ) ) ) {
      add_action( 'admin_notices', 'my_update_notice' );
  }
}


// add_filter( 'cron_schedules', 'add_cron' );
// function add_cron( $schedules ) { 
//     $schedules['five_seconds'] = array(
//         'interval' => 5,
//         'display'  => esc_html__( 'Every Five Seconds' ), );
//     print_r($schedules) ;
//     die;
// }

?>