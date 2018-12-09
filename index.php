<?php get_header(); ?>


<div class="search-title">
    <div class="container">
        <h1>Index</h1>
    </div>
</div>

<div class="container search-query">
    <div class="row">


        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


            <div class="search-item col-sm-12 col-xs-12">
                <?php if( has_post_thumbnail() ){ ?>
                    <div class="image-holder ngat">
                        <img src="<?php  echo the_post_thumbnail_url('full'); ?>"/>
                    </div> <?php } ?>
                    <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                </div>


            <?php endwhile; else: ?>

                <div class="container not-found">
                    <div class="col-sm-4 col-xs-12 no-margin no-padding">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/search-left.jpg" alt="">
                    </div>
                    <div class="col-sm-8 col-xs-12 no-margin no-padding">
                        <h1>
                            <p>AUCUN RÉSULTAT NE CORRESPOND Á VOTRE RECHERCHE...</p>
                        </h1>

                        <img src="<?php echo get_template_directory_uri(); ?>/assets/search-leftdown.jpg" alt="">
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <?php get_footer(); ?>
