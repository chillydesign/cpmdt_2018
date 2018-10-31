<?php 
	// Remove the view action for the Teachers and Programdata custom type
	add_filter( 'post_row_actions', 'mycustomtheme_remove_myposttype_row_actions' );
	function mycustomtheme_remove_myposttype_row_actions( $action ){
		if (get_post_type() == 'programdata' || get_post_type() == 'teacher' ){
			unset($action['view']);
		}
		return $action;
	}


	// Remove the trash action from the Programdata custom type
	add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id, $args ){
		if( 'delete_post' !== $cap || empty( $args[0] ) )
			return $caps;
		if( in_array( get_post_type( $args[0] ), [ 'programdata' ], true ) )
			$caps[] = 'do_not_allow';       

		return $caps;    
	}, 10, 4 );
?>