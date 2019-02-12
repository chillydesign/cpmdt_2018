<?php
		global $wpdb;

/*
 *! Creating the "Programs" custom post type*/

		// register a custom post type called 'Programme'
		function post_type_programme() {
		    $labels = array(
		        'name' => __( 'Cours' ),
		        'singular_name' => __( 'Cours' ),
		        'add_new' => __( 'Nouveau Cours' ),
		        'add_new_item' => __( 'Nouveau Cours' ),
		        'edit_item' => __( 'Modifier Cours' ),
		        'new_item' => __( 'Nouveau Cours' ),
		        'view_item' => __( 'Voir Cours' ),
		        'search_items' => __( 'Rechercher Cours' ),
		        'not_found' =>  __( 'Aucun résultat' ),
		        'not_found_in_trash' => __( 'Aucun résultat' ),);
		    $args = array(
		        'labels' => $labels,
		        'public' => true,
		        'publicly_queryable' => true,
		        'supports' => array(
                'title',
                'thumbnail',
                'editor',
            ),
		        'show_ui' => true,
		        'query_var' => true,
				'menu_position' => null,
		        'rewrite' => true,
		        'capability_type' => 'post',
		        'hierarchical' => true,
						'map_meta_cap' => true,
		        'menu_icon' => 'dashicons-media-spreadsheet',
		        'supports' => array('title','editor','thumbnail', 'page-attributes'));

		    register_post_type( 'programme', $args );
		}
		add_action( 'init', 'post_type_programme' );

		// Taxonomy
		register_taxonomy( "programmes",
			array( 	"programme" ),
			array( 	"hierarchical" => true,
					"labels" => array('name'=>"Categories",'add_new_item'=>"Add a new category"),
					"singular_label" => __( "Field" ),
					"rewrite" => array( 'slug' => 'programmes', 'with_front' => false)
				)
		);

        // WHICH COURSE IS IN WHICH INSCRIPTION FORM
        register_taxonomy( "inscriptionform",
            array( 	"programme" ),
            array( 	"hierarchical" => true,
                    "labels" => array('name'=>"Formulaire d'inscription"),
                    "rewrite" => array( 'slug' => 'programmes', 'with_front' => false)
                )
        );


		// Adding the metabox
        // TODO remove this at some point, been replaced by ACF
		add_action("admin_init", "programs_admin_init");

		function programs_admin_init(){
			add_meta_box("programme_meta", "Programme informations", "programs_details_meta", "programme", "normal", "default");
			add_meta_box("programme_meta2", "Programme autres informations", "programs_age_meta", "programme", "normal", "default");
		}
		function programs_age_meta() {

            $p_age = get_custom_field("p_age");
            $p_age2 = get_custom_field("p_age2");
			 $ret = '
				</br>
				<select name="p_age" id="p_age">';
					for($i = 4; $i < 26; $i++){
						$ret .= '<option value="'.$i.'" '.checkSelected($i, $p_age).'>'.$i.' Ans</option>';
					}
				$ret .= '</select>
					';
			$ret .= '
				</br>
                <select name="p_age2" id="p_age2">';

                        if( $p_age == '' || $p_age == null){
                            $p_age = 4;
                        }

						for($i = $p_age + 1 ; $i < 70; $i++){
							$ret .= '<option value="'.$i.'" '.checkSelected($i, $p_age2).'>'.$i.' Ans</option>';
						}
                        $ret .= '</select>';


				$ret .= '<p><label for="p_starlink">Lien cours complémentaire: </label><br/><input style="width:50%;" type="text" size="70" placeholder="" id="p_starlink" name="p_starlink" value="' . get_custom_field("p_starlink") . '" /></p>';
				$ret .= '<p><label for="p_notifications">Informations du programme: </label><br/><textarea style="width:50%;" id="p_notifications" name="p_notifications">' . get_custom_field("p_notifications") . '</textarea></p>';
				$ret .= '<p><label for="p_related">A découvrir aussi:<small style="display: block;">Please use <span style="background-color:#eee;padding:3px 5px;">HTML</span> tags.</small> </label><textarea style="width:50%;" id="p_related" name="p_related">' . get_custom_field("p_related") . '</textarea></p>';
				$ret .= '<p><label for="p_inscription">Inscription:<br> </label><input style="width:50%;" id="p_inscription" name="p_inscription" value="' . get_custom_field("p_inscription") . '"/></p>';
		    echo $ret;
		}

		function checkSelected($value, $db_value){
			if($value == $db_value)
				return 'selected';
			return '';
		}

		// Inside metabox
		// Custom fields
		function teachers(){
			global $wpdb;
			$sql = "SELECT * FROM wp_posts WHERE post_type = 'teacher' AND post_status = 'publish' ORDER BY post_title ASC";
			$result = $wpdb->get_results($sql, OBJECT);

			return $result;
		}

		function locations(){
			global $wpdb;
			$sql = "SELECT * FROM wp_posts WHERE post_type = 'location' AND post_status = 'publish' ORDER BY post_title ASC";
			$result = $wpdb->get_results($sql, OBJECT);

			return $result;
		}
		// Display the boxes
		function programs_details_meta() {
			$teachers = teachers();
			$locations = locations();
			$p_teachers = maybe_unserialize(get_custom_field('p_teacher'));
			$p_locations = maybe_unserialize(get_custom_field('p_location'));
			 $ret = '<div style="overflow: hidden; width: 100%;">
				 <select disabled style="width:49%; float: left; min-height: 300px;" multiple name="p_teacher[]" id="">';
				foreach($teachers as $teacher){
					if(count($p_teachers) > 0 && in_array($teacher->ID, $p_teachers)){
						$ret .= '<option value="'.$teacher->ID.'" selected>'.$teacher->post_title.'</option>';
					}else{
						$ret .= '<option value="'.$teacher->ID.'">'.$teacher->post_title.'</option>';
					}
				}
				$ret .= '</select>';
			 $ret .= '<select disabled style="width:49%; float: left; min-height: 300px;" multiple name="p_location[]" id="">';
				 foreach($locations as $location){
					if(count($p_locations) > 0 && in_array($location->ID, $p_locations)){
						$ret .= '<option value="'.$location->ID.'" selected>'.$location->post_title.'</option>';
					}else{
						$ret .= '<option value="'.$location->ID.'">'.$location->post_title.'</option>';
					}
				 }
				 $ret .='</select></div>';

		    echo $ret;
		}

		// Save the changes
		add_action('save_post', 'save_programs_details');
		function save_programs_details(){
		   	global $post;

		   	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		      	return;

		   	if(get_post_type($post) != 'programme')
		      	return;

		   	save_custom_field("p_teacher");
		   	save_custom_field("p_location");
			save_custom_field("p_age");
			save_custom_field("p_age2");
			save_custom_field("p_starlink");
			save_custom_field("p_notifications");
			save_custom_field("p_related");
			save_custom_field("p_inscription");

		}
		// Fileuploader 1
		require get_template_directory() . '/custom/metaboxes/fileuploader1.php';
		require get_template_directory() . '/custom/metaboxes/fileuploader2.php';
?>
