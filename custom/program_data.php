<?php
		// register a custom post type called ' Connections '
		function post_type_programdata() {
		    $labels = array(
		        'name' => __( 'Programdata' ),
		        'singular_name' => __( 'Programdata' ),
		        'add_new' => __( 'New Programdata' ),
		        'add_new_item' => __( 'Add New Programdata' ),
		        'edit_item' => __( 'Edit Programdata' ),
		        'new_item' => __( 'New Programdata' ),
		        'view_item' => __( 'View Programdata' ),
		        'search_items' => __( 'Search Programdata' ),
		        'not_found' =>  __( 'No Programdata Found' ),
		        'not_found_in_trash' => __( 'No Programdata found in Trash' ),);
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
		        'rewrite' => true,
		        'capability_type' => 'post',
		        'hierarchical' => false,
		        'menu_position' => null,
						'map_meta_cap' => true, 
				'menu_icon' => 'dashicons-networking',
				// Do not allow more than 1 post creations
				'capabilities' => array(
						'create_posts' => 'do_not_allow',
						),
							'map_meta_cap' => true,
						'capability_type' => 'post',
		        'supports' => array(''));

		    register_post_type( 'programdata', $args );
		}
		add_action( 'init', 'post_type_programdata' );

		


		// Metabox
		function programdata_admin_init(){
		  add_meta_box("programdata_meta", "Program Information", "programdata_details_meta", "programdata", "normal", "default");
		  add_meta_box("programdata_insert", "Connections", "programdata_connections", "programdata", "normal", "default");
		}
		add_action("admin_init", "programdata_admin_init");

		function c_programs(){
			global $wpdb;
			$sql = "SELECT * FROM wp_posts WHERE post_type = 'programme' AND post_status = 'publish' ORDER BY post_title ASC";
			$result = $wpdb->get_results($sql, OBJECT);

			return $result;
		}

		function programdata_details_meta() {
			$programs = c_programs();
			 $ret = '
				 <select name="p_programs" id="program-id">';
				 foreach($programs as $program){
					$ret .= '<option value="'.$program->ID.'">'.$program->post_title.'</option>';
				 }
				$ret .= '</select>
				
				 <br><br>';
				 $ret .= '
					<div class="delete-confirmation" style="display: none;">
						Are you sure you want to delete?<br/>
						<button type="button" class="button-remove" id="btn-cancel">Cancel</button>
						<button type="button" class="button-confirm" id="btn-approve">Remove</button>
						<input type="hidden" id="connection-id">
					</div>
				 ';
			
		    echo $ret;
			echo '

				 
				<table id="program-data" class="wp-list-table widefat fixed striped">
				<thead>
					<tr> 
						<th>Program</th>
						<th>Location</th>
						<th>Teacher</th>
						<th>Actions</th>
					</tr>
				</thead>';

			
			echo 	'<tbody>
				 
					</tbody>
				</table>';

			echo '
			<style> 
				.post-type-programdata #side-sortables{display: none;} 
			</style>';		    
		}

		function programdata_connections(){
			$programs = c_programs();
			echo '<select name="p_programs" id="program-connection-add">';
				echo '<option value="-1">Program</option>';
				foreach($programs as $program){
					echo'<option value="'.$program->ID.'">'.$program->post_title.'</option>';
				}
			echo '</select>';
			echo '<select id="program-locations"><option value="-1">Location</option></select>';
			echo '<select multiple id="program-teachers"><option value="-1">Teacher</option></select>';
			echo '<br>';
			echo '<button type="button" class="button button-primary button-large" id="save-connection">Save</button>';			
		}
?>