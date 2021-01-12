<?php die("ahsggdyyeki");?>
<?php  get_header(); ?>
		<!-- end #menu -->
		<div id="page">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="content">
						<div class="post">
							<?php if (have_posts() ) : while (have_posts() ) : the_post(); ?>
							<h2 class="title"><a href="<?php the_permalink() ;?>"><?php the_title(); ?></a></h2>
								<p class="meta">Posted by <a href="<?php the_permalink() ;?>"></a><?php the_author(); ?> on July 10, 2011
									&nbsp;&bull;&nbsp; <a href="<?php the_permalink() ;?>" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="<?php the_permalink() ?>" class="permalink">Full article</a></p>
								<div class="entry">
									<?php the_content();
									 comments_template('/comments.php');
									?>
								</div>
								<?php endwhile; 
									wp_reset_postdata();
									else : ?>
									<p><?php esc_html_e( 'Sorry, no posts matched your criteria......' ); ?></p>									
                                    ?>
									<?php endif; ?>
						          </div>

					</div>
					<!-- end #content -->
					<?php  get_sidebar(); ?>
					<!-- end #sidebar -->
					<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
		</div>
		<!-- end #page -->
		<?php get_footer() ?>
		<!-- end #footer -->
	</div>
</div>
</body>
</html>
