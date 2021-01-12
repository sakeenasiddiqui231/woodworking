<?php


if(isset($_POST['submit']))
{
    $user_id = get_current_user_id();
    $id = get_the_ID();
    $tittle = get_the_title($id);
    $res = get_post_meta( $post->ID,  'price_meta', true );
    $temp = $res['regular_price'];
    $value = $res['discount_price'];
    $quantity = 1;
    $cart_data= array();
    $cart_data = get_user_meta( $user_id, "cart_data", true );
    $data[] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$quantity);


if( empty( $cart_data ) || !is_array($cart_data) )
{
$cart_data = array();
}

if( isset( $cart_data[$id] ) && !empty( $cart_data[$id] ) )
{
$qty = intval($cart_data[$id]['quantity']) + $quantity;
$cart_data[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$qty);
}
else
{
$cart_data[$id] = array('id'=>$id, 'title'=>$tittle, 'regular'=>$temp, 'discount'=>$value, 'quantity'=>$quantity);
}

echo "<pre>";

update_user_meta( $user_id, 'cart_data', $cart_data);
echo "</pre>";
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
                    <?php
                $res = get_post_meta( $post->ID,  'price_meta', true );

                ?>
                    <h6>Regular Price <?php echo $res['regular_price']; ?></h6>
                    <h6>Discounted Price <?php echo $res['discount_price']; ?></h6>
                </div>

                <form method="post">
                    <input type="submit" name="submit" value="Add Cart"></input>
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

