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
        'exclude_from_search' => true,
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
		'type' => 'adults'
	), $atts, 'inscription_form' );

	$course_type = $atts['type'];

    if ($course_type == 'adults') {
        $courses = get_all_adult_courses();
    } else if ($course_type == 'danse') {
        $courses = get_all_courses_with_cat('dance');
    } else if ($course_type == 'theatre') {
        $courses = get_all_courses_with_cat('theatre');
    } else if ($course_type == '47musicale') {
        $courses = get_all_47_musicale_courses();
    } else if ($course_type == 'instrumentchant') {
        $courses = get_all_instrumentchant_courses();
    } else {
        $courses = get_all_current_courses();
    }




    $get_course_id = isset($_GET['course_id'])  ? $_GET['course_id'] : false;

    $rq_frm = '';
    $rq_frm .= ' <form class="inscription_form" action="' .  esc_url( admin_url('admin-post.php') ) . '" method="post"  enctype="multipart/form-data" >';



    if (  isset( $_GET['success']) ) :
        $rq_frm .=  '<div class="alert alert-success">Votre inscription a bien été enregistrée!</div>';
    elseif ( isset($_GET['problem'])  ) :
        $rq_frm .=  '<div class="alert alert-danger">Une erreur s’est produite. Veuillez réessayer..</div>';
    endif;




        if ( in_array($course_type,  array('instrumentchant') ) ):
            $rq_frm .=  '<h3> COURS D’INSTRUMENT / CHANT (choisir un cours) </h3>';
        endif; // end if in array instrumentchant


        $rq_frm .= '
        <div class="inscription_field">
        <label for="course_id">Choix du cours * </label>
        <div class="field_content">
        <select class="course_picker" id="course_id" name="course_id" data-field="location" >';
        $rq_frm .= '<option value="0">Choisir un cours</option>';
        foreach ($courses as $course) :
            $selected =  '' ; // ($course->ID == $get_course_id  ) ? 'selected' : '';
            $rq_frm .= '<option '. $selected .' value="'.  $course->ID  .'">'.  ($course->post_title)   .'</option>';
        endforeach;
        $rq_frm .= '</select>
        </div>
        </div>';

        if ( in_array($course_type,  array('instrumentchant') ) ):
            $rq_frm .=' <div class="inscription_field">
            <label for="instrument_chant_remarks">Remarque</label>
            <div class="field_content">
            <textarea  name="instrument_chant_remarks" id="instrument_chant_remarks"></textarea>
            <p class="meta">Pour la danse, spécifier le choix du jour.</p>
            </div>
            </div>';
            $rq_frm .=' <div class="inscription_field">
            <label for="prof_inst_chant">Professeur Instr. / chant  </label>
            <div class="field_content">
            <input type="text" name="prof_inst_chant" id="prof_inst_chant" />
            </div>
            </div>';

        endif; // end if in array instrumentchant



            $rq_frm .= '<div class="inscription_field">
            <label for="location_id">Lieu </label>
            <div class="field_content">
            <select name="location_id" id="locations_container"></select>
            <script id="locations_template" type="x-underscore">
                <%  _.each(locations,function(location,key,list){  %>
                <option value="<%= location.wid %>"><%= location.post_title %></option>
                <% }) %>
            </script>
            </div>
            </div>';


        if ( in_array($course_type,  array('47musicale', 'instrumentchant') ) ):
            $rq_frm .=' <div class="inscription_field">
            <label for="other_place_possible"> Autre lieu possible *</label>
            <div class="field_content">
            <label><input type="radio" class="radio_input" name="other_place_possible" value="Oui" />Oui</label>
            <label><input type="radio" class="radio_input" name="other_place_possible" value="Non" />Non</label>
            <p class="meta">Etes-vous d\'accord de vous déplacer dans un centre plus éloigné?</p>
            </div>
            </div>';
        endif;


        if ( in_array($course_type,  array( 'instrumentchant') ) ):
            $rq_frm .= '
            <div class="inscription_field" >
            <label for="course_id_second_choice">Second choix  </label>
            <div class="field_content">
            <select  id="course_id_second_choice" name="course_id_second_choice">';
            $rq_frm .= '<option value="0">Choisir un cours</option>';
            foreach ($courses as $course) :
                $selected =  '' ; // ($course->ID == $get_course_id  ) ? 'selected' : '';
                $rq_frm .= '<option '. $selected .' value="'.  $course->ID  .'">'.  ($course->post_title)   .'</option>';
            endforeach;
            $rq_frm .= '</select>
            <p class="meta">Si pas de place disponible dans le choix principal.</p>
            </div>
            </div>';
        endif;  // end if have second choice course id




        if ( in_array($course_type,  array('adults') ) ):
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

        endif; // end if course type adults


        if ( in_array($course_type,  array('instrumentchant') ) ):
            $rq_frm .=  '<hr />';
            $rq_frm .=  '<h3> COURS DE FORMATION MUSICALE </h3>';

            $rq_frm .= '
            <div class="inscription_field">
            <label for="musical_course_id">Formation musicale * </label>
            <div class="field_content">
            <select class="course_picker" id="musical_course_id" name="musical_course_id" data-field="musical_location">';
            $rq_frm .= '<option value="0">Choisir un cours</option>';
            foreach ($courses as $course) :
                $selected =  '' ; // ($course->ID == $get_course_id  ) ? 'selected' : '';
                $rq_frm .= '<option '. $selected .' value="'.  $course->ID  .'">'.  ($course->post_title)   .'</option>';
            endforeach;
            $rq_frm .= '</select>
            </div>
            </div>';
            $rq_frm .=' <div class="inscription_field">
            <label for="musical_remarks">Remarque</label>
            <div class="field_content">
            <textarea  name="musical_remarks" id="musical_remarks"></textarea>
            </div>
            </div>';
            $rq_frm .=' <div class="inscription_field">
            <label for="prof_musical">Professeur FM</label>
            <div class="field_content">
            <input type="text" name="prof_musical" id="prof_musical" />
            </div>
            </div>';

            $rq_frm .= '<div class="inscription_field">
            <label for="musical_location_id">Lieu </label>
            <div class="field_content">
            <select name="musical_location_id" id="musical_locations_container"></select>
            <script id="musical_locations_template" type="x-underscore">
                <%  _.each(locations,function(location,key,list){  %>
                <option value="<%= location.wid %>"><%= location.post_title %></option>
                <% }) %>
            </script>
            <p class="meta">Si le cours n’est pas disponible dans le lieu choisi, le centre le plus proche vous sera affecté.</p>
            </div>
            </div>';

            $rq_frm .=' <div class="inscription_field">
            <label for="musical_other_place_possible"> Autre lieu possible *</label>
            <div class="field_content">
            <label><input type="radio" class="radio_input" name="musical_other_place_possible" value="Oui" />Oui</label>
            <label><input type="radio" class="radio_input" name="musical_other_place_possible" value="Non" />Non</label>
            <p class="meta">Etes-vous d\'accord de vous déplacer dans un centre plus éloigné?</p>
            </div>
            </div>';

        endif; // end if in array instrumentchant




        $rq_frm .= '<hr/>';




    if ( in_array($course_type,  array('adults') ) ):
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
    endif;


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


    if (  in_array($course_type,  array('danse', 'theatre', '47musicale', 'instrumentchant') ) ):
        $rq_frm .=' <div class="inscription_field">
        <label for="gender">Sexe </label>
        <div class="field_content">
        <label><input type="radio" class="radio_input" name="gender" value="Fille" />Fille</label>
        <label><input type="radio" class="radio_input" name="gender" value="Garçon" />Garçon</label>
        </div>
        </div>';
    endif;

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


    if ( in_array($course_type,  array('danse', 'theatre', '47musicale', 'instrumentchant') ) ):
        $rq_frm .=  '<hr />';
        $rq_frm .=  '<h3> REPRÉSENTANT LÉGAL / RÉPONDANT </h3> <br />';
        $rq_frm .=
        '<div class="inscription_field">
        <label for="title_guardian">Titre</label>
        <div class="field_content">
        <select id="title_guardian" name="title_guardian">
        <option value="Madame">Madame</option>
        <option value="Mademoiselle">Mademoiselle</option>
        <option value="Monsieur">Monsieur</option>
        </select>
        </div>
        </div>';
        $rq_frm .=
        '<div class="inscription_field">
        <label for="last_name_guardian">Nom de le guardian * </label>
        <div class="field_content">
        <input type="text" name="last_name_guardian" id="last_name_guardian" />
        </div>
        </div>';
        $rq_frm .=' <div class="inscription_field">
        <label for="first_name_guardian">Prénom de le guardian * </label>
        <div class="field_content">
        <input type="text" name="first_name_guardian" id="first_name_guardian" />
        </div>
        </div>';


        $rq_frm .=  '<div class="inscription_field">
        <label for="address_guardian">Adresse si différente de l\'élève</label>
        <div class="field_content">
        <input type="text" name="address_guardian" id="address_guardian" />
        </div>
        </div>';

        $rq_frm .=' <div class="inscription_field">
        <label for="town_guardian">Ville</label>
        <div class="field_content">
        <input type="text" name="town_guardian" id="town_guardian" />
        </div>
        </div>';

    endif;  // end of if danse course type





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




    // $rq_frm .=' <div class="inscription_field">
    // <label for="hypothetical_file">Hypothetical file upload </label>
    // <div class="field_content">
    // <input type="file" name="hypothetical_file" id="hypothetical_file"  />
    // </div>
    // </div>';


    $rq_frm .=
    '<div class="inscription_field">
    <label for="authorisation_photo">Authorisation photo *</label>
    <div class="field_content">
    <div class="field_content">
    <label><input type="radio"  class="radio_input" name="authorisation_photo" value="Oui" />Oui</label>
    <label><input type="radio"  class="radio_input" name="authorisation_photo" value="Non" />Non</label>
    </div>
    <p class="meta">L\'institution peut utiliser des images (photo, vidéos) où apparaît mon enfant pour les diffuser sur son site Internet, dans des brochures, des articles ou autres publications institutionnelles.</p>
    </div>
    </div>';



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
    <input type="hidden" name="course_type" value="'. $course_type .'">
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


    function translate_course_type($type) {

        if ($type == 'adults') {
            return 'en course d\'adults';
        } else if ($type == 'danse') {
            return 'en cours de danse';
        } else if ($type == 'theatre') {
            return 'en course de theatre';
        } else if ($type == '47musicale') {
            return 'en course de 47musicale';
        } else if ($type == 'instrumentchant') {
            return 'en course d\'instrumentchant';
        } else {
            return 'en cours de danse';
            // return $type;
        };

    }


    function all_inscription_fields(){

        return array(

            'title' => 'Titre de l\'élève',
            'last_name' =>  'Nom de l\'élève',
            'first_name' => 'Prénom de l\'élève',
            'date_of_birth' =>  'Date de naissance de l\'élève',
            'gender' =>  'Sexe',
            'address' =>  'Adresse de l\'élève',
            'postcode' => 'N° postal ',
            'town' => 'Ville',
            'telephone_private' => 'Téléphone privé',
            'telephone_professional' => 'Téléphone professionnel ',
            'telephone_portable' => 'Téléphone portable ',
            'title_guardian' => 'Titre de guardian',
            'last_name_guardian' =>  'Nom de le guardian',
            'first_name_guardian' => 'Prénom de le guardian',
            'address_guardian' => 'address_guardian',
            'town_guardian' => 'town_guardian',
            'email' =>  'Email de l\'élève',
            'geneva_taxpayer' => 'Contribuable à Genève',
            'payment_frequency' => 'Je paierai ma facture en',
            'course_id' => 'Cours',
            'course_id_second_choice' => 'Second choice Cours',
            'location_id' => 'Location',
            'instrument_chant_remarks' => 'instrument_chant_remarks',
            'prof_inst_chant' => 'prof_inst_chant',
            'other_place_possible' => 'Autre lieu possible',
            'musical_course_id' =>'musical_course_id',
            'musical_remarks' =>'musical_remarks',
            'prof_musical' =>'prof_musical',
            'musical_location_id' =>'musical_location_id',
            'musical_other_place_possible' =>'musical_other_place_possible',
            'inscription_year' => 'Inscription pour l\'année ',
            'formation_musicale' => 'Formation musicale',
            'musical_level' => 'Niveau musical ',
            'choix_tarif' => 'Choix du tarif ',
            'choix_tarif_collectif' => 'Choix du tarif – cours collectif ',
            'terms' => 'Conditions générales',
            'date_inscription' => 'Date de l’inscription ',
            'how_know_school' => 'Comment avez-vous eu connaissance de notre école? ',
            'message' => 'Remarques si nécessaire ',
            'authorisation_photo' => 'Authorisation Photo',

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


    function get_all_courses_with_cat($category) {
        $posts_array = get_posts(
            array(
                'post_type'  => 'programme',
                'order'=> 'ASC',
                'orderby' => 'title',
                'posts_per_page' => -1,
                'post_status' => 'published',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'programmes',
                        'field' => 'slug',
                        'terms' => $category
                    ),
                )

            )
        );
        return $posts_array;
    }


    function get_all_instrumentchant_courses() {
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


    function get_all_47_musicale_courses() {
        $posts_array = get_posts(
            array(
                'post_type'  => 'programme',
                'order'=> 'ASC',
                'orderby' => 'title',
                'posts_per_page' => -1,
                'post_status' => 'published',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'programmes',
                        'field' => 'slug',
                        'terms' =>'music',
                    ),
                ),
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'p_age',
                            'value' => 4,
                            'compare' => '>=',
                            'type' => 'NUMERIC'
                        ),
                        array(
                            'key' => 'p_age',
                            'value' => 8,
                            'compare' => '<',
                            'type' => 'NUMERIC'
                        )
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'p_age2',
                            'value' => 4,
                            'compare' => '>=',
                            'type' => 'NUMERIC'
                        ),
                        array(
                            'key' => 'p_age2',
                            'value' => 8,
                            'compare' => '<',
                            'type' => 'NUMERIC'
                        )
                    )
                )
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


                if (isset($_FILES['hypothetical_file'])) {
                $hypothetical_file_file = $_FILES['hypothetical_file'];
                if ($hypothetical_file_file['size'] > 0 ) {
                    $photo_id = inscription_add_file_upload( $hypothetical_file_file, $new_inscription );
                    update_field( 'hypothetical_file', $photo_id,  $new_inscription  );
                };
                }


                // SEND EMAILS TO THE ADMIN AND THE PERSON WHO SUBMITTED
                send_inscription_emails( $_POST );



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






        function send_inscription_emails($data){


            $course_id = $data['course_id'];
            $course = get_post( $course_id );
            $course_title = $course->post_title;
            $course_type = $data['course_type'];


            $headers = 'From: Conservatoire populaire de musique, danse et théâtre <inscription@conservatoirepopualire.ch>' . "\r\n";
            $headers .= 'Reply-To: Conservatoire populaire de musique, danse et théâtre <inscription@conservatoirepopualire.ch>' . "\r\n";
            $emailheader = ''; // file_get_contents(dirname(__FILE__) . '/emails/email_header.php');
            $emailfooter = ''; // file_get_contents(dirname(__FILE__) . '/emails/email_footer.php');
            add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));


            $paragraph_for_user = '<p>Madame, Monsieur,</p>
            <p>Nous accusons réception de votre inscription ' . translate_course_type($course_type) .  '.</p>
            <p></p>Après votre inscription, vous recevrez une convocation pour un test qui aura lieu fin août.</p>
            <p>Ce rendez-vous nous permettra de faire connaissance avec l’enfant et lui donnera l’occasion de faire un essai.</p>
            <p>Vous recevrez, à ce moment-là, toutes les informations utiles ainsi que la confirmation finale de votre inscription.</p>
            <p>Avec nos remerciements pour la confiance que vous accordez au CPMDT, nous vous prions de recevoir nos meilleures salutations.</p>
            <p>L\'administration du CPMDT </p> ';


            $paragraph_for_user .= '<table style="font-size:14px;line-height:135%;border-bottom:1px solid #000;margin: 30px 0 20px;" cellspacing="0"><tbody>';


            $fields = all_inscription_fields();
            $cssstyle = ' style="text-align:left;color:#555555;padding:7px 9px;vertical-align:top;border-top:1px solid #000"';

            foreach ($fields as $field => $translation) :
                if (  $field != 'musical_course_id' &&
                $field != 'course_id' &&
                $field != 'location_id' &&
                $field != 'course_id_second_choice' &&
                $field != 'musical_location_id' ):
                    if (isset($data[$field])) :
                        $value = $data[$field];
                        if ($value != '') :
                            $paragraph_for_user .= '<tr>
                            <td '. $cssstyle .'>' .  $translation .'</td>
                            <td '. $cssstyle .'>' . $value .' </td>
                            </tr>';
                        endif;
                    endif;
                endif;
            endforeach;


            $paragraph_for_user .= '</tbody></table>';


            $email_subject_for_user = 'Inscription';
            $email_content_for_user = $emailheader . $paragraph_for_user .  $emailfooter;


            wp_mail( $_POST['email'], $email_subject_for_user, $email_content_for_user, $headers );



            remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );



        }






    function inscription_add_file_upload($file, $parent){
        $upload = wp_upload_bits($file['name'], null, file_get_contents( $file['tmp_name'] ) );
        $wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );
        $wp_upload_dir = wp_upload_dir();


        $attachment = array(
            'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $upload['file'] ),
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename( $upload['file'] )),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $upload['file'], $parent );


        return $attach_id;

    }


    ?>
