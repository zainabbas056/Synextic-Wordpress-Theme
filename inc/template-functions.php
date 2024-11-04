<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package synextic
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function synextic_body_classes( $classes ) {
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
add_filter( 'body_class', 'synextic_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function synextic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'synextic_pingback_header' );




function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$new_filetypes['webp'] = 'image/webp';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');


if ( function_exists('get_field') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	));
}


class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {
	// Start Level
	function start_lvl(&$output, $depth = 0, $args = null) {
		if ($depth === 0) {
			$output .= '<div class="dropdown_menu"><ul>';
		} else {
			$output .= '<ul class="dropdown-menu">';
		}
	}

	// End Level
	function end_lvl(&$output, $depth = 0, $args = null) {
		if ($depth === 0) {
			$output .= '</ul></div>';
		} else {
			$output .= '</ul>';
		}
	}

	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		// Get the classes assigned to the menu item
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item';

		// If the item has children, add a custom class
		if (in_array('menu-item-has-children', $classes)) {
			$classes[] = 'has-child';
		}

		// Generate the class names string
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		// Start building the list item
		$output .= '<li' . $class_names .'>';

		// Add attributes to the <a> tag
		$attributes = '';
		!empty($item->url) && $attributes .= ' href="' . esc_attr($item->url) . '"';
		!empty($item->attr_title) && $attributes .= ' title="' . esc_attr($item->attr_title) . '"';

		// Start building the item output
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';

		// Conditionally add the <span> and <img> for child items only
		if ($depth > 0) { // Check if this is a child item
			// Parse the URL to get the path
			$url_path = parse_url($item->url, PHP_URL_PATH); 

			// Split the path into parts and get the last part (e.g., 'web-development')
			$url_segments = explode('/', trim($url_path, '/')); 
			$last_segment = end($url_segments);

			// Create the image source URL using the last segment of the URL
			$img_src = get_template_directory_uri() . '/assets/media/nav-' . strtolower(str_replace(' ', '-', $last_segment)) . '.svg';

			// Add the <span> and <img> tag
			$item_output .= '<span><img src="' . esc_url($img_src) . '" "></span>';
		}

		// Append the item title
		!empty($item->title) && $item_output .= ' ' . apply_filters('the_title', $item->title, $item->ID);

		// If the item has children, add the dropdown indicator
		if (in_array('menu-item-has-children', $classes)) {
			$item_output .= '<span><i class="las la-angle-down"></i></span>';
		}

		// Close the <a> tag
		$item_output .= '</a>';

		// Append the after content
		$item_output .= $args->after;

		// Add the item output to the final output
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	// End Element
	function end_el(&$output, $item, $depth = 0, $args = null) {
		$output .= '</li>';
	}
}




if(!function_exists('synextic_main_header_menus')) { 
	function synextic_main_header_menus($class,$menu){

		$defaults = array(
			'theme_location'  => $menu,
			'menu'            => '', 
			'container'       => '', 
			'container_class' => '', 
			'container_id'    => '',
			'menu_class'      => $class,
			'menu_id'         => 'navs-'.$menu,
			'echo'            => true,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker'          => '',
			'add_li_class'  => 'menu-item');				
		if(has_nav_menu($menu)){ 
			wp_nav_menu( $defaults);

		}

	}
}


function synextic_add_button_to_menu($items, $args) {

	if ( function_exists('get_field') ) {
		$menu_button=		get_field('menu_button','options');
	}
	if ($args->theme_location == 'header_main_navigation') {
		$items .= '<li><a href="' . esc_url($menu_button['url']) . '" class="btn btn-mint-outline">' . esc_html($menu_button['title']) . '</a></li>';
	}
	return $items;
}

add_filter('wp_nav_menu_items', 'synextic_add_button_to_menu', 10, 2);



if(!function_exists('synextic_header_menus')) { 
	function synextic_header_menus($class,$menu){

		$defaults = array(
			'theme_location'  => $menu,
			'menu'            => '', 
			'container'       => '', 
			'container_class' => '', 
			'container_id'    => '',
			'menu_class'      => $class,
			'menu_id'         => 'navs-'.$menu,
			'echo'            => true,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker'          => '',
			'add_li_class'  => 'nav-item');				
		if(has_nav_menu($menu)){ 
			wp_nav_menu( $defaults);

		}

	}
}



function services_func() {
	$labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'synextic' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'synextic' ),
		'menu_name'             => __( 'Services', 'synextic' ),
		'name_admin_bar'        => __( 'Service', 'synextic' ),
		'archives'              => __( 'Service Archives', 'synextic' ),
		'parent_item_colon'     => __( 'Parent Service:', 'synextic' ),
		'all_items'             => __( 'All Services', 'synextic' ),
		'add_new_item'          => __( 'Add New Service', 'synextic' ),
		'add_new'               => __( 'Add New Service', 'synextic' ),
		'new_item'              => __( 'New Item Service', 'synextic' ),
		'edit_item'             => __( 'Edit Item', 'synextic' ),
		'update_item'           => __( 'Update Item', 'synextic' ),
		'view_item'             => __( 'View Item', 'synextic' ),
		'search_items'          => __( 'Search Item', 'synextic' ),
		'not_found'             => __( 'Not found', 'synextic' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'synextic' ),
		'featured_image'        => __( 'Featured Image', 'synextic' ),
		'set_featured_image'    => __( 'Set featured image', 'synextic' ),
		'remove_featured_image' => __( 'Remove featured image', 'synextic' ),
		'use_featured_image'    => __( 'Use as featured image', 'synextic' ),
		'insert_into_item'      => __( 'Insert into item', 'synextic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'synextic' ),
		'items_list'            => __( 'Items list', 'synextic' ),
		'items_list_navigation' => __( 'Items list navigation', 'synextic' ),
		'filter_items_list'     => __( 'Filter items list', 'synextic' ),
	);
	$args = array(
		'label'                 => __( 'Service', 'synextic' ),
		'description'           => __( 'Add Services', 'synextic' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail' , 'excerpt','comments'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 65,
		'menu_icon'             => 'dashicons-image-filter',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
	);
	register_post_type( 'services', $args );

	register_taxonomy(
		"service_cat", array("services"), array(
			"hierarchical" => true,
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			"label" => "Services Category",
			"singular_label" => "Services Category",
			"rewrite" => true
		)
	);
	register_taxonomy_for_object_type('service_cat', 'services');
}

add_action("init","services_func");





function careers_func() {
	$labels = array(
		'name'                  => _x( 'Careers', 'Post Type General Name', 'synextic' ),
		'singular_name'         => _x( 'Career', 'Post Type Singular Name', 'synextic' ),
		'menu_name'             => __( 'Careers', 'synextic' ),
		'name_admin_bar'        => __( 'Career', 'synextic' ),
		'archives'              => __( 'Career Archives', 'synextic' ),
		'parent_item_colon'     => __( 'Parent Career:', 'synextic' ),
		'all_items'             => __( 'All Careers', 'synextic' ),
		'add_new_item'          => __( 'Add New Career', 'synextic' ),
		'add_new'               => __( 'Add New Career', 'synextic' ),
		'new_item'              => __( 'New Item Career', 'synextic' ),
		'edit_item'             => __( 'Edit Item', 'synextic' ),
		'update_item'           => __( 'Update Item', 'synextic' ),
		'view_item'             => __( 'View Item', 'synextic' ),
		'search_items'          => __( 'Search Item', 'synextic' ),
		'not_found'             => __( 'Not found', 'synextic' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'synextic' ),
		'featured_image'        => __( 'Featured Image', 'synextic' ),
		'set_featured_image'    => __( 'Set featured image', 'synextic' ),
		'remove_featured_image' => __( 'Remove featured image', 'synextic' ),
		'use_featured_image'    => __( 'Use as featured image', 'synextic' ),
		'insert_into_item'      => __( 'Insert into item', 'synextic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'synextic' ),
		'items_list'            => __( 'Items list', 'synextic' ),
		'items_list_navigation' => __( 'Items list navigation', 'synextic' ),
		'filter_items_list'     => __( 'Filter items list', 'synextic' ),
	);
	$args = array(
		'label'                 => __( 'Career', 'synextic' ),
		'description'           => __( 'Add Careers', 'synextic' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail' , 'excerpt','comments'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 65,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
	);
	register_post_type( 'career', $args );

	register_taxonomy(
		"career_cat", array("career"), array(
			"hierarchical" => true,
			'show_ui' => true,
			'show_admin_column' => false,
			'query_var' => true,
			"label" => "Careers Category",
			"singular_label" => "Careers Category",
			"rewrite" => true
		)
	);
	register_taxonomy_for_object_type('career_cat', 'careers');
}
add_action("init","careers_func");



function case_study_func() {
	$labels = array(
		'name'                  => _x( 'Case Studies', 'Post Type General Name', 'synextic' ),
		'singular_name'         => _x( 'Case Study', 'Post Type Singular Name', 'synextic' ),
		'menu_name'             => __( 'Case Studies', 'synextic' ),
		'name_admin_bar'        => __( 'Case Study', 'synextic' ),
		'archives'              => __( 'Case Study Archives', 'synextic' ),
		'parent_item_colon'     => __( 'Parent Case Study:', 'synextic' ),
		'all_items'             => __( 'All Case Studies', 'synextic' ),
		'add_new_item'          => __( 'Add New Case Study', 'synextic' ),
		'add_new'               => __( 'Add New Case Study', 'synextic' ),
		'new_item'              => __( 'New Item Case Study', 'synextic' ),
		'edit_item'             => __( 'Edit Item', 'synextic' ),
		'update_item'           => __( 'Update Item', 'synextic' ),
		'view_item'             => __( 'View Item', 'synextic' ),
		'search_items'          => __( 'Search Item', 'synextic' ),
		'not_found'             => __( 'Not found', 'synextic' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'synextic' ),
		'featured_image'        => __( 'Featured Image', 'synextic' ),
		'set_featured_image'    => __( 'Set featured image', 'synextic' ),
		'remove_featured_image' => __( 'Remove featured image', 'synextic' ),
		'use_featured_image'    => __( 'Use as featured image', 'synextic' ),
		'insert_into_item'      => __( 'Insert into item', 'synextic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'synextic' ),
		'items_list'            => __( 'Items list', 'synextic' ),
		'items_list_navigation' => __( 'Items list navigation', 'synextic' ),
		'filter_items_list'     => __( 'Filter items list', 'synextic' ),
	);
	$args = array(
		'label'                 => __( 'Case Study', 'synextic' ),
		'description'           => __( 'Add Case Studies', 'synextic' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail' , 'excerpt','comments'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 65,
		'menu_icon'             => 'dashicons-media-spreadsheet',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
	);
	register_post_type( 'case-study', $args );

	// register_taxonomy(
	// 	"case_study_cat", array("case-studies"), array(
	// 		"hierarchical" => true,
	// 		'show_ui' => true,
	// 		'show_admin_column' => false,
	// 		'query_var' => true,
	// 		"label" => "Case Studies Category",
	// 		"singular_label" => "Case Studies Category",
	// 		"rewrite" => true
	// 	)
	// );
	// register_taxonomy_for_object_type('case_study_cat', 'case-studies');

}

add_action("init","case_study_func");



$success_message = '';

if (isset($_POST['contact_submit_form'])) { 
	
	if ( function_exists('get_field') ) {
		$form_submission_email=					get_field('form_submission_email','options');
	}
    // Sanitize and validate input fields
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone_number = sanitize_text_field($_POST['phone_number']);
    $services = sanitize_text_field($_POST['services']);
    $region = sanitize_text_field($_POST['region']);
    $budget = sanitize_text_field($_POST['budget']);
    $message = sanitize_textarea_field($_POST['message']);

    // Prepare the email content
    $to = $form_submission_email; // Replace with your desired recipient email address
    $subject = 'New Quote Request from ' . $name;
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone Number: $phone_number\n";
    $body .= "Service: $services\n";
    $body .= "Region: $region\n";
    $body .= "Budget: $budget\n\n";
    $body .= "Message:\n$message\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: '.$name.' <'.$email.'>');

	if (wp_mail($to, $subject, $body, $headers)) {
		// Store success message in a session variable
		session_start();
		$_SESSION['success_message'] = 'Thank you for your request! We will get back to you soon.';

		$site_url = home_url();
		$redirect_url = $site_url . '/thank-you/';
		header('Location: ' . esc_url($redirect_url));
		
		exit;
	} else {
		$_SESSION['success_message'] = 'There was an issue with your request. Please try again later.';
	}
}
// Custom permalink structure for blog posts
function custom_blog_permalinks() {
    // Add rewrite rule
    add_rewrite_rule(
        '^blog/([^/]*)/?',
        'index.php?name=$matches[1]',
        'top'
    );

    // Ensure blog posts use this structure
    add_rewrite_tag('%postname%', '([^/]+)', 'name=');
}
add_action('init', 'custom_blog_permalinks');

// Update the permalink structure
function custom_blog_permalink_structure($permalink, $post) {
    if ($post->post_type === 'post') {
        return home_url('/blog/' . $post->post_name);
    }
    return $permalink;
}
add_filter('post_link', 'custom_blog_permalink_structure', 10, 2);


function my_custom_styles_in_head() {
  if ( function_exists('get_field') ) {
	$h1=		get_field('h1','options');
	$h2=		get_field('h2','options');
	$h3=		get_field('h3','options');
	$h4=		get_field('h4','options');
    $h5=		get_field('h5','options');
    $h6=		get_field('h6','options');
}
  ?>
    <style>
        .post-template-default .blogContent h1{
            font-size: <?php echo $h1 ?>px !important;
        }
       .post-template-default .blogContent h2{
            font-size: <?php echo $h2 ?>px !important;
        }
        .post-template-default .blogContent h3{
            font-size: <?php echo $h3 ?>px !important;
        }
        .post-template-default .blogContent h4{
            font-size: <?php echo $h4 ?>px !important;
        }
        .post-template-default .blogContent h5{
            font-size: <?php echo $h5 ?>px !important;
        }
        .post-template-default .blogContent h6{
            font-size: <?php echo $h6 ?>px !important;
        }
    </style>
  <?php
}
add_action('wp_head', 'my_custom_styles_in_head');
