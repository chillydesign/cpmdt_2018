<?php
    get_header(); ?>


    <?php
        // Get terms for "Program" Taxonomy
        $programs = get_the_terms( $post->ID , 'programmes' );
        // Loop over each item since it's an array
        if ( $programs != null ){
            foreach( $programs as $program ) {
                $programName = $program->name;
                $programSlug = $program->slug;
                unset($program);
            }
        }
    ?>

	<!-- Search bar -->
    <?php
        get_template_part('programme.search');
        // Reset query beacause in the programme.search part is a query for the locations
        wp_reset_query();

    ?>

	<!-- Page title -->
    <div class="page-title background-<? echo $programSlug ?>">
        <div class="container">
            <h2> <? echo $programName ?> / <?php the_title() ;?></h2>
        </div>
	</div>

    <!-- Content container -->
	<div class="page-programs program-single container">
        <div class="row">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <div class="col-sm-4 col-xs-12">
                    <img class="<?php echo $programSlug ?>" src="<? echo the_post_thumbnail_url('full'); ?>"/>

                    <!-- Professors and Places -->
                    <div class="left-sidebar">
                        <div class="row no-margin header text-uppercase">
                            <div class="col-sm-6 col-xs-12">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icon-program_places.svg">
                                <h5>lieux</h5>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icon-program_professors.svg">
                                <h5>professeurs</h5>
                            </div>
                        </div>
                        <?php
                        $program_items = get_program_data($post->ID);
                        foreach($program_items as $item){?>
                            <div class="row no-margin body body-item">
                                <div class="col-sm-6 col-xs-12 font-bold">
                                    <span><?php echo $item['location']; ?></span>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <?php echo $item['teachers']; ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-sm-5 col-xs-12">
                    <!-- Content -->
                    <?php the_content(); ?>
                </div>
                <div class="col-sm-3 col-xs-12 right-sidebar">


                    <!-- *! Get age of the program -->
                    <?php
                        $age = get_custom_field("p_age");
                        if(!empty($age)){
                            $result =
                                '<div class="sidebar-box sidebar-age">
                                    dès '.$age.' Ans
                                </div>';
                            echo $result;
                        }
                    ?>

                    <!-- First *Media Upload Box -->
                    <?php
                        $strFile = get_post_meta($post -> ID, $key = 'podcast_file', true);
                        if(!empty($strFile)){
                            $result =
                                '<div class="sidebar-box sidebar-download text-uppercase font-bold">
                                        <a href="'. $strFile .'">télécharger le Plan d\'études</a>
                                </div>';
                            echo $result;
                        }
                    ?>

                    <!-- Second *Media Upload Box -->
                    <?php
                        $strFile2 = get_post_meta($post -> ID, $key = 'podcast_file2', true);
                        if(!empty($strFile2)){
                            $result =
                                '<div class="sidebar-box sidebar-download text-uppercase">
                                        <a href="'. $strFile2 .'">télécharger le pdf de la fiche</a>
                                </div>';
                            echo $result;
                        }
                    ?>

                    <!-- *Star Link -->
                    <?php
                        $star_link = get_custom_field("p_starlink");
                        if(!empty($star_link)){
                            $result =
                                '<div class="sidebar-box sidebar-star text-uppercase">
                                    <a href="'.$star_link.'">cours complémentaire</a>
                                </div>';
                            echo $result;
                        }
                    ?>

                    <!-- *! Notifications for each cat
                         *! Check in which template we are, and change the background-color of the box -->
                    <?php
                        $notifications = get_custom_field('p_notifications');
                        if(!empty($notifications)){
                            if ($programSlug == 'dance'){
                                $result =
                                    "<div class='sidebar-box sidebar-notifications background-dance'>
                                        ".get_custom_field('p_notifications')."
                                    </div>";
                                echo $result;
                            } elseif ($programSlug == 'music'){
                                $result =
                                    "<div class='sidebar-box sidebar-notifications background-music'>
                                        ".get_custom_field('p_notifications')."
                                    </div>";
                                echo $result;
                            } elseif ($programSlug == 'theatre'){
                                $result =
                                    "<div class='sidebar-box sidebar-notifications background-theatre'>
                                        ".get_custom_field('p_notifications')."
                                    </div>";
                                echo $result;
                            }
                        }
                    ?>

                    <!-- *! Related posts -->
                    <div class="sidebar-box sidebar-search search text-uppercase font-bold">
                        <h5 class="text-uppercase">a découvrir aussi</h5>
                        <p><?php echo get_custom_field('p_related'); ?></p>
                    </div>

                    <!-- *! Whoever knows what this is -->
                    <?php
                        $p_inscription = get_custom_field("p_inscription");
                        if(!empty($p_inscription)){

                            $p_inscription = $p_inscription . '?course_id=' . $post->ID;
                            $result =
                                '<div class="register-button text-uppercase text-center">
                                    <a href="'.$p_inscription.'"><h3>INSCRIPTION / TARIFS</h3></a>
                                </div>';
                            echo $result;
                        }
                    ?>
                    </div>

			<?php endwhile; else: ?>

				<div class="search">
					<h1> Aucun élément a été trouvé   </h1>
				</div>

			<?php endif; ?>
        </div>
	</div>

<?php get_footer(); ?>
