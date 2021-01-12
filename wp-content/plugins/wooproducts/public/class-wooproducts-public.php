<?php
 session_start();
// print_r($_SESSION['cart']);
// die;


/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooproducts
 * @subpackage Wooproducts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wooproducts
 * @subpackage Wooproducts/public
 * @author     Cedcoss <cedcoss@gmail.com>
 */
class Wooproducts_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('list-the-posts', array($this, 'post_listing' ));
		add_shortcode('list-the-cart', array($this, 'cart_listing' ));
		

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wooproducts-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		wp_enqueue_script('jquery');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wooproducts-public.js', array( 'jquery' ), $this->version, false );

	}





   /**
	* post_listing
	*function for listing the products through shortcode
	*@since 1.0.
	*@version 1.0.0
    *
    * @return void
    */
	function post_listing(){
 
		$args = array(
						'post_type'      => 'customposttype',
					 );
	 
		$query = new WP_Query($args);
	?>

<?php



$query = new WP_Query( array('posts_per_page'=>2,
                                 'post_type'=>'customposttype',
                                 'paged' => get_query_var('paged') ? get_query_var('paged') : 1) 
                            ); 

		if($query->have_posts()) :
	 
			while($query->have_posts()) :	 
				$query->the_post() ;						 
			$result = '<div class="product-item">';
			$result .= '<div class="product-poster">' .the_post_thumbnail('thumbnail', array('class'=> 'alignleft border')). '</div>';
			$result .= '<div class="product-name">' .the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ) . '</div>';
			$result .= '<div class="product-desc">' .the_content() . '</div>'; 
			$result .= '</div>';		  
			endwhile;	 
			wp_reset_postdata();	 
		endif; 					
		
		echo paginate_links( array(
		   'current' => max( 1, get_query_var('paged') ),
		   'total' => $query->max_num_pages
	   ) );
		return $result;            
	}

	
	/**
	 * page_direct_to_single
	 *function for going post type single page
	 *@version 1.0.0
	 *@since 1.0
	 * @param  mixed $file_path
	 * @return void
	 */
	function page_direct_to_single($file_path)
	{
	
		$data=get_post_type();
		if($data == "customposttype"){
			$file_path=plugin_dir_path(__FILE__).'partials/single-products.php';
		}
		return $file_path;
	}
	
	/**
	 * cart_listing
	 *list the products table
	 *version 1.0.0
	 *since 1.0
	 * @return void
	 */
	function cart_listing(){

	if(isset($_POST['update'])){
	$id = $_POST['id'];			
	$value=$_POST['quantity'];
	$user_id = get_current_user_id();
	$cart_data = get_user_meta( $user_id, "cart_data", true );
	foreach($cart_data as $element=>$value){	
	if($element['id']== $id){
	$qty = intval($cart_data[$id]['quantity']) + $value;
	$cart_data[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$qty);
	update_user_meta( $user_id, 'cart_data', $cart_data[$id]);

}
}
}


if(isset($_POST['delete']))
{
	foreach($_SESSION['cart'] as $element){
	$cart_id = $element['id'];
	$id = $_POST['id'];
	$user_id = get_current_user_id();
	$del = get_user_meta($user_id, 'cart_data', true);
	foreach($del as $value=>$value)
	{
	  if($cart_id == $value['id'])
	  {
		  unset($del[$cart_id]);
	  }

	}
	update_user_meta($user_id, 'cart_data', $del);
}
}
?>
<table>
    <thead>
        <th>Id</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Discounted Price</th>
        <th>Regular Price</th>
        <th>Update</th>
        <th>Delete</th>
    </thead>
    <tbody>
	
		<?php


$user_id = get_current_user_id();
$cart_data = get_user_meta( $user_id, "cart_data", true );

	   foreach($cart_data as $value)
	   { 
		
?>
        <form method="post" action="">
            <tr>
<?php 


?>
				
                <td><?php echo $value['id'];  ?></td>
                <td><?php echo $value['title'];  ?></td>
                <input type="hidden" value="<?php echo $value['id'];  ?>" name="id">
                <td><input type="number" name="quantity" value="<?php echo $value['quantity']; ?>" /></th>
                <td><?php echo $value['regular'];  ?></td>
                <td><?php echo $value['discount'];  ?></td>
                <td><input type="submit" name="update" value="update"></td>
                <td><input type="submit" name="delete" class="btn btn-danger btn-sm" value="Delete" /></td>
            </tr>
        </form>
        <?php	
	   }
	   ?>
    </tbody>
</table>
<h4>Total Amount:
    <?php
	   $grand_total = 0;
	   foreach($cart_data as $value => $val)
	{		
		$grand_total = $grand_total + ($val['regular']+ ($val['discount']*$val['quantity']));		
	} print_r($grand_total);
	?></h4>
<?php
	   }

}