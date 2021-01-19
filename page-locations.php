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


<section id="new_locations_map_outer">

    <div class="container-fluid">

        <div class="col-sm-4" style="padding:0">

            <div id="map_text_overlay">

                <?php $c = 0;
                foreach ($centers as $center) : ?>

                    <div class="single_center" id="center_<?php echo $center->ID; ?>">
                        <a class="center_title" data-centerid="<?php echo $center->ID; ?>" href="<?php echo get_permalink($center->ID); ?>"><?php echo $center->post_title; ?></a>

                        <div class="single_center_expanded"></div>
                    </div>
                <?php $c++;
                endforeach; ?>



            </div>

            <div id="single_center_explainer"></div>


        </div>
        <div class="col-sm-8" style="padding:0">

            <div id="locations_map_container"></div>


        </div>
    </div>



</section>


<script type="text/javascript">
    var n_locations_for_map = <?php locations_for_map(); ?>;
    var theme_directory = '<?php echo get_template_directory_uri(); ?>';
    var api_url = '<?php echo home_url(); ?>/api/v1/';
</script>







<!-- Scripts -->
<?php get_footer(); ?>