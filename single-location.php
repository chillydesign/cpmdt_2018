<?php get_header(); ?>

<?php // get_template_part( 'breadcrumbs' ); ?>

<!--Title  -->
<div class="page-title" style="margin-bottom: 50px;">
    <div class="container">
        <h1><span>Centre: <?php the_title(); ?></span></h1>
    </div>
</div>

<div class="blog-container">
    <!--Post Content-->

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php $location_id = get_the_ID(); ?>

        <?php $centers = get_posts(array('order' => 'ASC',  'orderby'=>'title',  'post_type' => 'location' , 'posts_per_page' => -1)); ?>


        <!-- Locations information -->
        <div class="container ">


            <div style="text-align:right;">
                <h4>Sélectionner un centre:</h4>
                <select name="locations" class="locations_dropdown">
                    <?php foreach ($centers as $center) : ?>
                        <?php $selected = ($center->ID == $location_id ) ? 'selected' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo  get_permalink( $center->ID ); ?>"><?php echo $center->post_title; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="locations-container">
                <div class="information">
                    <div class="row">
                        <div class="col-sm-6">


                            <?php $addresse = get_field('addresse'); ?>
                            <?php $description = get_field('description'); ?>
                            <?php $infos = get_field('infos'); ?>
                            <?php $responsible = get_field('responsible'); ?>
                            <?php $lat = get_field('lat'); ?>
                            <?php $long = get_field('long'); ?>

                            <?php if ($addresse): ?>
                                <p>
                                    <b>Adresse:</b>
                                    <span><?php echo $addresse;  ?></span>
                                </p>
                            <?php endif; ?>
                            <?php if ($infos): ?>
                                <p>
                                    <b>Infos TPG:</b>
                                    <span><?php echo $infos; ?></span>
                                </p>
                            <?php endif; ?>
                            <?php if ($description): ?>
                                <p>
                                    <b>Description:</b>
                                    <span><?php echo $description; ?></span>
                                </p>
                            <?php endif; ?>

                            <?php if ($responsible): ?>
                                <p>
                                    <b>Responsable:</b>
                                    <span><?php echo $responsible; ?></span>
                                </p>
                            <?php endif; ?>



                        </div>
                        <div class="col-sm-6">
                            <?php if ($lat) : ?>
                            <p>
                                <b>Google Map:</b>
                                <div style="height: 200px" id="single_location_map"></div>
                                <script>
                                    single_location_for_map = {"title": "<?php echo get_the_title(); ?> ","lat":<?php echo $lat; ?>,"lng":<?php echo $long; ?>,"id":<?php echo $location_id; ?>};
                                        	var theme_directory = '<?php echo get_template_directory_uri(); ?>';
                                </script>
                                <a target="_blank" href="https://www.google.com/maps/?q=<?php echo $lat; ?>,<?php echo $long; ?>" style="color: inherit;">
                                    <span>Afficher le plan</span>
                                </a>
                            </p>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> <!--END OF LOCATIONS CONTAINER -->

            <?php $courses = courses_from_location_id( $location_id ); ?>

            <?php if (sizeof($courses) > 0): ?>
                <div class="locations-connections ">
                    <h4>Disciplines enseignées:</h4>
                    <?php foreach( $courses as $course ) : ?>
                        <div class="connection-row">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="<?php echo $course->guid; ?>"><?php echo $course->post_title; ?></a>
                                </div>
                                <div class="col-sm-6">
                                    <ul>
                                        <?php $times = get_field('times',  $course->ID ); ?>
                                        <?php if ($times): ?>
                                        <?php foreach ($times as $time): ?>
                                            <?php if ($time['location']): ?>
                                                <?php  ///  ONLY SHOW TEACHERS OF COURSE WHO WORK AT THIS PARTICULAR LOCATION ?>
                                                <?php if ($time['location']->ID ==  $location_id  ): ?>
                                                    <?php foreach ($time['teachers'] as $teacher) : ?>
                                                        <li>
                                                            <?php echo $teacher->post_title; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                            <?php endif; ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> <!-- END OF LOCATIONS CONNECTIONS -->
            <?php endif; // end if courses ?>

        <?php $cours_complementaires = get_field('cours_complementaires'); ?>
        <?php if (sizeof($cours_complementaires) > 0): ?>
            <div class="locations-connections ">
                <h4>Cours Complémentaires:</h4>
                <?php foreach( $cours_complementaires as $course ) : ?>
                    <div class="connection-row">
                        <div class="row">
                            <div class="col-sm-6">
                                <a  target="_blank"  href="<?php echo $course['url']; ?>"><?php echo $course['name']; ?></a>
                            </div>
                            <div class="col-sm-6">
                                <ul>
                                    <?php $professeurs = $course['professeurs']; ?>
                                    <?php if ($professeurs): ?>
                                    <?php foreach ($professeurs as $prof): ?>

                                            <li>
                                                <?php echo $prof->post_title; ?>
                                            </li>
                                    <?php endforeach; ?>
                                        <?php endif; ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> <!-- END OF LOCATIONS CONNECTIONS -->
        <?php endif; // end if courses ?>


        </div>


    <?php endwhile; else: ?>

        <h1>Aucun article trouvé</h1>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
