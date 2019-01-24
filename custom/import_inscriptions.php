<?php


// DONE import_old_inscriptions_data(17, false);
// DONE import_old_inscriptions_data(18, false);
// DONe import_old_inscriptions_data(23, false);


    function import_old_inscriptions_data($form_id, $testing) {
        global $wpdb;

        var_dump('-------- STARTING -------');

// ID 	form_key 	name
// =======================
// 5 	nlpqy     	Inscription enfants de 4 à 7 ans
// 17 	nlpqy2      Inscription Instrument / Chant et Formation musicale
// 18 	nlpqy3 	    Inscription Danse
// 23 	nlpqy32 	Inscription Théâtre
// 27 	nlpqy22 	Inscription adultes





        $sql = "SELECT * FROM wp_frm_items WHERE form_id =  " .  $form_id;
        if ($testing) {
            $sql .= " LIMIT 4  ";
        }
        $rows = $wpdb->get_results($sql, OBJECT);

        foreach ($rows as $row) :

            $old_booking_id = intval($row->id);
            $metas_sql = "SELECT wp_frm_item_metas.id, meta_value, name, field_key
            FROM `wp_frm_item_metas`
            LEFT JOIN wp_frm_fields ON wp_frm_fields.id = wp_frm_item_metas.field_id
            WHERE `item_id` =  " . $old_booking_id;
            $metas = $wpdb->get_results($metas_sql, OBJECT);



            $title = '';
            $last_name = '';
            $first_name = '';
            $date_of_birth = '';
            $gender = '';
            $address = '';
            $postcode = '';
            $town = '';
            $telephone_private = '';
            $telephone_professional = '';
            $telephone_portable = '';
            $title_guardian = '';
            $last_name_guardian = '';
            $first_name_guardian = '';
            $address_guardian = '';
            $town_guardian = '';
            $email = '';
            $geneva_taxpayer = '';
            $payment_frequency = '';
            $course_id = '';
            $course_id_second_choice = '';
            $location_id = '';
            $instrument_chant_remarks = '';
            $prof_inst_chant = '';
            $other_place_possible = '';
            // $musical_course_id = '';
            $musical_course = '';
            $musical_remarks = '';
            $prof_musical = '';
            $musical_location_id = '';
            $musical_other_place_possible = '';
            $inscription_year = '';
            $formation_musicale = '';
            $musical_level = '';
            $choix_tarif = '';
            $choix_tarif_collectif = '';
            $terms = '';
            $date_inscription = '';
            $how_know_school = '';
            $message = '';
            $authorisation_photo = '';
            $professeur = '';


            if ($form_id == 17 ) { //  Inscription Instrument / Chant et Formation musicale
                $stupid_codes = array(
                    'first_name' => 	'd7jmi2',
                    'last_name' =>	'wlw0l2',
                    'gender' => 	'3qht62',
                    'date_of_birth' => 	'q9dn72',
                    'address' =>	'xeqqp2',
                    'postcode' => 	'ekv2f2',
                    'town' => 	'45v872',
                    'title_guardian' => 	'thhg52',
                    'first_name_guardian' => 	'lqipg2',
                    'last_name_guardian' => 	'kqovb2',
                    'town_guardian' => '6wn52',
                    'telephone_private' => 	'zuaat2',
                    'telephone_portable' => 	'sv1o12',
                    'telephone_professional' => 	'gqu342',
                    'email' => 	'9u6wl2',
                    'geneva_taxpayer' => 	'49awk2',
                    'payment_frequency' => 	'jvlvh2',
                    'course_id' => 	'ykcju2',
                    'location_id' => 	'pxbqo',
                    'musical_location_id' => 	'z1skc',
                    'authorisation_photo' => 	'kfm0x2',
                    'terms' => 	'k5gue2',
                    'date_inscription' => 	'9wuqm2',
                    'message' => 	'bejyc',
                    'other_place_possible' => 	'1ec9d2',
                    'musical_other_place_possible' => 	'xlk08',
                    'course_id_second_choice' => 	'znyfp',
                    'how_know_school' => '7igmi2',
                    'formation_musicale' => 'pa4uv',
                );
            } else if ($form_id == 18) { //DANSE
                $stupid_codes = array(
                    'first_name' => 	'wlw0l3',
                    'last_name' =>	'd7jmi3',
                    'gender' => 	'3qht63',
                    'date_of_birth' => 	'q9dn73',
                    'address' =>	'xeqqp3',
                    'postcode' => 	'ekv2f3',
                    'town' => 	'45v873',
                    'title_guardian' => 	'thhg53',
                    'first_name_guardian' => 	'kqovb3',
                    'last_name_guardian' => 	'lqipg3',
                    'town_guardian' => '6wn53',
                    'telephone_private' => 	'zuaat3',
                    'telephone_portable' => 	'sv1o13',
                    'telephone_professional' => 	'gqu343',
                    'email' => 	'9u6wl3',
                    'geneva_taxpayer' => 	'49awk3',
                    'payment_frequency' => 	'jvlvh3',
                    'course_id' => 	'ykcju3',
                    'location_id' => 	'f9lch3',
                    'authorisation_photo' => 	'kfm0x3',
                    'terms' => 	'k5gue3',
                    'date_inscription' => 	'9wuqm3',
                    'message' => 	'6sa0t3',
                    'how_know_school' => '7igmi3',
                    'professeur' => '9maop3',
                );
            } else if ($form_id == 23) { // THEATRE
                $stupid_codes = array(
                    'first_name' => 	'wlw0l32',
                    'last_name' =>	'd7jmi32',
                    'gender' => 	'3qht632',
                    'date_of_birth' => 	'q9dn732',
                    'address' =>	'xeqqp32',
                    'postcode' => 	'ekv2f32',
                    'town' => 	'45v8732',
                    'title_guardian' => 	'thhg532',
                    'first_name_guardian' => 	'kqovb32',
                    'last_name_guardian' => 	'lqipg32',
                    'town_guardian' => '6wn532',
                    'telephone_private' => 	'zuaat32',
                    'telephone_portable' => 	'sv1o132',
                    'telephone_professional' => 	'gqu3432',
                    'email' => 	'9u6wl32',
                    'geneva_taxpayer' => 	'49awk32',
                    'payment_frequency' => 	'jvlvh32',
                    'course_id' => 	'ykcju32',
                    'location_id' => 	'f9lch32',
                    'authorisation_photo' => 	'kfm0x32',
                    'terms' => 	'k5gue32',
                    'date_inscription' => 	'9wuqm32',
                    'message' => 	'6sa0t32',
                    'how_know_school' => '7igmi32',
                );
            };

            $stupid_code_keys = array_keys($stupid_codes);

            foreach ($metas as $old_meta) :

                if ($testing) {
                    var_dump($old_meta);
                    echo '<br />';
                }


                if (in_array( $old_meta->field_key, $stupid_codes)) {
                    $keyy =  array_search(  $old_meta->field_key ,  $stupid_codes);

                    if (
                        $keyy == 'course_id' ||
                        $keyy == 'course_id_second_choice' )
                        //  ||    $keyy == 'musical_course_id'
                    {
                        $course = get_page_by_title( $old_meta->meta_value, OBJECT, 'programme');
                        if ($course) {
                            $$keyy = $course->ID;
                        } else {
                            $$keyy = 0;
                        }

                    }  else if (
                        $keyy == 'location_id' ||
                        $keyy == 'musical_location_id'
                    ) {
                        $location = get_page_by_title( $old_meta->meta_value, OBJECT, 'location');
                        if ($location) {
                            $$keyy = $location->ID;
                        } else {
                            $$keyy = 0;
                        }

                    } else {
                        $$keyy = $old_meta->meta_value;
                    }



                }

            endforeach;

            if ($first_name  != '' && $last_name != '' && ($testing == false) ) :

            $post = array(
                'post_title'   => $first_name . ' ' . $last_name,
                'post_status'  => 'publish',
                'post_type'    => 'inscription',
                'post_content' => ''
            );
            $new_inscription = wp_insert_post( $post );
            if ($new_inscription) {

                foreach ($stupid_code_keys as $acf_key) :
                    if ($$acf_key != '') {
                        add_post_meta($new_inscription, $acf_key, $$acf_key , true);
                    }

                endforeach;

                var_dump('added inscription');
            };

        else:
            //var_dump('no full name');
        endif; // if first name last name


        endforeach; // end of each row



    }


?>
