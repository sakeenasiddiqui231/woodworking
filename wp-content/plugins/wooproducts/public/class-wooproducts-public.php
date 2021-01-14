<?php
 session_start();
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
		add_shortcode('checkout-products', array($this, 'cart_checkout' ));
		add_shortcode('thankyou-page', array($this, 'thankyou_page_for_shopping' ));
		

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
	 
		$query = new WP_Query($args); ?>
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
		if($data == "customposttype")
		{
		$file_path=plugin_dir_path(__FILE__).'partials/single-products.php';
		}
		return $file_path;
	}
	
	/**
	 * cart_listing
	 *list the products table
	 *@version 1.0.0
	 *@since 1.0
	 * @return void
	 */
	function cart_listing(){

			if(is_user_logged_in())
			{
				$user_id = get_current_user_id();
				if(!empty($_SESSION['cart']))
            {                       
                delete_user_meta($user_id, 'cart_data');
                update_user_meta( $user_id, 'cart_data', $_SESSION['cart']);
               
            }      
				if(isset($_POST['update'])){
				$id = $_POST['id'];			
				$value=$_POST['quantity'];
				$user_id = get_current_user_id();
				$cart_data = get_user_meta( $user_id, "cart_data", true );
				foreach($cart_data as $element=>$value){	
				if($element['id']== $id){
				$qty = intval($cart_data[$id]['quantity']) + $value;
				$cart_data[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$qty, 'inventory'=>$inventory);
				update_user_meta( $user_id, 'cart_data', $cart_data[$id]);

			}
			}
			}


			if(isset($_POST['delete']))
			{
				$user_id = get_current_user_id();
				$cart_data = get_user_meta( $user_id, "cart_data", true );
				foreach($cart_data as $element){
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
        <?php	}?>
		</tbody>
	 </table>
	 <h4>Total Amount:
				<?php
				$grand_total = 0;
				foreach($cart_data as $value => $val)
				{		
					$grand_total = $grand_total + ($val['regular']+ ($val['discount']*$val['quantity']));		
				} print_r($grand_total);?></h4>
		<form action="http://192.168.2.84/wordpress/checkout/" >
		<input type="submit" name="checkout" value="Checkout" />
		</form>
		<?php
		}
	
		if(isset($_POST['without_login_update'])){
			$id = $_POST['id'];			
			$value=$_POST['input_quantity'];
			$result = $_SESSION['cart'];
			foreach($result as $element=>$value){	
			if($element['id']== $id){
			$qty = intval($result[$id]['quantity']) + $value;
			$result[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$qty, 'inventory'=> $inventory);
		}
		}
		}

		if(isset($_POST['without_login_delete']))
			{
				$result = $_SESSION['cart'];
				foreach($result as $element){
				$cart_id = $element['id'];
				$id = $_POST['id'];
				foreach($result as $value=>$value)
				{
				if($cart_id == $value['id'])
				{
					unset($del[$cart_id]);
				}
				}
			
			}
			}
			if(!is_user_logged_in())
			{
			if(!empty( $_SESSION['cart'] ))
			{ 
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
				$result = $_SESSION['cart'];
				foreach($result as $value)
				{ 				
				?>
				<form method="post" action="">
				<tr>			
						<td><?php echo $value['id'];  ?></td>
						<td><?php echo $value['title'];  ?></td>
						<input type="hidden" value="<?php echo $value['id'];  ?>" name="id">
						<td><input type="number" name="input_quantity" value="<?php echo $value['quantity']; ?>" /></th>
						<td><?php echo $value['regular'];  ?></td>
						<td><?php echo $value['discount'];  ?></td>
						<td><input type="submit" name="without_login_update" value="update"></td>
						<td><input type="submit" name="without_login_delete" class="btn btn-danger btn-sm" value="Delete" /></td>
				</tr>
				</form>
				<?php	} ?>
				</tbody>
				</table>
				<h4>Total Amount:
					<?php
					$grand_total = 0;
					foreach($result as $value => $val)
					{		
						$grand_total = $grand_total + ($val['regular']+ ($val['discount']*$val['quantity']));		
					} print_r($grand_total);
					?></h4>
					<input type="submit" name="checkout" value="Checkout" />
				<?php 
			}
			}
	}

	function cart_checkout()
	{
		if(isset($_POST['checkout']))
		{
		$first_name = $_POST['firstname'];
		$last_name = $_POST['lastname'];
		$county = $_POST['country'];
		$street = $_POST['street'];
		$town_city = $_POST['town_city'];
		$pincode = $_POST['pincode'];
		$phone_number = $_POST['phone_number'];
		$email = $_POST['email'];
		$form_data = array('firstname'=>$first_name, 'lastname'=>$last_name, 'country'=> $county, 
		'street'=>$street, 'town_city'=>$town_city, 'pincode'=>$pincode, 'phone_number'=> $phone_number,
		'email'=>$email);

		$first_name = $_POST['f_name'];
		$last_name = $_POST['l_name'];
		$country = $_POST['country_name'];
		$street = $_POST['street_name'];
		$town_city_name = $_POST['town_city_name'];
		$pincode_number = $_POST['pincode_number'];
		$phone_number = $_POST['p_number'];
		$user_email = $_POST['user_email'];
		$shipping_checkout = array('f_name'=> $first_name, 'l_name'=> $last_name, 'country_name'=> $country, 
		'street_name'=> $country, 'town_city_name'=>$town_city_name, 'pincode_number'=> $pincode_number,
		'p_number'=> $phone_number, 'user_email'=> $user_email );

	
		$user_id = get_current_user_id();
		$cart_data = get_user_meta( $user_id, "cart_data", true );
		$cart_data_encode=json_encode($cart_data);
		$form_data_encode = json_encode($form_data);
		$shipping_checkout_encode = json_encode($shipping_checkout);
		

		global $wpdb;
			$tablename = $wpdb->prefix.'checkout_table';
			$wpdb->insert( $tablename, array(
				"user_id"=>$user_id,
				"billing_detail"=>$cart_data_encode, "shipping_detail"=>$shipping_checkout_encode,
				"customer_detail"=>$form_data_encode,
				"total_amount"=>890 
			));

			foreach ($cart_data as $result=>$value)
			{
				$product_inventory =  $value['inventory'];
				$product_quantity = $value['quantity'];
				$id = $value['id'];
				if($product_inventory > $product_quantity)
				{
					$final_inventory = $product_inventory - $product_quantity ;
					
				}
				update_post_meta($id,  'inventry_meta', $final_inventory);
			}	
			update_user_meta( $user_id, 'cart_data', '');
}
?>
  <h1>Billing Details:</h1>
			<div class="container">
			<form action="" method="post">
			<div class="row">
				<div class="col-25">
				<label for="fname">First Name</label>
				</div>
				<div class="col-75">
				<input type="text"  name="firstname" id="firstname" pattern="^[a-zA-Z ]*$" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Last Name</label>
				</div>
				<div class="col-75">
				<input type="text"  id="lastname" name="lastname" pattern="^[a-zA-Z ]*$" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="country">Country</label>
				</div>
				<div class="col-75">
				<select id="country" id="country" name="country">
					<option value="australia">India</option>
					<option value="canada">Canada</option>
					<option value="usa">USA</option>
				</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Street</label>
				</div>
				<div class="col-75">
				<input type="text" id="street" name="street" pattern="^[a-zA-Z ]*$" required>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Town/City</label>
				</div>
				<div class="col-75">
				<input type="text" id="town_city" name="town_city" pattern="^[a-zA-Z ]*$" required>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Pincode</label>
				</div>
				<div class="col-75">
				<input type="text" id="pincode" max="5" name="pincode" required>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Phone Number</label>
				</div>
				<div class="col-75">
				<input type="text" max="10"   id="phone_number" name="phone_number"  required>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Email</label>
				</div>
				<div class="col-75">
				<input type="text" id="email" name="email" pattern="^(?!.*\.{2})[a-zA-Z0-9.]+@[a-zA-Z]+(?:\.[a-zA-Z]+)*$" required>
				</div>
			</div>
		<div class="row">
			<div class="col-25">
			<label for="lname"><b>billing address same as shipping address</b></label>
			</div>
			<div class="col-75">
			<input type="checkbox" max="10"   id="checked" name="checked"  required>
			</div>
		</div>
			<a class="open-button" onclick="openForm()">Shipping Address </a>
			<div class="container" id="myForm">			
			<div class="row">
				<div class="col-25">
				<label for="fname">First Name</label>
				</div>
				<div class="col-75">
				<input type="text" id="f_name" name="f_name" pattern="^[a-zA-Z ]*$" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Last Name</label>
				</div>
				<div class="col-75">
				<input type="text" id="l_name" name="l_name" pattern="^[a-zA-Z ]*$" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="country">Country</label>
				</div>
				<div class="col-75">
				<select id="country" id = "country_name" name="country_name" required>
					<option value="australia">India</option>
					<option value="canada">Canada</option>
					<option value="usa">USA</option>
				</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Street</label>
				</div>
				<div class="col-75">
				<input type="text" id="street_name" name="street_name" pattern="^[a-zA-Z ]*$" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Town/City</label>
				</div>
				<div class="col-75">
				<input type="text" id="town_city_name" name="town_city_name" pattern="^[a-zA-Z ]*$" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Pincode</label>
				</div>
				<div class="col-75">
				<input type="text" id="pincode_number" name="pincode_number" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Phone Number</label>
				</div>
				<div class="col-75">
				<input type="text" id="p_number" name="p_number" required >
				</div>
			</div>
			<div class="row">
				<div class="col-25">
				<label for="lname">Email</label>
				</div>
				<div class="col-75">
				<input type="text" id="user_email" name="user_email" pattern="^(?!.*\.{2})[a-zA-Z0-9.]+@[a-zA-Z]+(?:\.[a-zA-Z]+)*$" required >
				</div>
			</div>
			<div class="row">
				<input type="submit" value="Placed Order" name="checkout">
			</div>
			</form>
			</div>

      <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
		</div>
		<script>
		function openForm() {
		document.getElementById("myForm").style.display = "block";
		}
		function closeForm() {
		document.getElementById("myForm").style.display = "none";
		}
		</script>
		<div class="col-25">
			<div class="container">
			<h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b></b></span></h4>
	   <?php
	   $user_id = get_current_user_id();
       $cart_data = get_user_meta( $user_id, "cart_data", true ); 
       foreach($cart_data as $value)
	   { 
       ?>
	   <p><a href="#"><?php echo $value['title'];?></a> <span class="price"><?php echo $value['regular'];?></span></p>
       <?php } ?>

   <h4>Total Amount:
			<?php
			$grand_total = 0;
			foreach($cart_data as $value => $val)
			{		
			$grand_total = $grand_total + ($val['regular']+ ($val['discount']*$val['quantity']));		
			} 
			print_r($grand_total);
			?></h4>

<?php
}

function thankyou_page_for_shopping()
{
	?>
	<h1>Your Order is placed.......Thankyou for Shopping</h1>
	<?php
}



}

