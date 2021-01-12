
<?php  get_header(); ?>
<div id="page">
    <div id="page-bgtop">
        <div id="page-bgbtm">
            <div id="content" class="post7">
                <div class="post">
                <?php 
                        $loop = new WP_Query( array( 'post_type' => 'customposttype', 'posts_per_page' => 10 ) ); 

                        while ( $loop->have_posts() ) : $loop->the_post();
                        the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );                        
                ?>
                           <div class="entry-content">
                            <?php  the_post_thumbnail('thumbnail', array('class'=> 'alignleft border')); ?>
                                <?php the_content(); ?>
                               
                            </div>
                              
                        <?php endwhile; ?>
                                             </div>
                          </div>					
					<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
		</div>
		
		<?php get_footer() ?>
		
	</div>
</div>
</body>
</html>
 