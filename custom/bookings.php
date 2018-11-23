<?php



add_action( 'init', 'post_type_booking' );

// GET POSTED DATA FROM FORM
// TO DO REMAME FUNCTION
add_action( 'admin_post_nopriv_booking_form',    'save_booking_form'   );
add_action( 'admin_post_booking_form',  'save_booking_form' );

// ALLOW BOOKING FORM TO BE ADDED AS A SHORTCODE
add_shortcode( 'booking_form',  'booking_form_shortcode' );


function post_type_booking() {
    register_post_type('booking', // Register Custom Post Type
    array(
        'labels' => array(
            'name' => __('Bookings', 'html5blank'), // Rename these to suit
            'singular_name' => __('Booking', 'html5blank'),
            'add_new' => __('Ajouter', 'html5blank'),
            'add_new_item' => __('Ajouter booking', 'html5blank'),
            'edit' => __('Modifier', 'html5blank'),
            'edit_item' => __('Modifier Booking', 'html5blank'),
            'new_item' => __('Nouvelle booking', 'html5blank'),
            'view' => __('Afficher insc', 'html5blank'),
            'view_item' => __('Afficher booking', 'html5blank'),
            'search_items' => __('Chercher booking', 'html5blank'),
            'not_found' => __('Aucune booking trouvée', 'html5blank'),
            'not_found_in_trash' => __('Aucune booking trouvée dans la crobeille', 'html5blank')
        ),
        'public' => true,
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-tickets-alt',
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            // 'editor',
            'title'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            // 'post_tag',
            // 'category'
        ) // Add Category and Post Tags support
    ));



};




function all_booking_fields(){

    return array(

        'no_people' => 'Nombre de personne',
        'last_name' =>  'Nom',
        'first_name' => 'Prénom',
        'telephone' => 'Téléphone  ',
        'email' =>  'Email',

    );
}





    function save_booking_form() {

        $referer = $_SERVER['HTTP_REFERER'];
        $referer =  explode('?',   $referer)[0];

        // IF DATA HAS BEEN POSTED
        if ( isset($_POST['action'])  && $_POST['action'] == 'booking_form'   ) {


            $agenda_id = $_POST['agenda_id'];
            $agenda_title = $_POST['agenda_title'];

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $no_people = $_POST['no_people'];




            // if we  have the right data and user logged in
            //  && $current_user_id > 0
            if ( !empty($email)  && !empty($first_name) &&  !empty($last_name)  ) {
                $post = array(
                    'post_title'   => $first_name . ' ' . $last_name,
                    'post_status'  => 'publish',
                    'post_type'    => 'booking',
                    'post_content' => '',
                    'post_parent' =>  $agenda_id

                );


                // EDIT OR ADD NEW POST
                $new_booking = wp_insert_post( $post );

                // IF SUCCESS
                if ($new_booking > 0) {
                    // add email to ACF

                    $fields = all_booking_fields();
                    foreach ($fields as $field => $value ) {
                        if (isset($_POST[$field])){
                            add_post_meta($new_booking, $field,  $_POST[$field] , true);
                        }
                    }


                    // SEND EMAILS TO THE ADMIN AND THE PERSON WHO SUBMITTED
                    send_booking_emails( $_POST );



                    wp_redirect( $referer . '?success', $status = 302 );


                    // something went wrong with adding the booking post
                } else {
                    wp_redirect($referer . '?problem', $status = 302);
                }

                // if we dont have all the data or user not logged in
            } else {
                wp_redirect($referer . '?problem', $status = 302);
            }

            // if the form didnt post the action field
        } else {
            wp_redirect($referer . '?problem', $status = 302);
        }


    }



    function send_booking_emails($data){

        $agenda_title = $data['agenda_title'];

        $headers = 'From: Someone <no-reply@example.org>' . "\r\n";
        $headers .= 'Reply-To: Someone <no-reply@example.org>' . "\r\n";
        $emailheader = ''; // file_get_contents(dirname(__FILE__) . '/emails/email_header.php');
        $emailfooter = ''; // file_get_contents(dirname(__FILE__) . '/emails/email_footer.php');
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));



        $paragraph_for_admin = '<p>Nouvelle booking pour l’évènement '.  $agenda_title .'</p><br /><br />';
        $paragraph_for_admin .= '<p><b>Prénom</b> : ' . $data['first_name']. '</p>';
        $paragraph_for_admin .= '<p><b>Nom</b> : ' .$data['last_name'] . '</p>';
        $paragraph_for_admin .= '<p><b>Adresse électronique</b> ' . $data['email'] . '</p>';
        $paragraph_for_admin .= '<p><b>Telephone</b> : ' . $data['telephone'] . '</p>';
        $paragraph_for_admin .= '<p><b>No Personnes</b> : ' . $data['no_people'] . '</p>';

        $email_subject_for_admin = 'Nouvelle booking pour l’évènement ' . $agenda_title;
        $email_content_for_admin = $emailheader  . $paragraph_for_admin  . $emailfooter;
        wp_mail( 'harvey.charles@gmail.com' , $email_subject_for_admin, $email_content_for_admin, $headers );



        $paragraph_for_user = '<p>Bonjour,</p><p>Votre booking for ' . $data['no_people'] . ' people a bien été enregistrée pour l’évènement '.  $agenda_title . '</p><p>Bien cordialement, <br/> L’équipe PFTU</p>';
        $email_subject_for_user = 'Booking pour l’évènement  ' . $agenda_title;
        $email_content_for_user = $emailheader . $paragraph_for_user .  $emailfooter;

        wp_mail( $_POST['email'], $email_subject_for_user, $email_content_for_user, $headers );



        remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );



    }




function booking_meta_box_markup(){

    $download_link = get_home_url() . '/api/v1/?bookings&id=' . $_GET['post'] ;
    echo '<div class=" "><a style="display:block;text-align:center" class="action button-primary button" href="'. $download_link .'">Télécharger les bookings (csv)</a></div>';

}

function add_booking_meta_box() {
    add_meta_box("booking-meta-box", " Bookings", "booking_meta_box_markup", "agenda", "side", "high", null);
}

add_action("add_meta_boxes", "add_booking_meta_box");



function count_people_at_event($post_id) {
    global $wpdb;
    $sql = "SELECT ID FROM wp_posts
    WHERE `post_parent` = " .$post_id . " AND `post_type` LIKE 'booking' ";
    $items = $wpdb->get_results($sql, OBJECT);
    if(count($items) > 0){
        $booking_ids = array_map(function ($object) { return $object->ID; }, $items);
        $item_ids = implode(', ', $booking_ids);
        $sql = "SELECT SUM(meta_value) as 'sum' FROM wp_postmeta
        WHERE meta_key = 'no_people'
        AND post_id IN ($item_ids) ";
        $results = $wpdb->get_results($sql, OBJECT);

        return intval($results[0]->sum);
    }
    return 0;

}



function import_old_bookings_data() {
    global $wpdb;

    $sql = "SELECT * FROM wp_frm_items WHERE form_id = 10 ";
    $rows = $wpdb->get_results($sql, OBJECT);

    foreach ($rows as $row) :

        $old_booking_id = intval($row->id);
        $metas_sql = "SELECT wp_frm_item_metas.id, meta_value, name
                    FROM `wp_frm_item_metas`
                    LEFT JOIN wp_frm_fields ON wp_frm_fields.id = wp_frm_item_metas.field_id
                    WHERE `item_id` =  " . $old_booking_id;
        $metas = $wpdb->get_results($metas_sql, OBJECT);

        foreach ($metas as $old_meta) :
            if ( $old_meta->name == 'NOM' ) {
                $last_name = $old_meta->meta_value;
            } elseif ($old_meta->name == 'PRÉNOM') {
                $first_name = $old_meta->meta_value;
            } elseif ($old_meta->name == 'Événement ID') {
                $agenda_id = $old_meta->meta_value;
            } elseif ($old_meta->name == 'NOMBRE DE PERSONNE') {
                $no_people = $old_meta->meta_value;
            } elseif ($old_meta->name == 'ADRESSE ÉLECTRONIQUE') {
                $email = $old_meta->meta_value;
            } elseif ($old_meta->name == 'TÉL') {
                $telephone = $old_meta->meta_value;
            };


        endforeach;


        $post = array(
            'post_title'   => $first_name . ' ' . $last_name,
            'post_status'  => 'publish',
            'post_type'    => 'booking',
            'post_content' => '',
            'post_parent' =>  $agenda_id
        );
        $new_booking = wp_insert_post( $post );
        if ($new_booking) {
            add_post_meta($new_booking, 'first_name', $first_name , true);
            add_post_meta($new_booking, 'last_name', $last_name , true);
            add_post_meta($new_booking, 'telephone', $telephone , true);
            add_post_meta($new_booking, 'email', $email , true);
            add_post_meta($new_booking, 'no_people', $no_people , true);
            var_dump('added booking');
        };






    endforeach;


}






?>
