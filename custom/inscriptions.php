<?php


add_action( 'init', 'post_type_inscription' );

// GET POSTED DATA FROM FORM
// TO DO REMAME FUNCTION
add_action( 'admin_post_nopriv_inscription_form',    'save_inscription_form'   );
add_action( 'admin_post_inscription_form',  'save_inscription_form' );

// ALLOW BOOKING FORM TO BE ADDED AS A SHORTCODE
add_shortcode( 'inscription_form',  'inscription_form_shortcode' );


function post_type_inscription() {
    register_post_type('inscription', // Register Custom Post Type
    array(
        'labels' => array(
            'name' => __('Inscriptions', 'html5blank'), // Rename these to suit
            'singular_name' => __('Inscription', 'html5blank'),
            'add_new' => __('Ajouter', 'html5blank'),
            'add_new_item' => __('Ajouter inscription', 'html5blank'),
            'edit' => __('Modifier', 'html5blank'),
            'edit_item' => __('Modifier Inscription', 'html5blank'),
            'new_item' => __('Nouvelle inscription', 'html5blank'),
            'view' => __('Afficher insc', 'html5blank'),
            'view_item' => __('Afficher inscription', 'html5blank'),
            'search_items' => __('Chercher inscription', 'html5blank'),
            'not_found' => __('Aucune inscription trouvée', 'html5blank'),
            'not_found_in_trash' => __('Aucune inscription trouvée dans la crobeille', 'html5blank')
        ),
        'public' => true,
        'menu_icon' => 'dashicons-list-view',
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






//  ADD inscription FORM AS A SHORTCODE
function inscription_form_shortcode($atts , $content = null) {


    $atts = shortcode_atts( array(
		'coursetype' => 'adults'
	), $atts, 'inscription_form' );

	$course_type = $atts['coursetype'];

    if ($course_type == 'adults') {
        $courses = get_all_adult_courses();
    } else {
        $courses = get_all_current_courses();
    }




    $rq_frm = '';



    $get_course_id = isset($_GET['course_id'])  ? $_GET['course_id'] : false;


    $rq_frm .= ' <form class="inscription_form" action="' .  esc_url( admin_url('admin-post.php') ) . '" method="post">';



    if (  isset( $_GET['success']) ) :
        $rq_frm .=  '<div class="alert alert-success">Votre inscription a bien été enregistrée!</div>';
    elseif ( isset($_GET['problem'])  ) :
        $rq_frm .=  '<div class="alert alert-danger">Une erreur s’est produite. Veuillez réessayer..</div>';
    endif;




    $rq_frm .=
    '<div class="inscription_field">
    <label for="title">Titre</label>
    <div class="field_content">
    <select id="title" name="title">
    <option value="Madame">Madame</option>
    <option value="Mademoiselle">Mademoiselle</option>
    <option value="Monsieur">Monsieur</option>
    </select>
    </div>
    </div>';



    $rq_frm .=
    '<div class="inscription_field">
    <label for="last_name">Nom de l\'élève * </label>
    <div class="field_content">
    <input type="text" name="last_name" id="last_name" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="first_name">Prénom de l\'élève * </label>
    <div class="field_content">
    <input type="text" name="first_name" id="first_name" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="date_of_birth">Date de naissance</label>
    <div class="field_content">
    <input type="text" name="date_of_birth" id="date_of_birth"  />
    </div>
    </div>';



    $rq_frm .=  '<div class="inscription_field">
    <label for="address">Adresse</label>
    <div class="field_content">
    <input type="text" name="address" id="address" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="postcode">N° postal</label>
    <div class="field_content">
    <input type="text" name="postcode" id="postcode" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="town">Ville</label>
    <div class="field_content">
    <input type="text" name="town" id="town" />
    </div>
    </div>';


    $rq_frm .=' <div class="inscription_field">
    <label for="telephone_private">Téléphone privé * </label>
    <div class="field_content">
    <input type="text" name="telephone_private" id="telephone_private" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="telephone_professional">Téléphone professionnel  </label>
    <div class="field_content">
    <input type="text" name="telephone_professional" id="telephone_professional" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="telephone_portable">Téléphone portable </label>
    <div class="field_content">
    <input type="text" name="telephone_portable" id="telephone_portable" />
    </div>
    </div>';
    $rq_frm .=' <div class="inscription_field">
    <label for="email">Courriel </label>
    <div class="field_content">
    <input type="name" name="email" id="email" />
    </div>
    </div>';



    $rq_frm .=' <div class="inscription_field">
    <label for="geneva_taxpayer">Contribuable à Genève * </label>
    <div class="field_content">
    <label><input type="radio"  class="radio_input" name="geneva_taxpayer" value="Oui" />Oui</label>
    <label><input type="radio"  class="radio_input" name="geneva_taxpayer" value="Non" />Non</label>
    </div>
    </div>';


    $rq_frm .=' <div class="inscription_field">
    <label for="payment_frequency">Je paierai ma facture en *</label>
    <div class="field_content">
    <label><input type="radio" class="radio_input" name="payment_frequency" value="1 fois" />1 fois</label>
    <label><input type="radio" class="radio_input" name="payment_frequency" value="3 fois" />3 fois</label>
    <label><input type="radio" class="radio_input" name="payment_frequency" value="6 fois" />6 fois</label>
    <p class="meta">Les factures de cours jusque 500.- se paient en une fois. Pour les abonnements l’écolage est payable d’avance en une fois à la réception du CPMDT.</p>
    </div>
    </div>';

    $rq_frm .= '<hr/>';



    $rq_frm .= '
    <div class="inscription_field" id="course_id_select_box">
    <label for="course_id">Choix du cours * </label>
    <div class="field_content">
    <select id="course_id" name="course_id">';
    $rq_frm .= '<option value="0">Choisir un cours</option>';
    foreach ($courses as $course) :
        $selected =  '' ; // ($course->ID == $get_course_id  ) ? 'selected' : '';
        $rq_frm .= '<option '. $selected .' value="'.  $course->ID  .'">'.  ($course->post_title)   .'</option>';
    endforeach;
    $rq_frm .= '</select>
    </div>
    </div>';

    $rq_frm .= '<div class="inscription_field" id="teacher_id_cont"></div>';



    $rq_frm .=
    '<div class="inscription_field">
    <label for="inscription_year">Inscription pour l\'année </label>
    <div class="field_content">
    <select id="inscription_year" name="inscription_year">
    <option value="2018-2019">2018-2019</option>
    </select>
    </div>
    </div>';


    $rq_frm .=
    '<div class="inscription_field">
    <label for="formation_musicale">Formation musicale *</label>
    <div class="field_content">
    <select id="formation_musicale" name="formation_musicale">
    <option value="débutant"  selected="selected">débutant</option>
    <option value="à classer">à classer</option>
    <option value="Actuellement en FM au CPMDT">Actuellement en FM au CPMDT</option>
    <option value="Autre école (donc sera à classer)">Autre école (donc sera à classer)</option>
    <option value="FM terminée (envoyer attestation)">FM terminée (envoyer attestation)</option>
    <option value="danse ou théâtre = pas de FM" >danse ou théâtre = pas de FM</option>
    </select>
    <p class="meta">Cours obligatoire selon le plan d\'études</p>
    </div>
    </div>';

    $rq_frm .=' <div class="inscription_field">
    <label for="musical_level">Niveau musical </label>
    <div class="field_content">
    <input type="text" name="musical_level" id="musical_level"  />
    </div>
    </div>';


    $rq_frm .=
    '<div class="inscription_field">
    <label for="choix_tarif">Choix du tarif *</label>
    <div class="field_content">
    <select id="choix_tarif" name="choix_tarif">
    <option value="Cours de 50 minutes toutes les 2 semaines / 1970.-"  selected="selected">Cours de 50 minutes toutes les 2 semaines / 1970.-</option>
    <option value="Cours hebdomadaire de 30 minutes / 2360.-" >Cours hebdomadaire de 30 minutes / 2360.-</option>
    <option value="Cours hebdomadaire de 40 minutes / 3150.-" >Cours hebdomadaire de 40 minutes / 3150.-</option>
    <option value="Cours hebdomadaire de 50 minutes / 3940.-" >Cours hebdomadaire de 50 minutes / 3940.-</option>
    <option value="Abonnement de 10 leçons individuelles de 40 minutes / 880.-" >Abonnement de 10 leçons individuelles de 40 minutes / 880.-</option>
    <option value="Abonnement de 10 leçons individuelles de 50 minutes / 1100.-" >Abonnement de 10 leçons individuelles de 50 minutes / 1100.-</option>
    <option value="Cours collectif, prix selon brochure" >Cours collectif, prix selon brochure</option>
    </select>
    <p class="meta"> Instrument / chant. Pour les abonnements l’écolage est payable d’avance en une fois à la réception du CPMDT. </p>
    </div>
    </div>';



    $rq_frm .=' <div class="inscription_field">

    <label for="choix_tarif_collectif">Choix du tarif – cours collectif </label>
    <div class="field_content">
    <input type="text" name="choix_tarif_collectif" id="choix_tarif_collectif" value="Prix selon brochure" readonly="readonly" disabled />
    </div>
    </div>';


    $rq_frm .= '<hr/>';

    $rq_frm .= '<div class="inscription_field">
        <label for="">Conditions générales *</label>
        <div class="field_content">
    <label><input id="agree_terms" type="checkbox" class="checkbox_input" value="agree" name="terms" />

    Je certifie avoir pris connaissance des
    <a href="' . get_home_url() . '/conditions-generales/">conditions générales</a> d’inscription et les accepte. </a>  </label>
    </div>
    </div>';


    $rq_frm .=' <div class="inscription_field">
    <label for="date_inscription">Date de l’inscription  </label>
    <div class="field_content">
    <input type="text" name="date_inscription" id="date_inscription"  />
    <p class="meta">Date du jour – non modifiable</p>
    </div>
    </div>';


    $rq_frm .=
    '<div class="inscription_field">
    <label for="how_know_school">Comment avez-vous eu connaissance de notre école? </label>
    <div class="field_content">
    <select id="how_know_school" name="how_know_school">
    <option value="Site internet"  selected="selected">Site internet</option>
    <option value="Bouche-à-oreille, réputation" >Bouche-à-oreille, réputation</option>
    <option value="Autre enfant déjà inscrit au CPMDT" >Autre enfant déjà inscrit au CPMDT</option>
    <option value="Publicité dans le domaine public" >Publicité dans le domaine public</option>
    <option value="Autre"  class="frm_other_trigger">Autre</option>
    </select>
    </div>
    </div>';

    $rq_frm .=' <div class="inscription_field">
    <label for="message">Remarques si nécessaire </label>
    <div class="field_content">
    <textarea  name="message" id="message"></textarea>
    <p class="meta">Pour la danse, spécifier le choix du jour.</p>
    </div>
    </div>';







        // HIDDEN ACTION INPUT IS REQUIRED TO POST THE DATA TO THE CORRECT PLACE
    $rq_frm .= '<div class="inscription_field submit_group_button">
    <input type="submit" id="submit_inscription_form" value="Envoyer">
    <input type="hidden" name="action" value="inscription_form">
    <div id="stopsubmit"></div>
    </div>
    <br><br>
    <p class="fillitall">Veuillez remplir tous les champs pour valider l\'inscription.</p>
    </form>';

    $rq_frm .= '<script type="text/javascript">
    	var search_url = "' . get_home_url(). '/api/v1/";
    </script>';



        return  $rq_frm;

    }



    function all_inscription_fields(){

        return array(

            'title' => 'Titre de l\'élève',
            'last_name' =>  'Nom de l\'élève',
            'first_name' => 'Prénom de l\'élève',
            'date_of_birth' =>  'Date de naissance de l\'élève',
            'address' =>  'Adresse de l\'élève',
            'postcode' => 'N° postal ',
            'town' => 'Ville',
            'telephone_private' => 'Téléphone privé',
            'telephone_professional' => 'Téléphone professionnel ',
            'telephone_portable' => 'Téléphone portable ',
            'email' =>  'Email de l\'élève',
            'geneva_taxpayer' => 'Contribuable à Genève',
            'payment_frequency' => 'Je paierai ma facture en',
            'course_id' => 'Cours',
            'inscription_year' => 'Inscription pour l\'année ',
            'formation_musicale' => 'Formation musicale',
            'musical_level' => 'Niveau musical ',
            'choix_tarif' => 'Choix du tarif ',
            'choix_tarif_collectif' => 'Choix du tarif – cours collectif ',
            'terms' => 'Conditions générales',
            'date_inscription' => 'Date de l’inscription ',
            'how_know_school' => 'Comment avez-vous eu connaissance de notre école? ',
            'message' => 'Remarques si nécessaire ',



        );
    }


    function get_all_adult_courses() {
        $posts_array = get_posts(
            array(
                'post_type'  => 'programme',
                'order'=> 'ASC',
                'orderby' => 'title',
                'posts_per_page' => 3,
                'post_status' => 'published',

            )
        );
        return $posts_array;
    }


    function get_all_current_courses() {
        $posts_array = get_posts(
            array(
                'post_type'  => 'programme',
                'order'=> 'ASC',
                'orderby' => 'title',
                'posts_per_page' => -1,
                'post_status' => 'published'

            )
        );
        return $posts_array;
    }





    function save_inscription_form () {

        // IF DATA HAS BEEN POSTED
        if ( isset($_POST['action'])  && $_POST['action'] == 'inscription_form'   ) :

            if (isset($_POST['first_name']) && isset($_POST['last_name']) ) :
            // TO DO CHECK IF ALL NECESSARY FIELDS HAVE BEEN FILLED IN

            $serv_referer = $_SERVER['HTTP_REFERER'];
            $referer =  explode('?',   $serv_referer)[0];


            $fullname = $_POST['first_name'] . ' ' . $_POST['last_name'];

            $post = array(
                'post_title'     => $fullname,
                'post_status'    => 'publish',
                'post_type'      => 'inscription',
                'post_content'   => ''

            );
            $new_inscription = wp_insert_post( $post );


            if ($new_inscription == 0) {
                $inscription = get_home_url() . '/inscription';
                wp_redirect( $inscription . '?problem' );
            } else {


                $fields = all_inscription_fields();

                foreach ($fields as $field => $value ) {
                    if (isset($_POST[$field])){
                        add_post_meta($new_inscription, $field,  $_POST[$field] , true);
                    }
                }




                wp_redirect( $referer . '?success' );
                // $redirect = get_home_url() . '/inscription-reussie/';
                // wp_redirect( $redirect );
            }


            exit;


        else: //  if isset first name and last name
            wp_redirect($referer . '?problem' );
        endif; // end if isset first name and last name
        endif; // if post action = inscription_form


    } // save_inscription_form



    ?>
