<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package neubird
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function neubird_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'neubird_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function neubird_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'neubird_pingback_header' );

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

if ( !function_exists( 'wp_toolbar_frontend_admin_menu_links_extras' ) ) {
	function wp_toolbar_frontend_admin_menu_links_extras($wp_admin_bar) {   
		if ( is_admin() || !is_admin_bar_showing() )
			  return;

	   if ( !current_user_can('edit_pages') ) 
			return;
		
		$wp_admin_bar->remove_node( 'menus' );
		$wp_admin_bar->remove_node( 'themes' );
		$wp_admin_bar->remove_node( 'widgets' );
		$wp_admin_bar->remove_node( 'dashboard' );

		$wp_admin_bar->add_node(array(
			'id' => 'theme-settings',
			'title' => 'Theme Settings',
			'href' => admin_url() . 'admin.php?page=theme-settings' ,
			'parent' => 'site-name',
			'meta' => array(
				'class' => 'theme-settings-top'
			)
		));

		$wp_admin_bar->add_node(array(
			'id' => 'pages',
			'title' => 'Pages',
			'href' => admin_url() . 'edit.php?post_type=page' ,
			'parent' => 'site-name',
			'meta' => array(
				'class' => 'pages-top'
			)
		));

		$wp_admin_bar->add_node(array(
			'id' => 'news-insights',
			'title' => 'News & Press',
			'href' => admin_url() . 'edit.php' ,
			'parent' => 'site-name',
			'meta' => array(
				'class' => 'news-insights-top'
			)
		));

		$wp_admin_bar->add_node(array(
			'id' => 'blog',
			'title' => 'Blog',
			'href' => admin_url() . 'edit.php?post_type=blog' ,
			'parent' => 'site-name',
			'meta' => array(
				'class' => 'blog-top'
			)
		));

		$wp_admin_bar->add_node(array(
			'id' => 'media',
			'title' => 'Media',
			'href' => admin_url() . 'upload.php' ,
			'parent' => 'site-name',
			'meta' => array(
				'class' => 'media-top'
			)
		));
	}

    add_action('admin_bar_menu', 'wp_toolbar_frontend_admin_menu_links_extras', 99);
}

function cp_change_post_object() {
    $get_post_type = get_post_type_object('post');
    $labels = $get_post_type->labels;
	$labels->name = 'News & Press';
	$labels->singular_name = 'News & Press';
	$labels->add_new = 'Add News & Press';
	$labels->add_new_item = 'Add News & Press';
	$labels->edit_item = 'Edit News & Press';
	$labels->new_item = 'News & Press';
	$labels->view_item = 'View News & Press';
	$labels->search_items = 'Search News & Press';
	$labels->not_found = 'No News & Press found';
	$labels->not_found_in_trash = 'No News & Press found in Trash';
	$labels->all_items = 'All News & Press';
	$labels->menu_name = 'News & Press';
	$labels->name_admin_bar = 'News & Press';
}

add_action( 'init', 'cp_change_post_object' );
