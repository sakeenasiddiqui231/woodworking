<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package advance-startup
 */
?>

<div id="sidebar">
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
        <aside id="archives" role="complementary" aria-label="firstsidebar" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Archives', 'advance-startup' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>
        <aside id="meta" role="complementary" aria-label="secondsidebar" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Meta', 'advance-startup' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>
    <?php endif; // end sidebar widget area ?>  
</div>