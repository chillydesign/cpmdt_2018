<?php  /* Template Name: Program Data */  
header("Content-type:application/json");
if(isset($_GET['request'])){

    $request = $_GET['request']; 

    if($request == "get_program_data"){
        $id = $_GET['id'];
        global $wpdb;
        $sql = "SELECT wp_program_data.*,  wp_posts.post_title FROM wp_program_data 
                    INNER JOIN wp_posts ON wp_program_data.location_id = wp_posts.id    
                    WHERE wp_program_data.program_id = ".$id ." ORDER BY post_title ASC";
        $results = $wpdb->get_results($sql, OBJECT);

        //echo json_encode($results);
        $items = array();
        $sql = "SELECT * FROM wp_posts WHERE id = ".$id;
        $p_name = $wpdb->get_results($sql, OBJECT);
        
        foreach($results as $result){
            $t_ids = json_decode($result->teacher_id);
            $teacher_ids = implode(",", $t_ids);

            $item = array();
            $item['id'] = $result->id;
            $item['program']  = $p_name[0]->post_title;
            $item['location'] = $result->post_title;
            
            $teachers_name = '';
            $sql = "SELECT * FROM wp_posts WHERE id IN ($teacher_ids) ORDER BY post_title ASC";
            $teachers = $wpdb->get_results($sql, OBJECT);
            for($i=0; $i < count($teachers); $i++){
                if($i > 0){
                    $teachers_name .= ', ';
                }
                $teachers_name .= $teachers[$i]->post_title;
            }
            $item['teachers'] = $teachers_name;

            array_push($items, $item);
        }
        echo json_encode($items);
    }else if($request == 'get_program_locations'){
        $id = $_GET['id'];
        global $wpdb;
        //print_r($postmeta);
        $test  = get_post_meta($id);
        $loaction_ids = $test['p_location'][0];
        $teachers_ids = $test['p_teacher'][0];
        $teachers_ids_good = implode(',', maybe_unserialize($teachers_ids));
        $loaction_ids_good = implode(',', maybe_unserialize($loaction_ids));
        
        $sql = "SELECT * FROM wp_posts WHERE post_type = 'teacher' AND post_status = 'publish' AND ID IN ($teachers_ids_good) ORDER BY post_title ASC";
        $teachers = $wpdb->get_results($sql, OBJECT);
        
        $sql = "SELECT * FROM wp_posts WHERE post_type = 'location' AND post_status = 'publish' AND ID IN ($loaction_ids_good) ORDER BY post_title ASC";
        $locations = $wpdb->get_results($sql, OBJECT);
        $final_data = [$locations, $teachers];
        echo json_encode($final_data);

    }else if($request == 'save_connection'){

        global $wpdb;
        $program_id = $_GET['program_id'];
        $location_id = $_GET['location_id'];
        $teachers_id = $_GET['teachers_id'];
        $t_ids = json_encode($teachers_id);
        $wpdb->insert( 
            'wp_program_data', 
            array( 
                'program_id' => $program_id, 
                'location_id' => $location_id,
                'teacher_id' => $t_ids
            ), 
            array( 
                '%s', 
                '%d' 
            ) 
        );
        $arr = array('status' => true);
        echo json_encode($arr);

    }else if($request == 'delete_connection'){

        global $wpdb;
        $id = $_GET['id'];
        $wpdb->delete( 'wp_program_data', array( 'ID' => $id ) );
        $arr = array('id' => $id);
        echo json_encode($arr);

    } else if ($request == 'locations_json'){
        global $wpdb;
        $sql = "SELECT * FROM wp_posts   
                    WHERE post_type = 'location' AND post_status = 'publish'" ." ORDER BY post_title ASC";
        $results = $wpdb->get_results($sql, OBJECT);
        foreach($results as $result){
            $post_meta = get_post_meta($result->ID);
            $result->latitude = $post_meta['lat'][0];
            $result->longitude = $post_meta['long'][0];
            $result->addresse = $post_meta['addresse'][0];
            $result->infos = $post_meta['infos'][0];
            $result->description = $post_meta['description'][0];
            $result->responsible = $post_meta['responsible'][0];

            //get program and teachers for location
            $program_sql = "SELECT * FROM wp_program_data  
                        INNER JOIN wp_posts ON wp_program_data.program_id = wp_posts.id
                        WHERE wp_program_data.location_id = ". $result->ID ." ORDER BY post_title ASC";
            $program_data = $wpdb->get_results($program_sql, OBJECT);

            $items = array();
            foreach($program_data as $program){
                $t_ids = json_decode($program->teacher_id);
                $teachers = implode(',', $t_ids);

                $sql = "SELECT * FROM wp_posts WHERE id IN ($teachers)";
                $teachers_data = $wpdb->get_results($sql, OBJECT);

                $teacher_name = '';
                for($i=0;$i<count($teachers_data);$i++){
                    $teacher_name .= $teachers_data[$i]->post_title;
                    if($i < count($teachers_data)-1){
                        $teacher_name .= ' | ';
                    }
                }

                $item['program'] = $program->post_title;
                $item['permalink'] = get_post_permalink($program->ID);
                $item['teachers'] = $teacher_name;
                array_push($items, $item);
            }
            //add programs with data to array
            $result->program_data = $items;
        }

        echo json_encode($results);
    }  

}


?>