<?php
/* Template Name: Locations Page */
get_header(); ?>
<div class="page-title" style="margin-bottom: 50px;">
    <div class="container">
        <h2> <?php the_title(); ?> </h2>
    </div>
</div>
<?php $args = array(
    'post_type' => 'location' ,
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1
); ?>
<?php $centers = get_posts($args); ?>

<div class="container">
    <div class="row">


        <?php $c = 0; foreach ($centers as $center): ?>
            <div class="col-sm-6 col-md-3">
                <div class="single_center">
                    <a href="<?php echo get_permalink( $center->ID ); ?>"><?php echo $center->post_title; ?></a>
                </div>
            </div>
            <?php echo ($c % 4 == 3) ? '</div><!-- END OF ROW --><div class="row">' : ''; ?>

            <?php $c++; endforeach; ?>
        </div><!-- END OF ROW -->
    </div>

<!-- Scripts -->
<?php get_footer(); ?>
