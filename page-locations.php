<?php
/* Template Name: Locations Page */
get_header(); ?>


<?php $args = array(
    'post_type' => 'location',
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1
); ?>
<?php $centers = get_posts($args); ?>


<div class="page-title">
    <div class="container">
        <h2> <?php the_title(); ?> </h2>
    </div>
</div>


<section class="container-fluid">


    <div class="col-sm-3">

        <div class=" ">
            <?php $c = 0;
            foreach ($centers as $center) : ?>

                <div class="single_center">
                    <a href="<?php echo get_permalink($center->ID); ?>"><?php echo $center->post_title; ?></a>
                </div>
            <?php $c++;
            endforeach; ?>

        </div>
    </div>


    <div class="col-sm-9">

        <div id="new_locations_map_outer">
            <div id="map_text_overlay">
                <h2 id="location_name"><a href="" id="location_link">....</a></h2>
                <p id="location_description">.....</p>
                <p id="location_responsible">.....</p>
                <p id="location_addresse">.....</p>

                <h3>Disciplines enseignées:</h3>
                <div id="location_courses_container"></div>
            </div>
            <div id="locations_map_container"></div>
        </div>

    </div>



</section>


<script type="text/javascript">
    var n_locations_for_map = <?php locations_for_map(); ?>;
    var theme_directory = '<?php echo get_template_directory_uri(); ?>';
    var search_url = '<?php echo home_url(); ?>/api/v1/';
</script>







<!-- Scripts -->
<?php get_footer(); ?>