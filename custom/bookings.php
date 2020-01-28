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
            'name' => __('Réservations', 'html5blank'), // Rename these to suit
            'singular_name' => __('Réservation', 'html5blank'),
            'add_new' => __('Ajouter', 'html5blank'),
            'add_new_item' => __('Ajouter booking', 'html5blank'),
            'edit' => __('Modifier', 'html5blank'),
            'edit_item' => __('Modifier Réservation', 'html5blank'),
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

        'no_people' => 'Nombre de personnes',
        'last_name' =>  'Nom',
        'first_name' => 'Prénom',
        'telephone' => 'Téléphone',
        'email' =>  'Email',
        'last_name_2' => 'Nom de la deuxième personne',
        'first_name_2' => 'Prénom de la deuxième personne',
        'last_name_3' => 'Nom de la troisième personne',
        'first_name_3' => 'Prénom de la troisième personne',
        'last_name_4' => 'Nom de la quatrième personne',
        'first_name_4' => 'Prénom de la quatrième personne',
        'last_name_5' => 'Nom de la cinquième personne',
        'first_name_5' => 'Prénom de la cinquième personne',
    );
}





    function save_booking_form() {

        $referer = $_SERVER['HTTP_REFERER'];
        $referer =  explode('?',   $referer)[0];

        // IF DATA HAS BEEN POSTED
        if ( isset($_POST['action'])  && $_POST['action'] == 'booking_form'  && $_POST['agenda_id']  ) {


            $agenda_id = $_POST['agenda_id'];
            $agenda_title = $_POST['agenda_title'];

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $email_confirmation = $_POST['email_confirmation'];
            $no_people = intval($_POST['no_people']);




            // if we  have the right data and user logged in
            //  && $current_user_id > 0
            if ( !empty($email)  && !empty($first_name) &&  !empty($last_name)  ) {

                // if email equal to email_confirmation
                if ($email == $email_confirmation) {


                    $count_persons = count_people_at_event(  $agenda_id  );
                    $places_allowed = intval( get_field("a_amount" ,  $agenda_id ));
                    $places_left = $places_allowed - $count_persons;
                    // only allow booking if  have spaces for people
                    if ($places_left >= $no_people  ) {

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

                    } else { //not enough places left
                        wp_redirect($referer . '?problem=notenoughplaces', $status = 302);
                    }

                } else {  // if email not equal to email_confirmation
                    wp_redirect($referer . '?problem=emailconfirmation', $status = 302);
                } // end if email not equal to email_confirmation

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

        $agenda_id = $data['agenda_id'];
        $agenda = get_post( $agenda_id );
        $agenda_title = $agenda->post_title;
        $agenda_date_str = get_field('a_date', $agenda_id );
        $agenda_date = date( ' d M Y'  ,strtotime($agenda_date_str));
        $agenda_time = get_field('a_time', $agenda_id );
        $address_id =  get_field('address_id', $agenda_id );
        $address = get_post( $address_id  );
        $agenda_location = $address->post_title;


        $headers = 'From: Conservatoire populaire de musique, danse et théâtre <info@conservatoirepopulaire.ch>' . "\r\n";
        $headers .= 'Reply-To: Conservatoire populaire de musique, danse et théâtre <info@conservatoirepopulaire.ch>' . "\r\n";
        $emailheader = ''; // file_get_contents(dirname(__FILE__) . '/emails/email_header.php');
        $emailfooter = ''; // file_get_contents(dirname(__FILE__) . '/emails/email_footer.php');
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));



        $paragraph_for_admin = '<p>Nouvelle réservation pour l’évènement '.  $agenda_title .'</p><br /><br />';
        $paragraph_for_admin .= '<p><b>Prénom</b> : ' . $data['first_name']. '</p>';
        $paragraph_for_admin .= '<p><b>Nom</b> : ' .$data['last_name'] . '</p>';
        $paragraph_for_admin .= '<p><b>Adresse électronique</b> ' . $data['email'] . '</p>';
        $paragraph_for_admin .= '<p><b>Télephone</b> : ' . $data['telephone'] . '</p>';
        $paragraph_for_admin .= '<p><b>No Personnes</b> : ' . $data['no_people'] . '</p>';

        $email_subject_for_admin = 'Nouvelle réservation pour l’évènement ' . $agenda_title;
        $email_content_for_admin = $emailheader  . $paragraph_for_admin  . $emailfooter;
        wp_mail( 'info@conservatoirepopulaire.ch' , $email_subject_for_admin, $email_content_for_admin, $headers );



        $paragraph_for_user = '<p>Madame, Monsieur,</p>
        <p>Nous avons bien pris note de votre réservation pour ' . $data['no_people'] . '  personne(s) pour le spectacle '.  $agenda_title . ' le '. $agenda_date . ' à '. $agenda_time . ' au Conservatoire populaire - '. $agenda_location . '.</p>
        <p>Les contremarques seront à votre disposition à l’entrée 1 heure avant le spectacle.</p>
        <p> Si vous désirez annuler ou modifier votre réservation, veuillez, s’il vous plaît, écrire à: <a href="mailto:info@conservatoirepopulaire.ch">info@conservatoirepopulaire.ch</a></p>
        <p>Avec nos remerciements. <br />
        <br/> Conservatoire Populaire de musique danse et théâtre  <br />
        <a href="https://cpmdt.ch/">www.conservatoirepopulaire.ch</a>
        </p>';

        $email_subject_for_user = 'Réservation pour l’évènement  ' . $agenda_title;
        $email_content_for_user = $emailheader . $paragraph_for_user .  $emailfooter;
        wp_mail( $_POST['email'], $email_subject_for_user, $email_content_for_user, $headers );



        remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );



    }


add_action( 'manage_posts_extra_tablenav', 'add_download_link_booking'  );
function add_download_link_booking($which){
    if ( is_post_type_archive('booking') ) {

            $download_link = get_home_url() . '/api/v1/?bookings'  ;
            echo '<div class="alignleft actions"><a class="action button-primary button" href="'. $download_link .'">Télécharger CSV</a></div>';

    } else if (is_post_type_archive('agenda')) {
        $download_link = get_home_url() . '/api/v1/?agenda';
        echo '<div class="alignleft actions"><a style="margin:0" title="Télécharger" class="action button-primary button" href="'. $download_link . '"> <span style="position:relative;top:4px" class="dashicons dashicons-download"></span>Télécharger</a></div>';
          
    }

}

function booking_meta_box_markup(){
    $download_link = get_home_url() . '/api/v1/?bookings&id=' . $_GET['post'] ;
    echo '<div class=" "><a style="display:block;text-align:center" class="action button-primary button" href="'. $download_link .'">Télécharger les réservations (csv)</a></div>';
}
function add_booking_meta_box() {
    add_meta_box("booking-meta-box", " Réservations", "booking_meta_box_markup", "agenda", "side", "high", null);
}
add_action("add_meta_boxes", "add_booking_meta_box");



function count_people_at_event($post_id) {
    global $wpdb;
    // $sql = "SELECT ID FROM wp_posts
    // WHERE `post_parent` = " .$post_id . " AND `post_type` LIKE 'booking' ";
    // $items = $wpdb->get_results($sql, OBJECT);
    // if(count($items) > 0){
    //     $booking_ids = array_map(function ($object) { return $object->ID; }, $items);
    //     $item_ids = implode(', ', $booking_ids);
    //     $sql = "SELECT SUM(meta_value) as 'sum' FROM wp_postmeta
    //     WHERE meta_key = 'no_people'
    //     AND post_id IN ($item_ids) ";
    //     $results = $wpdb->get_results($sql, OBJECT);
    //     return intval($results[0]->sum);
    // }
    // return 0;

    // MORE EFFICIENT QUERY

    $sql = "SELECT SUM(meta_value) as 'sum' FROM wp_postmeta LEFT JOIN wp_posts ON wp_posts.ID = wp_postmeta.post_id WHERE wp_postmeta.meta_key = 'no_people' AND wp_posts.post_status = 'publish' AND wp_posts.post_type = 'booking' AND wp_posts.post_parent = " . $post_id ;
    $results = $wpdb->get_results($sql, OBJECT);
    return intval($results[0]->sum);


}



function import_old_bookings_data() {
    global $wpdb;

    $sql = "SELECT * FROM wp_frm_items WHERE form_id = 10 ";
    $rows = $wpdb->get_results($sql, OBJECT);

    foreach ($rows as $row) :

        $old_booking_id = intval($row->id);
        $metas_sql = "SELECT wp_frm_item_metas.id, meta_value, name, field_key
                    FROM `wp_frm_item_metas`
                    LEFT JOIN wp_frm_fields ON wp_frm_fields.id = wp_frm_item_metas.field_id
                    WHERE `item_id` =  " . $old_booking_id;
        $metas = $wpdb->get_results($metas_sql, OBJECT);


        $first_name  = '';
        $last_name  = '';
        $telephone  = '';
        $email  = '';
        $no_people  = '';
        $last_name_2 = '';
        $first_name_2 = '';
        $last_name_3 = '';
        $first_name_3 = '';
        $last_name_4 = '';
        $first_name_4 = '';
        $last_name_5 = '';
        $first_name_5 = '';


        foreach ($metas as $old_meta) :
            if ( $old_meta->field_key == 'qh4icy4' ) {
                $last_name = $old_meta->meta_value;
            } elseif ($old_meta->field_key == 'yhp42') {
                $first_name = $old_meta->meta_value;
            } elseif ($old_meta->name == 'Événement ID') {
                $agenda_id = $old_meta->meta_value;
            } elseif ($old_meta->name == 'NOMBRE DE PERSONNE') {
                $no_people = $old_meta->meta_value;
            } elseif ($old_meta->name == 'ADRESSE ÉLECTRONIQUE') {
                $email = $old_meta->meta_value;
            } elseif ($old_meta->name == 'TÉL') {
                $telephone = $old_meta->meta_value;
            } elseif ($old_meta->field_key == '7texl') {
                $last_name_2 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == 'ocfup14') {
                $first_name_2 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == '9cggx') {
                $last_name_3 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == 'chtgh') {
                $first_name_3 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == 'xbfqx') {
                $last_name_4 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == '28vai') {
                $first_name_4 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == 's6t5o') {
                $last_name_5 = $old_meta->meta_value;
            } elseif ($old_meta->field_key == 'urgnt') {
                $first_name_5 = $old_meta->meta_value;
            }



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

            add_post_meta($new_booking, 'last_name_2', $last_name_2, true);
            add_post_meta($new_booking, 'first_name_2', $first_name_2, true);
            add_post_meta($new_booking, 'last_name_3', $last_name_3, true);
            add_post_meta($new_booking, 'first_name_3', $first_name_3, true);
            add_post_meta($new_booking, 'last_name_4', $last_name_4, true);
            add_post_meta($new_booking, 'first_name_4', $first_name_4, true);
            add_post_meta($new_booking, 'last_name_5', $last_name_5, true);
            add_post_meta($new_booking, 'first_name_5', $first_name_5, true);



            var_dump('added booking');
        };






    endforeach;


}






?>
