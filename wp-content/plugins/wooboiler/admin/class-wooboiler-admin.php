<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Wooboiler
 * @subpackage Wooboiler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wooboiler
 * @subpackage Wooboiler/admin
 * @author     cedcoss <cedcoss@gmail.com>
 */
class Wooboiler_Admin
{
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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wooboiler_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wooboiler_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'css/wooboiler-admin.css',
            [],
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wooboiler_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wooboiler_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/wooboiler-admin.js',
            ['jquery'],
            $this->version,
            false
        );
        wp_localize_script($this->plugin_name, 'arr_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('siddi'),
        ]);
    }

    public function addBoilermenu()
    {
        add_menu_page(
            "Boiler",
            "Boiler",
            'manage_options',
            "example-top-options",
            [$this, 'boilermenu']
        );
        // add_submenu_page("example-top-options", "BoilerAdmin", "BoilerAdmin",'manage_options', "example-option-2", "option2");
    }
    /**
     * boilermenu
     * version 1.0
     * @since 1.0.0
     *function for creating the form in boilermenu
     * @return void
     */
    function boilermenu()
    {
        ?>
  
  <form method="post">
	<br>
	<h1>form for custom post type:</h1>

	<label for="tittle">Tittle</label>
	<input type="text" name="tittle" value="" placeholder="Enter tittle" /><br><br>
	
	<input type="submit" name="post" value="Create Post" />
  </form>
  <?php
    }

    /**
     * brand_custom_box
     *function for creating custom meta box brand
     *@since 1.0.0
     *version 1.0
     * @return void
     */
    public function brand_custom_box()
    {
        $screens = ['post', 'wporg_cpt'];

        foreach ($screens as $screen) {
            add_meta_box(
                'wporg_id', // Unique ID
                'Brand Meta Box', // Box title
                [$this, 'box_html'], // Content callback, must be of type callable// becoz it is class that's why we call self class
                $screen,
                'advanced
			  ',
                'high' // Post type
            );
        }
    }

    //Html for metabox
    /**
     * box_html
     *function for meta box html
     *@since 1.0.0
     *version 1.0
     * @param  mixed $post
     * @return void
     */
    public function box_html($post)
    {
        ?>
	<label for="wporg_field"></label>
	<input type="text" id="brandnameid" name="brandname" placeholder="Enter the Brand" />
	<label for="wporg_field"></label>
	<input type="button" id="brandmetaid" name="Submit" value="Submit" />
	<input type="hidden" id="metaid" value="<?php echo get_the_ID(); ?>" />

	<?php
    }

    /**
     * post_type
     *function for creating custom type post on submitting form
     *@since 1.0.0
     *version 1.0
     * @return void
     */
    function post_type()
    {
        $result = get_option('custom_form', 1);
        foreach ($result as $value) {
            // Set UI labels for Custom Post Type
            $labels = [
                'name' => _x($value, 'Post Type General Name', 'twentytwenty'),
                'singular_name' => _x(
                    $value,
                    'Post Type Singular Name',
                    'twentytwenty'
                ),
            ];

            // Set other options for Custom Post Type

            $args = [
                'label' => __($value, 'twentytwenty'),
                'description' => __(
                    'Portfolio news and reviews',
                    'twentytwenty'
                ),
                'labels' => $labels,
                // Features this CPT supports in Post Editor
                'supports' => [
                    'title',
                    'editor',
                    'excerpt',
                    'author',
                    'thumbnail',
                    'comments',
                    'revisions',
                    'custom-fields',
                ],
                // You can associate this CPT with a taxonomy or custom taxonomy.
                'taxonomies' => ['genres'],
                /* A hierarchical CPT is like Pages and can have
                 * Parent and child items. A non-hierarchical CPT
                 * is like Posts.
                 */
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'menu_position' => 5,
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'post',
                'show_in_rest' => true,
            ];

            // Registering your Custom Post Type
            register_post_type($value, $args);
        }
    }

    /**
     * brand_save
     *function for saving meta box values
     * @param  mixed $post_id
     * @since 1.0.0
     * @version 1.0
     * @return void
     */
    public function brand_save(int $post_id)
    {
        if (array_key_exists('brandname', $_POST)) {
            update_post_meta($post_id, 'siddu_siddu', $_POST['brandname']);
            //add_action( 'admin_notices', 'sample_admin_notice__success' );
        }
    }

    /**
     * add_new_columns
     *
     * @param  mixed $columns
     * @return void
     */
    function add_new_columns($columns)
    {
        $column_meta = ['brand' => 'Brand'];
        $columns =
            array_slice($columns, 0, 6, true) +
            $column_meta +
            array_slice($columns, 6, null, true);
        return $columns;
    }

    // Register the columns as sortable
    function register_sortable_columns($columns)
    {
        $columns['brand'] = 'brand';
        return $columns;
    }

    //Add filter to the request to make the brand sorting process numeric, not string
    function brand_column_orderby($vars)
    {
        if (isset($vars['orderby']) && 'brand' == $vars['orderby']) {
            $vars = array_merge($vars, [
                'meta_key' => 'siddu_siddu',
                'orderby' => 'meta_value_num',
            ]);
        }

        return $vars;
    }

    /**
     * Display data in new columns
     *
     * @param  $column Current column
     *
     * @return Data for the column
     */
    function custom_columns($column)
    {
        global $post;

        switch ($column) {
            case 'brand':
                $brand = get_post_meta($post->ID, 'siddu_siddu', true);
                if ($brand == "") {
                    $brand = "__";
                }
                echo $brand;

                break;
        }
    }
    /**
     * add_meta
     * version:1.0
     *funtion for updating metabox value
     * @return void
     */
    function add_meta()
    {
        $metaname = $_POST['name'];
        $result = $_POST['id'];
        update_post_meta($result, 'siddu_siddu', $metaname);

        echo "updated";
    }

    /**
     * wpb_custom_notification
     * version 1.0
     *function for registering the widget
     * @return void
     */

    function wpb_custom_notification()
    {
        register_widget('custom_notification');
	}
	






	
} // ending of class

// Saving the values of form into database

	if (isset($_POST['notification'])) {
		$elements = [];

		$key = "sakeena";
		$postid = $_POST['postid'];
		$email = $_POST['email'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$result = get_post_meta($postid, $key, 1);
		if (!empty($result)) {
			$result[] = $_POST['email'];
		} else {
			$result = [$_POST['email'], $_POST['name'], $_POST['address']];
		}
		$res = update_post_meta($postid, $key, $result);
	}

// Saving the values of form into database

	add_option('custom_form');

	if (isset($_POST['post'])) {
		$name = $_POST['tittle'];
		$key = 'custom_form';
		$response = get_option($key, 1);
		if (!empty($response)) {
			$response[] = $_POST['tittle'];
		} else {
			$response = [$_POST['tittle']];
		}
		$result = update_option($key, $response);
	}

// class for custom Widgets 
class custom_notification extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'custom_notification',

            // Widget name will appear in UI
            __('Notification', 'wpb_widget_domain'),

            // Widget description
            ['description' => __('Notification', 'wpb_widget_domain')]
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // This is where you run the code and display the output

        // global $pages;
        $id = get_the_ID();
        ?>
	<?php $post_type = get_post_type($id); ?>
	<?php if (is_array($instance['posttype'])): ?>
	<?php if (is_single() && in_array($post_type, $instance['posttype'])): ?>
	<form method="post">
		<br>
		<h1>form for custom post</h1>
		<input type="hidden" name="postid" value="<?php echo $id; ?>" placeholder="" /><br>
		<label for="wporg_field"></label>
		<input type="text" name="email" value="" placeholder="email" /><br>
		<label for="wporg_field"></label>
		<input type="text" name="name" value="" placeholder="Enter name" /><br>
		<label for="wporg_field"></label>
		<input type="text" name="address" value="" placeholder="Enter the Address" /><br>
		<input type="submit" name="notification" value="Notification" />
	</form>
	<?php endif; ?>
	<?php endif; ?>
	<?php echo '</ul>';
    } /**Widget Backend
     * form
     *version:1.0
     * @param  mixed $instance
     * @return void
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }// Widget admin form
        ?>
	<p>
		<?php
	$args = ['public' => true, '_builtin' => false];
	$output = 'names';
	// names or objects, note names is the default
	$operator = 'or'; // 'and' or 'or'
	$post_types = get_post_types($args, $output, $operator);
	foreach ($post_types as $post_type) {
		echo '<input type="checkbox" id="' .
			$this->get_field_id('posttype') .
			$post_type .
			'" name=' .
			$this->get_field_name('posttype[]') .
			' value="' .
			$post_type .
			'">' .
			$post_type .
			''; ?>

	</p>
	<?php
	}
    } /** Updating widget replacing old instances with new
     * update
     *varsion:1.0
     * @param  mixed $new_instance
     * @param  mixed $old_instance
     * @return void
     */
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = !empty($new_instance['title'])
            ? strip_tags($new_instance['title'])
            : '';
        $instance['posttype'] = isset($new_instance['posttype'])
            ? $new_instance['posttype']
            : false;
        return $instance;
    }
}
