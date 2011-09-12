<?php
/**
 * SchoolsConnect Functions
 */

/** Tell WordPress to run schoolsconnect_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'schoolsconnect_setup' );

function schoolsconnect_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'schoolsconnect', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'schoolsconnect' ),
	) );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to schoolsconnect_header_image_width and schoolsconnect_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'schoolsconnect_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'schoolsconnect_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See schoolsconnect_admin_header_style(), below.
	add_custom_image_header( '', 'schoolsconnect_admin_header_style' );


	if ( !is_admin() ) 
	{
		wp_deregister_script( 'l10n' );
		add_action('init', 'my_init_method'); 
	}

  add_image_size( 'page-spread', 960, 600 );
  add_image_size( 'sub-page', 200, 120, true );
  add_image_size( 'sub-page-half', 420, 300, true );
}

function disable_jquery()
{
	wp_deregister_script('jquery');
}

add_action('wp_enqueue_scripts', 'disable_jquery');

/*
	Remove contact options that don't apply.
*/
function remove_contact_methods( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}

add_filter('user_contactmethods','remove_contact_methods',10,1);

/*
	Remove color options and rich text checkbox.
*/
function remove_user_prefs() {
	global $_wp_admin_css_colors;
	global $wp_rich_edit_exists;

	$_wp_admin_css_colors = 0;
	$wp_rich_edit_exists = 0;
}

add_action('admin_head', 'remove_user_prefs');


/**
	Remove User Bio from edit page.
*/
function remove_plain_bio($buffer) {
	$titles = array('#<h3>About Yourself</h3>#','#<h3>About the user</h3>#');
	$buffer=preg_replace($titles,'<h3>Password</h3>',$buffer,1);
	$biotable='#<h3>Password</h3>.+?<table.+?/tr>#s';
	$buffer=preg_replace($biotable,'<h3>Password</h3> <table class="form-table">',$buffer,1);
	return $buffer;
}

function profile_admin_buffer_start() { ob_start("remove_plain_bio"); }
function profile_admin_buffer_end() { ob_end_flush(); }
add_action('admin_head', 'profile_admin_buffer_start');
add_action('admin_footer', 'profile_admin_buffer_end');

/*
	Add profile fields to user edit page.
*/ 

function add_js_to_edit_user() {
    global $pagenow;

    if ( (isset( $_GET['user_id'] ) && $pagenow == 'user-edit.php') || ( $pagenow == 'profile.php' ) ) 
    {
    	echo '<script type="text/javascript" src="'.get_template_directory_uri().'/js/admin.js"></script>';
    }
}

add_filter('admin_footer', 'add_js_to_edit_user');

function member_inputs($type, $array)
{
	$content = "";
	$members = explode(', ', $array);

	if ( ! empty($members) ) 
	{
		for ($i=0; $i < count($members); $i++)
		{
			if ($i != 0)
	        	$content .= '<br />';
		    
		    $guid = $type.'['.($i + 1).']';

		    $content .= '<input type="text" name="'.$guid.'" id="'.$guid.'" value="'.$members[$i].'" class="regular-text" />';
		} 
	} else {
		$content .= '<input type="text" name="leader_1" id="leader_1" value="" class="regular-text" />';
	}

	return $content;
}

function show_extra_profile_fields( $user ) 
{ 
	global $wpdb;

	$school_info = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}school_info WHERE school_id = {$user->ID}");
?>
    <h3>School information</h3>
 
    <table class="form-table">
 
 	<?php if ($school_info->image): ?>
        <tr>
            <th><label for="name">Profile Image</label></th>
 
            <td>
                <input type="text" name="image" id="image" value="<?php echo esc_attr( $school_info->image ); ?>" class="regular-text" /><br />
                <span class="description">Remove this text to delete the image on the profile. This field won't upload new images, only remove them.</span>
            </td>
        </tr>
 	<?php endif ?>

        <tr>
            <th><label for="name">School Name</label></th>
 
            <td>
                <input type="text" name="name" id="name" value="<?php echo esc_attr( $school_info->name ); ?>" class="regular-text" /><br />
            </td>
        </tr>

        <tr>
            <th><label for="address">Address</label></th>
 
            <td>
                <input type="text" name="address" id="address" value="<?php echo esc_attr( $school_info->address ); ?>" class="regular-text" /><br />
                <input type="text" name="address_2" id="address_2" value="<?php echo esc_attr( $school_info->address_2 ); ?>" class="regular-text" /><br />
            </td>
        </tr>
 
        <tr>
            <th><label for="city">City</label></th>
 
            <td>
                <input type="text" name="city" id="city" value="<?php echo esc_attr( $school_info->city ); ?>" class="regular-text" /><br />
            </td>
        </tr>

        <tr>
            <th><label for="state">State</label></th>
 
            <td>
            	<select name="state" id="state">
					<option>Select One</option>
					<?php
						$state_list = array(
							'AL'=>"Alabama",  
							'AK'=>"Alaska",  
							'AZ'=>"Arizona",  
							'AR'=>"Arkansas",  
							'CA'=>"California",  
							'CO'=>"Colorado",  
							'CT'=>"Connecticut",  
							'DE'=>"Delaware",  
							'DC'=>"District Of Columbia",  
							'FL'=>"Florida",  
							'GA'=>"Georgia",  
							'HI'=>"Hawaii",  
							'ID'=>"Idaho",  
							'IL'=>"Illinois",  
							'IN'=>"Indiana",  
							'IA'=>"Iowa",  
							'KS'=>"Kansas",  
							'KY'=>"Kentucky",  
							'LA'=>"Louisiana",  
							'ME'=>"Maine",  
							'MD'=>"Maryland",  
							'MA'=>"Massachusetts",  
							'MI'=>"Michigan",  
							'MN'=>"Minnesota",  
							'MS'=>"Mississippi",  
							'MO'=>"Missouri",  
							'MT'=>"Montana",
							'NE'=>"Nebraska",
							'NV'=>"Nevada",
							'NH'=>"New Hampshire",
							'NJ'=>"New Jersey",
							'NM'=>"New Mexico",
							'NY'=>"New York",
							'NC'=>"North Carolina",
							'ND'=>"North Dakota",
							'OH'=>"Ohio",  
							'OK'=>"Oklahoma",  
							'OR'=>"Oregon",  
							'PA'=>"Pennsylvania",  
							'RI'=>"Rhode Island",  
							'SC'=>"South Carolina",  
							'SD'=>"South Dakota",
							'TN'=>"Tennessee",  
							'TX'=>"Texas",  
							'UT'=>"Utah",  
							'VT'=>"Vermont",  
							'VA'=>"Virginia",  
							'WA'=>"Washington",  
							'WV'=>"West Virginia",  
							'WI'=>"Wisconsin",  
							'WY'=>"Wyoming"
						);
					?>
					<?php foreach ($state_list as $state => $full_name): ?>
						<option value="<?php echo $state ?>"<?php if ($state == $school_info->state): ?> selected="true"<?php endif ?>><?php echo $full_name ?></option>
					<?php endforeach ?>
				</select>
            </td>
        </tr>

		<tr>
            <th><label for="zipcode">Zip Code</label></th>
 
            <td>
                <input type="text" name="zipcode" id="zipcode" value="<?php echo esc_attr( $school_info->zipcode ); ?>" class="regular-text" /><br />
            </td>
        </tr>

		<tr>
            <th><label for="advisor">Club Advisor</label></th>

            <td>
                <input type="text" name="advisor" id="advisor" value="<?php echo esc_attr( $school_info->advisor ); ?>" class="regular-text" /><br />
            </td>
        </tr>

		<tr>
            <th><label for="leader_1">Club Leaders</label></th>

            <td>
	            <?php echo member_inputs('leaders', $school_info->leaders) ?>
                <a href="#" class="add_member button-primary">+</a>
            </td>
        </tr>
		<tr>
            <th><label for="member_1">Club Members</label></th>

            <td>
	            <?php echo member_inputs('members', $school_info->members) ?>
                <a href="#" class="add_member button-primary">+</a>
            </td>
        </tr>

        <tr>
            <th><label for="name">Fundraising goal</label></th>
 
            <td>
                $<input type="text" name="goal" id="goal" value="<?php echo esc_attr( $school_info->goal ); ?>" class="regular-text" /><br />
                <span class="description">Numbers only</span>
            </td>
        </tr>
    </table>
<?php }
 
add_action( 'show_user_profile', 'show_extra_profile_fields' );
add_action( 'edit_user_profile', 'show_extra_profile_fields' );

function save_school_info( $user_id ) {
	global $wpdb;

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    
	$school_info = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}school_info WHERE school_id = $user_id");

	$data = array(
		'name'      => $_POST['name'],
		'address'   => $_POST['address'],
		'address_2' => $_POST['address_2'],
		'city'      => $_POST['city'],
		'state'     => $_POST['state'],
		'zipcode'   => $_POST['zipcode'],
		'advisor'   => $_POST['advisor'],
		'goal'		=> $_POST['goal'],
		'leaders'   => implode(', ', array_filter($_POST['leaders'], 'strlen')),
		'members'   => implode(', ', array_filter($_POST['members'], 'strlen')),
	);

	if ( empty($_POST['image']) )
		$data['image'] = '';

	$table = $wpdb->prefix.'school_info';

	if ( is_null($school_info) ) 
	{
		$data['school_id'] = $user_id;
		$wpdb->insert($table, $data);
	}
	else
	{
		$wpdb->update($table, $data, array( 'school_id' => $user_id ));
	}
}
add_action( 'personal_options_update', 'save_school_info' );
add_action( 'edit_user_profile_update', 'save_school_info' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function schoolsconnect_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'schoolsconnect_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function schoolsconnect_continue_reading_link() {
	return '<br /><br /> <a href="'. get_permalink() . '">' . __( 'Learn more <span class="meta-nav">&rarr;</span>', 'schoolsconnect' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and schoolsconnect_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function schoolsconnect_auto_excerpt_more( $more ) {
	return ' &hellip;' . schoolsconnect_continue_reading_link();
}
add_filter( 'excerpt_more', 'schoolsconnect_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function schoolsconnect_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= schoolsconnect_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'schoolsconnect_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function schoolsconnect_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override schoolsconnect_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function schoolsconnect_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'schoolsconnect' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'schoolsconnect' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Get Involved Sidebar',
		'id'   => 'getinvolved',
		'description' => 'Located on the Get Involved page.',
		'before_widget' => '<div id="%1$s" class="widget post childpost %2$s my_widget_class">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'schoolsconnect_widgets_init' );

function widget_class($params) {
	global $widget_num;

	// Widget class
	$class = array();
	$class[] = 'widget';

	// Iterated class
	$widget_num++;
	$class[] = 'widget-' . $widget_num;

	// Alt class
	if ($widget_num % 2) :
		$class[] = 'odd';
	else :
		$class[] = 'even';
	endif;

	// Join the classes in the array
	$class = join(' ', $class);

	// Interpolate the 'my_widget_class' placeholder
	$params[0]['before_widget'] = str_replace('my_widget_class', $class, $params[0]['before_widget']);
	return $params;
}
add_filter('dynamic_sidebar_params', 'widget_class');

?>