<?php
/* Template Name: Locations Page */
get_header(); ?>
<div class="page-title" style="margin-bottom: 50px;">
    <div class="container">
        <h2> <?php the_title(); ?> </h2>
    </div>
</div>

<?php $centers = get_posts(array('post_type' => 'location' , 'posts_per_page' => -1)); ?>

<div class="container">
    <ul class="centers_container">
        <?php foreach ($centers as $center): ?>

            <li class="single_center">
                <a href="<?php echo $center->guid; ?>"><?php echo $center->post_title; ?></a>
            </li>

        <?php endforeach; ?>
    </ul>
</div>

<!-- Scripts -->
<?php get_footer(); ?>
