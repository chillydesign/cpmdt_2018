<?php
/* Template Name: Locations Page */
get_header(); ?>
<div class="page-title" style="margin-bottom: 50px;">
    <div class="container">
        <h2> <?php the_title(); ?> </h2>
    </div>
</div>


<section>

    <div id="new_locations_map_outer">
        <div id="map_text_overlay">
            <h2 id="location_name">....</h2>
            <p id="location_description">.....</p>
            <p id="location_responsible">.....</p>
            <p id="location_address">.....</p>
        </div>
        <div id="locations_map_container"></div>
    </div>
</section>
<script type="text/javascript">
    var n_locations_for_map = <?php locations_for_map(); ?>;
    var theme_directory = '<?php echo get_template_directory_uri(); ?>';
</script>



<?php $args = array(
    'post_type' => 'location',
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1
); ?>
<?php $centers = get_posts($args); ?>

<div class="container centers_container">


    <?php $c = 0;
    foreach ($centers as $center) : ?>

        <div class="single_center">
            <a href="<?php echo get_permalink($center->ID); ?>"><?php echo $center->post_title; ?></a>
        </div>



    <?php $c++;
    endforeach; ?>

</div>


<?php // get_template_part('locations-map'); 
?>


<!-- Scripts -->
<?php get_footer(); ?>