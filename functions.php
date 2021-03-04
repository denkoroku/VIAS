<?php
add_action( 'wp_enqueue_scripts','enqueue_parent_styles' );

function enqueue_parent_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
//to make banner work
function our_features() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'our_features');
// Custom login css
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
    return esc_url(site_url('/')); 
}

function custom_admin_css() {
    wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/assets/custom_admin.css' );
}
add_action('admin_print_styles', 'custom_admin_css' );


// Remove dashboard widgets for nonadmin
function remove_dashboard_items() {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
	}
}
/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function wpexplorer_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget', // Widget slug.
		'(Nanoweb) Add News ', // Title.
		'wpexplorer_dashboard_widget_function' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'wpexplorer_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function wpexplorer_dashboard_widget_function() { ?>
	<div class="text-center">
		<div class="button btn-primary">
			<a href= "<?php get_home_url()?>/wp-admin/post-new.php">NewPost</a>
		</div>
	</div>
	<?php 
}
add_action( 'admin_init', 'remove_dashboard_items' ); 



// Custom Admin footer
function wpexplorer_custom_footer_admin () {
	echo '
	<div class="footer mx-auto">
		<span class="mx-auto" id="footer-thankyou">
			<img src="' . get_stylesheet_directory_uri() . '//images/icon.png" alt="Nanoweb logo" width="50" height="50">
			<span>
			Hand crafted by <a href="https://nanoweb.co.uk/" target="_blank">Nanoweb</a></span>
			</span>
		
	</div>';
}
add_filter( 'admin_footer_text', 'wpexplorer_custom_footer_admin' );

//Customising the login page
function wpexplorer_login_logo() { ?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/white_icon.png );
			padding-bottom: 30px;
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'wpexplorer_login_logo' );

function custom_login_css() {
    wp_enqueue_style('login-styles', get_stylesheet_directory_uri() . '/assets/custom_login.css');
}
add_action('login_enqueue_scripts', 'custom_login_css');

function modify_login_background() {
    $background_style = '<style type="text/css">';
    $background_style .= 'body {background-image: url(' . get_stylesheet_directory_uri() . '/images/background.png) !important;}';
    $background_style .= '</style>';
    echo $background_style;
}
add_action('login_head', 'modify_login_background');

// Custom post types

function template_post_types(){
	register_post_type('event', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
		'rewrite' => array('slug' => 'events'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'all_items' => 'All Events',
			'singular_name' => 'Event'
		),
		'menu_icon' => 'dashicons-calendar-alt'
	));
};

add_action('init', 'template_post_types');

function template_adjust_queries($query) {
	if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
		$today = date('Ymd');
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
			array(
				'key' => 'event_date',
				'compare' => '>=',
				'value' => $today,
				'type' => 'numeric'
			)
		));
	}
}

add_action('pre_get_posts', 'template_adjust_queries');

//Page Banner
function pageBanner($args = NULL) {

if (!$args['title']) {
    $args['title'] = get_the_title();
}

if (!$args['subtitle']) {
    $args['subtitle'] = get_field('page_banner_subtitle');
}

if (!$args['photo']) {
    if (get_field('page_banner_background_image')) {
		$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
		$args['photo'] = get_theme_file_uri('/images/background.png');
    }
}

?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);">
		</div>
		<div class="page-banner__content container">
			<h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle']; ?></p>
			</div>
		</div>  
	</div>
<?php }

// Redirect subscriber account

add_action('admin_init', 'redirectSubsToFrontEnd');

function redirectSubsToFrontEnd() {
	$ourCurrentUser = wp_get_current_user();

	if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber'){
		wp_redirect(esc_url(site_url('/')));
		exit;
	};
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
	$ourCurrentUser = wp_get_current_user();

	if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber'){
		show_admin_bar(false);
	};
}


?>