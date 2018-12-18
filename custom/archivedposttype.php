<?php
function rudr_custom_status_creation(){
    register_post_status( 'archived', array(
		'label'                     => _x( 'Archivé', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => false,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Archivé <span class="count">(%s)</span>', 'Archivé <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'rudr_custom_status_creation' );

add_action('admin_footer-edit.php','rudr_status_into_inline_edit');

function rudr_status_into_inline_edit() { // ultra-simple example
	echo "<script>
	jQuery(document).ready( function() {
		jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"archived\">Archivé</option>' );
	});
	</script>";
}
function rudr_display_status_label( $statuses ) {
	global $post; // we need it to check current post status
	if( get_query_var( 'post_status' ) != 'archived' ){ // not for pages with all posts of this status
		if( $post->post_status == 'archived' ){ // если статус поста - Архив
			return array('Archivé'); // returning our status label
		}
    }
	return $statuses; // returning the array with default statuses
}

add_filter( 'display_post_states', 'rudr_display_status_label' );


add_filter('pre_get_posts', 'chilly_hide_archived_posts');
function chilly_hide_archived_posts($query) {
    if ( is_admin() && $query->is_main_query() ) {
        if( get_query_var( 'post_status' ) != 'archived' ){ // not for pages with all posts of this status
            $query->set( 'post_status', array('publish', 'pending', 'draft') );
        }

  }
}

?>
