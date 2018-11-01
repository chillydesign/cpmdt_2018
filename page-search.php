<?php
    /* Template Name: Search.page */
    get_header();


    $zones = get_posts( array('post_type' => 'zone'));
    var_dump($zones);

    $programs_array = array(
        'post_type' => 'programme',
        'posts_per_page' =>  -1,
        'orderby' => 'post_title',
        'order' => 'ASC'
    );

    if (isset($_GET['cat'])) :
        $programs_array['tax_query']  = array(
            array(
                'taxonomy' => 'programmes',
                'field' => 'id',
                'terms' => $_GET['cat']
            )
        );
    endif; // end of ?cat=


    if (isset($_GET['age'])):
        $age_arr = explode('-', $_GET['age']);
        $age_1 = intval($age_arr[0]);
        $age_2 = intval($age_arr[1]);
        $programs_array['meta_query'] = array(
            'relation' => 'OR',
            array(
                'relation' => 'AND',
                array(
                    'key' => 'p_age',
                    'value' => $age_1,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => 'p_age',
                    'value' => $age_2,
                    'compare' => '<',
                    'type' => 'NUMERIC'
                )
            ),
            array(
                'relation' => 'AND',
                array(
                    'key' => 'p_age2',
                    'value' => $age_1,
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => 'p_age2',
                    'value' => $age_2,
                    'compare' => '<',
                    'type' => 'NUMERIC'
                )
            )

        );
    endif; // end of ?age=


    $programs = new WP_Query($programs_array);
    // if ($programs->have_posts() ) :  while($programs->have_posts()) : $programs->the_post();
    //     the_title();
    //     the_ID();
    //     echo '<br />';
    // endwhile; endif;

        //
        // $location_id = $_GET['location_id'];
        // $cat = $_GET['cat'];
        // $age_arr = explode('-', $_GET['age']);
        // $age_1 = $age_arr[0];
        // $age_2 = $age_arr[1];
        // global $wpdb;
        // $sql = "SELECT * FROM wp_posts
        //         INNER JOIN wp_term_relationships ON wp_term_relationships.object_id = wp_posts.ID
        //         WHERE wp_posts.post_type = 'programme' AND wp_posts.post_status = 'publish' AND wp_posts.ID != 641 AND wp_posts.ID != 831 AND wp_posts.ID != 655 AND wp_posts.ID !=836 AND wp_posts.ID !=682 AND wp_posts.ID !=719 AND wp_posts.ID !=710 AND wp_posts.ID !=713 AND wp_posts.ID !=1604 AND wp_posts.ID !=733 AND wp_posts.ID !=744 AND wp_posts.ID !=837 AND wp_posts.ID !=660 AND wp_posts.ID != 1468 AND wp_posts.ID != 1464
        //                 AND wp_term_relationships.term_taxonomy_id = ". $cat.  " ORDER BY wp_posts.post_title ASC";
        //
        // $programs = $wpdb->get_results($sql, OBJECT);
        // $items = array();
        // $p_location = array();
        // if(count($programs) > 0){
        //     foreach($programs as $program){
        //         $item = array();
        //         $post_meta  = get_post_meta($program->ID);
        //         if(isset($post_meta['p_location'][0])){
        //             $p_location = maybe_unserialize($post_meta['p_location'][0]);
        //         }
        //
        //         if($location_id == -1){
        //             //if(($post_meta['p_age'][0] >= $age_1 && $post_meta['p_age2'][0] <= $age_2) ){
        //             if(($post_meta['p_age'][0] >= $age_1 && $post_meta['p_age'][0] < $age_2 ) || ($post_meta['p_age2'][0] > $age_1 && $post_meta['p_age2'][0] <= $age_2 )){
        //                     $item['id'] = $program->ID;
        //                     $item['title'] = $program->post_title;
        //                     if(array_key_exists("_thumbnail_id",$post_meta)){
        //                         $item['thumbnail'] = wp_get_attachment_url($post_meta['_thumbnail_id'][0]);
        //                     }else{
        //                         $item['thumbnail'] = '';
        //                     }
        //                     $item['permalink'] = get_post_permalink($program->ID);
        //                     array_push($items, $item);
        //             }
        //         }else{
        //             //if($post_meta['p_age'][0] >= $age_1 && $post_meta['p_age2'][0] <= $age_2 && in_array($location_id, $p_location)){
        //             //if( ( ($post_meta['p_age'][0] >= $age_1 && $post_meta['p_age'][0] <= $age_2 ) || ($post_meta['p_age2'][0] >= $age_1 && $post_meta['p_age2'][0] <= $age_2 ) )
        //             if( ( ($post_meta['p_age'][0] >= $age_1 && $post_meta['p_age'][0] < $age_2 ) || ($post_meta['p_age2'][0] > $age_1 && $post_meta['p_age2'][0] <= $age_2 ) ) && in_array($location_id, $p_location)){
        //                     $item['id'] = $program->ID;
        //                     $item['title'] = $program->post_title;
        //                     if(array_key_exists("_thumbnail_id",$post_meta)){
        //                         $item['thumbnail'] = wp_get_attachment_url($post_meta['_thumbnail_id'][0]);
        //                     }else{
        //                         $item['thumbnail'] = '';
        //                     }
        //                     $item['permalink'] = get_post_permalink($program->ID);
        //                     array_push($items, $item);
        //
        //             }
        //         }
        //     }
        // }
        ?>


        <!-- Search bar -->
        <?php get_template_part('programme.search'); ?>


        <!-- Container -->
        <div class="container page-programs">
            <div class="row">
                <?php
                    if(count($items)>0){
                        foreach($items as $item){ ?>

                            <div class="col-sm-4 col-xs-12 program">
                                <div class="program-inner"
                                style="
                                    background-image: url('<?php echo $item["thumbnail"] ?>');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                ">
                                    <a href="<?php echo $item['permalink']; ?>"></a>
                                    <h4><?php echo $item['title'];?></h4>
                                </div>
                            </div>
                <?php
                        }
                    } else{?>


                        <div class="container not-found">
                        <br><br>
                            <div class="col-sm-4 col-xs-12 no-margin no-padding">
                            <br>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/search-left.jpg" alt="">
                            </div>
                            <div class="col-sm-8 col-xs-12 no-margin no-padding">
                                <h1>
                                    <p>AUCUN RÉSULTAT NE CORRESPOND Á VOTRE RECHERCHE...</p>
                                </h1>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/search-leftdown.jpg" alt="">
                            </div>
                        </div>

                        <?php
                    }
                ?>
            </div>
        </div>



<?php get_footer(); ?>
