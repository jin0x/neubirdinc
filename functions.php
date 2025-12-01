<?php
/**
 * neubird functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package neubird
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function neubird_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on neubird, use a find and replace
		* to change 'neubird' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'neubird', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'neubird' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'neubird_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'neubird_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function neubird_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'neubird_content_width', 640 );
}
add_action( 'after_setup_theme', 'neubird_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function neubird_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'neubird' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'neubird' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'neubird_widgets_init' );

/**
 * ACF JSON save and load paths
 */
function neubird_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'neubird_acf_json_save_point');

function neubird_acf_json_load_point($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'neubird_acf_json_load_point');

/**
 * ACF field sync notice
 */
function neubird_acf_sync_notice() {
    if (is_admin() && function_exists('acf_get_field_groups')) {
        $notice = get_transient('neubird_acf_sync_notice');
        if ($notice !== false) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p><strong>Event Timezone Fields Missing?</strong> Please go to <a href="' . admin_url('edit.php?post_type=acf-field-group') . '">Custom Fields → Field Groups</a> and:</p>';
            echo '<ol style="margin-left: 20px;">';
            echo '<li>Look for "Sync available" next to "Event Details"</li>';
            echo '<li>Click "Sync available" to update the fields</li>';
            echo '<li>If no sync option appears, try deactivating and reactivating the theme</li>';
            echo '</ol>';
            echo '</div>';
            delete_transient('neubird_acf_sync_notice');
        }
    }
}
add_action('admin_notices', 'neubird_acf_sync_notice');

/**
 * Set sync notice when editing events
 */
function neubird_event_edit_notice() {
    $screen = get_current_screen();
    if ($screen && ($screen->post_type === 'event' || $screen->id === 'edit-event')) {
        // Check if timezone fields exist
        if (function_exists('get_field_object')) {
            $pacific_field = get_field_object('field_event_pacific_time');
            if (!$pacific_field) {
                set_transient('neubird_acf_sync_notice', true, 600); // Show for 10 minutes
            }
        }
    }
}
add_action('current_screen', 'neubird_event_edit_notice');

/**
 * Enqueue scripts and styles.
 */
function neubird_scripts() {
	wp_enqueue_style( 'neubird-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'neubird-style-modules', get_template_directory_uri() . '/assets/modules.css', array(), _S_VERSION );
	wp_enqueue_style( 'neubird-style-theme', get_template_directory_uri() . '/assets/css/theme.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'neubird-style-image-video-w-text', get_template_directory_uri() . '/css/image-video-w-text.css', array(), _S_VERSION );
	wp_enqueue_style( 'slick-style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1' );
	wp_enqueue_style( 'slick-theme-style', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array(), '1.8.1' );
	
	wp_enqueue_style( 'neubird-style-blog-archive', get_template_directory_uri() . '/css/blog-archive.css', array(), _S_VERSION );
	// Enqueue rolling logos CSS
	wp_enqueue_style( 'neubird-style-rolling-logos', get_template_directory_uri() . '/css/rolling-logos.css', array(), _S_VERSION );
	// Enqueue testimonial slider CSS
	wp_enqueue_style( 'testimonial-slider-css', get_template_directory_uri() . '/css/testimonial-slider.css', array(), _S_VERSION );

	// Enqueue tabbed testimonials CSS (scoped under .testimonial-tabbed)
	wp_enqueue_style( 'testimonial-tabbed-css', get_template_directory_uri() . '/css/testimonial-tabbed.css', array('testimonial-slider-css'), _S_VERSION );


	// Enqueue homepage banner no image CSS
	wp_enqueue_style( 'homepage-banner-no-image-css', get_template_directory_uri() . '/css/homepage-banner-no-image.css', array(), _S_VERSION );

	// Enqueue hero banner CSS
	wp_enqueue_style( 'hero-banner-css', get_template_directory_uri() . '/css/hero-banner.css', array(), _S_VERSION );

	wp_enqueue_style( 'hero-banner-fix-css', get_template_directory_uri() . '/css/hero-banner-fix.css', array('hero-banner-css'), _S_VERSION );

	wp_enqueue_style( 'page-banner-css', get_template_directory_uri() . '/css/page-banner.css', array(), _S_VERSION );

	// Enqueue News & Press block CSS fix
	wp_enqueue_style( 'news-press-fix-css', get_template_directory_uri() . '/css/news-press-fix.css', array(), _S_VERSION );
	
	// Enqueue News & Press pagination CSS
	wp_enqueue_style( 'news-press-pagination-css', get_template_directory_uri() . '/css/news-press-pagination.css', array(), _S_VERSION );
	
	// Enqueue table of contents CSS
	wp_enqueue_style( 'table-of-contents-css', get_template_directory_uri() . '/css/table-of-contents.css', array(), _S_VERSION );

	// Enqueue breadcrumbs CSS
	wp_enqueue_style( 'breadcrumbs-css', get_template_directory_uri() . '/css/breadcrumbs.css', array(), _S_VERSION );

	// Enqueue related posts CSS for blog single pages
	wp_enqueue_style( 'related-posts-css', get_template_directory_uri() . '/css/related-posts.css', array(), _S_VERSION );

	// Enqueue integration posts CSS
	wp_enqueue_style( 'integration-posts-css', get_template_directory_uri() . '/css/integration-posts.css', array(), _S_VERSION );

	// Enqueue events CSS
	wp_enqueue_style( 'events-css', get_template_directory_uri() . '/css/events.css', array(), _S_VERSION );

	// Enqueue glossary CSS
	wp_enqueue_style( 'glossary-css', get_template_directory_uri() . '/css/glossary.css', array(), _S_VERSION );

	// Enqueue Font Awesome for event icons
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4' );

	// Enqueue Gallery Block CSS
	wp_enqueue_style( 'gallery-block-css', get_template_directory_uri() . '/css/gallery-block.css', array(), _S_VERSION );

	// Enqueue Open Positions Fix CSS with high priority
	wp_enqueue_style( 'open-positions-fix-css', get_template_directory_uri() . '/css/open-positions-fix.css', array(), _S_VERSION );
	// Set high priority for this CSS file
	wp_add_inline_style( 'open-positions-fix-css', '' );

	// Enqueue admin CSS for events
	if (is_admin()) {
		add_action('admin_enqueue_scripts', 'neubird_admin_styles');
	}

	// Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	// Enqueue Hero Banner Animation JS
	wp_enqueue_script( 'hero-banner-animation', get_template_directory_uri() . '/js/hero-banner-animation.js', array('jquery'), _S_VERSION, true );

	// Enqueue Slick slider JS
	wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true );

	// Enqueue testimonial slider JS
	wp_enqueue_script( 'testimonial-slider', get_template_directory_uri() . '/js/testimonial-slider.js', array('jquery', 'slick-js'), _S_VERSION, true );

	// Enqueue open positions fix JS
	wp_enqueue_script( 'open-positions-fix', get_template_directory_uri() . '/js/open-positions-fix.js', array('jquery'), _S_VERSION, true );

	// Enqueue Lenis smooth scroll
	wp_enqueue_script( 'lenis', 'https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js', array(), '1.0.29', true );
	
	// Enqueue Lenis initialization
	wp_enqueue_script( 'lenis-init', get_template_directory_uri() . '/js/lenis-smooth-scroll.js', array('lenis'), _S_VERSION, true );

	wp_enqueue_script( 'neubird-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'neubird_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


function acf_register_blocks() { 
    // Include the original blocks configuration
    require("blocks/blocks.config.php");
}

add_action('acf/init', 'acf_register_blocks');

function neubird_mime_types($mimes) {
	$mimes['json'] = 'application/json';
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

// Gravity Forms selector for ACF: populate choices and preview metadata
add_filter('acf/load_field/name=gravity_form', function($field){
    if (!class_exists('GFAPI')) {
        return $field;
    }
    $forms = GFAPI::get_forms(true);
    $choices = array();
    foreach ($forms as $form) {
        $id = isset($form['id']) ? $form['id'] : (isset($form->id) ? $form->id : null);
        $title = isset($form['title']) ? $form['title'] : (isset($form->title) ? $form->title : 'Untitled');
        if ($id) {
            $choices[(string)$id] = sprintf('%s — Form (ID %d)', $title, $id);
        }
    }
    $field['choices'] = $choices;
    return $field;
});

// Removed ACF admin AJAX preview and inline script for Gravity Forms metadata

add_filter('upload_mimes', 'neubird_mime_types');

add_action( 'init', 'unregister_tags' );

function unregister_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

function neubird_change_cat_object() {
    global $wp_taxonomies;
    $labels = &$wp_taxonomies['category']->labels;
    $labels->name = 'Type';
    $labels->singular_name = 'Type';
    $labels->add_new = 'Add Type';
    $labels->add_new_item = 'Add Type';
    $labels->edit_item = 'Edit Type';
    $labels->new_item = 'Type';
    $labels->view_item = 'View Type';
    $labels->search_items = 'Search Types';
    $labels->not_found = 'No Types found';
    $labels->not_found_in_trash = 'No Types found in Trash';
    $labels->all_items = 'All Types';
    $labels->menu_name = 'Type';
    $labels->name_admin_bar = 'Type';
}
add_action( 'init', 'neubird_change_cat_object' );


// Disabled custom validation for minimum word count (Form 1 Field 8)
// add_filter("gform_field_validation_1_8", "validate_word_count", 10, 4);

function validate_word_count($result, $value, $form, $field){
    // Keep function defined but do not enforce validation.
    // Returning the original result without modification.
    return $result;
}

function custom_post_type_neubird() {

	$singular = 'Blog';
	$plural   = 'Blog';
	$slug     = str_replace( ' ', '-', strtolower( $singular ) );

	$labels = [
		'name'               => __( 'Blog', 'neubird' ),
		'singular_name'      => __( $singular, 'neubird' ),
		'add_new'            => _x( 'Add New', 'neubird', 'neubird' ),
		'add_new_item'       => __( 'Add New ' . 'Blog', 'neubird' ),
		'edit'               => __( 'Edit', 'neubird' ),
		'edit_item'          => __( 'Edit ' . 'Blog', 'neubird' ),
		'new_item'           => __( 'New ' . 'Blog', 'neubird' ),
		'view'               => __( 'View ' . 'Blog', 'neubird' ),
		'view_item'          => __( 'View ' . 'Blog', 'neubird' ),
		'search_term'        => __( 'Search ' . 'Blog', 'neubird' ),
		'parent'             => __( 'Parent ' . 'Blog', 'neubird' ),
		'not_found'          => __( 'No ' . 'Blog' . ' found', 'neubird' ),
		'not_found_in_trash' => __( 'No ' . 'Blog' . ' in Trash', 'neubird' ),
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'menu_position' => 9,
		'public'            => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
		'has_archive'       => false,
		'show_in_rest'      => true,
		'rewrite'           => [ 'slug' => $slug ],
		'menu_icon'         => 'dashicons-admin-post',
		'supports'          => [ 'title', 'editor', 'thumbnail', 'author'],
	];

	register_post_type( $slug, $args );

	$singular = 'Categories';
	$plural   = 'Categories';
	$slug     = str_replace( ' ', '_', strtolower( $singular ) );

	$labels = [
		'name'              => _x( $plural, 'neubird' ),
		'singular_name'     => _x( $singular, 'neubird' ),
		'search_items'      => __( 'Search ' . $plural ),
		'all_items'         => __( 'All ' . $plural ),
		'parent_item'       => __( 'Parent ' . $singular ),
		'parent_item_colon' => __( 'Parent:' . $singular ),
		'edit_item'         => __( 'Edit ' . $singular ),
		'update_item'       => __( 'Update ' . $singular ),
		'add_new_item'      => __( 'Add New ' . $singular ),
		'new_item_name'     => __( 'New ' . $singular ),
		'menu_name'         => __( $plural ),
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	];
	register_taxonomy( 'blog-categories', 'blog', $args );

	$singular = 'Integrations';
	$plural   = 'Integrations';
	$slug     = str_replace( ' ', '-', strtolower( $singular ) );

	$labels = [
		'name'               => __( 'Integrations', 'neubird' ),
		'singular_name'      => __( $singular, 'neubird' ),
		'add_new'            => _x( 'Add New', 'neubird', 'neubird' ),
		'add_new_item'       => __( 'Add New ' . 'Integrations', 'neubird' ),
		'edit'               => __( 'Edit', 'neubird' ),
		'edit_item'          => __( 'Edit ' . 'Integrations', 'neubird' ),
		'new_item'           => __( 'New ' . 'Integrations', 'neubird' ),
		'view'               => __( 'View ' . 'Integrations', 'neubird' ),
		'view_item'          => __( 'View ' . 'Integrations', 'neubird' ),
		'search_term'        => __( 'Search ' . 'Integrations', 'neubird' ),
		'parent'             => __( 'Parent ' . 'Integrations', 'neubird' ),
		'not_found'          => __( 'No ' . 'Integrations' . ' found', 'neubird' ),
		'not_found_in_trash' => __( 'No ' . 'Integrations' . ' in Trash', 'neubird' ),
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'menu_position' => 9,
		'public'            => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
		'has_archive'       => false,
		'show_in_rest'      => true,
		'rewrite'           => [ 'slug' => $slug ],
		'menu_icon'         => 'dashicons-admin-post',
		'supports'          => [ 'title'],
		
	];

	register_post_type( $slug, $args );

	// Events Post Type
	$singular = 'Event';
	$plural   = 'Events';
	$slug     = str_replace( ' ', '-', strtolower( $singular ) );

	$labels = [
		'name'               => __( 'Events', 'neubird' ),
		'singular_name'      => __( $singular, 'neubird' ),
		'add_new'            => _x( 'Add New', 'neubird', 'neubird' ),
		'add_new_item'       => __( 'Add New ' . 'Event', 'neubird' ),
		'edit'               => __( 'Edit', 'neubird' ),
		'edit_item'          => __( 'Edit ' . 'Event', 'neubird' ),
		'new_item'           => __( 'New ' . 'Event', 'neubird' ),
		'view'               => __( 'View ' . 'Event', 'neubird' ),
		'view_item'          => __( 'View ' . 'Event', 'neubird' ),
		'search_term'        => __( 'Search ' . 'Events', 'neubird' ),
		'parent'             => __( 'Parent ' . 'Event', 'neubird' ),
		'not_found'          => __( 'No ' . 'Events' . ' found', 'neubird' ),
		'not_found_in_trash' => __( 'No ' . 'Events' . ' in Trash', 'neubird' ),
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'menu_position'     => 8,
		'public'            => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
		'has_archive'       => true,
		'show_in_rest'      => true,
		'rewrite'           => [ 'slug' => 'events' ],
		'menu_icon'         => 'dashicons-calendar-alt',
		'supports'          => [ 'title', 'thumbnail', 'excerpt' ],
	];

	register_post_type( $slug, $args );

	// Glossary Post Type
	$singular = 'Glossary';
	$plural   = 'Glossary';
	$slug     = str_replace( ' ', '-', strtolower( $singular ) );

	$labels = [
		'name'               => __( 'Glossary', 'neubird' ),
		'singular_name'      => __( $singular, 'neubird' ),
		'add_new'            => _x( 'Add New', 'neubird', 'neubird' ),
		'add_new_item'       => __( 'Add New ' . 'Glossary', 'neubird' ),
		'edit'               => __( 'Edit', 'neubird' ),
		'edit_item'          => __( 'Edit ' . 'Glossary', 'neubird' ),
		'new_item'           => __( 'New ' . 'Glossary', 'neubird' ),
		'view'               => __( 'View ' . 'Glossary', 'neubird' ),
		'view_item'          => __( 'View ' . 'Glossary', 'neubird' ),
		'search_term'        => __( 'Search ' . 'Glossary', 'neubird' ),
		'parent'             => __( 'Parent ' . 'Glossary', 'neubird' ),
		'not_found'          => __( 'No ' . 'Glossary' . ' found', 'neubird' ),
		'not_found_in_trash' => __( 'No ' . 'Glossary' . ' in Trash', 'neubird' ),
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'menu_position'     => 9,
		'public'            => true,
		'show_in_menu'      => true,
		'show_in_nav_menus' => true,
		'has_archive'       => true,
		'show_in_rest'      => true,
		'rewrite'           => [ 'slug' => 'glossary' ],
		'menu_icon'         => 'dashicons-book-alt',
		'supports'          => [ 'title', 'editor', 'excerpt' ],
	];

	register_post_type( $slug, $args );

	// Event Categories Taxonomy
	$singular = 'Event Categories';
	$plural   = 'Event Categories';
	$slug     = 'event-categories';

	$labels = [
		'name'              => _x( $plural, 'neubird' ),
		'singular_name'     => _x( $singular, 'neubird' ),
		'search_items'      => __( 'Search ' . $plural ),
		'all_items'         => __( 'All ' . $plural ),
		'parent_item'       => __( 'Parent ' . $singular ),
		'parent_item_colon' => __( 'Parent:' . $singular ),
		'edit_item'         => __( 'Edit ' . $singular ),
		'update_item'       => __( 'Update ' . $singular ),
		'add_new_item'      => __( 'Add New ' . $singular ),
		'new_item_name'     => __( 'New ' . $singular ),
		'menu_name'         => __( $plural ),
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	];
	register_taxonomy( 'event-categories', 'event', $args );
}

add_action( 'init',  'custom_post_type_neubird' );

/**
 * Enqueue admin styles for events
 */
function neubird_admin_styles() {
    global $post_type;
    
    // Only load on event post type
    if( 'event' === $post_type ) {
        wp_enqueue_style( 'neubird-admin-events', get_template_directory_uri() . '/css/admin-events.css', array(), _S_VERSION );
    }
}





/**
 * Force Glossary to use Classic Editor instead of Gutenberg
 */
function neubird_force_classic_editor_for_glossary($use_block_editor, $post_type) {
    if ($post_type === 'glossary') {
        return false;
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'neubird_force_classic_editor_for_glossary', 10, 2);

/**
 * Client-Side Salesforce Form Handler Integration
 * Submit form data directly from browser to Pardot maintaining visitor cookie
 */
function add_pardot_client_side_script() {
    if (!is_admin()) {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            
            // GCLID Tracking Functions
            var queuedSubmissions = {};
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }
            
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }
            
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }
            
            function getGclidData() {
                // Check URL parameter first, then fall back to cookie
                var gclid = getUrlParameter('gclid') || getCookie('gclid') || '';
                
                // Store in cookie if found in URL (30 days expiration)
                if (getUrlParameter('gclid')) {
                    setCookie('gclid', gclid, 30);
                }
                
                return gclid;
            }
            
            // Initialize GCLID tracking on page load
            var gclidValue = getGclidData();
            
            // Helper to send any queued payload for a form id
            function sendQueued(formId) {
                try {
                    formId = String(formId || '');
                    var queued = queuedSubmissions[formId];
                    if (!queued || !queued.url) return;

                    // Simple in-memory guard to avoid duplicate sends
                    if (queued.__submitted) return;
                    queued.__submitted = true;

                    var iframeName = 'pardot-submit-' + formId + '-' + Date.now();
                    var $iframe = $('<iframe name="' + iframeName + '" style="display:none;"></iframe>').appendTo('body');
                    var $pardotForm = $('<form method="POST" action="' + queued.url + '" target="' + iframeName + '" style="display:none;"></form>');
                    $.each(queued.data, function(key, val) {
                        $('<input>').attr({ type: 'hidden', name: key, value: val || '' }).appendTo($pardotForm);
                    });
                    $pardotForm.appendTo('body').submit();
                    setTimeout(function () {
                        $iframe.remove();
                        $pardotForm.remove();
                    }, 3000);
                    delete queuedSubmissions[formId];
                    if (window.console && console.log) console.log('[Pardot] Sent queued submission for form', formId);
                } catch(e) {
                    // swallow
                }
            }

            $('body').on('submit', '.gform_wrapper form', function(e) {
                var $form = $(this);
                // Prefer hidden gform_submit value, fallback to form id attribute
                var formId = $form.find('input[name="gform_submit"]').val();
                if (!formId) {
                    var fidAttr = $form.attr('id'); // e.g., "gform_7"
                    var m = fidAttr && fidAttr.match(/gform_(\d+)/);
                    formId = m && m[1] ? m[1] : '';
                }
                
                // Only handle Form IDs 1, 2, 4, and 7
                if (!(formId == '1' || formId == '2' || formId == '4' || formId == '7')) {
                    return;
                }

                // Collect form data object
                var formData = {};
                var pardotUrl = '';

                if (formId == '1') {
                    pardotUrl = 'https://go.neubird.ai/l/1087303/2024-11-26/knr59z';
                    formData = {
                        'input_1_3': $form.find('input[name="input_3"]').val() || '',
                        'input_1_4': $form.find('input[name="input_4"]').val() || '',
                        'input_1_5': $form.find('input[name="input_5"]').val() || '',
                        'input_1_6': $form.find('input[name="input_6"]').val() || '',
                        'input_1_8': $form.find('input[name="input_8"], select[name="input_8"], textarea[name="input_8"]').val() || '',
                        'input_1_10': $form.find('input[name="input_10"]').val() || '',
                        'input_1_11': gclidValue || '',
                        'input_1_12': $form.find('input[name="input_12"]').val() || '',
                        'input_1_13': $form.find('input[name="input_13"]').val() || '',
                        'input_1_14': $form.find('input[name="input_14"]').val() || '',
                        'input_1_15': $form.find('input[name="input_15"]').val() || '',
                        'input_1_16': $form.find('input[name="input_16"]').val() || ''
                    };
                } else if (formId == '2') {
                    pardotUrl = 'https://go.neubird.ai/l/1087303/2025-01-13/kntr3b';
                    formData = {
                        'input_2_6': $form.find('input[name="input_6"]').val() || '',
                        'input_2_3': $form.find('input[name="input_3"]').val() || '',
                        'input_2_4': $form.find('input[name="input_4"]').val() || '',
                        'input_2_5': $form.find('input[name="input_5"]').val() || '',
                        'input_2_8': $form.find('input[name="input_8"], textarea[name="input_8"]').val() || '',
                        'input_2_9': gclidValue || '',
                        'input_2_10': $form.find('input[name="input_10"]').val() || '',
                        'input_2_11': $form.find('input[name="input_11"]').val() || '',
                        'input_2_12': $form.find('input[name="input_12"]').val() || '',
                        'input_2_13': $form.find('input[name="input_13"]').val() || '',
                        'input_2_14': $form.find('input[name="input_14"]').val() || ''
                    };
                } else if (formId == '4') {
                    pardotUrl = 'https://go.neubird.ai/l/1087303/2025-01-16/kntzb4';
                    formData = {
                        'input_4_3': $form.find('input[name="input_3"]').val() || '',
                        'input_4_4': $form.find('input[name="input_4"]').val() || '',
                        'input_4_5': $form.find('input[name="input_5"]').val() || '',
                        'input_4_6': $form.find('input[name="input_6"]').val() || '',
                        'input_4_8': $form.find('input[name="input_8"], textarea[name="input_8"]').val() || '',
                        'input_4_10': gclidValue || '',
                        'input_4_11': $form.find('input[name="input_11"]').val() || '',
                        'input_4_12': $form.find('input[name="input_12"]').val() || '',
                        'input_4_13': $form.find('input[name="input_13"]').val() || '',
                        'input_4_14': $form.find('input[name="input_14"]').val() || '',
                        'input_4_15': $form.find('input[name="input_15"]').val() || ''
                    };
                } else if (formId == '7') {
                    // Form 7: Hawkeye landing form with enhanced tracking
                    // Endpoint provided by user requirements
                    pardotUrl = 'https://go.neubird.ai/l/1087303/2025-11-04/kpvqjs';
                    formData = {
                        // Standard fields
                        'input_7_6': $form.find('input[name="input_6"]').val() || '', // Email (required)
                        'input_7_3': $form.find('input[name="input_3"]').val() || '', // First Name
                        'input_7_4': $form.find('input[name="input_4"]').val() || '', // Last Name
                        'input_7_5': $form.find('input[name="input_5"]').val() || '', // Company
                        'input_7_8': $form.find('input[name="input_8"], textarea[name="input_8"]').val() || '', // Comments

                        // Custom tracking fields
                        'input_7_10': $form.find('input[name="input_10"]').val() || '', // Neubird CTA Source
                        'input_7_11': gclidValue || '', // Google Click ID
                        'input_7_12': $form.find('input[name="input_12"]').val() || '', // UTM Source
                        'input_7_13': $form.find('input[name="input_13"]').val() || '', // UTM Medium
                        'input_7_14': $form.find('input[name="input_14"]').val() || '', // UTM Campaign
                        'input_7_15': $form.find('input[name="input_15"]').val() || '', // UTM Term
                        'input_7_16': $form.find('input[name="input_16"]').val() || ''  // UTM Content
                    };
                } else if (formId == '10') {
                    // Form 10: New Form Handler
                    pardotUrl = 'http://go.neubird.ai/l/1087303/2025-11-28/kpyc23';
                    formData = {
                        'input_10_6': $form.find('input[name="input_6"]').val() || '', // Email
                        'input_10_3': $form.find('input[name="input_3"]').val() || '', // First Name
                        'input_10_4': $form.find('input[name="input_4"]').val() || '', // Last Name
                        'input_10_5': $form.find('input[name="input_5"]').val() || '', // Company
                        'input_10_8': $form.find('input[name="input_8"], textarea[name="input_8"]').val() || '', // Comments
                        'input_10_10': $form.find('input[name="input_10"]').val() || '', // Neubird CTA Source
                        'input_10_11': gclidValue || '', // Google Click ID
                        'input_10_12': $form.find('input[name="input_12"]').val() || '', // UTM Source
                        'input_10_13': $form.find('input[name="input_13"]').val() || '', // UTM Medium
                        'input_10_14': $form.find('input[name="input_14"]').val() || '', // UTM Campaign
                        'input_10_15': $form.find('input[name="input_15"]').val() || '', // UTM Term
                        'input_10_16': $form.find('input[name="input_16"]').val() || ''  // UTM Content
                    };
                }

                // Queue and only send after successful Gravity Forms AJAX confirmation
                if (pardotUrl) {
                    queuedSubmissions[formId] = { url: pardotUrl, data: formData };
                    if (window.console && console.log) console.log('[Pardot] Queued submission for form', formId);
                    // Poll for confirmation DOM as a safety net (up to ~10s)
                    (function(fid){
                        var tries = 0;
                        var poll = setInterval(function(){
                            tries++;
                            if (queuedSubmissions[fid] && !queuedSubmissions[fid].__submitted && $('#gform_confirmation_wrapper_' + fid).length) {
                                if (window.console && console.log) console.log('[Pardot] Confirmation wrapper detected for form', fid);
                                sendQueued(fid);
                                clearInterval(poll);
                                return;
                            }
                            if (tries > 40) { // ~10s at 250ms
                                clearInterval(poll);
                            }
                        }, 250);
                    })(formId);
                }
            });
            
            // Send only after Gravity Forms loads confirmation (AJAX-enabled forms)
            $(document).off('gform_confirmation_loaded.pardot').on('gform_confirmation_loaded.pardot', function(event, formId) {
                if (window.console && console.log) console.log('[Pardot] gform_confirmation_loaded fired for form', formId);
                sendQueued(formId);
            });

            // Fallback: some GF versions still fire gform_ajax_success with varying signatures
            $(document).off('gform_ajax_success.pardot').on('gform_ajax_success.pardot', function(event, response) {
                var fid = '';
                if (response) {
                    fid = response.formId || response.form_id || (response.data && (response.data.form_id || response.data.formId)) || '';
                }
                if (window.console && console.log) console.log('[Pardot] gform_ajax_success fired with derived form', fid);
                if (!fid) return;
                sendQueued(fid);
            });

            // Additional fallback: when confirmation markup is injected, GF also triggers post_render
            $(document).off('gform_post_render.pardot').on('gform_post_render.pardot', function(event, fid /*, current_page*/){
                // If confirmation wrapper exists for this form, send now.
                if (typeof fid === 'undefined' || fid === null) return;
                var formId = String(fid);
                if ($('#gform_confirmation_wrapper_' + formId).length) {
                    sendQueued(formId);
                }
            });
        });
        </script>
        <?php
    }
}

/**
 * Generate breadcrumbs navigation
 */
function neubird_breadcrumbs() {
    // Don't display on the homepage
    if (is_home() || is_front_page()) {
        return;
    }

    $breadcrumbs = array();
    $home_title = get_bloginfo('name');
    
    // Add home link
    $breadcrumbs[] = array(
        'title' => $home_title,
        'url' => home_url('/'),
        'current' => false
    );

    if (is_single()) {
        $post_type = get_post_type();
        
        if ($post_type === 'glossary') {
            // For glossary posts
            $glossary_archive_url = get_post_type_archive_link('glossary');
            if ($glossary_archive_url) {
                $breadcrumbs[] = array(
                    'title' => 'Glossary',
                    'url' => $glossary_archive_url,
                    'current' => false
                );
            }
            
            $breadcrumbs[] = array(
                'title' => get_the_title(),
                'url' => '',
                'current' => true
            );
        } elseif ($post_type === 'integrations') {
            // For integration posts
            $integrations_archive_url = get_post_type_archive_link('integrations');
            if ($integrations_archive_url) {
                $breadcrumbs[] = array(
                    'title' => 'Integrations',
                    'url' => $integrations_archive_url,
                    'current' => false
                );
            }
            
            $breadcrumbs[] = array(
                'title' => get_the_title(),
                'url' => '',
                'current' => true
            );
        } elseif ($post_type === 'post') {
            // For blog posts
            $blog_page_id = get_option('page_for_posts');
            if ($blog_page_id) {
                $breadcrumbs[] = array(
                    'title' => get_the_title($blog_page_id),
                    'url' => get_permalink($blog_page_id),
                    'current' => false
                );
            } else {
                $breadcrumbs[] = array(
                    'title' => 'Blog',
                    'url' => home_url('/blog/'),
                    'current' => false
                );
            }
            
            // Add categories
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                $breadcrumbs[] = array(
                    'title' => $category->name,
                    'url' => get_category_link($category->term_id),
                    'current' => false
                );
            }
            
            $breadcrumbs[] = array(
                'title' => get_the_title(),
                'url' => '',
                'current' => true
            );
        }
    } elseif (is_page()) {
        // For pages, add parent pages if they exist
        $page_id = get_queried_object_id();
        $parents = array();
        
        while ($page_id) {
            $page = get_post($page_id);
            if ($page->post_parent) {
                $parents[] = $page->post_parent;
                $page_id = $page->post_parent;
            } else {
                break;
            }
        }
        
        // Reverse to show from top level down
        $parents = array_reverse($parents);
        
        foreach ($parents as $parent_id) {
            $breadcrumbs[] = array(
                'title' => get_the_title($parent_id),
                'url' => get_permalink($parent_id),
                'current' => false
            );
        }
        
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => '',
            'current' => true
        );
    } elseif (is_archive()) {
        $breadcrumbs[] = array(
            'title' => get_the_archive_title(),
            'url' => '',
            'current' => true
        );
    } elseif (is_search()) {
        $breadcrumbs[] = array(
            'title' => 'Search Results for "' . get_search_query() . '"',
            'url' => '',
            'current' => true
        );
    } elseif (is_404()) {
        $breadcrumbs[] = array(
            'title' => '404 - Page Not Found',
            'url' => '',
            'current' => true
        );
    }

    // Output breadcrumbs
    if (!empty($breadcrumbs)) {
        echo '<nav class="breadcrumbs-navigation" aria-label="Breadcrumb">';
        echo '<div class="breadcrumbs-container">';
        
        foreach ($breadcrumbs as $index => $breadcrumb) {
            if ($index > 0) {
                echo '<span class="breadcrumb-separator" aria-hidden="true">›</span>';
            }
            
            if ($breadcrumb['current']) {
                echo '<span class="breadcrumb-item current" aria-current="page">';
                if ($index === 0) {
                    echo '<svg class="breadcrumb-home-icon" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>';
                    echo '<span class="breadcrumb-text">' . esc_html($breadcrumb['title']) . '</span>';
                } else {
                    echo esc_html($breadcrumb['title']);
                }
                echo '</span>';
            } else {
                echo '<a href="' . esc_url($breadcrumb['url']) . '" class="breadcrumb-item">';
                if ($index === 0) {
                    echo '<svg class="breadcrumb-home-icon" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>';
                    echo '<span class="breadcrumb-text">' . esc_html($breadcrumb['title']) . '</span>';
                } else {
                    echo esc_html($breadcrumb['title']);
                }
                echo '</a>';
            }
        }
        
        echo '</div>';
        echo '</nav>';
    }
}
add_action('wp_footer', 'add_pardot_client_side_script');

/**
 * Add comprehensive UTM tracking for Gravity Forms
 */
function add_utm_tracking_script() {
    ?>
    <script type="text/javascript">
    (function() {
        function getParam(name) {
            const match = new RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
            return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
        }

        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days*864e5).toUTCString();
            document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : null;
        }

        // --- Step 1: Collect UTMs from URL or referrer ---
        var utm_source = getParam('utm_source');
        var utm_medium = getParam('utm_medium');
        var utm_campaign = getParam('utm_campaign');
        var utm_term = getParam('utm_term');
        var utm_content = getParam('utm_content');

        // If no UTM parameters, infer from referrer or set as direct
        if (!utm_source || !utm_medium) {
            var ref = document.referrer.toLowerCase();
            if (ref.includes('google.') || ref.includes('bing.') || ref.includes('yahoo.') || ref.includes('duckduckgo.')) {
                utm_source = 'google';
                utm_medium = 'organic';
            } else if (ref.includes('linkedin.')) {
                utm_source = 'linkedin';
                utm_medium = 'social';
            } else if (ref.includes('twitter.') || ref.includes('x.com')) {
                utm_source = 'twitter';
                utm_medium = 'social';
            } else if (ref.includes('facebook.')) {
                utm_source = 'facebook';
                utm_medium = 'social';
            } else if (ref === '' || ref === null) {
                utm_source = '(direct)';
                utm_medium = '(none)';
            } else {
                try {
                    utm_source = (new URL(ref)).hostname;
                    utm_medium = 'referral';
                } catch(e) {
                    utm_source = '(direct)';
                    utm_medium = '(none)';
                }
            }
        }

        // --- Step 2: Persist for 30 days ---
        setCookie('_nb_utm_source', utm_source || '', 30);
        setCookie('_nb_utm_medium', utm_medium || '', 30);
        setCookie('_nb_utm_campaign', utm_campaign || '', 30);
        setCookie('_nb_utm_term', utm_term || '', 30);
        setCookie('_nb_utm_content', utm_content || '', 30);

        // --- Step 3: Populate Gravity Forms hidden fields when forms load ---
        function populateUTMFields() {
            // Form 1 UTM fields
            const form1Fields = {
                'input_12': getCookie('_nb_utm_source'),
                'input_13': getCookie('_nb_utm_medium'),
                'input_14': getCookie('_nb_utm_campaign'),
                'input_15': getCookie('_nb_utm_term'),
                'input_16': getCookie('_nb_utm_content')
            };

            // Form 2 UTM fields
            const form2Fields = {
                'input_10': getCookie('_nb_utm_source'),
                'input_11': getCookie('_nb_utm_medium'),
                'input_12': getCookie('_nb_utm_campaign'),
                'input_13': getCookie('_nb_utm_term'),
                'input_14': getCookie('_nb_utm_content')
            };

            // Form 4 UTM fields
            const form4Fields = {
                'input_11': getCookie('_nb_utm_source'),
                'input_12': getCookie('_nb_utm_medium'),
                'input_13': getCookie('_nb_utm_campaign'),
                'input_14': getCookie('_nb_utm_term'),
                'input_15': getCookie('_nb_utm_content')
            };

            // Form 7 UTM fields
            const form7Fields = {
                'input_12': getCookie('_nb_utm_source'),
                'input_13': getCookie('_nb_utm_medium'),
                'input_14': getCookie('_nb_utm_campaign'),
                'input_15': getCookie('_nb_utm_term'),
                'input_16': getCookie('_nb_utm_content')
            };

            // Form 10 UTM fields
            const form10Fields = {
                'input_12': getCookie('_nb_utm_source'),
                'input_13': getCookie('_nb_utm_medium'),
                'input_14': getCookie('_nb_utm_campaign'),
                'input_15': getCookie('_nb_utm_term'),
                'input_16': getCookie('_nb_utm_content')
            };

            // Populate Form 1 fields
            Object.keys(form1Fields).forEach(fieldName => {
                const field = document.querySelector('input[name="' + fieldName + '"]');
                if (field && form1Fields[fieldName] && !field.value) {
                    field.value = form1Fields[fieldName];
                }
            });

            // Populate Form 2 fields
            Object.keys(form2Fields).forEach(fieldName => {
                const field = document.querySelector('input[name="' + fieldName + '"]');
                if (field && form2Fields[fieldName] && !field.value) {
                    field.value = form2Fields[fieldName];
                }
            });

            // Populate Form 4 fields
            Object.keys(form4Fields).forEach(fieldName => {
                const field = document.querySelector('input[name="' + fieldName + '"]');
                if (field && form4Fields[fieldName] && !field.value) {
                    field.value = form4Fields[fieldName];
                }
            });

            // Populate Form 7 fields
            Object.keys(form7Fields).forEach(fieldName => {
                const field = document.querySelector('input[name="' + fieldName + '"]');
                if (field && form7Fields[fieldName] && !field.value) {
                    field.value = form7Fields[fieldName];
                }
            });

            // Populate Form 10 fields
            Object.keys(form10Fields).forEach(fieldName => {
                const field = document.querySelector('input[name="' + fieldName + '"]');
                if (field && form10Fields[fieldName] && !field.value) {
                    field.value = form10Fields[fieldName];
                }
            });
        }

        // Run on page load and when Gravity Forms render
        window.addEventListener('load', populateUTMFields);
        
        // Also run when Gravity Forms are rendered (for AJAX forms)
        if (typeof jQuery !== 'undefined') {
            jQuery(document).on('gform_post_render', function(event, form_id, current_page) {
                setTimeout(populateUTMFields, 100); // Small delay to ensure fields are ready
            });
        }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'add_utm_tracking_script', 1); // High priority to run early

/**
 * Add Pardot Account Engagement tracking code
 * Hardcoded implementation to reduce ad blocker interference
 * Placed before </body> tag as per Salesforce documentation
 */
function add_pardot_tracking_code() {
    ?>
    <script type='text/javascript'> 
        piAId = '1088303'; 
        piCId = ''; 
        piHostname = 'go.neubird.ai'; 
        
        (function() { 
            function async_load(){ 
                var s = document.createElement('script'); s.type = 'text/javascript'; 
                s.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + piHostname + '/pd.js'; 
                var c = document.getElementsByTagName('script')[0]; c.parentNode.insertBefore(s, c); 
            } 
            if(window.attachEvent) { window.attachEvent('onload', async_load); } 
            else { window.addEventListener('load', async_load, false); } 
        })(); 
    </script>
    <?php
}
add_action('wp_footer', 'add_pardot_tracking_code', 99); // High priority to load near end

/**
 * Server-side fallback: Post to Pardot after successful Gravity Forms submission
 * Ensures delivery even if client-side is blocked by extensions or CSP.
 */
function neubird_pardot_after_submission($entry, $form) {
    $fid = isset($form['id']) ? (int)$form['id'] : 0;
    if (!in_array($fid, array(1,2,4,7,10), true)) {
        return;
    }

    // Deduplicate per-entry
    $entry_id = isset($entry['id']) ? (int)$entry['id'] : 0;
    $dedup_key = 'neubird_pardot_sent_' . $entry_id;
    if ($entry_id && get_transient($dedup_key)) {
        return; // Already sent
    }

    // Read GCLID from cookie if available
    $gclid = isset($_COOKIE['gclid']) ? sanitize_text_field($_COOKIE['gclid']) : '';

    // Build payload per form
    $payload = array();
    $pardot_url = '';

    if ($fid === 1) {
        $pardot_url = 'https://go.neubird.ai/l/1087303/2024-11-26/knr59z';
        $payload = array(
            'input_1_3'  => isset($entry['3']) ? $entry['3'] : '',
            'input_1_4'  => isset($entry['4']) ? $entry['4'] : '',
            'input_1_5'  => isset($entry['5']) ? $entry['5'] : '',
            'input_1_6'  => isset($entry['6']) ? $entry['6'] : '',
            'input_1_8'  => isset($entry['8']) ? $entry['8'] : '',
            'input_1_10' => isset($entry['10']) ? $entry['10'] : '',
            'input_1_11' => $gclid ?: (isset($entry['11']) ? $entry['11'] : ''),
            'input_1_12' => isset($entry['12']) ? $entry['12'] : '',
            'input_1_13' => isset($entry['13']) ? $entry['13'] : '',
            'input_1_14' => isset($entry['14']) ? $entry['14'] : '',
            'input_1_15' => isset($entry['15']) ? $entry['15'] : '',
            'input_1_16' => isset($entry['16']) ? $entry['16'] : ''
        );
    } elseif ($fid === 2) {
        $pardot_url = 'https://go.neubird.ai/l/1087303/2025-01-13/kntr3b';
        $payload = array(
            'input_2_6'  => isset($entry['6']) ? $entry['6'] : '',
            'input_2_3'  => isset($entry['3']) ? $entry['3'] : '',
            'input_2_4'  => isset($entry['4']) ? $entry['4'] : '',
            'input_2_5'  => isset($entry['5']) ? $entry['5'] : '',
            'input_2_8'  => isset($entry['8']) ? $entry['8'] : '',
            'input_2_9'  => $gclid ?: (isset($entry['9']) ? $entry['9'] : ''),
            'input_2_10' => isset($entry['10']) ? $entry['10'] : '',
            'input_2_11' => isset($entry['11']) ? $entry['11'] : '',
            'input_2_12' => isset($entry['12']) ? $entry['12'] : '',
            'input_2_13' => isset($entry['13']) ? $entry['13'] : '',
            'input_2_14' => isset($entry['14']) ? $entry['14'] : ''
        );
    } elseif ($fid === 4) {
        $pardot_url = 'https://go.neubird.ai/l/1087303/2025-01-16/kntzb4';
        $payload = array(
            'input_4_3'  => isset($entry['3']) ? $entry['3'] : '',
            'input_4_4'  => isset($entry['4']) ? $entry['4'] : '',
            'input_4_5'  => isset($entry['5']) ? $entry['5'] : '',
            'input_4_6'  => isset($entry['6']) ? $entry['6'] : '',
            'input_4_8'  => isset($entry['8']) ? $entry['8'] : '',
            'input_4_10' => $gclid ?: (isset($entry['10']) ? $entry['10'] : ''),
            'input_4_11' => isset($entry['11']) ? $entry['11'] : '',
            'input_4_12' => isset($entry['12']) ? $entry['12'] : '',
            'input_4_13' => isset($entry['13']) ? $entry['13'] : '',
            'input_4_14' => isset($entry['14']) ? $entry['14'] : '',
            'input_4_15' => isset($entry['15']) ? $entry['15'] : ''
        );
    } elseif ($fid === 7) {
        $pardot_url = 'https://go.neubird.ai/l/1087303/2025-11-04/kpvqjs';
        $payload = array(
            'input_7_6'  => isset($entry['6']) ? $entry['6'] : '',
            'input_7_3'  => isset($entry['3']) ? $entry['3'] : '',
            'input_7_4'  => isset($entry['4']) ? $entry['4'] : '',
            'input_7_5'  => isset($entry['5']) ? $entry['5'] : '',
            'input_7_8'  => isset($entry['8']) ? $entry['8'] : '',
            'input_7_10' => isset($entry['10']) ? $entry['10'] : '',
            'input_7_11' => $gclid ?: (isset($entry['11']) ? $entry['11'] : ''),
            'input_7_12' => isset($entry['12']) ? $entry['12'] : '',
            'input_7_13' => isset($entry['13']) ? $entry['13'] : '',
            'input_7_14' => isset($entry['14']) ? $entry['14'] : '',
            'input_7_15' => isset($entry['15']) ? $entry['15'] : '',
            'input_7_16' => isset($entry['16']) ? $entry['16'] : ''
        );
    } elseif ($fid === 10) {
        $pardot_url = 'http://go.neubird.ai/l/1087303/2025-11-28/kpyc23';
        $payload = array(
            'input_10_6'  => isset($entry['6']) ? $entry['6'] : '',
            'input_10_3'  => isset($entry['3']) ? $entry['3'] : '',
            'input_10_4'  => isset($entry['4']) ? $entry['4'] : '',
            'input_10_5'  => isset($entry['5']) ? $entry['5'] : '',
            'input_10_8'  => isset($entry['8']) ? $entry['8'] : '',
            'input_10_10' => isset($entry['10']) ? $entry['10'] : '',
            'input_10_11' => $gclid ?: (isset($entry['11']) ? $entry['11'] : ''),
            'input_10_12' => isset($entry['12']) ? $entry['12'] : '',
            'input_10_13' => isset($entry['13']) ? $entry['13'] : '',
            'input_10_14' => isset($entry['14']) ? $entry['14'] : '',
            'input_10_15' => isset($entry['15']) ? $entry['15'] : '',
            'input_10_16' => isset($entry['16']) ? $entry['16'] : ''
        );
    }

    if (!$pardot_url) {
        return;
    }

    $args = array(
        'timeout' => 8,
        'body'    => $payload,
    );

    $resp = wp_remote_post($pardot_url, $args);
    if (is_wp_error($resp)) {
        error_log('[Pardot] Server-side post failed for form ' . $fid . ': ' . $resp->get_error_message());
    } else {
        set_transient($dedup_key, 1, DAY_IN_SECONDS);
        error_log('[Pardot] Server-side post succeeded for form ' . $fid);
    }
}
add_action('gform_after_submission', 'neubird_pardot_after_submission', 10, 2);
