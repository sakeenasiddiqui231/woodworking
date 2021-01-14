<?php

// session_start();


 function enqueue_scripts() {

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
if(isset($_POST['submit_add_cart']))
{ 
        $user_id = get_current_user_id();
        $id = get_the_ID();
        $tittle = get_the_title($id);
        $res = get_post_meta( $post->ID,  'price_meta', true );
        $inventory = get_post_meta($post->ID,  'inventry_meta', true);
       
        $temp = $res['regular_price'];
        $value = $res['discount_price'];
        $quantity = 1;
        $cart_data= array();
        $cart_data = get_user_meta( $user_id, "cart_data", true );
        $data[] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$quantity, 'inventory'=> $inventory);
        
        if(is_user_logged_in())
        {
            if( empty( $cart_data ) || !is_array($cart_data) )
            {
                $cart_data = array();
            }
            if( isset( $cart_data[$id] ) && !empty( $cart_data[$id] ) )
            {
                $qty = intval($cart_data[$id]['quantity']) + $quantity;
                $cart_data[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$qty, 'inventory'=> $inventory);
            }
            else
            {
            $cart_data[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$quantity, 'inventory'=> $inventory);
            }
             update_user_meta( $user_id, 'cart_data', $cart_data);
            //  print_r($cart_data);
            //  die;
        }

        if(!is_user_logged_in())
        {
           if( empty( $_SESSION['cart'] ) || !is_array($_SESSION['cart']) )
            {
            $_SESSION['cart'] = array();
            }

            if( isset( $_SESSION['cart'][$id] ) && !empty( $_SESSION['cart'][$id] ) )
            {
            $qty = intval($_SESSION['cart'][$id]['quantity']) + $quantity;
            $_SESSION['cart'][$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$qty, 'inventory'=> $inventory);
            }

            else
            {
                $_SESSION['cart'][$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$quantity, 'inventory'=> $inventory);
            } 
             session_unset(); 
        }
}
?>
<?php  get_header(); ?>
<!-- end #menu -->
<html>
<div id="page">
    <div id="page-bgtop">
        <div id="page-bgbtm">
            <div id="content" class="post7">
                <div class="post">
                    <?php 
                        the_post_thumbnail('thumbnail', array('class'=> 'alignleft border'));
                        the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); 
                    ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>                 
                <?php $res = get_post_meta( $post->ID,  'price_meta', true ); ?>
                    <h6>Regular Price <?php echo $res['regular_price']; ?></h6>
                    <h6>Discounted Price <?php echo $res['discount_price']; ?></h6>
                </div>
                <form method="post">
                    <input type="submit" id="add_cart" name="submit_add_cart" value="Add Cart"></input>
                </form>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
    </div>
</div>
<!-- end #page -->
<!-- end #footer -->
</div>
</div>
</body>
</html>

