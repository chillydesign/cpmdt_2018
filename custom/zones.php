<?php


		add_action( 'init', 'post_type_zone' );


function post_type_zone() {



    register_post_type('zone', // Register Custom Post Type
    array(
        'labels' => array(
            'name' => __('Zones', 'chillydesign'), // Rename these to suit
            'singular_name' => __('Zone', 'chillydesign'),
            'add_new' => __('Ajouter', 'chillydesign'),
            'add_new_item' => __('Nouvelle Zone', 'chillydesign'),
            'edit' => __('Modifier', 'chillydesign'),
            'edit_item' => __('Modifier Zone', 'chillydesign'),
            'new_item' => __('Ajouter Zone', 'chillydesign'),
            'view' => __('Afficher Zone', 'chillydesign'),
            'view_item' => __('Afficher Zone', 'chillydesign'),
            'search_items' => __('Chercher Zones', 'chillydesign'),
            'not_found' => __('Aucune Zone trouvée', 'chillydesign'),
            'not_found_in_trash' => __('Aucune Zone trouvée dans la Corbeille', 'chillydesign')
        ),
        'public' => true,
        'exclude_from_search' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'excerpt'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            // 'post_tag',
            // 'category'
        ) // Add Category and Post Tags support
    ));

}







function import_old_program_data() {
    global $wpdb;
    $times_field = 'field_5bd9eb6eb77d4'; // acf id for times field
    $sql = "SELECT * FROM wp_program_data ";
    $rows = $wpdb->get_results($sql, OBJECT);

    foreach ($rows as $row) :

        $post_id = intval($row->program_id);
        $location_id = $row->location_id;
        $teacher_ids = json_decode($row->teacher_id);

        $time = array(
            'teachers' =>  serialize($teacher_ids)  ,
            'location' => intval($location_id)
        );

        // add rows to repeater if it exists
        if (have_rows( $times_field , $post_id)) :
            $i = add_row('times',  $time, $post_id  );
            var_dump('add additional row');
        else:  # if not have any rows yet, need to create the field
            $i = update_field( $times_field,  array($time), $post_id  );
            var_dump('add first row');
        endif;

    endforeach;


}






?>
