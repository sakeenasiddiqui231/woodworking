<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package advance-startup
 */
?>
<header role="banner">
	<h2 class="entry-title"><?php echo esc_html(get_theme_mod('advance_startup_nosearch_found_title',__('Nothing Found','advance-startup')));?></h2>
</header>
<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	<p><?php printf( esc_html__( 'Ready to publish your first post? Get started here.', 'advance-startup' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
	<?php elseif ( is_search() ) : ?>
		<p><?php echo esc_html(get_theme_mod('advance_startup_nosearch_found_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','advance-startup')));?></p><br />
		<?php if( get_theme_mod( 'advance_startup_show_noresult_search',true) != '') { ?>
			<?php get_search_form(); ?>
		<?php } ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Dont worry&hellip it happens to the best of us.', 'advance-startup' ); ?></p><br />
		<div class="read-moresec">
			<a href="<?php echo esc_url(home_url()); ?>" class="button"><?php esc_html_e( 'Return to Home Page', 'advance-startup' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Return to Home Page', 'advance-startup' ); ?></span></a>
		</div>
<?php endif; ?>