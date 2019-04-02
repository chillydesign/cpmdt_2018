<?php

//Date formatage
add_filter('frm_csv_date_format', 'change_my_csv_format');
function change_my_csv_format($format){
  $format = 'd.m.Y';
  return $format;
}

//Suppression de champ inutiles
add_filter( 'frm_csv_columns', 'remove_id_column', 10, 2 );
function remove_id_column( $headings, $form_id ) {
  if ( $form_id == 5 or $form_id == 17 or $form_id == 27 or $form_id == 18 or $form_id ==23) {
    unset( $headings['created_at'] );
    unset( $headings['updated_at'] );
    unset( $headings['is_draft'] );
    unset( $headings['updated_by'] );
    unset( $headings['item_key'] );
    unset( $headings['user_id'] );
  }

  // Nettoyage des colonnes pour Formulaire 5 (4-7ans)
  if ( $form_id == 5 ) {
  $position1 = array_search( 'Professeur', array_values( $headings ) ) + 1;
  $position2 = array_search( 'Autre lieu possible', array_values( $headings ) );

  $headings = (
  	array_slice( $headings, 0, $position1, true ) +
  	array( 'lieu' => 'Lieu' ) +
  	array_slice( $headings, $position2, NULL, true )
  );
  }

  // Nettoyage des colonnes pour Formulaire 17 (Instrument chant)
  if ( $form_id == 17 ) {
  $position11 = array_search( 'Professeur Instr. / chant', array_values( $headings ) ) + 1;
  $position22 = array_search( 'Autre lieu possible', array_values( $headings ) );

  $headings = (
  	array_slice( $headings, 0, $position11, true ) +
  	array( 'lieu' => 'Lieu' ) +
  	array_slice( $headings, $position22, NULL, true )
  );
  }

  //Déplacement téléphone (formulaire 17)
  //if ( $form_id == 17 ) {
  //$position1 = array_search( 'Ville', array_values( $headings ) ) + 1;
  //$headings = (
  //	array_slice( $headings, 0, $position1, true ) +
  //	array( '179' => 'Téléphone privé' ) +
  //	array_slice( $headings, $position1, NULL, true )
  //);
 // }

  //Suppression du champ courril confirmation (formulaire 5)
  if ( $form_id == 5 ) {
		$export_columns = array( 192 );
		foreach ( $headings as $col_key => $data ) {
			if ( in_array( $col_key, $export_columns ) ) {
				unset( $headings[ $col_key ] );
			}
		}
	}

   //Suppression du champ courril confirmation (formulaire 17)
	if ( $form_id == 17 ) {
		$export_columns = array( 211 );
		foreach ( $headings as $col_key => $data ) {
			if ( in_array( $col_key, $export_columns ) ) {
				unset( $headings[ $col_key ] );
			}
		}
	}

	//Suppression du champ courril confirmation (formulaire 27)
	if ( $form_id == 27 ) {
		$export_columns = array( 608 );
		foreach ( $headings as $col_key => $data ) {
			if ( in_array( $col_key, $export_columns ) ) {
				unset( $headings[ $col_key ] );
			}
		}
	}

  	//Suppression du champ courril confirmation (formulaire 18)
	if ( $form_id == 18 ) {
		$export_columns = array( 244 );
		foreach ( $headings as $col_key => $data ) {
			if ( in_array( $col_key, $export_columns ) ) {
				unset( $headings[ $col_key ] );
			}
		}
	}

    	//Suppression du champ courril confirmation (formulaire 23)
	if ( $form_id == 23 ) {
		$export_columns = array( 425 );
		foreach ( $headings as $col_key => $data ) {
			if ( in_array( $col_key, $export_columns ) ) {
				unset( $headings[ $col_key ] );
			}
		}
	}
  return $headings;

  }

/**
 * Rassemblement des colonnes "Lieu"
 */

add_filter( 'frm_csv_row', 'conservatoire_frm_csv_row' );
function conservatoire_frm_csv_row( $row, $params )
{
	$lieux = array(
		540, 541, 542, 543, 544, 545, 546, 547, 548, 549, 550, 551,
		559, 561, 562, 563, 564, 565, 566, 567, 568, 569, 570, 571, 572, 573, 574, 575, 576, 577, 578, 579, 580, 581, 582, 583, 584, 585, 586, 587, 588, 589, 590
	);
	foreach ( $lieux as $col_id )
		if ( isset( $row[$col_id] ) && $row[$col_id] )
			$row['lieu'] = $row[$col_id];

	return $row;
}


function get_custom_field($custom_field) {
	global $post;

	$custom = get_post_custom($post->ID);

	if (isset($custom[$custom_field])) {
		return $custom[$custom_field][0];
	}
}



function save_custom_field($custom_field) {
	global $post;

	if(isset($_POST[$custom_field])) {
		update_post_meta($post->ID, $custom_field, $_POST[$custom_field]);
	}
}

require get_template_directory() . '/custom/location.php';
require get_template_directory() . '/custom/programme.php';
require get_template_directory() . '/custom/teachers.php';
require get_template_directory() . '/custom/agenda.php';
// require get_template_directory() . '/custom/program_data.php';
require get_template_directory() . '/custom/_disable-abilities.php';
require get_template_directory() . '/custom/_post-meta.php';
require get_template_directory() . '/custom/address.php';
require get_template_directory() . '/custom/zones.php';
require get_template_directory() . '/custom/inscriptions.php';
// require get_template_directory() . '/custom/import_inscriptions.php';
require get_template_directory() . '/custom/bookings.php';

/* Theme Supports*/
add_theme_support( 'post-thumbnails' );
function max_title_length( $title ) {
$max = 25;
if( strlen( $title ) > $max ) {
return substr( $title, 0, $max ). " &hellip;";
} else {
return $title;
}
}






/*
 *! Rename the "Posts" to "News"
 */
function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Articles';
    $submenu['edit.php'][5][0] = 'Articles';
    $submenu['edit.php'][10][0] = 'Ajouter';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Articles';
    $labels->singular_name = 'Articles';
    $labels->add_new = 'Ajouter';
    $labels->add_new_item = 'Ajouter';
    $labels->edit_item = 'Modifier Articles';
    $labels->new_item = 'Articles';
    $labels->view_item = 'Voir Articles';
    $labels->search_items = 'Rechercher Articles';
    $labels->not_found = 'Aucun résultat';
    $labels->not_found_in_trash = 'Aucun résultat';
    $labels->all_items = 'All Articles';
    $labels->menu_name = 'Articles';
    $labels->name_admin_bar = 'Articles';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );



function wf_version(){
  return '1.2.4';
}



/*Theme Stylesheets*/
function theme_styles() {
	/*Main Stylesheet*/
    $tdu =  get_template_directory_uri();
	wp_enqueue_style( 'bootstrap-sass', $tdu . '/bower_components/bootstrap-sass/assets/stylesheets/bootstrap.css' );
	/*Main Stylesheet*/

    wp_register_style('wf_style', $tdu . '/style.css', array(), wf_version(),  'all');
    wp_enqueue_style('wf_style'); // Enqueue it!
    wp_register_style('cpmdt-print', $tdu . '/cpmdt-print.css', array(), wf_version(),  'all');
    wp_enqueue_style('cpmdt-print'); // Enqueue it!


}
add_action( 'wp_enqueue_scripts', 'theme_styles' );



/* Theme Supports*/
add_theme_support( 'post-thumbnails' );
add_image_size('large', 1600, '', true); // Large Thumbnail
add_image_size('medium', 800, '', true); // Medium Thumbnail
add_image_size('small', 400, '', true); // Small Thumbnail
add_image_size('tiny', 30, 30, true); // Tiny Thumbnail // used for checking brightness
add_image_size('square', 200, 200, true); // Custom Thumbnail Size call using


/*Theme Javascript*/
function theme_js() {
	/*Main JS*/
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js', array('jquery'), '', true );
	/*Main JS*/

	wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), '', true );
	// wp_enqueue_script( 'matchheight', get_template_directory_uri() . '/js/matchHeight.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'underscore', get_template_directory_uri() . '/js/underscore.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'theme_js' );





/*Theme Menus*/
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'prenav-menu' => __( 'Pre Navigation Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );





function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');





/*Theme Widgets i.e Sidebars*/
function create_widget( $name, $id, $description ) {
	register_sidebar(array(
		'name' => __( $name ),
		'id' => $id,
		'description' => __( $description ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

}
create_widget( 'Footer Left Sidebar', 'footer-1', 'Display a menu in the Footer left sidebar, first column.' );
create_widget( 'Footer Center Sidebar', 'footer-2', 'Display a menu in the Footer left sidebar, second column.' );




add_filter('tc_show_post_metas' , 'display_metas_on_home');
function display_metas_on_home( $bool ) {
    return  tc__f('__is_home') ? true : $bool;
}




/*Theme Customizer*/
function edonrexhepi_logo_customizer( $wp_customize ) {
	/* Header Section*/
	$wp_customize->add_section( 'logo-section' , array(
		'title' => __( 'Header modify', 'edonrexhepi' ),
		'priority' => 30,
		'description' => 'Upload your logo, partners logo on the PRENAV section <br> and the other links for Contact Page and Private Page.',
	) );
		/*Logo Upload*/
		$wp_customize->add_setting( 'er-logo_change' );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'er-logo_change', array(
			'label' => __( 'Logo', 'edonrexhepi' ),
			'section' => 'logo-section',
			'settings' => 'er-logo_change',
		) ) );


	/* Footer Section*/
	$wp_customize->add_section( 'footer-section' , array(
		'title' => __( 'Footer modify', 'edonrexhepi' ),
		'priority' => 30,
		'description' => 'Change <i>Social Media</i> links on the footer. ',
	) );
		/*Facebook LINK*/
		$wp_customize->add_setting( 'er-facebook' );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'er-facebook', array(
			'label' => __( '(Link) Facebook', 'edonrexhepi' ),
			'section' => 'footer-section',
			'settings' => 'er-facebook',
		) ) );
		/*Instagram LINK*/
		$wp_customize->add_setting( 'er-insta' );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'er-insta', array(
			'label' => __( '(Link) Instagram', 'edonrexhepi' ),
			'section' => 'footer-section',
			'settings' => 'er-insta',
		) ) );
		/*Youtube LINK*/
		$wp_customize->add_setting( 'er-youtube' );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'er-youtube', array(
			'label' => __( '(Link) Youtube', 'edonrexhepi' ),
			'section' => 'footer-section',
			'settings' => 'er-youtube',
		) ) );

}; add_action('customize_register', 'edonrexhepi_logo_customizer');






/*Limit excerpt to 17*/
function custom_excerpt_length( $length ) {
	return 23;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );






/*Modify excerpt 'MORE' text and replace it with plain HTML*/
function change_excerpt_more(){
  function new_excerpt_more($more)
    {
    // Use .read-more to style the link
    //   return '<a href="' . get_permalink() . '">LIRE LA SUITE</a>';
    }
  add_filter('excerpt_more', 'new_excerpt_more');
}
add_action('after_setup_theme', 'change_excerpt_more');









add_action( 'pre_get_posts', 'change_sort_order' );
function change_sort_order(&$query){
    if (isset($_POST['cs_action']) && $_POST['cs_action'] == 'custom_sort_order'){
        global $wp;
        if (isset($wp->query_vars["CU_Order"])){
            $query->set( 'order', $wp->query_vars["CU_Order"] );
        }
    }
}
add_filter('query_vars', 'add_custom_order_query_vars');
function add_custom_order_query_vars($vars) {
    // add CU_Order to the valid list of variables
    $new_vars = array('CU_Order');
    $vars = $new_vars + $vars;
    return $vars;
}










/*
 * While we're editing a post with type of "Document(In this case)"
 * hide the Media Button
 */
function wpse_78595_hide_editor() {
    global $current_screen;

    if( $current_screen->post_type == 'document' ) {
        $css = '<style type="text/css">';
            $css .= '#wp-content-media-buttons { display: none; }';
        $css .= '</style>';

        echo $css;
    }
}
add_action('admin_footer', 'wpse_78595_hide_editor');





/*
 * Creating a shortcode
 * with a loop inside of custom post type
 */
function posts_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'perpage' => 2
    ), $atts ) );
    $output = '<div class="posts-row row">';
    $args = array(
        'posts_per_page' => $perpage,
        'sort_column'   => 'menu_order'
    );
    $andrew_query = new  WP_Query( $args );
    while ( $andrew_query->have_posts() ) : $andrew_query->the_post();
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

		$output .= '<div class="col-sm-6 col-xs-12"'.
					'<h4></h4>'.
					'<h4>'. get_the_title() .'</h4>'.
					'<img src="'. $image[0]. '" alt="" />'.
					'<p>'. get_the_excerpt(). '</p>'.
					'<a class="read-more" href="'.
					get_permalink().
					'">LIRE LA SUITE</a></div>';
    endwhile;
    wp_reset_query();
    $output .= '</div>';
    return $output;
}
add_shortcode('frontpage-posts', 'posts_shortcode');


function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">LIRE LA SUITE</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

function get_program_data($id){
	global $wpdb;
	$sql = "SELECT wp_program_data.*,  wp_posts.post_title FROM wp_program_data
				INNER JOIN wp_posts ON wp_program_data.location_id = wp_posts.id
				WHERE wp_program_data.program_id = ".$id." ORDER BY post_title ASC";
	$results = $wpdb->get_results($sql, OBJECT);

	$items = array();
	$sql = "SELECT * FROM wp_posts WHERE id = ".$id;
	$p_name = $wpdb->get_results($sql, OBJECT);

	foreach($results as $result){
		$t_ids = json_decode($result->teacher_id);
		$teacher_ids = implode(",", $t_ids);

		$item = array();
		$item['program']  = $p_name[0]->post_title;
		$item['location'] = $result->post_title;

		$teachers_name = '';
		$sql = "SELECT * FROM wp_posts WHERE id IN ($teacher_ids) ORDER BY post_title ASC";
		$teachers = $wpdb->get_results($sql, OBJECT);
		for($i=0; $i < count($teachers); $i++){
			if($i > 0){
				$teachers_name .= '<br>';
			}
			$teachers_name .= $teachers[$i]->post_title;
		}
		$item['teachers'] = $teachers_name;

		array_push($items, $item);
	}
	return $items;
}


function get_agenda_count($field_id, $agenda_id, $count_field){
	global $wpdb;
	$sql = "SELECT item_id FROM wp_frm_item_metas
				WHERE field_id = ".$field_id
				." AND meta_value = ".$agenda_id;
	$items = $wpdb->get_results($sql, OBJECT);
	if(count($items) > 0){
		$output = array_map(function ($object) { return $object->item_id; }, $items);
		$item_ids = implode(', ', $output);

		$sql = "SELECT SUM(meta_value) as 'sum' FROM wp_frm_item_metas
					WHERE field_id = 70
					AND item_id IN ($item_ids) ";
		$results = $wpdb->get_results($sql, OBJECT);

		return $results[0]->sum;
	}
	return 0;

}


// Removes from admin menu
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
    //remove_menu_page( 'tools.php' );
}
// Removes from post and pages
add_action('init', 'remove_comment_support', 100);
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}
// Removes from admin bar
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

function get_address($agenda_id){
	global $wpdb;
  $sql = "SELECT * FROM wp_postmeta
  					INNER JOIN wp_posts ON wp_posts.id = wp_postmeta.post_id
  					WHERE wp_postmeta.meta_key = 'address_id'
  					AND  wp_posts.id = {$agenda_id} LIMIT 1";
  $result = $wpdb->get_results($sql, OBJECT);
  if(isset($result[0])){
	$sql2 = "SELECT * FROM wp_posts WHERE wp_posts.id = {$result[0]->meta_value}";
	$address = $wpdb->get_results($sql2, OBJECT);
	$post_meta = get_post_meta($address[0]->ID);

	$arr = array();
	$arr['short_address'] = $post_meta['a_shortaddress'][0];
	$arr['long_address'] = $post_meta['a_longaddress'][0];

	return $arr;
  }
}

// function set_post_order_in_admin( $wp_query ) {
// 	if ( is_admin() ){
// 		$post_type = $_GET['post_type'];
// 		if($post_type == 'address' || $post_type == 'teacher' || $post_type == 'programme'  || $post_type == 'location' || $post_type = 'agenda'){
// 			$wp_query->set( 'orderby', 'title' );
// 			$wp_query->set( 'order', 'ASC' );
// 		}
// 	}
// }
// add_filter('pre_get_posts', 'set_post_order_in_admin' );

// Register datepicker ui for properties
function admin_agenda_javascript(){
    global $post;
    if ($post) {
        if($post->post_type == 'agenda' && is_admin()) {
            wp_enqueue_script('jquery-ui-datepicker', WP_CONTENT_URL . '/themes/conservatoire-populaire/datepicker/jquery-ui.js');
        }
    }
}
add_action('admin_print_scripts', 'admin_agenda_javascript');

// Register ui styles for properties
function admin_agenda_styles(){
    global $post;
    if ($post) {
        if($post->post_type == 'agenda' && is_admin()) {
            wp_enqueue_style('jquery-ui', WP_CONTENT_URL . '/themes/conservatoire-populaire/datepicker/jquery-ui.css');
        }
    }
}
add_action('admin_print_styles', 'admin_agenda_styles');




function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  // add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );



function thumbnail_of_post_url( $post_id,  $size='large'  ) {

     $image_id = get_post_thumbnail_id(  $post_id );
     $image_url = wp_get_attachment_image_src($image_id, $size  );
     $image = $image_url[0];
     return $image;

}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}



function remove_events_from_search( $wp_query ) {
	if ( is_search() && !is_admin() ){
		global $wp_query;
        $wp_query->set( 'post_type', array('page',  'programme') );
        $wp_query->set( 'order', 'DESC' );
        $wp_query->set( 'orderby',  'type' );
        $wp_query->set( 'posts_per_page',  -1 );
	}
}
add_filter('pre_get_posts', 'remove_events_from_search' );



require get_template_directory() . '/custom/archivedposttype.php';


/// PAGE TO ALLOW ADMINS TO CHANGE TEXT INSIDE INSCRIPTION EMAILS
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Textes emails',
        'menu_title'	=> 'Textes emails',
        'menu_slug' 	=> 'email_settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

}



function sort_times_by_location($a, $b) {
    return strnatcmp($a['location']->post_title, $b['location']->post_title);
}
function sort_teachers_by_title($a, $b) {
    return strnatcmp($a->post_title, $b->post_title);
}


function chilly_map( $atts, $content = null ) {

    $attributes = shortcode_atts( array(
        'title' => "Conservatoire populaire de musique, danse et théâtre",
        'lat' => 46.1971525,
        'lng' => 6.1511941,
    ), $atts );


    $title = $attributes['title'];
    $lat = $attributes['lat'];
    $lng = $attributes['lng'];
    $chilly_map = '<div style="height:450px" id="single_location_map"></div>';
    $chilly_map .= '<script>
            var single_location_for_map = {"title": "' .  $title .   '","lat":' . $lat. ',"lng":' . $lng . ',"id":0, "default_style" : true };
            var theme_directory = "' .   get_template_directory_uri() . '";
        </script>';
    return $chilly_map;

}
add_shortcode( 'chilly_map', 'chilly_map' );


function  use_new_age_range() {
    return true;
}


?>
