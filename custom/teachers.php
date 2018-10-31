<?php
		// register a custom post type called 'teacher'
		function post_type_teacher() {
		    $labels = array(
		        'name' => __( 'Professeurs' ),
		        'singular_name' => __( 'Professeur' ),
		        'add_new' => __( 'Ajouter' ),
		        'add_new_item' => __( 'Ajouter' ),
		        'edit_item' => __( 'Modifier Professeur' ),
		        'new_item' => __( 'Ajouter' ),
		        'view_item' => __( 'Voir professeur' ),
		        'search_items' => __( 'Rechercher professeur' ),
		        'not_found' =>  __( 'Aucun résultat' ),
		        'not_found_in_trash' => __( 'Aucun résultat' ),);
		    $args = array(
		        'labels' => $labels,
		        'public' => false,
		        'publicly_queryable' => true,
		        'supports' => array(
                'title',
                'thumbnail',
                'editor',
            ),
		        'show_ui' => true,
		        'query_var' => true,
		        'rewrite' => true,
		        'capability_type' => 'post',
		        'hierarchical' => false,
		        'menu_position' => null,
				'map_meta_cap' => true, 
		        'menu_icon' => 'dashicons-businessman',
		        'supports' => array('title'));

		    register_post_type( 'teacher', $args );
		}
		add_action( 'init', 'post_type_teacher' );


		// Create the meta box
		add_action("admin_init", "teachers_admin_init");
		function teachers_admin_init(){
		  add_meta_box("teachers_meta", "Professeurs informations", "teachers_details_meta", "teacher", "normal", "default");
		}
		// Display the boxes
		function teachers_details_meta() {
		 	$ret = '<p><label for="phone_1">Téléphone 1: </label><br/><input style="width:50%" type="text" size="70" placeholder="" id="phone_1" name="phone_1" value="' . get_custom_field("phone_1") . '" /></p>';
		 	$ret .= '<p><label for="phone_2">Téléphone 2: </label><br/><input style="width:50%" type="text" size="70" placeholder="" id="phone_2" name="phone_2" value="' . get_custom_field("phone_2") . '" /></p>';
		 	$ret .= '<p><label for="email_1">Email: </label><br/><input style="width:50%" type="text" size="70" placeholder="" id="email_1" name="email_1" value="' . get_custom_field("email_1") . '" /></p>';
		 	$ret .= '<p><label for="website_1">Www: </label><br/><input style="width:50%" type="text" size="70" placeholder="" id="website_1" name="website_1" value="' . get_custom_field("website_1") . '" /></p>';
		 	$ret .= '<p><label for="description_1">Description: </label><br/><textarea rows="5" style="width:50%" placeholder="" id="description_1" name="description_1">' . get_custom_field("description_1") . '</textarea></p>';
		    
		    echo $ret;
		}

		// Save the changes
		add_action('save_post', 'save_teachers_details');
		function save_teachers_details(){
		   	global $post;
		 
		   	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		      	return;

		   	if(get_post_type($post) != 'teacher')
		      	return;
		 
		   	save_custom_field("phone_1");
		   	save_custom_field("phone_2");
		   	save_custom_field("email_1");
		   	save_custom_field("website_1");
		   	save_custom_field("description_1");
		}
?>